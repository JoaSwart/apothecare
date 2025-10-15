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
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'E-mail en wachtwoord verplicht']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            'success' => true,
            'message' => 'Login succesvol',
            'user_id' => $user['user_id'],
            'username' => $user['username'],
            'is_admin' => (bool)$user['is_admin']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ongeldige inloggegevens']);
    }
} catch (PDOException $e) {
    // Geef geen raw DB errors
    echo json_encode(['success' => false, 'message' => 'Fout bij inloggen']);
}
?>
