<?php
require_once "./0 FRONT/composents/buttons.php";
session_start();

// Gestion de la déconnexion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<form method="POST" action="Logout" class="w-full">
    <?php 
    mediumButton('Disconnect', 'submit', 'red', style:"w-full", other:'name="logout"');
    ?>
</form>