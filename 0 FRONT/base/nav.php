<?php
require_once "./0 FRONT/composents/buttons.php";

$isConnected = true;
$email = "mathieu@souflis.fr";
$avatar = "https://cdn.cosmos.so/1f89cd92-f0ca-4715-90f8-3b1e2e20b224?format=jpeg";

$navBonnusStyles = "p-4 gap-4 radius-12";
if($isConnected){
    $navBonnusStyles = "p-10 gap-10 radius-10 items-center";
}

?>


<nav class="flex justify-end">
    <div class="flex flex-row w-max <?=$navBonnusStyles?> bg-white">
        <?php 
     if($isConnected){
         
         ?>
        
        <div calss="flex flex-col gap-4">
            <p class="text-14 text-black"><?=$email?></p>
            <p class="text-10 text-gray">Thanks for using us</p>
        </div>
        <img src="<?=$avatar?>" alt="" class="w-33 radius-5 lock-ratio">
        
        <?php
     
    }else {
        mediumButton("Sign Up", "white");
        mediumButton("Log In", "red");
    }
    
    ?>
    </div>
</nav>