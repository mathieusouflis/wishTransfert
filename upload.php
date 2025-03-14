<?php

$userid = 123;
 $title = "blabla";
 
require_once "controllers/FileController.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" placeholder="Choisissez un fichier">
    </form>
    <button type="submit" name="create">upload</button>
    
</body>
</html>