<?php
$title = "新增報修單";
include("header.php");
require_once "db.php";

// 只有住民可以新增報修
$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] === 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = mysqli_real_escape_string($conn, $_POST['location'] ?? "");
    $item = mysqli_real_escape_string($conn, $_POST['item'] ?? "");
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? "");

    if ($location && $item && $description) {
        $sql = "INSERT INTO repair_requests (resident_id, location, item, description, status) VALUES (?, ?, ?, ?, '待處理')";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $user['id'], $location, $item, $description);
        $res = mysqli_stmt_execute($stmt);
        if ($res) $msg = "<div class='alert alert-success'>新增成功</div>";
        else $msg = "<div class='alert alert-danger'>新增失敗</div>";
        mysqli_stmt_close($stmt);
    } else {
        $msg = "<div class='alert alert-warning'>請填寫完整資料</div>";
    }
}
?>

<div class="container my-4">
    <h2>新增報修單</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">地點</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">項目</label>
            <input type="text" name="item" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">問題描述</label>
            <textarea name="description" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">送出報修</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
