<?php
require_once './controllers/AuthController.php';
AuthController::LogIn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <?php require_once './utils/erreurs.php'; ?>
    <form method="POST">
        <!-- Correction: Changement de "identifiant" à "email" pour correspondre au contrôleur -->
        <label for="email">Email</label>
        <input type="text" id="email" name="email">

        <!-- Correction: Changement de "motdepasse" à "password" pour correspondre au contrôleur -->
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">

        <input type="submit" value="Connexion">
    </form>
</body>
</html>