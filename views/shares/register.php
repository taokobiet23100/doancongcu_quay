<?php
require_once __DIR__ . '/../../config/db.php'; // Kết nối database

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ request
    $hoTen = $_POST['hoTen'] ?? null;
    $email = $_POST['email'] ?? null;
    $matKhau = $_POST['matKhau'] ?? null;
    $soDienThoai = $_POST['soDienThoai'] ?? null;
    $diaChi = $_POST['diaChi'] ?? null;
    $phuongThucThanhToan = $_POST['phuongThucThanhToan'] ?? null;

    if (!$email || !$matKhau) {
        $error = 'Email và mật khẩu là bắt buộc';
    } else {
        try {
            // Kiểm tra nếu email đã tồn tại
            $stmt = $pdo->prepare("SELECT * FROM nguoidung WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                $error = 'Email đã tồn tại';
            } else {
                // Mã hóa mật khẩu
                $matKhauHash = password_hash($matKhau, PASSWORD_BCRYPT);

                // Thực hiện insert vào database
                $stmt = $pdo->prepare("INSERT INTO nguoidung (hoTen, email, matKhau, soDienThoai, diaChi, phuongThucThanhToan) 
                                       VALUES (:hoTen, :email, :matKhau, :soDienThoai, :diaChi, :phuongThucThanhToan)");
                $stmt->execute([
                    'hoTen' => $hoTen,
                    'email' => $email,
                    'matKhau' => $matKhauHash,
                    'soDienThoai' => $soDienThoai,
                    'diaChi' => $diaChi,
                    'phuongThucThanhToan' => $phuongThucThanhToan
                ]);

                $success = 'Đăng ký thành công';
            }
        } catch (PDOException $e) {
            $error = 'Lỗi đăng ký: ' . $e->getMessage();
        }
    }

    
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Thành Tâm Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .register-container {
            max-width: 500px;
            margin: 60px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .btn-register {
            background-color: gold;
            color: black;
            font-weight: bold;
        }
        .btn-register:hover {
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
    <div class="register-container">
        <h2>Đăng Ký</h2>
        <?php if (isset($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
        <form method="post">
            <div class="form-group">
                <label>Họ và Tên:</label>
                <input type="text" name="hoTen" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="soDienThoai" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Địa chỉ:</label>
                <input type="text" name="diaChi" class="form-control">
            </div>
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="matKhau" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Xác nhận mật khẩu:</label>
                <input type="password" name="xacNhanMatKhau" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-register btn-block">Đăng ký</button>
        </form>
        <p class="text-center mt-3">Đã có tài khoản? <a href="/DoAnPHP/views/shares/login.php">Đăng nhập</a></p>
    </div>
</div>

<div class="footer">
    &copy; 2025 Thành Tâm Music - Tất cả quyền được bảo lưu
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
