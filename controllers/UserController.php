<?php
require_once "Models/User.Model.php";

if(session_status() === PHP_SESSION_NONE) session_start();

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
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editProfile"])){
            $username = filter_input(INPUT_POST,"username");
            $email = filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);

            if($username === $_SESSION["username"]) $username = null;
            if($email === $_SESSION["email"]) $email = null;

            if(empty($username) && empty($email)){
                $errors[] = "Everything is empty, can't edit";
            }else {
                if($username && !User::isUsernameUnique($username)) $errors[] = "Username allready taken.";
                if($email && !User::isEmailUnique($email)) $errors[] = "Email allready taken.";

                if(empty($errors)){
                    $modifyRequest = User::update($_SESSION["user_id"], $username ? $username : null, null, $email ? $email : null);
                    if(!$modifyRequest){
                        $errors[] = "An error occured";
                    }else {
                        $_SESSION["username"] = $username? $username : $_SESSION["username"];
                        $_SESSION["email"] = $email? $email : $_SESSION["email"];
                        return true;
                    }
                }
            }
        }
    }

    public static function editPassword(){
        global $errors;
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["change-password"])){
            $oldPassword = filter_input(INPUT_POST,"oldPassword");
            $newPassword = filter_input(INPUT_POST,"newPassword");
            $newPasswordConfirm = filter_input(INPUT_POST,"newPasswordConfirm");

            $user = User::get(["user_id" => $_SESSION["user_id"]]);
            if(!$user) {
                $errors[] = "Votre compte n'existe pas";
                return false;
            }

            if(empty($oldPassword)){
                $errors[] = "Old password is required";
            }else if (!password_verify($oldPassword, $user->password)){
                $errors[] = "Old password is wrong.";
            }
            if(empty($newPassword)){
                $errors[] = "New password is required";
            } else if (!User::isPasswordValid($newPassword)) {
                $errors[] = "Le mot de passe n'est pas valide, il doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@$!%*?&)";
            }
            if(empty($newPasswordConfirm)){
                $errors[] = "New password confirmation is required";
            }else if ($newPassword !== $newPasswordConfirm){
                $errors[] = "Passwords do not match";
            }

            if(empty($errors)){
                $modifyRequest = User::update($_SESSION["user_id"], null, $newPassword, null);
                if(!$modifyRequest){
                    $errors[] = 'An error occured.';
                }else {
                    return true;
                }
            }
        }
    }

    public static function delete(){
        global $errors;
        if($_SERVER["REQUEST_METHOD"] === "POST"){
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
