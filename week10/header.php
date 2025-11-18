<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? '宿舍系統' ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="custom.css">
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
        <?php if(isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="residents.php">住民管理</a></li>
          <li class="nav-item"><a class="nav-link" href="repair.php">報修單</a></li>
          <li class="nav-item"><a class="nav-link" href="activity.php">活動</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">登出</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
