<?php
// details_product.php - Xem chi tiết sản phẩm
include __DIR__ . '/views/shares/header.php'; // Gọi header

// Lấy ID sản phẩm từ URL
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$apiUrl = "http://localhost/DoAnPHP/controller/InstrumentController.php?id=$productId";
$response = file_get_contents($apiUrl);
$instrument = json_decode($response, true);

if (!$instrument) {
    echo "<div class='container'><h2 class='text-center'>Sản phẩm không tồn tại</h2></div>";
    include __DIR__ . '/views/shares/footer.php'; // Gọi footer
    exit;
}
?>

<div class="container my-4">
    <h2 class="text-center"><?php echo $instrument['ten']; ?></h2>
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $instrument['hinhAnh']; ?>" class="img-fluid" alt="<?php echo $instrument['ten']; ?>" style="height: auto;">
        </div>
        <div class="col-md-6">
            <h5>Thông Tin Chi Tiết</h5>
            <p><strong>Xuất xứ:</strong> <?php echo $instrument['xuatXu']; ?></p>
            <p><strong>Hãng:</strong> <?php echo $instrument['hang']; ?></p>
            <p><strong>Giá:</strong> <?php echo number_format($instrument['giaThanh'], 2); ?> VND</p>
            <p><strong>Mô tả:</strong> <?php echo $instrument['moTa']; ?></p>
            <div class="text-center">
                <a href="index.php" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/views/shares/footer.php'; // Gọi footer ?>