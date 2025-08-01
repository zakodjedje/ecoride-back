<?php
header("Access-Control-Allow-Origin: http://localhost:8001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "connexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$role = trim($data["role"] );



try {
    $sql = "SELECT id, username, email, role FROM user WHERE role = :role";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([ ":role" => $role ]);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "users" => $users]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur DB", "error" => $e->getMessage()]);
}