<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include __DIR__ . '/../config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    if ($action === 'list') {
        $stmt = $pdo->query("SELECT BestellingID, KlantID, Naam, Contact, Items, Datum, Status, BetaaldBedrag FROM bestellingen ORDER BY Datum DESC");
        $orders = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orders[] = [
                'id' => $row['BestellingID'],
                'klantId' => $row['KlantID'],
                'name' => $row['Naam'],
                'contact' => $row['Contact'],
                'items' => $row['Items'],
                'date' => date('d M Y', strtotime($row['Datum'])),
                'status' => $row['Status'],
                'statusClass' => strtolower(str_replace(' ', '', $row['Status'])),
                'betaaldBedrag' => number_format($row['BetaaldBedrag'], 2)
            ];
        }
        echo json_encode(['success' => true, 'orders' => $orders]);
        exit;
    }

    if ($action === 'add') {
        $klantId = $_POST['klantId'] ?? 0;
        $naam = $_POST['naam'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $items = $_POST['items'] ?? '';
        $status = $_POST['status'] ?? 'In afwachting';
        $betaaldBedrag = $_POST['betaaldBedrag'] ?? 0.00;

        if (!$klantId || !$naam) {
            echo json_encode(['success' => false, 'message' => 'Klant ID en Naam zijn verplicht']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO bestellingen (KlantID, Naam, Contact, Items, Status, BetaaldBedrag) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$klantId, $naam, $contact, $items, $status, $betaaldBedrag]);
        echo json_encode(['success' => true, 'message' => 'Bestelling toegevoegd']);
        exit;
    }

    if ($action === 'update') {
        $id = $_POST['bestellingId'] ?? 0;
        $status = $_POST['status'] ?? '';
        $betaaldBedrag = $_POST['betaaldBedrag'] ?? '';

        $stmt = $pdo->prepare("UPDATE bestellingen SET Status = ?, BetaaldBedrag = ? WHERE BestellingID = ?");
        $stmt->execute([$status, $betaaldBedrag, $id]);
        echo json_encode(['success' => true, 'message' => 'Bestelling bijgewerkt']);
        exit;
    }

    if ($action === 'delete') {
        $id = $_POST['bestellingId'] ?? 0;
        $stmt = $pdo->prepare("DELETE FROM bestellingen WHERE BestellingID = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Bestelling verwijderd']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Ongeldige actie']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
