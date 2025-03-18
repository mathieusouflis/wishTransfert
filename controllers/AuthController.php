<?php
session_start();
require_once "Models/User.Model.php"; 

class AuthController {
    // vérifie si l'utilisateur est connecté
    public static function isLog() {
        if(isset($_SESSION["connecte"])) {
            return true;
        }
        return false;
    }

    // gere la page d'inscription
    public static function Register() {
        global $errors;
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $username = filter_input(INPUT_POST, "username");
            $password = filter_input(INPUT_POST, "password");
            $verify = filter_input(INPUT_POST, "password2");
        
            // liste de messages d'errors
            if(empty($email)) {
                $errors[] = "L'email est obligatoire.";
            }else if (User::isEmailUnique($email) === false) {
                $errors[] = "L'email est déjà utilisée.";
            }

            if(empty($username)){
                $errors[] = "Le nom d'utilisateur est obligatoire.";
            // Correction: Inversion de la condition pour la validation du nom d'utilisateur
            }else if (!User::isUsernameValid($username)) {
                $errors[] = "Le nom d'utilisateur n'est pas valide. Il doit comporter au moins 4 caractères et les seuls caractères spéciaux autorisées sont (._)";
            }else if (User::get(["username" => $username])){
                $errors[] = "Le nom d'utilisateur est déjà pris";
            }
            
            if(empty($password)) {
                $errors[] = "Le mot de passe est obligatoire";
            // Correction: Inversion de la condition pour la validation du mot de passe
            }else if(!User::isPasswordValid($password)) {
                $errors[] = "Le mot de passe n'est pas valide, il doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@$!%*?&)";
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

    // gere la page de connexion
    public static function LogIn() {
        global $errors;
        if(isset($_SESSION["connecte"])) {
            header('Location: dashboard.php');
            exit();
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password");
            
            // liste de messages d'errors
            if(empty($email)) {
                $errors[] = "L'identifiant est obligatoire";
            }
            if(empty($password)) {
                $errors[] = "Le mot de passe est obligatoire";
            }

            $utilisateur = User::get(["email" => $email]);

            if(empty($utilisateur)) {
                $errors[] = "Le compte n'existe pas";
            } else {    
                $hash = $utilisateur->password;
                echo($hash);

                if(!password_verify($password, $hash)) {
                    $errors[] = "Le mot de passe est incorrect";
                }
            }

            if(empty($errors)) {
                $_SESSION["identifiant"] = $utilisateur->id;
                $_SESSION["connecte"] = true;
                $_SESSION["email"] = $utilisateur->email;
                header('Location: dashboard.php');
                exit();
            }
        }
    }
}