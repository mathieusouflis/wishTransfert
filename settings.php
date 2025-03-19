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
    <div class="page-left3">
    <div class="h-410 w-738 bg-white border-radius20 flex flex-col p-16">
        <div class="flex justify-between">
        <h2 class="text-20 text-black">Link List</h2>
        <a href="index.php"><button class="text-black">X</button></a>
        </div>
        <div class="flex flex-col">
        <div class="w-full h-full m-20 flex justify-between">
            <h3 class="w-198 text-start text-14 text-black">Link</h3>
            <h3 class="text-start text-14 text-black">Size</h3>
            <h3 class="text-start text-14 text-black">Views</h3>
        </div>
        <div class="w-full h-full m-20 flex justify-between">
            <a id="token" href="localhost:...../downloads.php/?token="LETOKEN"&download_all=1"><?php littleButton("test") ?></a>
            <button onclick="Copied()" class="text-10 text-black" id="copy">Copy</button>
            <button class="text-10 text-black">X</button>
        </div>
        </div>
    </div>
    </div>
</div>
<script>
    function Copied() {
  document.getElementById("copy").innerHTML = "Copied";
  navigator.clipboard.writeText(document.getElementById("token"));
  setTimeout(() => {
    document.getElementById("copy").innerHTML = "Copy";
}, 3000);
}
</script>
<?php
require_once '0 FRONT/base/footer.php';
?>