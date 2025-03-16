<?php
require_once "Models/File.Model.php"; 

class fileController {
    private $userid;
    private $title;
    private $filedata;
    
    
    
    public function uploadFile($userid,$title,$type,$filedata){
        File::createFile($userid,$title,$type,$filedata);
    }
    public function deleteFile($userid, $title, $filedata){
        $fileModel->moveToBin($userid, $title, $filedata);
    }
    public function downloadFile($fileid){
        File::downloadFile($fileid);
        exit;
        
    }
}

if($_SERVER["REQUEST_METHOD"]=== "POST"){
    
    
    $fileController = new FileController();
    if(isset($_POST["create"])) {
        $file = $_FILES["file"];
        $userid = 1232;
        $title = $file["name"];
        $type = $file["type"];
        $filedata = file_get_contents($file ["tmp_name"]);
        $fileController->uploadFile($userid,$title,$type,$filedata);
    }
    if(isset($_POST["delete"])) $fileController->deleteFile($userid, $title, $filedata);
    if(isset($_POST["download"])) $fileController->downloadFile($fileid);
}
$fileController = new FileController();



?>