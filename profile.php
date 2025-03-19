<?php
require_once "./0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/buttons.php";
require_once "./0 FRONT/composents/icons.php";

require_once '0 FRONT/base/header.php';

?>
<div class="h-410 w-561 gap-10 page-left">
    <div class="w-171 h-410 bg-white border-radius20 flex flex-col justify-between"></a>
        <div class="p-16 flex flex-col gap-4">
            <a href="profile.php"><?php mediumButtonWithIcon("person", "Profile", "button", "full-white", 'w-full active')?></a>
            <a href="links.settings.php"> <?php mediumButtonWithIcon("link", "Links Created", "button", "full-white", 'w-full'); ?></a>
        </div>
        <div class="flex items-center p-16 border-top">
            <?php include './0 FRONT/composents/disconnectButton.php'; ?>
        </div>
    </div>
    <div class="page-left2">
    <div class="h-410 w-380 bg-white border-radius20 flex flex-col p-16">
        <div class="flex justify-between">
            <h2 class="text-20 text-black">Profile</h2>
            <a href="index.php"><button class="text-black"><?php icon("x", "big") ?></button></a>
        </div>
        <div class="flex flex-col h-full justify-between">
            <form action="POST" class="flex flex-col gap-10">
                <?php input("text", "Username", "username", "", "w-full");?>
                <?php input("text", "Email", "email", "", "w-full");?>
                <?php mediumButton("Update", "submit", "red");?>
            </form>
            <form action="POST" class="flex flex-col gap-10">
                <?php input("password", "Password", "password", "", "w-full");?>
                <?php input("password", "Password", "password", "", "w-full");?>
                <?php mediumButton("Change password", "submit", "red");?>
            </form>
        </div>
    </div>
    </div>
</div>
<?php
require_once '0 FRONT/base/footer.php';
?>