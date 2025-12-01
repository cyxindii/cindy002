<?php
$servername = "localhost";
$dbname = "project";  // 改成你目前的資料庫名稱
$dbUsername = "root"; // 預設 XAMPP root
$dbPassword = "";     // 如果 root 沒密碼就留空

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbname,3307 );


if (!$conn) {
    die("連線失敗: " . mysqli_connect_error());
}
// echo "連線成功!";
?>
