<?php
$title = "登入";
include('header.php');
require_once 'db.php';

$error = '';
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $account = mysqli_real_escape_string($conn, $_POST["account"] ?? '');
    $password = mysqli_real_escape_string($conn, $_POST["password"] ?? '');
    $role_type = $_POST["role_type"] ?? 'user'; // 從下拉選單取得身份

    if ($role_type === 'user') {
        // 管理員登入 user 表
        $sql = "SELECT id, account, password, name, role FROM user WHERE account='$account'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if ($password === $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'account' => $user['account'],
                    'name' => $user['name'],
                    'role' => $user['role']
                ];
                header("Location: $redirect");
                exit;
            } else {
                $error = "帳號或密碼錯誤";
            }
        } else {
            $error = "帳號或密碼錯誤";
        }
    } else {
        // 住民登入 residents 表
        $sql = "SELECT id, account, password, name, room_number, role FROM residents WHERE account='$account'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if ($password === $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'account' => $user['account'],
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'room_number' => $user['room_number']
                ];
                header("Location: $redirect");
                exit;
            } else {
                $error = "帳號或密碼錯誤";
            }
        } else {
            $error = "帳號或密碼錯誤";
        }
    }
}
mysqli_close($conn);
?>

<div class="container my-5">
    <h2>登入</h2>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label class="form-label">身份</label>
            <select name="role_type" class="form-select mb-2">
                <option value="user">管理員</option>
                <option value="resident">住民</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">帳號</label>
            <input type="text" name="account" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">密碼</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">登入</button>
    </form>
    <?php if($error): ?>
        <div class="alert alert-danger mt-3"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
