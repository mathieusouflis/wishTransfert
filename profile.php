<?php
global $errors;
$errors = [];
require_once './controllers/AuthController.php';
AuthController::needLog();

require_once "./controllers/UserController.php";
UserController::editProfile();
UserController::editPassword();

require_once "./0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/buttons.php";
require_once "./0 FRONT/composents/icons.php";
require_once '0 FRONT/base/header.php';
require_once "./0 FRONT/composents/errorModal.php";
errorModal($errors);

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
    <div class="h-410 w-380 gap-10 bg-white border-radius20 flex flex-col p-16">
        <div class="flex justify-between">
            <h2 class="text-20 text-black">Profile</h2>
            <a href="index.php"><button class="text-black"><?php icon("x", "big") ?></button></a>
        </div>
        <div class="flex flex-col h-full gap-10 justify-between overflow-y-scroll">
            <form method="post" class="flex flex-col gap-10">
                <?php input("username", "Username", "text", $_SESSION["username"], "w-full");?>
                <?php input("email", "Email", "email", $_SESSION["email"], "w-full");?>
                <?php mediumButton("Update", "submit", "red", other: "name='editProfile'");?>
            </form>
            <form method="post" class="flex flex-col gap-10">
                <?php input("oldPassword", "Password", "password", "", "w-full");?>
                <?php input("newPassword", "Password", "password", "", "w-full");?>
                <?php input("newPasswordConfirm", "Password", "password", "", "w-full");?>
                <?php mediumButton("Change password", "submit", "red", other: "name='change-password'");?>
            </form>
        </div>
    </div>
    </div>
</div>
<?php
require_once '0 FRONT/base/footer.php';
?>