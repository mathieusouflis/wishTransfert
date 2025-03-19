<?php
require_once "./0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/buttons.php";
require_once "./0 FRONT/composents/icons.php";

require_once '0 FRONT/base/header.php';

?>
<div class="h-410 w-561 gap-10 page-left">
    <div class="w-171 h-410 bg-white border-radius20 flex flex-col justify-between">
        <div class="p-16">
        <h3 class="w-full h-34 flex items-center text-15 text-black button-bg-gray h-34 gap-10"><?php icon("person") ?>Profile</h3>
            <h3 class="w-full h-34 flex items-center text-15 text-black button-bg-gray h-34 gap-10"><?php icon("link") ?>Links created</h3>
        </div>
        <div class="flex items-center p-16 border-top">
            <h3 class="w-full h-34 flex items-center text-15 text-red button-bg-gray gap-10"><?php icon("trash") ?>Disconnect</h3>
        </div>
    </div>
    <div class="page-left2">
    <div class="h-410 w-380 bg-white border-radius20 flex flex-col p-16">
        <div class="flex justify-between">
        <h2 class="text-20 text-black">Profile</h2>
        <a href="index.php"><button class="text-black">X</button></a>
        </div>
        <div class="w-80 h-103 m-20 flex justify-center">
            <img class="h-full" src="" alt="">
            <button class="h-34 text-14 text-black">Edit</button>
        </div>
        <div class="m-20">
            <?php input("username", "__blueorchide");?>
        </div>
        <div class="m-20">
            <?php input("email", "__blueorchide@gmail.com");?>
        </div>
    </div>
    </div>
</div>
<?php
require_once '0 FRONT/base/footer.php';
?>