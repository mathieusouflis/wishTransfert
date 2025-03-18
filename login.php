<?php
require_once './controllers/AuthController.php';
require_once "./0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/buttons.php";

global $errors;
$errors = [];

AuthController::LogIn();

require_once '0 FRONT/base/header.php';
require_once '0 FRONT/base/nav.php';
?>

<div class="page-center flex flex-col p-16 bg-white radius-20 gap-20 w-272">
    <h1 class="text-black text-20 text-center">Log In</h1>
    <form method="post" class="flex flex-col gap-20">
        <?php input("email", "mon@email.com", "email");?>
        <?php input("password", "arcanerobuste", "password");?>
        <?php mediumButton("Log In", "submit", style: "w-full" );?>
    </form>
    <?php require_once './utils/erreurs.php';?>
</div>
</input>
<?
require_once '0 FRONT/base/footer.php';