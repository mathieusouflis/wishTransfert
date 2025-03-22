<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once "Models/User.Model.php"; 
require_once "./config/config.php";

class AuthController {

    public static function needLog(){
        if(!isset($_SESSION["connecte"]) && $_SESSION["connecte"] !== true){
            header("Location: ". APP_URL ."login.php");
            exit();
        }
    }
    
    public static function needNoLog() {
        if (isset($_SESSION["connecte"]) && $_SESSION["connecte"] === true) {
            header("Location: ". APP_URL ."login.php");
            exit();
        }
    }
    public static function isLog() {
        if(!empty($_SESSION["connecte"])) {
            return true;
        }
        return false;
    }

    public static function Register() {
        global $errors;
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $username = filter_input(INPUT_POST, "username");
            $password = filter_input(INPUT_POST, "password");
            $verify = filter_input(INPUT_POST, "password2");
        
            if(empty($email)) {
                $errors[] = "L'email est obligatoire.";
            }else if (User::isEmailUnique($email) === false) {
                $errors[] = "L'email est déjà utilisée.";
            }

            if(empty($username)){
                $errors[] = "Le nom d'utilisateur est obligatoire.";
            }else if (!User::isUsernameValid($username)) {
                $errors[] = "Le nom d'utilisateur n'est pas valide. Il doit comporter au moins 4 caractères et les seuls caractères spéciaux autorisées sont (._)";
            }else if (User::get(["username" => $username])){
                $errors[] = "Le nom d'utilisateur est déjà pris";
            }
            
            if(empty($password)) {
                $errors[] = "Le mot de passe est obligatoire";
            }else if(!User::isPasswordValid($password)) {
                $errors[] = "Le mot de passe n'est pas valide, il doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre.";
            }
            
            if(empty($verify)) {
                $errors[] = "La confirmation de mot de passe est obligatoire";
            }else if($password !== $verify) {
                $errors[] = "Les deux mots de passe ne correspondent pas";
            }

            if(empty($errors)) {
                $user = User::create($username, $password, $email);
                if(empty($errors)) {
                    header('Location: login.php');
                    exit();
                }
            }
        }
    }

    public static function LogIn() {
        global $errors;

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password");
            
            if(empty($email)) {
                $errors[] = "L'identifiant est obligatoire";
            }
            if(empty($password)) {
                $errors[] = "Le mot de passe est obligatoire";
            }

            $utilisateur = User::get(["email" => $email]);

            if(empty($utilisateur)) {
                $errors[] = "L'email est incorrecte";
            } else {    
                $hash = $utilisateur->password;

                if(!password_verify($password, $hash)) {
                    $errors[] = "Le mot de passe est incorrect";
                }
            }

            if(empty($errors)) {
                $_SESSION["user_id"] = $utilisateur->id;
                $_SESSION["connecte"] = true;
                $_SESSION["email"] = $utilisateur->email;
                $_SESSION["username"] = $utilisateur->username;
                
                header("Location: ". APP_URL ."login.php");
                exit();
            }
        }
    }
}