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

$id = $_GET['id'] ?? null;
$data = null;
$msg = "";

/* 編輯模式：先撈資料 */
if ($id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM dorm_activities WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt)->fetch_assoc();
    mysqli_stmt_close($stmt);

    if (!$data) {
        echo "<div class='alert alert-danger'>找不到活動</div>";
        include("footer.php");
        exit;
    }
}

/* 表單送出 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $location = $_POST['location'] ?? '';
    $activity_date = $_POST['activity_date'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($name && $location && $activity_date) {
        if ($id) {
            // 更新
            $stmt = mysqli_prepare($conn,
                "UPDATE dorm_activities 
                 SET name=?, location=?, activity_date=?, description=? 
                 WHERE id=?"
            );
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $location, $activity_date, $description, $id);
            $ok = mysqli_stmt_execute($stmt);
            $msg = $ok
                ? "<div class='alert alert-success'>更新成功</div>"
                : "<div class='alert alert-danger'>更新失敗</div>";
        } else {
            // 新增
            $stmt = mysqli_prepare($conn,
                "INSERT INTO dorm_activities (name, location, activity_date, description)
                 VALUES (?,?,?,?)"
            );
            mysqli_stmt_bind_param($stmt, "ssss", $name, $location, $activity_date, $description);
            $ok = mysqli_stmt_execute($stmt);
            $msg = $ok
                ? "<div class='alert alert-success'>新增成功</div>"
                : "<div class='alert alert-danger'>新增失敗</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $msg = "<div class='alert alert-warning'>請填寫活動名稱、地點與時間</div>";
    }
}
?>

<div class="container my-4">
    <h2><?= $id ? '編輯活動' : '新增活動' ?></h2>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">活動名稱</label>
            <input type="text" name="name" class="form-control"
                   value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">地點</label>
            <input type="text" name="location" class="form-control"
                   value="<?= htmlspecialchars($data['location'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">日期與時間</label>
            <input type="datetime-local" name="activity_date" class="form-control"
                   value="<?= isset($data['activity_date']) ? date('Y-m-d\TH:i', strtotime($data['activity_date'])) : '' ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">活動簡介</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $id ? '儲存修改' : '新增活動' ?>
        </button>

        <a href="activity_admin.php" class="btn btn-secondary">返回列表</a>

        <?= $msg ?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
