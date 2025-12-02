<?php
$title = "活動簽到";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user) {
    echo "<div class='alert alert-danger'>請先登入</div>";
    include("footer.php");
    exit;
}

$activity_id = $_GET['id'] ?? 0;

// 取得活動
$stmt = mysqli_prepare($conn, "SELECT * FROM dorm_activities WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $activity_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$activity = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$activity) {
    echo "<div class='alert alert-danger'>活動不存在</div>";
    include("footer.php");
    exit;
}

// 檢查是否當天
$today = date('Y-m-d');
$activity_day = date('Y-m-d', strtotime($activity['activity_date']));
if ($today !== $activity_day) {
    echo "<div class='alert alert-warning'>簽到尚未開放，請在活動當天簽到</div>";
    include("footer.php");
    exit;
}

// 簽到
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'] ?? '';
    $student_id = $_POST['student_id'] ?? '';

    // 驗證房號學號
    $stmt_check = mysqli_prepare($conn, "SELECT * FROM residents WHERE room_number=? AND student_id=?");
    mysqli_stmt_bind_param($stmt_check, "ss", $room_number, $student_id);
    mysqli_stmt_execute($stmt_check);
    $res_check = mysqli_stmt_get_result($stmt_check);

    if(mysqli_num_rows($res_check) === 0) {
        $msg = "<div class='alert alert-danger'>房號或學號錯誤</div>";
    } else {
        $resident = mysqli_fetch_assoc($res_check);
        $resident_id = $resident['id'];

        // 檢查是否已簽到
        $stmt_dup = mysqli_prepare($conn, "SELECT * FROM activity_signups WHERE activity_id=? AND resident_id=?");
        mysqli_stmt_bind_param($stmt_dup, "ii", $activity_id, $resident_id);
        mysqli_stmt_execute($stmt_dup);
        $res_dup = mysqli_stmt_get_result($stmt_dup);

        if(mysqli_num_rows($res_dup) > 0){
            $msg = "<div class='alert alert-warning'>您已經簽到過了</div>";
        } else {
            // 執行簽到
            $stmt = mysqli_prepare($conn, "INSERT INTO activity_signups (activity_id, resident_id, signed_at) VALUES (?, ?, NOW())");
            mysqli_stmt_bind_param($stmt, "ii", $activity_id, $resident_id);
            if(mysqli_stmt_execute($stmt)) $msg = "<div class='alert alert-success'>簽到成功</div>";
            else $msg = "<div class='alert alert-danger'>簽到失敗</div>";
            mysqli_stmt_close($stmt);
        }
        mysqli_stmt_close($stmt_dup);
    }
}
?>

<div class="container my-4">
    <h2><?= htmlspecialchars($activity['name']) ?> - 簽到</h2>
    <p>地點：<?= htmlspecialchars($activity['location']) ?> | 日期：<?= htmlspecialchars($activity['activity_date']) ?></p>
    <p><?= nl2br(htmlspecialchars($activity['description'])) ?></p>

    <form method="post">
        <div class="mb-3">
            <label>房號</label>
            <input type="text" name="room_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>學號</label>
            <input type="text" name="student_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">簽到</button>
        <?= $msg ?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
