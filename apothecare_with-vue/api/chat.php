<?php
// CORS headers for Vue dev server
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// DEV error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Make sure request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Alleen POST is toegestaan']);
    exit;
}

// Get the "vraag" from POST
$vraag = $_POST['vraag'] ?? '';
if (!$vraag) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);
    if (json_last_error() === JSON_ERROR_NONE && !empty($json['vraag'])) {
        $vraag = trim($json['vraag']);
    }
}

if (!$vraag) {
    echo json_encode(['success' => false, 'message' => 'Vraag is leeg']);
    exit;
}

// Path to Ollama executable
$ollama_path = 'C:\\Users\\xxsha\\AppData\\Local\\Programs\\Ollama\\ollama.exe';
if (!file_exists($ollama_path)) {
    echo json_encode(['success' => false, 'message' => 'Ollama executable niet gevonden']);
    exit;
}

// Escape input safely
$escapedVraag = escapeshellarg($vraag);

// Build command
$cmd = '"' . $ollama_path . '" run mistral:instruct ' . $escapedVraag . ' 2>&1';

// Execute command
$output = shell_exec($cmd);
$antwoord = $output !== null ? trim($output) : "ERROR: Ollama returned nothing";

// Wrap in old HTML formatting
$antwoord_html = '<p><strong>Jij:</strong> ' . htmlspecialchars($vraag) . '</p>';
$antwoord_html .= '<p><strong>AI:</strong> ' . nl2br(htmlspecialchars($antwoord)) . '</p>';

// Return JSON
echo json_encode([
    'success' => true,
    'vraag' => $vraag,
    'antwoord' => $antwoord_html
]);
exit;
?>