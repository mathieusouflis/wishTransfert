<?php
require_once './Models/Model.php';

class File {
    public $fileid;
    public $userid;
    public $title;
    public $filedata;
    public $downloadcount;
    public $status;
    public $createdat;
    public $type;
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
        // Correction: Accès au bon index du tableau
        $file->type = $result[0]["type"];
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
            // Correction: Accès direct au tableau result sans index supplémentaire
            $file->type = $result["type"];
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
            "status" => $status,
            "type" => $type // Ajout: Inclure le type dans l'insertion
        ]);

        $file = new self();
        $file->fileid = $result["file_id"];
        $file->userid = $result["user_id"];
        $file->title = $result["title"];
        $file->filedata = $result["file_data"];
        $file->downloadcount = $result["download_count"];
        $file->status = $result["status"];
        // Correction: Accès direct au tableau result sans index supplémentaire
        $file->type = $result["type"];
        $file->createdat = $result["created_at"];
        return $file;
    }

    public static function moveToBin($fileid){
        $status = "Trash";
        $result = Model::update(self::$table, [
            "status" => $status
        ], ["file_id" => $fileid]);
        
        $file = new self();
        $file->fileid = $result["file_id"];
        $file->userid = $result["user_id"];
        $file->title = $result["title"];
        $file->filedata = $result["file_data"];
        $file->downloadcount = $result["download_count"];
        $file->status = $result["status"];
        // Correction: Accès direct au tableau result sans index supplémentaire
        $file->type = $result["type"];
        $file->createdat = $result["created_at"];

        return $file;
    }

    public static function deleteFile($fileid){
        $result = Model::delete(self::$table, ["file_id"=> $fileid]);
        
        $file = new self();
        $file->fileid = $result["file_id"];
        $file->userid = $result["user_id"];
        $file->title = $result["title"];
        $file->filedata = $result["file_data"];
        $file->downloadcount = $result["download_count"];
        $file->status = $result["status"];
        // Correction: Accès direct au tableau result sans index supplémentaire
        $file->type = $result["type"];
        $file->createdat = $result["created_at"];

        return $file;
    }
}