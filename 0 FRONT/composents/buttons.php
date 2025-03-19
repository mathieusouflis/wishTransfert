<?php
require_once "./0 FRONT/composents/icons.php";

function bigButton($iconName, $content, $type="button", $other= ""){
    ?>
    <div class="relative">
        <?=icon($iconName, "big", "white", "absolute left-20 top-20")?>
        <input type="<?=$type?>"  class="button flex flex-row w-full py-20 pl-54 pr-20 items-center gap-10 bg-primary radius-10 text-20" value="<?=$content?>" <?=$other?>>
    </div>
    <?php
}

function mediumButtonWithIcon($iconName, $content, $type="button", $buttonStyle="full", $style="", $other= ""){
    switch ($buttonStyle) {
        case 'full':
            ?>
                <div class="<?=$style?> relative">
                    <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                    <input type="<?=$type?>" class="flex flex-row radius-10 pl-33 pr-10 py-8 content-center items-center gap-10 button bg-primary text-15 w-max <?=$style?>" value="<?=$content?>" <?=$other?>>
                </div>
            <?php
            break;
        case 'full-white':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "black", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="flex flex-row radius-10 pl-33 pr-10 py-8 content-center items-center gap-10 button bg-white text-15 text-black w-max <?=$style?>" value="<?=$content?>" <?=$other?>>
            </div>
            <?php
            break;
        case 'left':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="flex flex-row radius-l-10 pl-33 pr-10 py-8 content-center items-center gap-10 button bg-white text-15 w-max <?=$style?>" value="<?=$content?>" <?=$other?>>
            </div>
            <?php
            break;
        case 'right':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="flex flex-row radius-r-10 pl-33 pr-10 py-8 content-center items-center gap-10 button bg-white text-15 w-max <?=$style?>" value="<?=$content?>" <?=$other?>>
            </div>
            <?php
            break;
        case 'none':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="flex flex-row pl-33 pr-10 py-8 content-center items-center gap-10 button bg-white text-15 w-max <?=$style?>" value="<?=$content?>" <?=$other?>>
            </div>
            <?php
            break;
    }
}

function mediumButton($content, $type="button", $buttonStyle="red", $style= "", $other= ""){
    switch ($buttonStyle) {
        case 'white':
            ?>
            <input type="<?=$type?>" class="flex text-center radius-10 py-8 px-10 button bg-white w-max text-15 text-black <?=$style?>" value="<?=$content?>" <?=$other?>>
            <?php
            break;
        case 'red':
            ?>
            <input type="<?=$type?>" class="flex text-center radius-10 py-8 px-10 button bg-primary w-max text-15 <?=$style?>" value="<?=$content?>" <?=$other?>>
            <?php
            break;
    }
}

function littleButton($content, $type="button", $other= ""){
    ?>
    <input type="<?=$type?>" class="py-6 px-8 flex text-center radius-4 bg-white button w-max text-black text-10" value="<?=$content?>" <?=$other?>>
    <?php
}
