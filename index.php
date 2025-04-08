<?php
// index.php - Trang chủ hiển thị danh sách tất cả nhạc cụ
include __DIR__ . '/views/shares/header.php'; // Gọi header

$apiUrl = 'http://localhost/DoAnPHP/controller/InstrumentController.php';
$response = file_get_contents($apiUrl);
$instruments = json_decode($response, true);
?>
<div class="container">
    <!-- Slider -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./images/slider/slide1.jpg" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="./images/slider/slide_2.jpg" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="./images/slider/slide3.jpg" class="d-block w-100" alt="Slide 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Thêm thẻ sản phẩm -->
    <h2 class="text-center my-4">Sản Phẩm</h2>
</div>

<div class="container">
    <div class="row">
        <?php if (!empty($instruments) && is_array($instruments)): ?>
            <?php foreach ($instruments as $instrument): ?>
                <div class="col-md-4">
                    <div class="card mb-4" style="height: 100%;">
                        <img src="<?php echo $instrument['hinhAnh']; ?>" class="card-img-top" alt="<?php echo $instrument['ten']; ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $instrument['ten']; ?></h5>
                            <p class="card-text">Xuất xứ: <?php echo $instrument['xuatXu']; ?></p>
                            <p class="card-text">Hãng: <?php echo $instrument['hang']; ?></p>
                            <p class="card-text">Giá: <?php echo number_format($instrument['giaThanh'], 2); ?> VND</p>
                            <div class="card-footer text-center">
                                <a href="/DoAnPHP/views/shares/profile.php?ma=<?php echo htmlspecialchars($instrument['ma'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Xem Chi Tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có nhạc cụ nào.</p>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/views/shares/footer.php'; // Gọi footer ?>