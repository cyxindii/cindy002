<?php
$title = "活動管理";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    include("footer.php");
    exit;
}

// 處理刪除動作
if(isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = mysqli_prepare($conn, "DELETE FROM dorm_activities WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: activity_admin.php");
    exit;
}

// 讀取活動列表
$sql = "SELECT * FROM dorm_activities ORDER BY created_at DESC, id DESC";
$res = mysqli_query($conn, $sql);
?>

<div class="container my-4">
    <h2>活動管理</h2>
    <p><a href="activity_create.php" class="btn btn-success">＋ 新增活動</a></p>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>活動名稱</th>
                <th>地點</th>
                <th>日期時間</th>
                <th>簡介</th>
                <th>建立時間</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['activity_date']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <a href="activity_create.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">編輯</a>
                    <a href="activity_admin.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</a>
                    <a href="activity_signups_admin.php?activity_id=<?= $row['id'] ?>" class="btn btn-sm btn-success">簽到管理</a>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($res) === 0): ?>
            <tr><td colspan="7" class="text-center">目前無活動資料</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
