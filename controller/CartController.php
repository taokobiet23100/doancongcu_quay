<?php
session_start();
error_reporting(E_ALL); // Bật tất cả các thông báo lỗi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && isset($data['quantity'])) {
        $productId = $data['id'];
        $quantity = (int)$data['quantity'];

        $product = getProductById($productId);

        if ($product) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;  // Khởi tạo biến $found với giá trị false
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['ma'] == $productId) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $product['quantity'] = $quantity;
                $_SESSION['cart'][] = $product;
            }

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
}

function getProductById($id) {
    try {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=webbandan', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM instrument WHERE ma = :ma");
        $stmt->bindParam(':ma', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi cơ sở dữ liệu: ' . $e->getMessage()]);
        exit;
    }
}
?>