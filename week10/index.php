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
            <!-- 報修單管理 -->
            <div class="col-md-4">
                <a href="repair.php" class="menu-card">報修單管理</a>
            </div>

            <!-- 活動管理 -->
            <div class="col-md-4">
                <a href="activity_admin.php" class="menu-card">活動管理</a>
            </div>

            <!-- ⭐ 管理員查看飲料機吃錢紀錄 -->
            <div class="col-md-4">
                <a href="drink_list.php" class="menu-card">飲料機吃錢紀錄</a>
            </div>

        <?php else: ?>

            <!-- 報修單 -->
            <div class="col-md-4">
                <a href="repair.php" class="menu-card">報修單</a>
            </div>

            <!-- 活動 -->
            <div class="col-md-4">
                <a href="activity.php" class="menu-card">活動</a>
            </div>

            <!-- ⭐ 住民登記飲料機吃錢 -->
            <div class="col-md-4">
                <a href="drink_form.php" class="menu-card">飲料機吃錢登記</a>
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
