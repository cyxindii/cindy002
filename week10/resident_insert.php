<?php
$title = "新增住民";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if(!$user || $user['role'] !== 'M'){
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

$msg = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? "");
    $dorm_room = mysqli_real_escape_string($conn, $_POST['dorm_room'] ?? "");
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? "");

    if($name){
        $sql = "INSERT INTO resident (name,dorm_room,phone) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"sss",$name,$dorm_room,$phone);
        $res = mysqli_stmt_execute($stmt);
        $msg = $res ? "<div class='alert alert-success'>新增成功</div>" : "<div class='alert alert-danger'>新增失敗</div>";
    } else {
        $msg = "<div class='alert alert-warning'>姓名為必填</div>";
    }
}
?>

<div class="container my-4">
    <h2>新增住民</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">姓名</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">房號</label>
            <input type="text" name="dorm_room" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">電話</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">新增</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
