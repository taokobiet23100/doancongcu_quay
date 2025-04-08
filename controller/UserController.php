<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
// controller/InstrumentController.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php'; // Kết nối database

try {
    
        $stmt = $pdo->prepare("SELECT * FROM nguoidung");
    

    $stmt->execute();
    $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($instruments);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
}
