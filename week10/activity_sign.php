<?php
$title = "活動簽到";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user) exit("請先登入");

$activity_id = (int)($_GET['id'] ?? 0);
if ($activity_id <= 0) exit("無效活動");

$msg = "";
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $resident_id = $user['id'];

    // 檢查是否已簽到
    $check = mysqli_query($conn, "SELECT * FROM activity_signups WHERE activity_id=$activity_id AND resident_id=$resident_id");
    if (mysqli_num_rows($check) > 0) {
        $msg = "<div class='alert alert-warning'>您已簽到過</div>";
    } else {
        $sql = "INSERT INTO activity_signups (activity_id, resident_id) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $activity_id, $resident_id);
        if (mysqli_stmt_execute($stmt)) $msg = "<div class='alert alert-success'>簽到成功</div>";
        else $msg = "<div class='alert alert-danger'>簽到失敗</div>";
        mysqli_stmt_close($stmt);
    }
}

// 讀活動名稱
$res = mysqli_query($conn, "SELECT name, activity_date FROM dorm_activities WHERE id=$activity_id");
$activity = mysqli_fetch_assoc($res);
?>

<div class="container my-4">
    <h2>活動簽到 - <?=htmlspecialchars($activity['name'])?></h2>
    <p>日期: <?=$activity['activity_date']?></p>

    <form method="post">
        <button type="submit" class="btn btn-primary">我要簽到</button>
    </form>
    <?=$msg?>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
