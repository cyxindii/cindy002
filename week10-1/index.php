<?php
$title = "宿舍系統首頁";
include("header.php");
?>

<div class="container my-5">
    <h2 class="mb-4">歡迎來到宿舍系統</h2>

    <?php if(isset($_SESSION['user'])): 
        $user = $_SESSION['user'];
        $is_admin = $user['role'] === 'M'; // 管理員判斷
    ?>
    
    <p>您好，<strong><?=htmlspecialchars($user['name'])?></strong>！</p>

    <div class="row g-4">
        <?php if($is_admin): ?>
            <div class="col-md-6">
                <a href="repair.php" class="menu-card">報修單管理</a>
            </div>
            <div class="col-md-6">
                <a href="activity_admin.php" class="menu-card">活動管理</a> <!-- 連到活動管理頁 -->
            </div>
        <?php else: ?>
            <div class="col-md-6">
                <a href="repair.php" class="menu-card">報修單</a>
            </div>
            <div class="col-md-6">
                <a href="activity.php" class="menu-card">活動</a>
            </div>
        <?php endif; ?>
    </div>

    <?php else: ?>
        <p>請先 <a href="login.php">登入</a> 才能使用系統功能</p>
    <?php endif; ?>
</div>

<style>
.menu-card {
    display: block;
    text-align: center;
    padding: 40px 20px;
    background-color: #204080;
    color: #fff;
    font-size: 1.2rem;
    border-radius: 12px;
    text-decoration: none;
    transition: 0.3s;
}
.menu-card:hover {
    background-color: #1a3666;
    transform: translateY(-5px);
}
</style>

<?php include("footer.php"); ?>
