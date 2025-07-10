<?php

require_once 'connexion.php';
require_once 'user.php';

addUser ($pdo,"djedje", "zako","zakodjedje@gmail.com", "dizafoya", "chauffeur" );

echo "Bienvenue sur l'API EcoRide";
