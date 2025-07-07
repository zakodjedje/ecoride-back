<?php
// Obligatoire pour autoriser l'appel depuis le front
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Réponse de test
echo json_encode(["message" => "Connexion réussie"]);
require_once(__DIR__ . '/../db/connexion.php');

echo json_encode(["status" => "OK", "message" => "Connexion réussie"]);
try {
    $stmt = $pdo->query("SELECT * FROM trip");
    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($trips);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
