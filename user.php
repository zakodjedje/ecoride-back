<?php
require_once 'connexion.php';
require_once 'user.php';

header("Content-Type: application/json");

function addUser (PDO $pdo,string $username, string $firstname, string $email, string $password, string $role ) :bool {
    $query =$pdo->prepare("INSERT INTO user(username, firstname, email, password, role) VALUES (:username, :firstname, :email, :password, :role)");

    $motdepasse = password_hash($password, PASSWORD_DEFAULT);

    $query ->bindValue (':username', $username);
    $query ->bindValue (':firstname', $firstname);
    $query ->bindValue (':email', $email);
    $query ->bindValue (':password', $password);
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


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    // 1. Vérifier les données
    $res = verifyUser($input);
    var_dump($res);
    if ($res === true) {
        // 2. Si vérification OK, on ajoute l'utilisateur
        $addResult = addUser(
            $pdo,
        $input["username"],
        $input["firstname"],
        $input["email"],
        $input["password"],
        $input["role"]
        );

        if ($addResult === true) {
            echo json_encode([
                "success" => true,
                "message" => "Utilisateur ajouté avec succès"
            ]);
        } else {
            // ⚠️ Si addUser échoue (ex: doublon email)
            echo json_encode([
                "success" => false,
                "errors" => ["global" => "Impossible d'ajouter l'utilisateur"]
            ]);
        }
    } else {
        // 3. Si la vérification échoue, on retourne les erreurs
        echo json_encode([
            "success" => false,
            "errors" => $res
        ]);
    }

    exit;
};


