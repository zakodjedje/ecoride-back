<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:8001");
header("Content-Type: application/json");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");




if (isset($_SESSION['user'])) {
    echo json_encode([
        "connected" => true,
        "user" => $_SESSION['user']
    ]);
} else {
    echo json_encode([
        "connected" => false
    ]);
}
