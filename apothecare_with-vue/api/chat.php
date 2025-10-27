<?php
// ==== CORS (Vue dev) ====
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Alleen POST toegestaan']);
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
    echo json_encode(['success' => false, 'message' => 'Vraag is leeg']);
    exit;
}

// ==== 1. OPTIONAL: exact FAQ match ====
$faqFile = __DIR__ . '/apothecare_faq.json';
$faqAnswer = null;
if (file_exists($faqFile)) {
    $faq = json_decode(file_get_contents($faqFile), true);
    // Normaliseer zowel vraag als FAQ-keys (kleine letters, trim)
    $normVraag = mb_strtolower(trim($vraag));
    foreach ($faq as $q => $a) {
        if (mb_strtolower(trim($q)) === $normVraag) {
            $faqAnswer = $a;
            break;
        }
    }
}
if ($faqAnswer !== null) {
    echo json_encode([
        'success' => true,
        'vraag'   => $vraag,
        'antwoord'=> $faqAnswer,
        'source'  => 'faq'
    ]);
    exit;
}

// ==== 2. SYSTEM PROMPT ====
$systemPrompt = <<<EOT
Je bent ApotheCare Bot, een vriendelijke en deskundige apotheek-assistent van de ApotheCare website.
Je helpt klanten met vragen over medicijnen, dosering, bijwerkingen, wisselwerkingen, openingstijden, bezorging en algemene gezondheidsadviezen.
- Geef altijd duidelijke, korte antwoorden in het Nederlands.
- Als je iets niet zeker weet, zeg dan eerlijk: “Ik raad aan dit met een apotheker of arts te bespreken.”
- Nooit medisch advies geven dat een arts zou moeten geven.
- Gebruik de officiële productnamen die op ApotheCare.nl staan.
- Houd je antwoorden beleefd en professioneel.
EOT;

// ==== 3. CALL OLLAMA API ====
$ollamaUrl = 'http://localhost:11434/api/generate';

$payload = [
    'model'  => 'llama3.2:3b',          // change if you use another model
    'prompt' => $systemPrompt . "\n\nVraag: " . $vraag . "\nAntwoord:",
    'stream' => false,
    'options' => [
        'temperature' => 0.7,
        'top_p'       => 0.9,
    ]
];

$context = stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/json\r\n",
        'content' => json_encode($payload),
        'timeout' => 60,
    ]
]);

$response = @file_get_contents($ollamaUrl, false, $context);
if ($response === false) {
    echo json_encode(['success' => false, 'message' => 'Kan Ollama niet bereiken']);
    exit;
}

$decoded = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE || empty($decoded['response'])) {
    echo json_encode(['success' => false, 'message' => 'Ongeldig antwoord van Ollama', 'raw' => $response]);
    exit;
}

$antwoord = trim($decoded['response']);

// ==== 4. FINAL JSON ====
echo json_encode([
    'success'  => true,
    'vraag'    => $vraag,
    'antwoord' => $antwoord,
    'source'   => 'llm'
]);
exit;
?>