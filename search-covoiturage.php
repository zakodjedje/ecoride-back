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

$depart = trim($data["depart"]);
$arrivee = trim($data["arrivee"]);
$date = trim($data["date"]);
$role = trim($data["role"]);
$filterType = trim($data["filterType"]);




try {
    $sql = "
        SELECT t.id AS trip_id, t.depart, t.arrivé, t.date_heure, t.prix,
               u.id AS user_id, u.username, u.email, u.role
        FROM trip t
        JOIN user u ON t.user_id = u.id
        WHERE t.depart LIKE :depart
          AND t.arrivé LIKE :arrivee
          AND DATE(t.date_heure) = :date
    ";

    // Ajout tri si demandé
    if ($filterType === "prix") {
        $sql .= " ORDER BY t.prix ASC";
    } elseif ($filterType === "note") {
        // Remplace `note` par ta vraie colonne si tu en as une
        $sql .= " ORDER BY u.note DESC";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":depart" => "%$depart%",
        ":arrivee" => "%$arrivee%",
        ":date" => $date
    ]);

    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "trips" => $trips]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur DB",
        "error" => $e->getMessage()
    ]);
}
