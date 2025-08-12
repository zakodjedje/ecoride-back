<?php
// add-trip.php
session_start();

// Entêtes CORS si ton front et ton back sont sur des hôtes/ports différents.
// Ajuste l’URL selon ta configuration.
header('Access-Control-Allow-Origin: http://localhost:8001');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

require_once 'connexion.php';

// Vérifie la connexion de l'utilisateur
// Ici, je suppose que l'ID de l'utilisateur est stocké en session dans $_SESSION['user_id'].
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Utilisateur non connecté'
    ]);
    exit;
}

// Récupération des données envoyées via FormData ($_POST)
$depart = trim($_POST['depart'] ?? '');
$arrivee = trim($_POST['arrivee'] ?? '');
$dateHeure = $_POST['date-heure'] ?? '';   // nom de l'input : date-heure
$prix = $_POST['prix'] ?? '';
$carId = intval($_POST['vehicle_id'] ?? $_POST['car_id'] ?? 0); // le select est nommé "vehicle_id"
$userId = $_SESSION['user_id'];

if (empty($depart) || empty($arrivee) || empty($dateHeure) || $prix === '' || $carId <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Champs manquants'
    ]);
    exit;
}

try {
    // Prépare et exécute l’insertion en base
    // Remplace "arrivee" par le nom réel de ta colonne (évite le caractère accentué dans les noms de colonnes)
    $stmt = $pdo->prepare("
        INSERT INTO trip (depart, arrivee, date_heure, prix, car_id, user_id)
        VALUES (:depart, :arrivee, :date_heure, :prix, :car_id, :user_id)
    ");
    $stmt->execute([
        ':depart'    => $depart,
        ':arrivee'   => $arrivee,
        ':date_heure'=> $dateHeure,
        ':prix'      => $prix,
        ':car_id'    => $carId,
        ':user_id'   => $userId
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Renvoie le message d’erreur SQL en développement (à désactiver en production)
    echo json_encode([
        'success' => false,
        'message' => 'Erreur DB',
        'error'   => $e->getMessage()
    ]);
}
