<?php
require_once "./0 FRONT/base/header.php";
require_once "./0 FRONT/composents/buttons.php";
require_once "./0 FRONT/composents/input.php";
require_once "./0 FRONT/composents/fileList.php";

bigButton("link", "cc");
mediumButtonWithIcon("link", "Coucou", "full");
mediumButtonWithIcon("link", "Coucou","full-white");
mediumButtonWithIcon("link", "Coucou", "left");
mediumButtonWithIcon("link", "Coucou", "right");
mediumButtonWithIcon("link", "Coucou", "none");
mediumButton("Coucou", "white");
mediumButton("Coucou", "red");
littleButton("Content");
input("test", "Un Test", "");
topList("File Name1", "10Go");
midList("File Name2", "10Go", true);
midList("File Name3", "10Go");
bottomList("File Name4", "10Go", true);


?>
COUCOU


<?php
require_once "./0 FRONT/base/footer.php";