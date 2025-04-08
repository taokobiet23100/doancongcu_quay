<?php
// db.php
$host = '127.0.0.1';
$db = 'webbandan';
$user = 'root';  // Thay đổi username nếu cần
$pass = '';      // Thay đổi mật khẩu nếu cần

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>