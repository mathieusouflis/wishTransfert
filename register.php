<?php
require_once './controllers/AuthController.php';

global $errors;
$errors = [];

AuthController::Register();

require_once "./0 FRONT/composents/errorModal.php";
errorModal($errors);
require_once "./0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/buttons.php";
require_once '0 FRONT/base/header.php';
require_once '0 FRONT/base/nav.php';
?>

<div class="page-center flex flex-col p-16 bg-white radius-20 gap-20 w-272">
    <h1 class="text-black text-20 text-center">Register</h1>
    <form method="post" class="flex flex-col gap-20">
        <?php input("username", "__blueorchide", required: true);?>
        <?php input("email", "__blueorchide@hetic.eu","email", required: true);?>
        <?php input("password", "mysuperbpassword", "password", required: true);?>
        <?php input("password2", "myseperbpassword", "password", required: true);?>
        <?php mediumButton("Register", "submit", style: "w-full", other:"name='register'");?>
    </form>
    <?php require_once './utils/erreurs.php';?>
</div>
</input>

<?php

require_once '0 FRONT/base/footer.php';