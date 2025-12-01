<?php
$title = "更新報修單狀態";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    include("footer.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "<div class='alert alert-danger'>無效 ID</div>";
    include("footer.php");
    exit;
}

$msg = "";

// 讀取該筆
$sql = "SELECT r.id, r.location, r.item, r.description, r.status, u.name AS resident_name
        FROM repair_requests r
        LEFT JOIN residents u ON r.resident_id = u.id
        WHERE r.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $rid, $location, $item, $description, $status, $resident_name);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$found) {
    echo "<div class='alert alert-warning'>找不到該報修單</div>";
    include("footer.php");
    exit;
}

// 更新
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'] ?? $status;
    if (!in_array($new_status, ['待處理','處理中','已完成'])) $new_status = $status;

    $sql = "UPDATE repair_requests SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $msg = $ok ? "<div class='alert alert-success'>更新成功</div>" : "<div class='alert alert-danger'>更新失敗</div>";
    $status = $new_status;
}
?>

<div class="container my-4">
    <h2>更新報修單狀態</h2>
    <p>住民：<?=htmlspecialchars($resident_name ?? '')?></p>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">地點</label>
            <input type="text" class="form-control" value="<?=htmlspecialchars($location)?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">項目</label>
            <input type="text" class="form-control" value="<?=htmlspecialchars($item)?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">描述</label>
            <textarea class="form-control" rows="4" readonly><?=htmlspecialchars($description)?></textarea>
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
