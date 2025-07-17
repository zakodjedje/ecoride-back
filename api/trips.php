<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../connexion.php';

try {
    $stmt = $pdo->query("SELECT * FROM trip");
    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "OK",
        "message" => "Connexion réussie entre back et front",
        "data" => $trips
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
