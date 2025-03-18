<?php
require_once "Models/User.Model.php";

class UserController{
    public static function editEmail(){
        global $errors;
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

            if(empty($email)){
                $errors[] = "Email is required";
            }else {
                $user = User::get(["email" => $email]);
                if($user){
                    $errors[] = "Email already exists";
                }else {
                    if(!isset($_SESSION)) session_start();
                    if(User::isEmailUnique($email)){
                        $modifyRequest = User::update($_SESSION["user_id"], null, null, $email);
                        if($modifyRequest){
                            return true;
                        }else{
                            $errors[] = "An error occured";
                        }
                    }else {
                        $errors[] = "Email allready taken.";
                    }
                }
            }
        }
    }

    public static function editProfile(){
        global $errors;
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $username = filter_input(INPUT_POST,"username");
            $avatar = filter_input(INPUT_POST,"avatar");

            if(empty($username && empty($avatar))){
                $errors[] = "Everything is empty, can't edit";
            }else {
                if(!isset($_SESSION)) session_start();
                if($username && User::isUsernameUnique($username)){
                    $modifyRequest = User::update($_SESSION["user_id"], $username ? null : $username, null, null);
                    if(!$modifyRequest){
                        $errors[] = "An error occured";
                    }else {
                        return true;
                    }
                } else {
                    $errors[] = "Username allready taken.";
                }
            }
        }
    }

    public static function editPassword(){
        global $errors;
        $oldPassword = filter_input(INPUT_POST,"oldPassword");
        $newPassword = filter_input(INPUT_POST,"newPassword");
        $newPasswordConfirm = filter_input(INPUT_POST,"newPasswordConfirm");

        if(empty($oldPassword)){
            $errors[] = "Old password is required";
        }
        if(empty($newPassword)){
            $errors[] = "New password is required";
        } else if (User::isPasswordValid($newPassword)) {
            $errors[] = "Password not ok";
        }
        if(empty($newPasswordConfirm)){
            $errors[] = "New password confirmation is required";
        }else if ($newPassword !== $newPasswordConfirm){
            $errors[] = "Passwords do not match";
        }

        if(empty($errors)){
            if(!isset($_SESSION)) session_start();
            $modifyRequest = User::update($_SESSION["user_id"], null, $newPassword, null);
            if(!$modifyRequest){
                $errors[] = 'An error occured.';
            }else {
                return true;
            }
        }
    }

    public static function delete(){
        global $errors;
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(!isset($_SESSION)) session_start();
            $userId = $_SESSION["user_id"];
            if(empty($userId)){
                $errors[] = "You must be logged in to delete your account";
            }else{
                $deleteRequest = User::delete($userId);
                if($deleteRequest){
                    return true;
                }else{
                    $errors[] = "An error occured";
                }
            }
        }
    }
}