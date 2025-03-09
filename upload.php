<?php
$errors= false;
$user =[
    "name"=>"John",
    "id" => 123,
    "connected" => true,
    "creationDate" => "14-07-2014",
];
$refused_extension =["php","exe","mathieu","leoFaitlHabit",'Bananjara'];
$max_size = 20 * 1024 * 1024; #20 Mo

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
    <h1>Hello world</h1>
    <?php if($user["connected"]): ?>
    <h3>Connecté !</h3>
    <form method="POST" enctype="multipart/form-data">
         <input type="file" name="file" id="file"> 
        <button type="submit" name="create">envoyer</button>
    </form>
    <?php endif; ?>
    <?php if($fichier): ?>
    <?= "<span>".$fichier["name"]."<span>" ?>
    <form method="POST">
        <button name="delete" type="submit">supprimer</button>
    </form>
    <?php endif; ?>
    
</body>
</html>