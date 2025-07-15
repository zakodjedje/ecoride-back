<?php

function addUser (PDO $pdo,string $nom, string $prenom, string $email, string $motdepasse, string $role ) :bool {
    $query =$pdo->prepare("INSERT INTO user(nom, prenom, email, motdepasse, role) VALUES (:nom, :prenom, :email, :motdepasse, :role)");

    $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT);

    $query ->bindValue (':nom', $nom);
    $query ->bindValue (':prenom', $prenom);
    $query ->bindValue (':email', $email);
    $query ->bindValue (':motdepasse', $motdepasse);
    $query ->bindValue (':role', $role);

    return $query->execute();
}

function verifyUser ($user):array|bool {

    $errors=[];

    if (isset($user["username"])) {
        if ($user["username"]=== ""){
            $errors ["username"]="le champ username est Obligatoire";
        }
    } else {$errors["username"]="le champ n'a pas été envoyé"; }


     if (isset($user["email"])) {
        if ($user["email"]=== ""){
            $errors ["email"]="le champ email est Obligatoire";
        }
    } else {$errors["email"]="le champ n'a pas été envoyé"; }


    if (isset($user["password"])) {
        if ($user["password"]=== ""){
            $errors ["password"]="le champ username est Obligatoire";
        }
    } else {$errors["password"]="le champ n'a pas été envoyé"; }


    if (count($errors)){
        return $errors;
    }else {
        return true;
    };

}