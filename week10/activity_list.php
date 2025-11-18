<?php
$title = "活動列表";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user) {
    echo "<div class='alert alert-danger'>請先登入</div>";
    exit;
}

$sql = "SELECT * FROM dorm_activities ORDER BY activity_date DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container my-4">
    <h2>活動列表</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>名稱</th>
                <th>日期</th>
                <?php if($user['role']==='M') echo "<th>操作</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['activity_date']?></td>
                <?php if($user['role']==='M'): ?>
                <td>
                    <a href="activity_sign.php?id=<?=$row['id']?>" class="btn btn-sm btn-success">簽到</a>
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
