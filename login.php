<?php
require_once './controllers/AuthController.php';
LogIn();
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
        <label for="identifiant">Identifiant</label>
        <input type="text" id="identifiant" name="identifiant">

        <label for="motdepasse">Mot de passe</label>
        <input type="password" name="motdepasse" id="motdepasse">

        <input type="submit" value="Connexion">
    </form>
</body>
</html>