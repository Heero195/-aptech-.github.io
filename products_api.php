<?php
// products_api.php
include 'D:\dts\doan1newdashboard (1)\doan1newdashboard\doan1newdashboard\doan1\db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM product ORDER BY product_id DESC");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
        break;

    case 'POST':
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];

        $uploadDir = __DIR__ . '/../../../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $target = $uploadDir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $stmt = $pdo->prepare("INSERT INTO product (name, type, price, images, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $type, $price, basename($image), $description]);
        echo json_encode(['message' => 'Product added successfully']);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        $id = $data['id'];
        $stmt = $pdo->prepare("DELETE FROM product WHERE product_id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Product deleted successfully']);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $data);
        $id = $data['id'];
        $name = $data['name'];
        $type = $data['type'];
        $price = $data['price'];
        $description = $data['description'];

        $stmt = $pdo->prepare("UPDATE product SET name = ?, type = ?, price = ?, description = ? WHERE product_id = ?");
        $stmt->execute([$name, $type, $price, $description, $id]);
        echo json_encode(['message' => 'Product updated successfully']);
        break;
}
