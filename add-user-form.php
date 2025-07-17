<?php

// Autoriser le front (localhost:8001) à communiquer
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Connexion à la BDD
require_once 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode([
        "success" => false,
        "message" => "Aucune donnée reçue"
    ]);
    exit;
}

$requiredFields = ['username', 'firstname', 'email', 'password', 'role'];
$errors = [];

foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        $errors[$field] = "Le champ '$field' est obligatoire";
    }
}

if (!empty($errors)) {
    echo json_encode([
        "success" => false,
        "errors" => $errors
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO `user` (username, firstname, email, password, role)
                           VALUES (:username, :firstname, :email, :password, :role)");

    $stmt->execute([
        ':username' => $input['username'],
        ':firstname' => $input['firstname'],
        ':email' => $input['email'],
        ':password' => password_hash($input['password'], PASSWORD_DEFAULT),
        ':role' => $input['role']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Utilisateur ajouté depuis le formulaire"
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur SQL : " . $e->getMessage()
    ]);
}
