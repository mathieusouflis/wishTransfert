<?php
require_once './Models/Model.php';

class User {
    public $id;
    public $username;
    public $password;
    public $email;
    private static $table = "USERS";

    public static function get($params){
        $result = Model::find(self::$table, $params, 1);
        
        if(!$result) return false;

        $user = new self();
        $user->id = $result[0]["user_id"];
        $user->username = $result[0]["username"];
        $user->password = $result[0]["password"];
        $user->email = $result[0]["email"];
        
        return $user;
    }
    
    public static function getAll($params){
        $result = Model::find(self::$table, $params);
        
        if (!$result) return false;
        
        $users = [];
        
        foreach($result as $user){
            $newUser = new self();
            $newUser->id = $user["user_id"];
            $newUser->username = $user["username"];
            $newUser->email = $user["email"];
            $newUser->password = $user["password"];
            $users[] = $newUser;
        }

        return $users;
    }

    public static function create($username, $password, $email){
        global $errors;
        $errors = [];
        
        if(!self::isUsernameValid($username)){
            $errors[] = "Username is not valid (minimum 4 characters), only . and _ allowed";
            error_log("Username invalide: $username");
        }else if (!self::isUsernameUnique($username)){
            $errors[] = "Username is note unique";
            error_log("Username déjà utilisé: $username");
        }
        
        if(!self::isEmailUnique($email)){
            $errors[] = "Email is allready used";
            error_log("Email déjà utilisé: $email");
        }
        
        if(!self::isPasswordValid($password)){
            $errors[] = "Password must contain at least  8 characters, 1 lowercase, 1 uppercase, 1 number and 1 special characters (@$!%*?&)";
            error_log("Mot de passe invalide");
        }

        if(empty($errors)){
            error_log("Tentative d'insertion d'utilisateur: $username, $email");
            try {
                $result = Model::insert(self::$table, ["username"=> $username,"password"=> $password,"email"=> $email]);
                error_log("Insertion réussie");
                return $result;
            } catch (Exception $e) {
                error_log("Erreur d'insertion: " . $e->getMessage());
                $errors[] = "Database error: " . $e->getMessage();
                return false;
            }
        } else {
            error_log("Erreurs de validation: " . implode(", ", $errors));
            return false;
        }
    }

    public static function update($id, $username, $password, $email){
        $errors = [];
        if($username && !self::isUsernameValid($username)){
            $errors[] = "Username is not valid (minimum 4 characters), only . and _ allowed";
        }else if ($username && !self::isUsernameUnique($username)){
            $errors[] = "Username is note unique";
        }
        if($email && !self::isEmailUnique($email)){
            $errors[] = "Email is allready used";
        }
        if($password && !self::isPasswordValid($password)){
            $errors[] = "Password must contain at least  8 characters, 1 lowercase, 1 uppercase, 1 number and 1 special characters (@$!%*?&)";
        }

        if(empty($errors)){
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
        }else{
            return false;
        }
    }

    public static function delete($id){
        $result = Model::delete(self::$table, ["user_id"=> $id]);
        return $result;
    }

    public static function isPasswordValid($password){
        return preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password);
    }

    public static function isUsernameValid($username){
        return preg_match("/^[a-zA-Z0-9._]{4,}$/", $username);
    }

    public static function isEmailUnique($email){
        return self::get(["email"=> $email]) === false;
    }

    public static function isUsernameUnique($username){
        return self::get(["username" => $username]) === false;
    }
}