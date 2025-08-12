<?php
// get-user-vehicles.php
session_start();

header('Access-Control-Allow-Origin: http://localhost:8001');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

require_once 'connexion.php';

// Vérifie que l'utilisateur est bien connecté et que l'ID est dans $_SESSION['user']['id']
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$userId = $_SESSION['user']['id'];

try {
    // Sélectionne id, marque, modèle et plaque (immatriculation) du véhicule
    $stmt = $pdo->prepare("
        SELECT id, brand, model, immatriculation
        FROM car
        WHERE user_id = :user_id
    ");
    $stmt->execute([':user_id' => $userId]);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'cars' => $cars]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur DB',
        'error' => $e->getMessage()
    ]);
}
