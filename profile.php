<?php
require_once "./0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/buttons.php";
require_once "./0 FRONT/composents/icons.php";

require_once '0 FRONT/base/header.php';

?>
<div class="h-410 w-561 gap-10 page-left">
    <div class="w-171 h-410 bg-white border-radius20 flex flex-col justify-between">
        <div class="p-16">
            <h3 class="flex items-center text-20 text-black button-bg-gray h-34">Profile</h3>
            <h3 class="flex items-center text-20 text-black button-bg-gray h-34">Links created</h3>
        </div>
        <div class="flex items-center p-16 border-top">
            <h3 class="text-20 text-red">Disconnect</h3>
        </div>
    </div>
    <div class="page-left2">
    <div class="h-410 w-380 bg-white border-radius20 flex flex-col p-16">
        <h2 class="text-20 text-black">Profile</h2>
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