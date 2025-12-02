<?php
$title = "新增活動";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    include("footer.php");
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $location = mysqli_real_escape_string($conn, $_POST['location'] ?? '');
    $activity_date = mysqli_real_escape_string($conn, $_POST['activity_date'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

    if($name && $location && $activity_date) {
        $stmt = mysqli_prepare($conn, "INSERT INTO dorm_activities (name, location, activity_date, description) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $location, $activity_date, $description);
        if(mysqli_stmt_execute($stmt)) $msg = "<div class='alert alert-success'>新增成功</div>";
        else $msg = "<div class='alert alert-danger'>新增失敗</div>";
        mysqli_stmt_close($stmt);
    } else {
        $msg = "<div class='alert alert-warning'>請填寫活動名稱、地點與時間</div>";
    }
}
?>

<div class="container my-4">
    <h2>新增活動</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">活動名稱</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">地點</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">日期與時間</label>
            <input type="datetime-local" name="activity_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">活動簡介</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">新增活動</button>
        <?= $msg ?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
