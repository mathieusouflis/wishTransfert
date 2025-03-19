<?php
require_once './controllers/AuthController.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <h1>Dashboard</h1>
    <?= var_dump($_SESSION)?>
    <p>Vous êtes connecté(e), <?= $_SESSION["email"] ?>.</p>
    <?php require_once 'logout.php'; ?>
</body>
</html>