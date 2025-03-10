<?php
require_once './Models/Model.php';

class File {
    private $fileid;
    private $userid;
    private $title;
    private $filedata;
    private $downloadcount;
    private static $table = "FILES";

    public static function getByFileId($fileid) {
        $result = Model::find(self::$table, ['file_id' => $fileid], 1);

        $file = new self();
        $file->fileid = $result[0]["file_id"];
        $file->userid = $result[0]["user_id"];
        $file->title = $result[0]["title"];
        $file->filedata = $result[0]["file_data"];
        $file->downloadcount = $result[0]["download_count"];

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

        return $file;
    }

    public static function getByTitle($title) {
        $result = Model::find(self::$table, ['title' => $title], 1);

        $file = new self();
        $file->fileid = $result[0]["file_id"];
        $file->userid = $result[0]["user_id"];
        $file->title = $result[0]["title"];
        $file->filedata = $result[0]["file_data"];
        $file->downloadcount = $result[0]["download_count"];

        return $file;
    }

    public static function getByDownloadCount($downloadcount) {
        $result = Model::find(self::$table, ['download_count' => $downloadcount], 1);

        $file = new self();
        $file->fileid = $result[0]["file_id"];
        $file->userid = $result[0]["user_id"];
        $file->title = $result[0]["title"];
        $file->filedata = $result[0]["file_data"];
        $file->downloadcount = $result[0]["download_count"];

        return $file;
    }

    public static function createFile($userid, $title, $filedata, $downloadcount){
        $result = Model::insert(self::$table, ["user_id" => $userid, "title" => $title, "file_data" => $filedata, "download_count" => $downloadcount]);
        return $result;
    }

    public static function deleteFile($fileid){
        $result = Model::delete(self::$table, ["file_id"=> $fileid]);
        return $result;
    }
}
?>