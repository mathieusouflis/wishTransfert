<?php
require_once "Models/File.Model.php"; 
require_once "Models/User.Model.php"; 
require_once "./controllers/LinkAuth.php";
require_once "./config/config.php";

class FileController {
    private $userid;
    private $title;
    private $filedata;
    
    public static function uploadFile($userid, $title, $type, $filedata){
        global $errors;
        if (strlen($filedata) > MAX_UPLOAD_SIZE) {
            $errors[] = "Le fichier est trop volumineux.";
            return false;
        }
        
        $extension = pathinfo($title, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'php') {
            $errors[] = "Les fichiers php ne sont pas autorisés.";
            return false;
        }
        
        return File::createFile($userid, $title, $type, $filedata);
    }
    
    public static function deleteFile($fileid){
        return File::deleteFile($fileid);
    }
    public static function downloadFile($fileid){
        $file = File::getByFileId($fileid);
        $filename = $file->title; 
        $filedata = $file->filedata; 
        $filetype = $file->type; 
         if (ob_get_level()) {
    ob_clean();
}
        header("Content-Type: " . $filetype);
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . strlen($filedata));
        exit;
    }
    
    public static function moveToBin($fileid){
        return File::moveToBin($fileid);
    }

    public static function useController(){
        global $errors;
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST["upload-file"])) {
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                $userid = $_SESSION["user_id"];
                if(!isset($_FILES["file-to-upload"]) || empty($_FILES["file-to-upload"]) || empty($_FILES["file-to-upload"]["name"][0]) || !$email) {
                    $errors[] = "Files or email is missing.";
                    return;
                }else if (User::isEmailUnique($email)){
                    $errors[] = "Email is not associated to a valid user.";
                    return;
                }
                
                $uploadedFilesId = [];
                
            if (!is_array($_FILES["file-to-upload"])) {
                $file = $_FILES["file-to-upload"];
                if ($file["error"] === UPLOAD_ERR_OK) {
                    $tmpName = $file["tmp_name"];
                    $title = $file["name"];
                    $type = $file["type"];
                    $filedata = file_get_contents($tmpName);
                    $uploadedFile = FileController::uploadFile($userid, $title, $type, $filedata);
                    if ($uploadedFile) {
                        $uploadedFilesId[] = $uploadedFile->fileid;
                    }
                }
            } else {
                foreach ($_FILES["file-to-upload"]["name"] as $key => $name) {
                    $title = $_FILES["file-to-upload"]["name"][$key];
                    $type = $_FILES["file-to-upload"]["type"][$key];
                    $tmpName = $_FILES["file-to-upload"]["tmp_name"][$key];
                    $filedata = file_get_contents($tmpName);
                    $uploadedFile = FileController::uploadFile($userid, $title, $type, $filedata);
                    if ($uploadedFile) {
                        $uploadedFilesId[] = $uploadedFile->fileid;
                    }
                }
            }
                if(!empty($uploadedFilesId)) {
                    $link = LinkAuthController::createShareLink($uploadedFilesId, $userid, $email);
                    $shareLink = APP_URL . "download.php/?token=" . $link;
                    echo "<script>
                        navigator.clipboard.writeText('" . $shareLink . "').then(function() {
                            alert('Link copied to clipboard!');
                        }).catch(function() {
                            // Fallback for older browsers
                            var tempInput = document.createElement('input');
                            tempInput.value = '" . $shareLink . "';
                            document.body.appendChild(tempInput);
                            tempInput.select();
                            document.execCommand('copy');
                            document.body.removeChild(tempInput);
                            alert('Link copied to clipboard!');
                        });
                    </script>";
                }
            }
            
            if(isset($_POST["delete-file"])) {
                $fileid = $_POST["fileid"];
                FileController::deleteFile($fileid);
            }
        }
    }
}