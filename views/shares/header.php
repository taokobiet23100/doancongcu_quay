<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();
// Bắt đầu session để kiểm tra trạng thái đăng nhập
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thành Tâm Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .header {
            background-color: gold;
            padding: 10px 0;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .contact-number {
            background-color: #ff4d4d;
            color: white;
            border-radius: 20px;
            padding: 10px 15px;
            font-weight: bold;
            margin-right: 20px;
        }
        .navbar-nav .nav-link {
            color: black;
            margin-right: 20px;
        }
        .navbar-nav .nav-link:hover {
            color: darkorange;
        }
        .search-bar {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .search-bar input {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand logo" href="/DoAnPHP/index.php">THÀNH TÂM MUSIC</a>
            <div class="contact-number">0967.518.158</div>
            <div class="navbar-nav ml-auto">
               <?php if (isset($_SESSION['user'])): ?>
    <!-- Dropdown nếu đã đăng nhập -->
    <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
            <?php echo htmlspecialchars($_SESSION['user']['hoTen']); ?>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/DoAnPHP/views/shares/user_detail.php">Chi tiết tài khoản</a>
            <a class="dropdown-item text-danger" href="/DoAnPHP/views/shares/logout.php">Đăng xuất</a>
        </div>
    </div>

    <?php if ($_SESSION['user']['vaiTro'] == 'admin'): ?>
        <a class="nav-link" href="/DoAnPHP/views/admin/user.php">Quản lý người dùng</a>
        <a class="nav-link" href="/DoAnPHP/views/admin/instrument.php">Quản lý nhạc cụ</a>
        <a class="nav-link" href="/DoAnPHP/views/admin/order.php">Quản lý đơn hàng</a>
    <?php endif; ?>

<?php else: ?>
    <!-- Nút đăng nhập nếu chưa đăng nhập -->
    <a class="nav-link" href="/DoAnPHP/views/shares/login.php">Đăng nhập</a>
<?php endif; ?>

<a class="nav-link" href="#">Giỏ Hàng</a>

            </div>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/DoAnPHP/views/shares/guitar.php">Đàn Guitar</a></li>
                    <li class="nav-item"><a class="nav-link" href="/DoAnPHP/views/shares/organ.php">Đàn Organ</a></li>
                    <li class="nav-item"><a class="nav-link" href="/DoAnPHP/views/shares/piano.php">Đàn Piano</a></li>
                    <li class="nav-item"><a class="nav-link" href="/DoAnPHP/views/shares/ukulele.php">Đàn Ukulele</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Phụ Kiện</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Khóa Học</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
