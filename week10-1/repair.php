<?php
$title = "報修單列表";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user) {
    echo "<div class='alert alert-danger'>請先登入</div>";
    include("footer.php");
    exit;
}

if ($user['role'] === 'M') {
    // 管理員看全部（包含住民姓名）
    $sql = "SELECT r.id, r.resident_id, u.name AS resident_name, r.location, r.item, r.description, r.status, r.created_at
            FROM repair_requests r
            LEFT JOIN residents u ON r.resident_id = u.id
            ORDER BY r.created_at DESC, r.id DESC";
    $res = mysqli_query($conn, $sql);
} else {
    // 住民只看自己的
    $sql = "SELECT id, location, item, description, status, created_at FROM repair_requests WHERE resident_id = ? ORDER BY created_at DESC, id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user['id']);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
}
?>

<div class="container my-4">
    <h2>報修單列表</h2>

    <?php if($user['role'] !== 'M'): ?>
        <p><a href="repair_create.php" class="btn btn-success">＋ 新增報修</a></p>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <?php if($user['role'] === 'M'): ?><th>住民姓名</th><?php endif; ?>
                <th>地點</th>
                <th>項目</th>
                <th>描述</th>
                <th>狀態</th>
                <th>時間</th>
                <?php if($user['role'] === 'M'): ?><th>操作</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><?=htmlspecialchars($row['id'])?></td>
                <?php if($user['role'] === 'M'): ?><td><?=htmlspecialchars($row['resident_name'] ?? '—')?></td><?php endif; ?>
                <td><?=htmlspecialchars($row['location'])?></td>
                <td><?=htmlspecialchars($row['item'])?></td>
                <td><?=nl2br(htmlspecialchars($row['description']))?></td>
                <td><?=htmlspecialchars($row['status'])?></td>
                <td><?=htmlspecialchars($row['created_at'] ?? '')?></td>
                <?php if($user['role'] === 'M'): ?>
                <td>
                    <a href="repair_update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">更新狀態</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($res) === 0): ?>
            <tr><td colspan="<?= $user['role'] === 'M' ? 8 : 6 ?>" class="text-center">目前無任何報修紀錄</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
