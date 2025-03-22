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
        
        if (!$result || empty($result)) {
            return false;
        }

        if (isset($result[0])) {
            $result = $result[0];
        } else {
            return false;
        }

        $file = new self();
        $file->fileid = $result["file_id"];
        $file->userid = $result["user_id"];
        $file->title = $result["title"];
        $file->filedata = $result["file_data"];
        $file->downloadcount = $result["download_count"];
        $file->status = $result["status"];
        // Correction: Accès au bon index du tableau
        $file->type = $result["type"];
        $file->createdat = $result["created_at"];

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
        
        // Check if multiple files were deleted
        if (is_array($result) && isset($result[0])) {
            $files = [];
            foreach ($result as $deletedFile) {
                $file = new self();
                $file->fileid = $deletedFile["file_id"];
                $file->userid = $deletedFile["user_id"];
                $file->title = $deletedFile["title"];
                $file->filedata = $deletedFile["file_data"];
                $file->downloadcount = $deletedFile["download_count"];
                $file->status = $deletedFile["status"];
                // Correction: Accès direct au tableau result sans index supplémentaire
                $file->type = $deletedFile["type"];
                $file->createdat = $deletedFile["created_at"];
                $files[] = $file;
            }
            return $files;
        } else {
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
}