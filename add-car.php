<?php
session_start();
header('Access-Control-Allow-Origin: http://localhost:8001');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

require_once 'connexion.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

// Récupération depuis $_POST (puisque tu utilises FormData)
$marque = trim($_POST['marque'] ?? '');
$modele = trim($_POST['modele'] ?? '');
$couleur = trim($_POST['couleur'] ?? '');
$nombrePlace = intval($_POST['nombrePlace'] ?? 0);
$immatriculation = trim($_POST['immatriculation'] ?? '');
$user_id = $_SESSION['user_id'];

if (!$marque || !$modele || !$couleur || !$nombrePlace || !$immatriculation) {
    echo json_encode(['success' => false, 'message' => 'Champs manquants']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO car (brand, model, color, seats, plate, user_id)
        VALUES (:marque, :modele, :couleur, :nombrePlace, :immatriculation, :user_id)
    ");
    $stmt->execute([
        ':marque' => $marque,
        ':modele' => $modele,
        ':couleur' => $couleur,
        ':nombrePlace' => $nombrePlace,
        ':immatriculation' => $immatriculation,
        ':user_id' => $user_id
    ]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur SQL', 'error' => $e->getMessage()]);
}
