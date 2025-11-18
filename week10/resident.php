<?php
$title = "住民管理";
include("header.php");
require_once "db.php";

if(!isset($_SESSION['user'])){
    $redirect = $_SERVER['REQUEST_URI'];
    header("Location: login.php?redirect=".urlencode($redirect));
    exit;
}

$user = $_SESSION['user'];

// 讀取住民資料
$sql = "SELECT * FROM resident ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container my-4">
    <h3 class="mb-4 text-center">住民管理
        <?php if($user['role'] === 'M'): ?>
            <a href="resident_insert.php" class="btn btn-success btn-sm float-end">＋新增住民</a>
        <?php endif; ?>
    </h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>房號</th>
                <th>電話</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['dorm_room']?></td>
                <td><?=$row['phone']?></td>
                <td>
                    <?php if($user['role'] === 'M'): ?>
                        <a href="resident_update.php?id=<?=$row['id']?>" class="btn btn-primary btn-sm">修改</a>
                        <a href="resident_delete.php?id=<?=$row['id']?>" class="btn btn-danger btn-sm">刪除</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
