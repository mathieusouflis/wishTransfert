<?php
require_once './controllers/AuthController.php';
AuthController::Register();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <?php require_once './utils/erreurs.php'; ?>
    <form method="POST">
        <!-- Correction: Changement des noms de champs pour correspondre au contrôleur -->
        <label for="email">Email</label>
        <input type="email" id="email" name="email">

        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">

        <label for="password2">Confirmer le mot de passe</label>
        <input type="password" name="password2" id="password2">

        <input type="submit" value="Inscription">
    </form>
</body>
</html>