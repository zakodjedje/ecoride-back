<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:8001");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Credentials: true");

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
    $_SESSION['user'] = $result;
    error_log("✅ Connexion réussie pour : " . $result['email']);
    echo json_encode([
        "success" => true,
        "message" => "Connexion réussieeeeeeeeeee",
        "user" => $result
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Email ou mot de passe incorrect"
    ]);
}
