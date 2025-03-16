<?php
require_once "Models/File.Model.php"; 

class FileController {
    private $userid;
    private $title;
    private $filedata;
    
    public function uploadFile($userid, $title, $type, $filedata){
        // Vérification de la taille
        if (strlen($filedata) > 20 * 1024 * 1024) {
            return false;
        }
        
        // Interdire les fichiers .php
        $extension = pathinfo($title, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'php') {
            return false;
        }
        
        // Renommage du fichier
        $newFilename = uniqid() . '_' . $title;
        
        return File::createFile($userid, $newFilename, $type, $filedata);
    }
    
    public function deleteFile($fileid){
        return File::deleteFile($fileid);
    }
    
    public function moveToBin($userid, $title, $filedata){
        $status = "Trash";
        return File::moveToBin($userid, $title, $filedata);
    }
}

if($_SERVER["REQUEST_METHOD"]=== "POST"){
    
    $file = $_FILES["file"];
    
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $userid = $_SESSION["user_id"] ?? 1232; // Fallback pour le test
    $title = $file["name"];
    $type = $file["type"];
    $filedata = file_get_contents($file["tmp_name"]);
    
    $fileController = new FileController();
    if(isset($_POST["create"])) $fileController->uploadFile($userid, $title, $type, $filedata);
    if(isset($_POST["delete"])) $fileController->deleteFile($fileid);
}
$fileController = new FileController();