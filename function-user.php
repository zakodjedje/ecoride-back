<?php 
function verifyuserLoginPassword(PDO $pdo, string $email, string $password): bool|array {
    $stmt = $pdo->prepare("SELECT id, username, email, password, role FROM user WHERE email = :email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // On retourne les infos utilisateur sans le mot de passe
        unset($user['password']);
        return $user;
    }

    return false;
}
