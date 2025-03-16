<?php
require_once 'controllers/AuthController.php';
if (isLog() == false) {
    header('Location: http://localhost:8888/login.php');
    exit;
}
?>