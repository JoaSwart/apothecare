<?php
// ==== CORS ====
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Alleen POST']);
    exit;
}

// ==== INPUT ====
$raw = file_get_contents('php://input');
$postData = $_POST;
if (!empty($raw)) {
    $json = json_decode($raw, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $postData = array_merge($postData, $json);
    }
}
$vraag = trim($postData['vraag'] ?? '');
if ($vraag === '') {
    echo json_encode(['success' => false, 'message' => 'Vraag leeg']);
    exit;
}

// ==== SYSTEM PROMPT (RELAXED & VEILIG) ====
$system_prompt = <<<EOT
Je bent ApotheCare Bot, een vriendelijke apotheek-assistent van ApotheCare.nl.
Je helpt volwassenen (18+) met medicijnen, dosering, bijwerkingen, openingstijden en bezorging.

REGELS:
- Antwoord kort en duidelijk in normaal Nederlands.
- Geef standaarddosering voor volwassenen als het veilig is.
- Zeg altijd: "Volg de bijsluiter."
- Alleen "raadpleeg apotheker" bij:
  - kinderen, zwangeren, lever/nierproblemen
  - meer dan 3 dagen gebruik
  - combinatie met andere medicijnen
- Paracetamol is vrij verkrijgbaar.

VOORBEELD (volg dit format!):
Vraag: Hoeveel paracetamol mag ik als ik 22 ben?
Antwoord: Voor volwassenen: 500-1000 mg per keer, maximaal 4x per dag (4000 mg). Volg de bijsluiter.
EOT;

// ==== API: /api/chat (NIET /api/generate!) ====
$url = 'http://localhost:11434/api/chat';

$payload = [
    'model' => 'llama3.2:3b',
    'messages' => [
        ['role' => 'system', 'content' => $system_prompt],
        // Few-shot voorbeeld (forceert correct gedrag)
        ['role' => 'user', 'content' => 'Hoeveel paracetamol mag ik als ik 25 ben?'],
        ['role' => 'assistant', 'content' => 'Voor volwassenen: 500-1000 mg per keer, maximaal 4x per dag (4000 mg). Volg de bijsluiter.'],
        // Echte vraag
        ['role' => 'user', 'content' => $vraag]
    ],
    'stream' => false,
    'options' => ['temperature' => 0.6]
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($payload),
        'timeout' => 60
    ]
]);

$response = @file_get_contents($url, false, $context);
if ($response === false) {
    echo json_encode(['success' => false, 'message' => 'Ollama niet bereikbaar']);
    exit;
}

$data = json_decode($response, true);
if (!isset($data['message']['content'])) {
    echo json_encode(['success' => false, 'message' => 'Fout in antwoord', 'raw' => $response]);
    exit;
}

$antwoord = trim($data['message']['content']);

echo json_encode([
    'success' => true,
    'vraag' => $vraag,
    'antwoord' => $antwoord
]);
exit;
?>