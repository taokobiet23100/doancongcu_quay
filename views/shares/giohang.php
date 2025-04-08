<?php
// giohang.php - Trang giỏ hàng
session_start();
include __DIR__ . '/header.php';

// Giả định user_id được lưu trong session khi đăng nhập
$user_id = $_SESSION['user_id'] ?? null;
$apiUrl = 'http://localhost/DoAnPHP/controller/UserController.php?user_id=' . $user_id;
$userData = json_decode(file_get_contents($apiUrl), true);

// Giả định giỏ hàng lưu trong session
$cart = $_SESSION['cart'] ?? [];

// Tính tổng giá trị giỏ hàng
$total = 0;
foreach ($cart as $item) {
    $total += $item['giaThanh'] * ($item['quantity'] ?? 1); // Giả định quantity có trong giỏ hàng
}
?>

<h1 class="text-center my-4">Giỏ Hàng</h1>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Danh sách sản phẩm</h3>
            <?php if (!empty($cart)): ?>
                <ul class="list-group">
                    <?php foreach ($cart as $index => $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <?php if (!empty($item['hinhAnh'])): ?>
                                    <img src="<?php echo htmlspecialchars($item['hinhAnh']); ?>" alt="<?php echo htmlspecialchars($item['ten']); ?>" class="img-thumbnail me-3" style="width: 170px; height: auto;">
                                <?php endif; ?>
                                <div>
                                    <strong><?php echo htmlspecialchars($item['ten']); ?></strong><br>
                                    <span>Số lượng:</span>
                                    <div class="input-group" style="width: 120px;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(<?php echo $index; ?>, -1)">-</button>
                                        <input type="number" class="form-control text-center" id="quantity-<?php echo $index; ?>" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" max="100" onchange="updateTotal(<?php echo $index; ?>)">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(<?php echo $index; ?>, 1)">+</button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="fw-bold"><?php echo number_format($item['giaThanh'], 2); ?> VND</span>
                                <form method="POST" action="remove_from_cart.php" style="display:inline;">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm ms-3">Xóa</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <h4 class="mt-3">Tổng Giá Trị: <span class="fw-bold"><?php echo number_format($total, 2); ?> VND</span></h4>
            <?php else: ?>
                <p class="text-muted">Giỏ hàng trống.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <h3>Thông Tin Giao Hàng</h3>
            <form action="process_order.php" method="POST">
                <div class="mb-3">
                    <label>Họ Tên:</label>
                    <input type="text" name="hoTen" value="<?php echo htmlspecialchars($userData['hoTen'] ?? ''); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" class="form-control" required readonly>
                </div>
                <div class="mb-3">
                    <label>Số Điện Thoại:</label>
                    <input type="text" name="soDienThoai" value="<?php echo htmlspecialchars($userData['soDienThoai'] ?? ''); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Địa Chỉ Giao Hàng:</label>
                    <input type="text" name="diaChi" value="<?php echo htmlspecialchars($userData['diaChi'] ?? ''); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Phương Thức Thanh Toán:</label>
                    <select name="phuongThucThanhToan" class="form-control">
                        <option value="COD" <?php echo ($userData['phuongThucThanhToan'] == 'COD') ? 'selected' : ''; ?>>Thanh toán khi nhận hàng</option>
                        <option value="Chuyển khoản" <?php echo ($userData['phuongThucThanhToan'] == 'Chuyển khoản') ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-3">Thanh Toán</button>
            </form>
        </div>
    </div>
</div>

<script>
function changeQuantity(index, delta) {
    const quantityInput = document.getElementById(`quantity-${index}`);
    let currentQuantity = parseInt(quantityInput.value) || 1; // Lấy giá trị hiện tại, mặc định là 1 nếu không hợp lệ
    currentQuantity += delta; // Thay đổi số lượng theo delta
    if (currentQuantity < 1) currentQuantity = 1; // Đảm bảo số lượng không dưới 1
    quantityInput.value = currentQuantity; // Cập nhật giá trị số lượng
}

function updateTotal(index) {
    const quantityInput = document.getElementById(`quantity-${index}`);
    let currentQuantity = parseInt(quantityInput.value) || 1; // Lấy giá trị hiện tại
    // Cập nhật giá trị trong giỏ hàng nếu cần thiết
    // Có thể thêm logic để cập nhật tổng giá trị trong giỏ hàng nếu cần
}
</script>

<?php include __DIR__ . '/footer.php'; ?>