<?php
require_once './Models/Model.php';

class Links {
    public $linkid;
    public $fileid;
    public $userid;
    public $token;
    public $createdat;
    private static $table = "links";

    public static function getByLinkId($linkid) {
        $result = Model::find(self::$table, ['link_id' => $linkid], 1);

        if (!$result || empty($result)) {
            return false;
        }

        if (isset($result[0])) {
            $result = $result[0];
        } else {
            return false;
        }

        $link = new self();
        // Correction: Accès direct au premier élément du tableau result sans index supplémentaire
        $link->linkid = $result["link_id"];
        $link->userid = $result["user_id"];
        $link->token = $result["token"];
        $link->createdat = $result["created_at"];

        return $link;
    }

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

        $link = new self();
        // Correction: Accès direct au premier élément du tableau result sans index supplémentaire
        $link->linkid = $result["link_id"];
        $link->fileid = $result["file_id"];
        $link->userid = $result["user_id"];
        $link->token = $result["token"];
        $link->createdat = $result["created_at"];

        return $link;
    }

    public static function getByUserId($userid) {
        $results = Model::find(self::$table, ['user_id' => $userid]);

        $links = [];

        foreach ($results as $result) {
            $link = new self();
            // Correction: Accès direct au tableau result sans index supplémentaire
            $link->linkid = $result["link_id"];
            $link->userid = $result["user_id"];
            $link->token = $result["token"];
            $link->createdat = $result["created_at"];
            $links[] = $link;
        }

        return $links;
    }

    public static function getByToken($token) {
        $result = Model::find(self::$table, ['token' => $token], 1);

        if (!$result || empty($result)) {
            return false;
        }

        if (isset($result[0])) {
            $result = $result[0];
        } else {
            return false;
        }

        $link = new self();
        // Correction: Accès direct au premier élément du tableau result sans index supplémentaire
        $link->linkid = $result["link_id"];
        $link->userid = $result["user_id"];
        $link->token = $result["token"];
        $link->createdat = $result["created_at"];

        return $link;
    }

    public static function createLink($userid){
        $token = bin2hex(random_bytes(32));
        $result = Model::insert(self::$table, ["user_id"=> $userid, "token"=> $token]);
        
        $link = new self();
        // Correction: Accès direct au tableau result sans index supplémentaire
        $link->linkid = $result["link_id"];
        $link->userid = $result["user_id"];
        $link->token = $result["token"];
        $link->createdat = $result["created_at"];

        return $link;
    }
    
    public static function delete($linkid){
        $result = Model::delete(self::$table, ["link_id"=> $linkid]);

        $link = new self();
        // Correction: Accès direct au tableau result sans index supplémentaire
        $link->linkid = $result["link_id"];
        $link->userid = $result["user_id"];
        $link->token = $result["token"];
        $link->createdat = $result["created_at"];

        return $link;
    }
}
?>