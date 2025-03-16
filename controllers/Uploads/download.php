<?php
require_once "./Models/File.Model.php";

if (isset($_GET['file_id'])) {
    $fileid = 3;
    File::downloadFile($fileid);
} else {
    echo "Aucun ID de fichier fourni.";
}
?>
