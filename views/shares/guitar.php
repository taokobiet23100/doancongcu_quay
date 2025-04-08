<?php
// guitar.php - Hiển thị danh sách Guitar (loaiDan_id = 3)
include __DIR__ . '/header.php';
$apiUrl = 'http://localhost/DoAnPHP/controller/InstrumentController.php?loaiDan_id=3';
$response = file_get_contents($apiUrl);
$instruments = json_decode($response, true);
?>

<div class="container my-4">
    <h2 class="text-center">Danh Sách Guitar</h2>
    <div class="row">
        <?php foreach ($instruments as $instrument): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?php echo $instrument['hinhAnh']; ?>" class="card-img-top" alt="<?php echo $instrument['ten']; ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $instrument['ten']; ?></h5>
                        <p class="card-text">Giá: <?php echo number_format($instrument['giaThanh'], 2); ?> VND</p>
                        <a href="/DoAnPHP/views/shares/profile.php?ma=<?php echo htmlspecialchars($instrument['ma'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>