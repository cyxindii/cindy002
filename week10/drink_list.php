<?php
$title = "飲料機吃錢紀錄（管理員）";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
// 只允許管理員查看
if (!$user || $user['role'] !== 'M') {
    echo "<div class='alert alert-danger'>您沒有權限查看此頁面</div>";
    include("footer.php");
    exit;
}

$sql = "SELECT dl.*, r.name AS resident_name 
        FROM drinks_lost dl
        LEFT JOIN residents r ON dl.resident_id = r.id
        ORDER BY dl.created_at DESC";
$result = $conn->query($sql);
?>

<div class="container my-4">
    <div class="card">
        <h2 class="title mb-4 text-center">飲料機吃錢紀錄（管理員查看）</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>住民姓名</th>
                        <th>登記姓名</th>
                        <th>金額</th>
                        <th>備註</th>
                        <th>時間</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= htmlspecialchars($row["resident_name"]) ?></td>
                                <td><?= htmlspecialchars($row["name"]) ?></td>
                                <td><?= htmlspecialchars($row["amount"]) ?></td>
                                <td><?= htmlspecialchars($row["note"]) ?></td>
                                <td><?= $row["created_at"] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6">沒有資料</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
