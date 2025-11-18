<?php
$title = "修改住民資料";
include("header.php");
require_once "db.php";

$user = $_SESSION['user'] ?? null;
if(!$user || $user['role'] !== 'M'){
    echo "<div class='alert alert-danger'>您沒有權限操作此頁面</div>";
    exit;
}

// 取得住民 id
$id = (int)($_GET['id'] ?? 0);
if($id <= 0){
    echo "<div class='alert alert-danger'>無效的住民 ID</div>";
    exit;
}

// 讀取現有資料
$sql = "SELECT name, dorm_room, phone FROM resident WHERE id=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt,$sql);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt,$name,$dorm_room,$phone);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$msg = "";

// 處理表單送出
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $new_name = mysqli_real_escape_string($conn,$_POST['name'] ?? "");
    $new_dorm = mysqli_real_escape_string($conn,$_POST['dorm_room'] ?? "");
    $new_phone = mysqli_real_escape_string($conn,$_POST['phone'] ?? "");

    if($new_name){
        $sql = "UPDATE resident SET name=?, dorm_room=?, phone=? WHERE id=?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"sssi",$new_name,$new_dorm,$new_phone,$id);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if($res){
            $msg = "<div class='alert alert-success'>修改成功</div>";
            $name = $new_name;
            $dorm_room = $new_dorm;
            $phone = $new_phone;
        } else {
            $msg = "<div class='alert alert-danger'>修改失敗</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>姓名為必填</div>";
    }
}
?>

<div class="container my-4">
    <h2>修改住民資料</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">姓名</label>
            <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($name)?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">房號</label>
            <input type="text" name="dorm_room" class="form-control" value="<?=htmlspecialchars($dorm_room)?>">
        </div>
        <div class="mb-3">
            <label class="form-label">電話</label>
            <input type="text" name="phone" class="form-control" value="<?=htmlspecialchars($phone)?>">
        </div>
        <button type="submit" class="btn btn-primary">送出修改</button>
        <?=$msg?>
    </form>
</div>

<?php
mysqli_close($conn);
include("footer.php");
?>
