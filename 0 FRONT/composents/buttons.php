<?php
require_once "./0 FRONT/composents/icons.php";

function bigButton($iconName, $content){
    ?>
    <button class="button flex flex-row w-full p-20 items-center gap-10 bg-primary radius-10">
        <?=icon($iconName, "big", "white")?>
         <span class="text-20"><?= $content ?></span>
    </button>
    <?php
}

function mediumButtonWithIcon($iconName, $content, $style){
    switch ($style) {
        case 'full':
            ?>
            <button class="flex flex-row radius-10 py-8 px-10 content-center items-center gap-10 button bg-primary w-max">
                <?=icon($iconName, "little", "white")?>
                <span class="text-15"><?=$content?></span>
            </button>
            <?php
            break;
        case 'full-white':
            ?>
            <button class="flex flex-row radius-10 py-8 px-10 content-center items-center gap-10 button bg-white w-max">
                <?=icon($iconName, "little", "black")?>
                <span class="text-15 text-black"><?=$content?></span>
            </button>
            <?php
            break;
        case 'left':
            ?>
            <button class="flex flex-row radius-l-10 py-8 px-10 content-center items-center gap-10 button bg-primary w-max">
                <?=icon($iconName, "little", "white")?>
                <span class="text-15"><?=$content?></span>
            </button>
            <?php
            break;
        case 'right':
            ?>
            <button class="flex flex-row radius-r-10 py-8 px-10 content-center items-center gap-10 button bg-primary w-max">
                <?=icon($iconName, "little", "white")?>
                <span class="text-15"><?=$content?></span>
            </button>
            <?php
            break;
        case 'none':
            ?>
            <button class="flex flex-row py-8 px-10 content-center items-center gap-10 button bg-primary w-max">
                <?=icon($iconName, "little", "white")?>
                <span class="text-15"><?=$content?></span>
            </button>
            <?php
            break;
    }
}

function mediumButton($content, $style="red"){
    switch ($style) {
        case 'white':
            ?>
            <button class="flex radius-10 py-8 px-10 button bg-white w-max text-15 text-black"><?=$content?></button>
            <?php
            break;
        case 'red':
            ?>
            <button class="flex radius-10 py-8 px-10 button bg-primary w-max text-15"><?=$content?></button>
            <?php
            break;
    }
}

function littleButton($content){
    ?>
    <button class="py-6 px-8 flex radius-4 bg-white button w-max text-black text-10"><?=$content?></button>
    <?php
}
