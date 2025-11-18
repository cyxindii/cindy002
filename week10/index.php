<?php
$title = "宿舍系統首頁";
include("header.php");
?>

<div class="container my-5">
    <h2>歡迎來到宿舍系統</h2>
    <?php if(isset($_SESSION['user'])): ?>
        <p>您好，<?=htmlspecialchars($_SESSION['user']['name'])?>！</p>
        <ul>
            <li><a href="residents.php">住民管理</a></li>
            <li><a href="repair.php">報修單</a></li>
            <li><a href="activity.php">活動管理</a></li>
        </ul>
    <?php else: ?>
        <p>請先 <a href="login.php">登入</a> 才能使用系統功能</p>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>

