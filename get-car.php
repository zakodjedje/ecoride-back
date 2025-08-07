<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");



header("Content-Type: application/json");
require_once 'connexion.php'; // ton fichier de connexion PDO

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("SELECT id, brand, model FROM car WHERE id = ?");
    $stmt->execute([$id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($car) {
        echo json_encode(['success' => true, 'car' => $car]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Voiture non trouvée']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur DB: ' . $e->getMessage()]);
}
