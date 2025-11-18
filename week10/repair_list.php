<?php
$title = "報修單列表";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user) {
    echo "<div class='alert alert-danger'>請先登入</div>";
    exit;
}

// 管理員查看全部，住民只看自己的
if ($user['role'] === 'M') {
    $sql = "SELECT r.id, u.name, r.location, r.item, r.description, r.status FROM repair_requests r JOIN residents u ON r.resident_id = u.id ORDER BY r.id DESC";
} else {
    $sql = "SELECT id, location, item, description, status FROM repair_requests WHERE resident_id=? ORDER BY id DESC";
}
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
if ($user['role'] !== 'M') mysqli_stmt_bind_param($stmt, "i", $user['id']);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
?>

<div class="container my-4">
    <h2>報修單列表</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <?php if($user['role']==='M') echo "<th>住民姓名</th>"; ?>
                <th>地點</th>
                <th>項目</th>
                <th>描述</th>
                <th>狀態</th>
                <?php if($user['role']==='M') echo "<th>操作</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><?=$row['id']?></td>
                <?php if($user['role']==='M') echo "<td>{$row['name']}</td>"; ?>
                <td><?=$row['location']?></td>
                <td><?=$row['item']?></td>
                <td><?=$row['description']?></td>
                <td><?=$row['status']?></td>
                <?php if($user['role']==='M'): ?>
                    <td>
                        <a href="repair_update.php?id=<?=$row['id']?>" class="btn btn-sm btn-warning">更新狀態</a>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
