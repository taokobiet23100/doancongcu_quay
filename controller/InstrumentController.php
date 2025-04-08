<?php
// controller/InstrumentController.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php'; // Kết nối database

try {
    if (isset($_GET['ma'])) {
    $ma = (int) $_GET['ma'];
    $stmt = $pdo->prepare("SELECT * FROM instrument WHERE ma = :ma");
    $stmt->bindParam(':ma', $ma, PDO::PARAM_INT);
    $stmt->execute();
    $instrument = $stmt->fetch(PDO::FETCH_ASSOC); // Lấy sản phẩm

    if ($instrument) {
        echo json_encode($instrument); // Trả về sản phẩm nếu tìm thấy
    } else {
        echo json_encode(null); // Không tìm thấy sản phẩm
    }
}else {
        // Lấy theo loaiDan_id hoặc toàn bộ
        $loaiDanId = isset($_GET['loaiDan_id']) ? (int) $_GET['loaiDan_id'] : 0;

        if ($loaiDanId > 0) {
            $stmt = $pdo->prepare("SELECT * FROM instrument WHERE loaiDan_id = :loaiDan_id");
            $stmt->bindParam(':loaiDan_id', $loaiDanId, PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM instrument");
        }

        $stmt->execute();
        $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($instruments);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
}
?>