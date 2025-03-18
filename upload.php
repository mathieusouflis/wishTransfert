<?php
 $fileid = 14;
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
        <input type="file" name="files[]" placeholder="Choisissez un fichier" multiple>
        <button type="submit" name="create">upload</button>
    </form>
    <form method="POST">
        <input type="text" name="file_id" placeholder="ID du fichier">
        <button type="submit" name="download">Download</button>
    </form>

    
</body>
</html>