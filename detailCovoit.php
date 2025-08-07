<?php
require_once 'connexion.php'; // connexion à ta base de données

if (!isset($_GET['id'])) {
    echo "Aucun identifiant de voiture fourni.";
    exit;
}

$carId = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM car WHERE id = ?");
$stmt->execute([$carId]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo "Aucune voiture trouvée.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du véhicule</title>
    <link rel="stylesheet" href="/scss/main.css">
</head>
<body>

<h1 class="text-center">Détails du véhicule</h1>

<div class="text-center">
    <div class="card">
        <p>🚗 Marque : <?= htmlspecialchars($car['marque']) ?></p>
        <p>📦 Modèle : <?= htmlspecialchars($car['modele']) ?></p>
        <p>🎨 Couleur : <?= htmlspecialchars($car['couleur']) ?></p>
        <p>🔢 Places : <?= htmlspecialchars($car['nombrePlace']) ?></p>
        <p>🪪 Immatriculation : <?= htmlspecialchars($car['immatriculation']) ?></p>
    </div>
</div>

</body>
</html>
