<?php
$title = "活動簽到列表";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    include("footer.php");
    exit;
}

$activity_id = $_GET['id'] ?? 0;

// 取得簽到名單
$sql = "SELECT s.*, r.name AS resident_name 
        FROM activity_signups s 
        LEFT JOIN residents r ON s.resident_id = r.id
        WHERE s.activity_id=? ORDER BY signed_at";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $activity_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
?>

<div class="container my-4">
    <h2>活動簽到列表</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>住民姓名</th>
                <th>簽到時間</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><?= htmlspecialchars($row['resident_name']) ?></td>
                <td><?= htmlspecialchars($row['signed_at']) ?></td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($res) === 0): ?>
            <tr><td colspan="2" class="text-center">尚無簽到紀錄</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
