<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Alleen POST is toegestaan']);
    exit;
}

// Haal data uit POST
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Alle velden zijn verplicht']);
    exit;
}

// Hash het wachtwoord
$hashed = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $hashed]);
    echo json_encode(['success' => true, 'message' => 'Registratie succesvol!']);
} catch (PDOException $e) {
    // Specifiek checken op duplicate email
    if ($e->getCode() == 23000) {
        echo json_encode(['success' => false, 'message' => 'E-mail is al in gebruik']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Fout bij registratie']);
    }
}
?>