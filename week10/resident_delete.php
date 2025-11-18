<?php
$title = "刪除住民資料";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if(!$user || $user['role'] !== 'M'){
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if($id <= 0){
    echo "<div class='alert alert-danger'>無效的住民 ID</div>";
    exit;
}

if(isset($_GET['action']) && $_GET['action'] === 'confirmed'){
    $sql = "DELETE FROM resident WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: residents.php");
    exit;
}

// 讀取住民資料做刪除確認
$sql = "SELECT id, name, dorm_room, phone FROM resident WHERE id=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt,$sql);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$id,$name,$dorm_room,$phone);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

<div class="container my-4">
    <h3 class="mb-3">刪除確認</h3>
    <p>請確認是否要刪除以下住民資料：</p>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>房號</th>
                <th>電話</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$id?></td>
                <td><?=$name?></td>
                <td><?=$dorm_room?></td>
                <td><?=$phone?></td>
            </tr>
        </tbody>
    </table>

    <a href="resident_delete.php?id=<?=$id?>&action=confirmed" class="btn btn-danger">刪除</a>
    <a href="residents.php" class="btn btn-secondary">取消</a>
</div>

<?php include("footer.php"); ?>
