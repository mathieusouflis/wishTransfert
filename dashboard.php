<?php
require_once './controllers/AuthController.php';
AuthController::needLog();

require_once "0 FRONT/base/header.php";
require_once "0 FRONT/composents/buttons.php";
require_once "0 FRONT/composents/input.php";
require_once "0 FRONT/composents/dashboard/files.php";
?>

<div class="flex flex-col absolute bg-white w-332 top-200 left-20 radius-20 p-10 gap-16 ">
    <?php  bigButton("plus","Add File","file", "addFile"); ?>
    <div class="flex flex-col w-full gap-10">
        <div  class="w-full py-4 gap-10 border-bottom-1"><span class="text-black text-20">Files</span></div>
        <div id="fileList">
            <?php files(); ?>
            <?php files(); ?>
            <?php files(); ?>
        </div>
    </div>
    <?php input("email", "Saisissez un email"); ?>
    <?php mediumButtonWithIcon("link", "Get a link"); ?>
</div>


<?php
require_once "0 FRONT/base/footer.php";
