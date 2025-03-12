<?php
session_start();
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
        $erreurs = [];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = filter_input(INPUT_POST, "identifiant", FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "motdepasse");
            $verify = filter_input(INPUT_POST, "motdepasse2");
        
        // liste de messages d'erreurs
        if(empty($id)) {
            $erreurs[] = "L'identifiant est absent ou incorrect";
        }
        if(empty($password)) {
            $erreurs[] = "Le mot de passe est obligatoire";
        }
        if(empty($verify)) {
            $erreurs[] = "La confirmation de mot de passe est obligatoire";
        }
        elseif($password !== $verify) {
            $erreurs[] = "Les deux mots de passe ne correspondent pas";
        }
        if($this->existingadress($id)) {
            $erreurs[] = "L'adresse existe déjà";
        }

        if(empty($erreurs)) {
            $utilisateur = [
                "login" => $id,
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ];
            $this->ajouterUtilisateur($utilisateur);
        }
    }
    }

    // gere la page de connexion
    public function LogIn() {
        if(isset($_SESSION["connecte"])) {
            header('Location: dashboard.php');
            exit();
        }

    $erreurs = [];
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = filter_input(INPUT_POST, "identifiant", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "motdepasse");
        
        // liste de messages d'erreurs
        if(empty($id)) {
            $erreurs[] = "L'identifiant est obligatoire";
        }
        if(empty($password)) {
            $erreurs[] = "Le mot de passe est obligatoire";
        }
        
        $utilisateur = $this->getUsersbyid($id);
        if(empty($utilisateur)) {
            $erreurs[] = "Le compte n'existe pas";
        } else {    
            $hash = $utilisateur["password"];
            if(!password_verify($password, $hash)) {
                $erreurs[] = "Le mot de passe est incorrect";
            }
        }

        if(empty($erreurs)) {
            $_SESSION["identifiant"] = $id;
            header('Location: dashboard.php');
            exit();
        }
    }
}
}
?>