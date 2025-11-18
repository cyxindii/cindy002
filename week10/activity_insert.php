<?php
$title = "新增活動";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? "");
    $date = mysqli_real_escape_string($conn, $_POST['date'] ?? "");

    if ($name && $date) {
        $sql = "INSERT INTO dorm_activities (name, activity_date) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $name, $date);
        if (mysqli_stmt_execute($stmt)) $msg = "<div class='alert alert-success'>新增成功</div>";
        else $msg = "<div class='alert alert-danger'>新增失敗</div>";
        mysqli_stmt_close($stmt);
    } else {
        $msg = "<div class='alert alert-warning'>請填寫完整資料</div>";
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
            <label class="form-label">活動日期</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">新增活動</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
