<?php
require_once './Models/Model.php';

class EmailLink {
    public $email_link_id;
    public $link_id;
    public $email;
    private static $table = "emails_links";

    public static function getByEmail($email) {
        $results = Model::find(self::$table, ['email' => $email]);

        $email_links = [];
        foreach ($results as $result) {
            $email_link = new self();
            $email_link->email_link_id = $result["email_link_id"];
            $email_link->link_id = $result["link_id"];
            $email_link->email = $result["email"];
            $email_links[] = $email_link;
        }

        return $email_links;
    }

    public static function getByLink_id($link_id) {
        $results = Model::find(self::$table, ['link_id' => $link_id]);

        $email_links = [];
        foreach ($results as $result) {
            $email_link = new self();
            $email_link->email_link_id = $result["email_link_id"];
            $email_link->link_id = $result["link_id"];
            $email_link->email = $result["email"];
            $email_links[] = $email_link;
        }
        
        return $email_links;
    }

    public static function createEmailLinks($link_id, $email){
        $result = Model::insert(self::$table, ["link_id"=> $link_id, "email"=> $email]);
        
        if (!$result) {
            return false;
        }
        
        $email_link = new self();
        $email_link->email_link_id = $result["email_link_id"];
        $email_link->link_id = $result["link_id"];
        $email_link->email = $result["email"];

        return $email_link;
    }
    
    public static function deleteEmailLinks($email = null, $link_id = null){
        $conditions = [];
        if ($email !== null) {
            $conditions['email'] = $email;
        }
        if ($link_id !== null) {
            $conditions['link_id'] = $link_id;
        }
        
        $result = Model::delete(self::$table, $conditions);
        
        if (!$result) {
            return false;
        }
        
        $email_link = new self();
        $email_link->email_link_id = $result["email_link_id"];
        $email_link->link_id = $result["link_id"];
        $email_link->email = $result["email"];

        return $email_link;
    }
}
?>
