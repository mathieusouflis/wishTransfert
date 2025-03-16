<?php
require_once './Models/Model.php';
// Supprimez cette ligne pour éviter la double inclusion
// require_once './Models/User.Model.php';

class File {
    public $fileid;
    public $userid;
    public $title;
    public $filedata;
    public $downloadcount;
    public $status;
    public $createdat;
    private static $table = "files";

    public static function getByFileId($fileid) {
        $result = Model::find(self::$table, ['file_id' => $fileid], 1);
        
        if (empty($result)) {
            return false;
        }

        $file = new self();
        $file->fileid = $result[0]["file_id"];
        $file->userid = $result[0]["user_id"];
        $file->title = $result[0]["title"];
        $file->filedata = $result[0]["file_data"];
        $file->downloadcount = $result[0]["download_count"];
        $file->status = $result[0]["status"];
        $file->createdat = $result[0]["created_at"];

        return $file;
    }

    public static function getByUserId($userid) {
        $results = Model::find(self::$table, ['user_id' => $userid]);
        
        if (empty($results)) {
            return [];
        }
        
        $files = [];
        foreach ($results as $result) {
            $file = new self();
            $file->fileid = $result["file_id"];
            $file->userid = $result["user_id"];
            $file->title = $result["title"];
            $file->filedata = $result["file_data"];
            $file->downloadcount = $result["download_count"];
            $file->status = $result["status"];
            $file->createdat = $result["created_at"];
            $files[] = $file;
        }

        return $files;
    }

    public static function createFile($userid, $title, $type, $filedata){
        $downloadcount = 0;
        $status = "Stored";
        $result = Model::insert(self::$table, [
            "user_id" => $userid, 
            "title" => $title, 
            "file_data" => $filedata, 
            "download_count" => $downloadcount, 
            "status" => $status
        ]);
        return $result;
    }

    public static function moveToBin($userid, $title, $filedata){
        $downloadcount = 0;
        $status = "Trash";
        $result = Model::insert(self::$table, [
            "user_id" => $userid, 
            "title" => $title, 
            "file_data" => $filedata, 
            "download_count" => $downloadcount, 
            "status" => $status
        ]);
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
    
        echo $filedata;
        exit;
    }
    

}