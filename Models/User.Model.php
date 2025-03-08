<?php
require_once './Models/Model.php';

class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private static $table = "USERS";

    public static function getById($id){
        $result = Model::find(self::$table, ['user_id' => $id], 1);

        $user = new self();
        $user->id = $result[0]["user_id"];
        $user->username = $result[0]["username"];
        $user->password = $result[0]["password"];
        $user->email = $result[0]["email"];
        
        return $user;
    }
    
    public static function getByEmail($email){
        $result = Model::find(self::$table, ["email"=> $email],1);
        
        $user = new self();
        $user->id = $result[0]["user_id"];
        $user->username = $result[0]["username"];
        $user->password = $result[0]["password"];
        $user->email = $result[0]["email"];
        
        return $user;
    }

    public static function create($username, $password, $email){
        $result = Model::insert(self::$table, ["username"=> $username,"password"=> $password,"email"=> $email]);
        return $result;
    }

    public static function update($id, $username, $password, $email){
        $result = Model::update(
            self::$table,
             array_merge(
                $username ? ["username"=> $username] : [],
                $password ? ["password"=> $password] : [],
                $email ? ["email"=> $email] : []
            ),
            ["user_id"=> $id]
        );
        return $result;
    }

    public static function delete($id){
        $result = Model::delete(self::$table, ["user_id"=> $id]);
        return $result;
    }
}