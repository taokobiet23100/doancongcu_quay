<?php
// profile.php - Xem chi tiết sản phẩm
include __DIR__ . '/header.php';

$ma = isset($_GET['ma']) ? intval($_GET['ma']) : 0;
$response = file_get_contents("http://localhost/DoAnPHP/controller/InstrumentController.php?ma=$ma");

if ($response === false) {
    echo "<div class='container'><h2 class='text-center'>Không thể kết nối đến API</h2></div>";
    include __DIR__ . '/views/shares/footer.php';
    exit;
}

$product = json_decode($response, true);

// Kiểm tra xem sản phẩm có tồn tại không
if (!$product || !isset($product['ma'])) {
    echo "<div class='container'><h2 class='text-center'>Sản phẩm không tồn tại</h2></div>";
    include __DIR__ . '/views/shares/footer.php';
    exit;
}
?>

<div class="container my-4">
    <h2 class="text-center"><?php echo htmlspecialchars($product['ten'] ?? 'Chưa có tên', ENT_QUOTES, 'UTF-8'); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($product['hinhAnh'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['ten'] ?? 'Hình ảnh sản phẩm', ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="col-md-6">
            <h5>Thông Tin Chi Tiết</h5>
            <p><strong>Xuất xứ:</strong> <?php echo htmlspecialchars($product['xuatXu'] ?? 'Chưa có thông tin', ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Hãng:</strong> <?php echo htmlspecialchars($product['hang'] ?? 'Chưa có thông tin', ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Giá:</strong> <?php echo number_format((float)($product['giaThanh'] ?? 0), 2); ?> VND</p>
            <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($product['moTa'] ?? 'Chưa có mô tả', ENT_QUOTES, 'UTF-8'); ?></p>
            
            <!-- Thêm phần nhập số lượng và nút thêm giỏ hàng -->
            <div class="input-group mb-3">
                <span class="input-group-text">Số lượng</span>
                <input type="number" class="form-control" id="quantity" value="1" min="1" max="100">
            </div>
            <div class="text-center">
                <button class="btn btn-success" onclick="addToCart(<?php echo $product['ma']; ?>)">Thêm vào giỏ hàng</button>
                <a href="/DoAnPHP/index.php" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
</div>

<!-- Thêm phần thông tin cửa hàng -->
<div class="container my-4">
    <h4>Danh sách cửa hàng</h4>
    <ul>
        <li>230/13 Tân Kỳ Tân Quý, phường Sơn Kỳ, quận Tân Phú</li>
        <li>99 Võ Thành Trang, phường 11, quận Tân Bình</li>
    </ul>
    
    <h4>Vì sao chọn Thành Tâm Music</h4>
    <ul>
        <li>✔ Sản phẩm chính hãng 100%</li>
        <li>✔ Cam kết giá rẻ nhất thị trường</li>
        <li>✔ Bảo hành tại các chi nhánh của Thành Tâm Music</li>
        <li>✔ Giao hàng nhanh chóng trong 2H (nội thành TPHCM)</li>
        <li>✔ Shop dần uy tín trên 10 năm</li>
    </ul>
</div>

<?php include __DIR__ . '/views/shares/footer.php'; // Gọi footer ?>

<script>
function addToCart(productId) {
    var quantity = document.getElementById('quantity').value;

    // Gửi yêu cầu Ajax để thêm sản phẩm vào giỏ hàng
    fetch('http://localhost/DoAnPHP/controller/CartController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: productId, quantity: quantity }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // In ra phản hồi từ server
        if (data.success) {
            // Chuyển hướng ngay đến trang giỏ hàng
            window.location.href = '/DoAnPHP/views/shares/giohang.php';
        } else {
            alert('Có lỗi xảy ra: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại.');
    });
}
</script>