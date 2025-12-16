<?php
$title = "飲料機吃錢登記";
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
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? "");
    $amount = mysqli_real_escape_string($conn, $_POST['amount'] ?? "");
    $note = mysqli_real_escape_string($conn, $_POST['note'] ?? "");

    if ($name && $amount) {
        $sql = "INSERT INTO drinks_lost (resident_id, name, amount, note, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isds", $user['id'], $name, $amount, $note);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $msg = $ok ? "<div class='alert alert-success'>登記成功 ✅</div>" : "<div class='alert alert-danger'>登記失敗 ❌</div>";
    } else {
        $msg = "<div class='alert alert-warning'>請填寫姓名與金額</div>";
    }
}
?>

<div class="container my-4" style="max-width: 550px;">
    <h2>飲料機吃錢登記</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">姓名</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">金額</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">備註（可不填）</label>
            <input type="text" name="note" class="form-control">
        </div>
        <button type="submit" class="btn btn-success w-100">送出登記</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
