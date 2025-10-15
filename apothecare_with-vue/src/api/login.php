<?php
header("Access-Control-Allow-Origin: *"); // allow any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include __DIR__ . '/../config.php';

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

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
    echo json_encode(['success' => false, 'message' => 'Fout bij inloggen: ' . $e->getMessage()]);
}
?>