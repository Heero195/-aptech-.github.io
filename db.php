<?php

$host = 'localhost'; // Địa chỉ máy chủ MySQL
$dbname = 'snowell_electric'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên người dùng MySQL
$password = ''; // Mật khẩu MySQL

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Bật chế độ báo lỗi
    // echo "Database connection successful!";
} catch (PDOException $e) {
    // Xử lý lỗi kết nối
    die("Database connection failed: " . $e->getMessage());
}
?>