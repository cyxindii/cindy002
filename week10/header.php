<?php
session_start();

// 取得使用者資料
$user = $_SESSION['user'] ?? null;
$is_admin = isset($user['role']) && $user['role'] === 'M'; // M = 管理員
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? '宿舍系統' ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="custom.css">
<style>
/* 方塊按鈕 */
.menu-card {
    display: block;
    padding: 30px 20px;
    text-align: center;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    font-size: 20px;
    font-weight: 600;
    color: #333;
    text-decoration: none;
    transition: 0.25s ease;
}
.menu-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.18);
}
.custom-bg {
    background-color: #4b72ff;
}
.navbar-brand, .nav-link {
    color: white !important;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg custom-bg">
  <div class="container">
    <a class="navbar-brand" href="index.php">宿舍系統</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <?php if($user): ?>

          <?php if($is_admin): ?>
             <!-- 管理員選單 -->
          <li class="nav-item"><a class="nav-link" href="repair.php">報修單管理</a></li>
          <li class="nav-item"><a class="nav-link" href="activity_admin.php">活動管理</a></li>
          <li class="nav-item"><a class="nav-link" href="drink_list.php">飲料機吃錢紀錄</a></li>
          <?php else: ?>
            <!-- 學生選單 -->
          <li class="nav-item"><a class="nav-link" href="repair.php">報修單登記</a></li>
          <li class="nav-item"><a class="nav-link" href="activity.php">活動列表</a></li>
          <li class="nav-item"><a class="nav-link" href="drink_form.php">飲料機吃錢登記</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="logout.php">登出</a></li>

        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
