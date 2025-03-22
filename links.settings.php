<?php
global $errors;
$errors = [];
require_once './controllers/AuthController.php';
AuthController::needLog();
require_once './controllers/LinkController.php';
LinkController::delete();

require_once "./Models/Link.Model.php";
$links = Links::getByUserId($_SESSION["user_id"]);
var_dump($links); 
require_once "./0 FRONT/composents/buttons.php";
require_once '0 FRONT/base/header.php';
?>
<div class="h-410 w-561 gap-10 page-left">
    <div class="w-171 h-410 bg-white border-radius20 flex flex-col justify-between"></a>
        <div class="p-16 flex flex-col gap-4">
            <a href="profile.php"><?php mediumButtonWithIcon("person", "Profile", "button", "full-white", 'w-full')?></a>
            <a href="links.settings.php"> <?php mediumButtonWithIcon("link", "Links Created", "button", "full-white", 'w-full active'); ?></a>
        </div>
        <div class="flex items-center p-16 border-top">
        <?php include './0 FRONT/composents/disconnectButton.php'; ?>
        </div>
    </div>
    <div class="page-left3 h-410 w-738 bg-white border-radius20 p-16">
        <div class=" flex flex-col h-full">
            <div class="flex justify-between">
                <h2 class="text-20 text-black">Link List</h2>
                <a href="index.php"><button class="text-black"><?php icon("x", "big") ?></button></a>
            </div>
            <div class="w-full m-20 flex gap-50">
                <h3 class="w-198 text-start text-14 text-black">Link</h3>
                <h3 class="w-171 text-14 text-black">Date</h3>
            </div>
            <div class="flex flex-col overflow-y-scroll">
                <?php foreach($links as $link){
                    $token = $link->token;
                    $date = $link->createdat;
                    $url = "http://localhost:8888/download.php/?token=$token";
                    $linkid = $link->linkid;
                    ?>
                <div class="w-full m-20 flex items-center gap-50">
                    <div class="flex flex-row justify-between gap-4 w-198 items-center">
                        <a id="token" class="w-full text-wrap text-black text-10 underline" href="<?=$url?>"><?=$url?></a>
                        <?php littleButton("Copy", style: "copy-btn text-10 text-black", other:"id='copy'") ?>
                    </div>
                    <p class="w-171 text-black text-10"><?=$date?></p>
                    <form method="post" class="flex ml-auto">
                        <input type="hidden" name="id" value="<?= $linkid ?>">
                        <label for=`submit-<?=$linkid?>` class="pointer"><?php icon("x") ?></label>
                        <input type="submit" id=`submit-<?=$linkid?>` value="" class="text-10 text-black" name="delete-link">
                    </form>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll(".copy-btn").forEach(button => {
        button.addEventListener("click", function(e) {
            const link = e.target.parentElement.querySelector("#token").href;
            navigator.clipboard.writeText(link);
            
            e.target.value = "Copied";
            setTimeout(() => {
                e.target.value = "Copy";
            }, 3000);
        });
    });
</script>
<?php
require_once "./0 FRONT/composents/errorModal.php";
errorModal($errors); 
require_once '0 FRONT/base/footer.php';
?>