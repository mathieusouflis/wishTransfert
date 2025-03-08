<?php
if (!isset($_SESSION["connecte"])) {
    header('Location: http://localhost:8888/login.php');
    exit;
}
?>