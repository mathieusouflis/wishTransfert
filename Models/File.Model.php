<?php
require_once './Models/Model.php';

class File {
    private $fileid;
    private $userid;
    private $title;
    private $filedata;
    private $downloadcount;
    private $status;
    private $createdat;
    private static $table = "FILES";

    public static function getByFileId($fileid) {
        $result = Model::find(self::$table, ['file_id' => $fileid], 1);

        $file = new self();
        $file->fileid = $result[0]["file_id"];
        $file->userid = $result[0]["user_id"];
        $file->title = $result[0]["title"];
        $file->filedata = $result[0]["file_data"];
        $file->downloadcount = $result[0]["download_count"];
        $file->status = $result[0]["status"];
        $file->createdat = $createdat[0]["created_at"];

        return $file;
    }

    public static function getByUserId($userid) {
        $result = Model::find(self::$table, ['user_id' => $userid], 1);

        $file = new self();
        $file->fileid = $result[0]["file_id"];
        $file->userid = $result[0]["user_id"];
        $file->title = $result[0]["title"];
        $file->filedata = $result[0]["file_data"];
        $file->downloadcount = $result[0]["download_count"];
        $file->status = $result[0]["status"];
        $file->createdat = $createdat[0]["created_at"];

        return $file;
    }

    public static function createFile($userid, $title, $filedata){
        $downloadcount = 0;
        $status = "Stored";
        $result = Model::insert(self::$table, ["user_id" => $userid, "title" => $title, "file_data" => $filedata, "download_count" => $downloadcount, "status" => $status]);
        return $result;
    }

    public static function moveToBin($userid, $title, $filedata){
        $status = "Trash";
        $result = Model::insert(self::$table, ["user_id" => $userid, "title" => $title, "file_data" => $filedata, "download_count" => $downloadcount, "status" => $status]);
        return $result;
    }

    public static function deleteFile($fileid){
        $result = Model::delete(self::$table, ["file_id"=> $fileid]);
        return $result;
    }

    public static function downloadFile($fileid) {
        $result = Model::find(self::$table, ['file_id' => $fileid], 1);
    
        $filename = $result[0]["title"]; 
        $filedata = $result[0]["file_data"]; 
        $filetype = $result[0]["type"]; 
    
        // Définir les headers HTTP pour le téléchargement
        header("Content-Type: " . $filetype);
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . strlen($filedata));
    
        return $result;
    }
    

}

$fileModel = new File();
?>
