<?php
require_once ("Models/Link.Model.php");
require_once ("Models/FileLink.Model.php");
require_once ("Models/File.Model.php");
require_once ("controllers/FileController.php");

class LinkController{

    public static function delete(){
        global $errors;
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete-link"])){
            $id = $_POST["id"]; 

            if(empty($id)){
                $errors[] = "Internal Error.";
            }else {
                $link = Links::getByLinkId($id);
                if(empty($link)){
                    $errors[] = "Link not found.";
                }else{
                    $fileLinks = FileLink::getByLink_id($id);
                    $files = [];
                    foreach ($fileLinks as $fileLink){
                        $file = Files::getByFileId($fileLink->file_id);
                        Files::delete($file->fileid);
                        FileLink::delete($fileLink->file_link_id);
                    }
                    Links::delete($link->linkid);
                }
            }

            
        }
    }

    public static function getFiles(){
        $link_token = $_GET['token'];
        $link = Links::getByToken($link_token);
        $filesIds = FileLink::getByLink_id($link->linkid);
        $files = [];
        foreach($filesIds as $id){
            $files[] = File::getByFileId( $id );
        }
        FileController::downloadFile($files);
    }

}
