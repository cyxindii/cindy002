<?php
$title = "活動簽到管理";
include("header.php");
require_once "db.php";

// 權限判斷
$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    include("footer.php");
    exit;
}

// 查詢簽到資料
$sql = "SELECT 
            a.name AS activity_name, 
            a.activity_date,
            r.name AS resident_name, 
            r.room_number, 
            r.student_id, 
            s.signed_at
        FROM activity_signups s
        JOIN dorm_activities a ON s.activity_id = a.id
        JOIN residents r ON s.resident_id = r.id
        ORDER BY a.activity_date DESC, s.signed_at";

$result = mysqli_query($conn, $sql);
?>

<div class="container my-4">
    <h2>活動簽到管理</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>活動名稱</th>
                <th>活動日期</th>
                <th>學生姓名</th>
                <th>房號</th>
                <th>學號</th>
                <th>簽到時間</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['activity_name']) ?></td>
                <td><?= htmlspecialchars($row['activity_date']) ?></td>
                <td><?= htmlspecialchars($row['resident_name']) ?></td>
                <td><?= htmlspecialchars($row['room_number']) ?></td>
                <td><?= htmlspecialchars($row['student_id']) ?></td>
                <td><?= htmlspecialchars($row['signed_at']) ?: '未簽到' ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
