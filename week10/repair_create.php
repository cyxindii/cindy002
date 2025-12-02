<?php
$title = "新增報修單";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
// 只允許住民（非管理員）新增
if (!$user || $user['role'] === 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    include("footer.php");
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = mysqli_real_escape_string($conn, $_POST['location'] ?? "");
    $item = mysqli_real_escape_string($conn, $_POST['item'] ?? "");
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? "");
    if ($location && $item && $description) {
        $sql = "INSERT INTO repair_requests (resident_id, location, item, description, status, created_at) VALUES (?, ?, ?, ?, '待處理', NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $user['id'], $location, $item, $description);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = $ok ? "<div class='alert alert-success'>新增成功</div>" : "<div class='alert alert-danger'>新增失敗</div>";
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
        <button type="submit" class="btn btn-success">送出報修</button>
        <?=$msg?>
    </form>
</div>
<?php
mysqli_close($conn);
include("footer.php");
?>
