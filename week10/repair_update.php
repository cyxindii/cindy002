<?php
$title = "更新報修單狀態";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) exit("無效 ID");

$msg = "";

// 讀取現有資料
$sql = "SELECT id, location, item, description, status FROM repair_requests WHERE id=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $rid, $location, $item, $description, $status);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// 表單提交
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $new_status = $_POST['status'] ?? $status;
    $sql = "UPDATE repair_requests SET status=? WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $id);
    if (mysqli_stmt_execute($stmt)) $msg = "<div class='alert alert-success'>更新成功</div>";
    else $msg = "<div class='alert alert-danger'>更新失敗</div>";
    mysqli_stmt_close($stmt);
    $status = $new_status;
}
?>

<div class="container my-4">
    <h2>更新報修單狀態</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">地點</label>
            <input type="text" class="form-control" value="<?=$location?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">項目</label>
            <input type="text" class="form-control" value="<?=$item?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">描述</label>
            <textarea class="form-control" rows="4" readonly><?=$description?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">狀態</label>
            <select name="status" class="form-select">
                <option value="待處理" <?=($status==='待處理')?'selected':''?>>待處理</option>
                <option value="處理中" <?=($status==='處理中')?'selected':''?>>處理中</option>
                <option value="已完成" <?=($status==='已完成')?'selected':''?>>已完成</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">更新狀態</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
