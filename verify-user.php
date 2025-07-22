<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once 'connexion.php';
require_once 'function-user.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['email']) || !isset($input['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Champs email et mot de passe requis"
    ]);
    exit;
}

$result = verifyuserLoginPassword($pdo, $input['email'], $input['password']);

if ($result) {
    echo json_encode([
        "success" => true,
        "message" => "Connexion réussie",
        "user" => $result
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Email ou mot de passe incorrect"
    ]);
}
