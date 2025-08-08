<?php



// Autoriser le front (localhost:8001) à communiquer
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Connexion à la BDD
require_once 'connexion.php';




$input = json_decode(file_get_contents("php://input"), true);




try {
    $stmt = $pdo->prepare("INSERT INTO `user` (username, firstname, email, password, role, note)
                           VALUES (:username, :firstname, :email, :password, :role, :note)");

    $stmt->execute([
        ':username' => $input['username'],
        ':firstname' => $input['firstname'],
        ':email' => $input['email'],
        ':password' => password_hash($input['password'], PASSWORD_DEFAULT),
        ':role' => $input['role'],
        ':note' => $input['note']
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

