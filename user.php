<?php

function addUser (PDO $pdo,string $nom, string $prenom, string $email, string $motdepasse, string $role ) :bool {
    $query =$pdo->prepare("INSERT INTO user(nom, prenom, email, motdepasse, role) VALUES (:nom, :prenom, :email, :motdepasse, :role)");
    $query ->bindValue (':nom', $nom);
    $query ->bindValue (':prenom', $prenom);
    $query ->bindValue (':email', $email);
    $query ->bindValue (':motdepasse', $motdepasse);
    $query ->bindValue (':role', $role);

    return $query->execute();
}

