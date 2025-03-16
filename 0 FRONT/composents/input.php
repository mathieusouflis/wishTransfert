<?php {
    function input($name, $placeHolder, $default, $styles=""){
        ?>
        <div class="input flex flex-col p-8 items-start gap-4 bg-white radius-10 border-2 border-gray w-full">
            <label class="text-10 w-full text-black" for="<?=$name?>"><?=$name?></label>
            <input class="text-14 text-gray w-full" type="text" name="<?=$name?>" id="<?=$name?>" value="<?=$default?>" placeholder="<?=$placeHolder?>">
        </div>
        <?php
    }
}