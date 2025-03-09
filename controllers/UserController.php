<?php
require_once("models/User.Model.php");

class UserController{

    public function getById($id){
        // $user = User::get(["user_id" => $id]);

    }
    
    public function getByEmail($email){
        // $user = User::get(["email" => $email]);
        // return $user;
    }

    public function getByUsername($username){
        // return User::get(["username" => $username]);
    }
    public function create($data){
        $username = $data["username"];
        $email = $data["email"];
        $password = $data["password"];
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email format";
        }
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            $errors[] = "Password must be at least 8 characters long and contain at least one letter and one number";
        }
        if (!preg_match('/^[A-Za-z0-9._]{2,}$/', $username)) {
            $errors[] = "Username must be at least 2 characters and can only contain letters, numbers, dots and underscores";
        }


    }

    public function update($id, $data){
        $username = $data["username"];
        $email = $data["email"];
        $password = $data["password"];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email format";
        }
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
            $errors[] = "Password must be at least 8 characters long and contain at least one letter and one number";
        }
        if (!preg_match('/^[A-Za-z0-9._]{2,}$/', $username)) {
            $errors[] = "Username must be at least 2 characters and can only contain letters, numbers, dots and underscores";
        }


    }

    public function delete($id){
    
    }

}