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
        $files = $_FILES["files"]["tmp_name"];
        $userid = 1232;
        foreach ($files as $index => $tmpName) {
            $title = $_FILES["files"]["name"][$index];
            $type = $_FILES["files"]["type"][$index];
            $filedata = file_get_contents($tmpName);
            $fileController->uploadFile($userid,$title,$type,$filedata);
        }
    }
    if(isset($_POST["delete"])) $fileController->deleteFile($userid, $title, $filedata);
    if(isset($_POST["download"])) $fileController->downloadFile($fileid);
}
$fileController = new FileController();



?>