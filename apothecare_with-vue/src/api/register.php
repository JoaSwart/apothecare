<?php
header("Access-Control-Allow-Origin: *"); // allow any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include __DIR__ . '/../config.php';

// Get raw JSON from Vue
$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$name || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Alle velden zijn verplicht']);
    exit;
}

// Hash password
$hashed = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashed]);
    echo json_encode(['success' => true, 'message' => 'Registratie succesvol!']);
} catch (PDOException $e) {
    // duplicate email or other error
    echo json_encode(['success' => false, 'message' => 'Fout bij registratie: ' . $e->getMessage()]);
}
?>