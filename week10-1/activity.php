<?php
$title = "活動列表";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user) {
    echo "<div class='alert alert-danger'>請先登入</div>";
    include("footer.php");
    exit;
}

// 讀取活動
$sql = "SELECT * FROM dorm_activities ORDER BY activity_date DESC";
$res = mysqli_query($conn, $sql);
?>

<div class="container my-4">
    <h2>活動列表</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>活動名稱</th>
                <th>地點</th>
                <th>日期</th>
                <th>簡介</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['activity_date']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                <td>
                    <a href="activity_signup.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">簽到</a>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($res) === 0): ?>
            <tr><td colspan="5" class="text-center">目前無活動</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
