<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Content-Type: application/json");

include __DIR__ . '/../config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? null;

try {
    if ($action === 'delete') {
        $user_id = $_POST['user_id'] ?? null;
        if (!$user_id) throw new Exception("Geen user_id opgegeven");

        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);

        echo json_encode([
            'success' => true,
            'message' => "Gebruiker verwijderd"
        ]);
        exit;
    }

    if ($action === 'update') {
        $user_id = $_POST['user_id'] ?? null;
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;

        if (!$user_id || !$username || !$email) throw new Exception("Onvoldoende gegevens");

        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, phone = ? WHERE user_id = ?");
        $stmt->execute([$username, $email, $phone, $user_id]);

        echo json_encode([
            'success' => true,
            'message' => "Gebruiker bijgewerkt"
        ]);
        exit;
    }

    // Default: fetch users
    $stmt = $pdo->query("SELECT user_id, username, email, phone, registration_date FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'users' => $users
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
