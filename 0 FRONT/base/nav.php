<?php
require_once "./0 FRONT/composents/buttons.php";
require_once "./controllers/AuthController.php";


$isConnected = AuthController::isLog();
$email = $_SESSION['email'] ?? '';
$avatar = "https://cdn.cosmos.so/1f89cd92-f0ca-4715-90f8-3b1e2e20b224?format=jpeg";

?>


<nav class="absolute top-10 right-10 pointer">
        <?php 
     if($isConnected){
         
         ?>
         <a href="http://localhost:8888/profile.php">
            <div class="flex flex-row w-max p-10 gap-10 radius-10 items-center bg-white">
                <div calss="flex flex-col gap-4">
                    <p class="text-14 text-black"><?=$email?></p>
                    <p class="text-10 text-gray">Thanks for using us</p>
                </div>
                <img src="<?=$avatar?>" alt="" class="w-33 radius-5 lock-ratio">
            </div>
        </a>
        <?php
     
    }else {
        ?>
    <div class="flex flex-row w-max p-4 gap-4 radius-12 bg-white">
        <a href="http://localhost:8888/register.php">
            <?php mediumButton("Sign Up", "button","white", style:"w-70"); ?>
        </a>
        <a href="http://localhost:8888/login.php">
            <?php mediumButton("Log In", "button","red", style:"w-70"); ?>
        </a>
    </div>
    <?php
    }
    ?>
    </div>
</nav>