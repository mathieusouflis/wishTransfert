<?php
require_once './Models/Model.php';

class FileLink {
    private $file_link_id;
    private $link_id;
    private $file_id;
    private static $table = "files_links";

    public static function getByLink_id($link_id) {
        $result = Model::find(self::$table, ['link_id' => $link_id]);

        $link = new self();
        $link->file_link_id = $result[0]["file_link_id"];
        $link->link_id = $result[0]["link_id"];
        $link->file_id = $result[0]["file_id"];

        return $link;
    }

    public static function getByFile_id($file_id) {
        $result = Model::find(self::$table, ['file_id' => $file_id]);

        $link = new self();
        $link->file_link_id = $result[0]["file_link_id"];
        $link->link_id = $result[0]["link_id"];
        $link->file_id = $result[0]["file_id"];

        return $link;
    }

    public static function createFilesLinks($link_id, $file_id){
        $result = Model::insert(self::$table, ["link_id"=> $link_id, "file_id"=> $file_id]);
        //TODO: Faire en sorte que ça renvois le lien créé
        return $result;
    }
    
    public static function deleteFilesLinks($link_id = null, $file_id = null){
        $conditions = [];
        if ($link_id !== null) {
            $conditions['link_id'] = $link_id;
        }
        if ($file_id !== null) {
            $conditions['file_id'] = $file_id;
        }
        
        $result = Model::delete(self::$table, $conditions);
        return $result;
    }
}
?>
