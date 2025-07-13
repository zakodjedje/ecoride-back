<?php

require_once 'connexion.php';
require_once 'user.php';
header("Content-Type: application/json");

$errors =[];

if ($_SERVER ["REQUEST_METHOD"] === "POST"){
    $input= json_decode(file_get_contents("php://input"), true);
    $res= verifyUser($input);
    var_dump($res);
}

echo "Bienvenue sur l'API EcoRide";
