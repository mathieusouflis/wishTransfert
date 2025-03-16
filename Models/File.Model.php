<?php
require_once './Models/Model.php';
// Supprimez cette ligne pour éviter la double inclusion
// require_once './Models/User.Model.php';

class File {
    private $fileid;
    private $userid;
    private $title;
    private $filedata;
    private $downloadcount;
    private $status;
    private $createdat;
    private static $table = "files";

    public function getFileid() {
        return $this->fileid;
    }
    
    public function getUserid() {
        return $this->userid;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getFiledata() {
        return $this->filedata;
    }
    
    public function getDownloadcount() {
        return $this->downloadcount;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function getCreatedat() {
        return $this->createdat;
    }

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
}