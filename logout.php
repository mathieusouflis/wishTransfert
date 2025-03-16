<?php
session_destroy();
if(isset($_POST['deconnexion'])) {
    header('Location: login.php'); exit;
}
?>
<form method="POST">
<input type="submit" value="Deconnexion" name="deconnexion">
</form>