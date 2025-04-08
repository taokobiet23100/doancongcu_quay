<?php
session_start();
session_destroy(); // Hủy toàn bộ session
header("Location: /DoAnPHP/views/shares/login.php"); // Quay lại trang đăng nhập
exit;
?>
