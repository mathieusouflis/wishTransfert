<?php 
require_once "./0 FRONT/composents/icons.php";

function topList($leftContent, $rightContent = ""){
    ?>

    <div class="flex flex-row justify-between p-10 bg-white radius-t-10">
        <span class="text-15 text-black"><?=$leftContent?></span>
        <div class="flex flex-row gap-10">
            <span class="text-15 text-black"><?=$rightContent?></span>
            <?= icon("x", "small")?>
        </div>
    </div>

    <?php
}

function midList($leftContent, $rightContent = "", $o2 = false){
    ?>

    <div class="flex flex-row justify-between p-10 <?php if($o2){
        echo "bg-gray";
        }else{
            echo "bg-white";
        }?>">
        <span class="text-15 text-black"><?=$leftContent?></span>
        <div class="flex flex-row gap-10">
            <span class="text-15 text-black"><?=$rightContent?></span>
            <?= icon("x", "small")?>
        </div>
    </div>

    <?php
}


function bottomList($leftContent, $rightContent = "", $o2 = false){
    ?>

    <div class="flex flex-row justify-between p-10  <?php 
        if($o2){
            echo "bg-gray";
        }else{
            echo 'bg-white';
        }
        ?> radius-b-10">
        <span class="text-15 text-black"><?=$leftContent?></span>
        <div class="flex flex-row gap-10">
            <span class="text-15 text-black"><?=$rightContent?></span>
            <?= icon("x", "small")?>
        </div>
    </div>

    <?php
}

