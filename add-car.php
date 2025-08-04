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
    $stmt = $pdo->prepare("INSERT INTO `car` (marque, modele, couleur, nombrePlace, immatriculation,user_id )
                           VALUES (:marque, :modele, :couleur, :nombrePlace, :immatriculation,:user_id)");

    $stmt->execute([
        ':marque' => $input['marque'],
        ':modele' => $input['modele'],
        ':couleur' => $input['couleur'],
        ':nombrePlace' => $input['nombrePlace'], 
        ':immatriculation' => $input['immatriculation'],
        ':user_id' => $input['user_id']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Véhicule ajouté depuis le formulaire"
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur SQL : " . $e->getMessage()
    ]);
}
