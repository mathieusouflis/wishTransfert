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
    $baseStyle = "flex flex-row pl-33 pr-10 py-8 content-center items-center gap-10 button text-15 w-max";
    switch ($buttonStyle) {
        case 'full':
            ?>
                <div class="<?=$style?> relative">
                    <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                    <input type="<?=$type?>" class="<?=$baseStyle?> radius-10 bg-primary <?=$style?>" value="<?=$content?>"  <?=$other?>>
                </div>
            <?php
            break;
        case 'full-white':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "black", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="<?=$baseStyle?> radius-10 text-black bg-white <?=$style?>" value="<?=$content?>"  <?=$other?>>
            </div>
            <?php
            break;
        case 'left':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="<?=$baseStyle?> radius-l-10 <?=$whiteColor?> <?=$style?>" value="<?=$content?>" <?=$other?>>
            </div>
            <?php
            break;
        case 'right':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="<?=$baseStyle?> radius-r-10 <?=$whiteColor?> <?=$style?>" value="<?=$content?>" <?=$other?>>
            </div>
            <?php
            break;
        case 'none':
            ?>
            <div class="<?=$style?> relative">
                <?=icon($iconName, "little", "white", "absolute left-10 top-8")?>
                <input type="<?=$type?>" class="<?=$baseStyle?> <?=$whiteColor?> <?=$style?>" value="<?=$content?>" <?=$other?>>
            </div>
            <?php
            break;
    }
}

function mediumButton($content, $type="button", $buttonStyle="red", $style= "", $other = ""){
    $mediumButtonBaseStyle = "flex text-center radius-10 py-8 px-10 button text-15 w-max";
    switch ($buttonStyle) {
        case 'white':
            ?>
            <input type="<?=$type?>" class="<?=$mediumButtonBaseStyle?> bg-white text-black <?=$style?>" value="<?=$content?>"  <?=$other?>>
            <?php
            break;
        case 'red':
            ?>
            <input type="<?=$type?>" class="<?=$mediumButtonBaseStyle?> bg-primary <?=$style?>" value="<?=$content?>"  <?=$other?>>
            <?php
            break;
    }
}

function littleButton($content, $type="button", $other= ""){
    ?>
    <input type="<?=$type?>" class="py-6 px-8 flex text-center radius-4 bg-white button w-max text-black text-10" value="<?=$content?>" <?=$other?>>
    <?php
}
