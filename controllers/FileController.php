<?php
require_once "Models/File.Model.php"; 

class FileController {
    private $userid;
    private $title;
    private $filedata;
    
    public static function uploadFile($userid, $title, $type, $filedata){
        // Vérification de la taille
        if (strlen($filedata) > 20 * 1024 * 1024) { //TODO: AJOUTER LA TAILLE MAX AVEC LE CONFIG
            return false;
        }
        
        // Interdire les fichiers .php
        $extension = pathinfo($title, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'php') {
            return false;
        }
        
        // Renommage du fichier
        $newFilename = uniqid() . '_' . $title; //COMMENT: Pas besoin comme on met tout dans la DB
        
        return File::createFile($userid, $newFilename, $type, $filedata);
    }
    
    public static function deleteFile($fileid){
        return File::deleteFile($fileid);
    }
    public static function downloadFile($fileid){
        // TODO: Doit être fait pour plusieurs fichiers
        $file = File::getByFileId($fileid);
        $filename = $file->title; 
        $filedata = $file->filedata; 
        $filetype = $file->type; 
    
        // Définir les headers HTTP pour le téléchargement
        header("Content-Type: " . $filetype);
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . strlen($filedata));
    
        echo $filedata;
        exit;
    }
    
    public static function moveToBin($fileid){
        return File::moveToBin($fileid);
    }
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    if(isset($_POST["create"])) {
        $files = $_FILES["files"]["tmp_name"];
        $userid = 1232;
        foreach ($files as $index => $tmpName) {
            $title = $_FILES["files"]["name"][$index];
            $type = $_FILES["files"]["type"][$index];
            $filedata = file_get_contents($tmpName);
            FileController::uploadFile($userid, $title, $type, $filedata);
        }
    }
    
    if(isset($_POST["delete"])) {
        $fileid = $_POST["fileid"];
        FileController::deleteFile($fileid);
    }
}
