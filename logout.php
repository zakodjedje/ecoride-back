<?php
session_start();

// Vider la session
$_SESSION = [];

// Supprimer le cookie PHPSESSID (avec path /)
setcookie(session_name(), '', time() - 3600, "/");

// Détruire la session
session_destroy();

header("Access-Control-Allow-Origin: http://localhost:8001");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
echo json_encode(["success" => true]);
