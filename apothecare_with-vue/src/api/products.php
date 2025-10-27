<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include __DIR__ . '/../config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    if ($action === 'list') {
        // Bestaande GET list code...
        $stmt = $pdo->query("SELECT product_id, name, category, price, grams, image_url FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'products' => $products]);
        exit;
    }

    if ($action === 'add') {
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $price = $_POST['price'] ?? 0;
        $grams = $_POST['grams'] ?? 0;
        $image_url = $_POST['image_url'] ?? '';

        if (!$name || !$category) {
            echo json_encode(['success' => false, 'message' => 'Naam en categorie verplicht']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO products (name, category, price, grams, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $category, $price, $grams, $image_url]);
        echo json_encode(['success' => true, 'message' => 'Product toegevoegd']);
        exit;
    }

    if ($action === 'update') {
        $id = $_POST['product_id'] ?? 0;
        $name = $_POST['name'] ?? '';
        // ... andere velden

        $stmt = $pdo->prepare("UPDATE products SET name = ?, category = ?, price = ?, grams = ?, image_url = ? WHERE product_id = ?");
        $stmt->execute([$name, $_POST['category'], $_POST['price'], $_POST['grams'], $_POST['image_url'], $id]);
        echo json_encode(['success' => true, 'message' => 'Product bijgewerkt']);
        exit;
    }

    if ($action === 'delete') {
        $id = $_POST['product_id'] ?? 0;
        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Product verwijderd']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Ongeldige actie']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>