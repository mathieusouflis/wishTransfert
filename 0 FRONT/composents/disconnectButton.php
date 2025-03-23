<?php
require_once "./0 FRONT/composents/buttons.php";
require_once "./config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    echo '<script>window.location.href = "'.APP_URL.'login.php";</script>';
    exit;
}
?>

<form method="POST" class="w-full">
    <?php 
    mediumButton('Disconnect', 'submit', 'red', style:"w-full", other:'name="logout"');
    ?>
</form>
