<?php
require_once './Models/Model.php';

class Links {
    private $linkid;
    private $userid;
    private $token;
    private $createdat;
    private static $table = "links";

    public static function getByLinkId($linkid) {
        $result = Model::find(self::$table, ['link_id' => $linkid], 1);

        $link = new self();
        $link->linkid = $result[0]["link_id"];
        $link->userid = $result[0]["user_id"];
        $link->token = $result[0]["token"];
        $link->createdat = $result[0]["created_at"];

        return $link;
    }

    public static function getByUserId($userid) {
        $result = Model::find(self::$table, ['user_id' => $userid], 1);

        $link = new self();
        $link->linkid = $result[0]["link_id"];
        $link->userid = $result[0]["user_id"];
        $link->token = $result[0]["token"];
        $link->createdat = $result[0]["created_at"];

        return $link;
    }

    public static function getByToken($token) {
        $result = Model::find(self::$table, ['token' => $token], 1);

        $link = new self();
        $link->linkid = $result[0]["link_id"];
        $link->userid = $result[0]["user_id"];
        $link->token = $result[0]["token"];
        $link->createdat = $result[0]["created_at"];

        return $link;
    }

    public static function createLink($userid){
        $token = bin2hex(random_bytes(32));
        $result = Model::insert(self::$table, ["user_id"=> $userid, "token"=> $token]);
        return $result;
    }
    
    public static function deleteLink($linkid){
        $result = Model::delete(self::$table, ["link_id"=> $linkid]);
        return $result;
    }
}
?>
