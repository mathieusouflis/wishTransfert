<?php
if (!isset($_SESSION["connecte"])) {
    header('Location: http://localhost/test/login/connexion.php');
    exit;
}
?>