<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/db.php'; // kết nối database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $matKhau = $_POST['matKhau'] ?? '';

    if (empty($email) || empty($matKhau)) {
        $_SESSION['message'] = 'Email và mật khẩu là bắt buộc!';
        $_SESSION['message_type'] = 'danger';
        header('Location: login.php');
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM nguoidung WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['message'] = 'Email không tồn tại!';
            $_SESSION['message_type'] = 'danger';
            header('Location: login.php');
            exit;
        }

        if (!password_verify($matKhau, $user['matKhau'])) {
            $_SESSION['message'] = 'Mật khẩu không đúng!';
            $_SESSION['message_type'] = 'danger';
            header('Location: login.php');
            exit;
        }

        $_SESSION['user'] = $user;
        $_SESSION['message'] = $user['role'] === 'admin' ? 'Đăng nhập thành công với quyền ADMIN!' : 'Đăng nhập thành công!';
        $_SESSION['message_type'] = 'success';
        header('Location: /DoAnPHP/index.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Lỗi đăng nhập: ' . $e->getMessage();
        $_SESSION['message_type'] = 'danger';
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Thành Tâm Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .btn-login {
            background-color: gold;
            color: black;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: darkorange;
        }
        .footer {
            text-align: center;
            padding: 10px;
            margin-top: 30px;
            background-color: gold;
            color: black;
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container">
    <div class="login-container">
        <h2>Đăng Nhập</h2>

        <!-- Hiển thị thông báo nếu có -->
        <?php if (isset($_SESSION['message'])): ?>
            <div id="popup-message" class="alert alert-<?php echo $_SESSION['message_type'] === 'success' ? 'success' : 'danger'; ?>">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="matKhau" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login btn-block">Đăng nhập</button>
        </form>
        <p class="text-center mt-3">Chưa có tài khoản? <a href="/DoAnPHP/views/shares/register.php">Đăng ký</a></p>
    </div>
</div>

<div class="footer">
    &copy; 2025 Thành Tâm Music - Tất cả quyền được bảo lưu
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Hiển thị popup nếu có thông báo
        if ($('#popup-message').length) {
            alert($('#popup-message').text());
        }
    });
</script>

</body>
</html>
