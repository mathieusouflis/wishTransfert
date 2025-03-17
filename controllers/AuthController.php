<?php
session_start();
require_once "Models/User.Model.php"; 

class AuthC {
    // vérifie si l'utilisateur est connecté
    public function isLog() {
        if(isset($_SESSION["connecte"])) {
            return true;
        }
        return false;
    }

    // gere la page d'inscription
    public function Register() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $username = filter_input(INPUT_POST, "username");
            $password = filter_input(INPUT_POST, "password");
            $verify = filter_input(INPUT_POST, "password2");
        
            // liste de messages d'erreurs
            if(empty($email)) {
                $erreurs[] = "L'email est obligatoire.";
            }else if (User::isEmailUnique($email) === false) {
                $erreurs[] = "L'email est déjà utilisée.";
            }

            if(empty($username)){
                $erreurs[] = "Le nom d'utilisateur est obligatoire.";
            // Correction: Inversion de la condition pour la validation du nom d'utilisateur
            }else if (!User::isUsernameValid($username)) {
                $erreurs[] = "Le nom d'utilisateur n'est pas valide. Il doit comporter au moins 4 caractères et les seuls caractères spéciaux autorisées sont (._)";
            }else if (User::get(["username" => $username])){
                $erreurs[] = "Le nom d'utilisateur est déjà pris";
            }
            
            if(empty($password)) {
                $erreurs[] = "Le mot de passe est obligatoire";
            // Correction: Inversion de la condition pour la validation du mot de passe
            }else if(!User::isPasswordValid($password)) {
                $erreurs[] = "Le mot de passe n'est pas valide, il doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@$!%*?&)";
            }
            
            if(empty($verify)) {
                $erreurs[] = "La confirmation de mot de passe est obligatoire";
            }else if($password !== $verify) {
                $erreurs[] = "Les deux mots de passe ne correspondent pas";
            }
            
            if(User::get(["email" => $email])) {
                $erreurs[] = "L'email existe déjà";
            }

            if(empty($erreurs)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                User::create($username, $password, $email);
                header('Location: login.php');
                exit();
            }
        }
    }

    // gere la page de connexion
    public function LogIn() {
        if(isset($_SESSION["connecte"])) {
            header('Location: dashboard.php');
            exit();
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password");
            
            // liste de messages d'erreurs
            if(empty($email)) {
                $erreurs[] = "L'identifiant est obligatoire";
            }
            if(empty($password)) {
                $erreurs[] = "Le mot de passe est obligatoire";
            }
            
            $utilisateur = User::get(["email" => $email]);

            if(empty($utilisateur)) {
                $erreurs[] = "Le compte n'existe pas";
            } else {    
                $hash = $utilisateur->password;
                if(!password_verify($password, $hash)) {
                    $erreurs[] = "Le mot de passe est incorrect";
                }
            }

            if(empty($erreurs)) {
                $_SESSION["identifiant"] = $utilisateur->id;
                $_SESSION["connecte"] = true;
                header('Location: dashboard.php');
                exit();
            }
        }
    }
}