<?php
require_once "./0 FRONT/composents/buttons.php";
// require_once "./0 FRONT/composents/input.php";
// require_once "./0 FRONT/composents/buttons.php";
// require_once "./0 FRONT/composents/icons.php";

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
                <h3 class="w-171 text-14 text-black">Size</h3>
                <h3 class="w-171 text-14 text-black mr-31">Downloads</h3>
            </div>
            <div class="flex flex-col overflow-y-scroll">
                <div class="w-full m-20 flex items-center gap-50">
                    <div class="flex flex-row justify-between gap-4 w-198">
                        <a id="token" href="localhost:...../downloads.php/?token="LETOKEN"&download_all=1"><?php littleButton("test") ?></a>
                        <button  class="copy-btn text-10 text-black" id="copy">Copy</button>
                    </div>
                    <p class="w-171 text-black text-10">10Go</p>
                    <p class="w-171 text-black text-10">0</p>
                    <button class="text-10 text-black ml-auto"><?php icon("x") ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll(".copy-btn").forEach(button => {
        button.addEventListener("click", function(e) {
            const link = e.target.parentElement.querySelector("#token").href;
            navigator.clipboard.writeText(link);
            
            e.target.innerHTML = "Copied";
            setTimeout(() => {
                e.target.innerHTML = "Copy";
            }, 3000);
        });
    });
</script>
<?php
require_once '0 FRONT/base/footer.php';
?>