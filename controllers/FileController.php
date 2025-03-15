<?php
require_once "Models/file.Model.php"; 

class fileController {
    private $userid;
    private $title;
    private $filedata;
    
    
    
    public function uploadFile($userid,$title,$filedata){
        $fileModel->createFile($userid, $title, $filedata);
    }
    public function deleteFile($userid, $title, $filedata){
        $fileModel->moveToBin($userid, $title, $filedata);
    }
    
}

if($_SERVER["REQUEST_METHOD"]=== "POST"){
    
    $filedata = $_FILES["file"];
    $fileController = new FileController();
    if(isset($_POST["create"])) $fileController->uploadFile($userid,$title,$filedata);
    if(isset($_POST["delete"])) $fileController ->deleteFile($userid, $title, $filedata);
}


//
?>