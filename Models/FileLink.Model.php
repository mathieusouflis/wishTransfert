<?php
require_once './Models/Model.php';

class FileLink {
    public $file_link_id;
    public $link_id;
    public $file_id;
    private static $table = "files_links";

    public static function getByLink_id($link_id) {
        $results = Model::find(self::$table, ['link_id' => $link_id]);

        $links = [];
        foreach ($results as $result) {
            $link = new self();
            $link->file_link_id = $result["file_link_id"];
            $link->link_id = $result["link_id"];
            $link->file_id = $result["file_id"];
            $links[] = $link;
        }

        return $links;
    }

    public static function getByFile_id($file_id) {
        $results = Model::find(self::$table, ['file_id' => $file_id]);

        $links = [];
        foreach ($results as $result) {
            $link = new self();
            $link->file_link_id = $result["file_link_id"];
            $link->link_id = $result["link_id"];
            $link->file_id = $result["file_id"];
            $links[] = $link;
        }

        return $links;
    }

    public static function createFilesLinks($link_id, $file_id){
        $result = Model::insert(self::$table, ["link_id"=> $link_id, "file_id"=> $file_id]);
        
        $link = new self();
        $link->file_link_id = $result["file_link_id"];
        $link->link_id = $result["link_id"];
        $link->file_id = $result["file_id"];

        return $link;
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
        
        $link = new self();
        $link->file_link_id = $result["file_link_id"];
        $link->link_id = $result["link_id"];
        $link->file_id = $result["file_id"];

        return $link;
    }
}
?>
