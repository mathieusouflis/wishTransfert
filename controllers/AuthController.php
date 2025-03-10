<?php
session_start();
class AuthC {
    public function isLog() {
        if(isset($_SESSION["identifiant"])) {
            return true;
        }
        return false;
    }

    // gere la page d'inscription
    public function Register() {
        $erreurs = [];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $identifiant = filter_input(INPUT_POST, "identifiant", FILTER_VALIDATE_EMAIL);
            $motdepasse = filter_input(INPUT_POST, "motdepasse");
            $motdepasse2 = filter_input(INPUT_POST, "motdepasse2");
        
        // liste de messages d'erreurs
        if(empty($identifiant)) {
            $erreurs[] = "L'identifiant est absent ou incorrect";
        }
        if(empty($motdepasse)) {
            $erreurs[] = "Le mot de passe est obligatoire";
        }
        if(empty($motdepasse2)) {
            $erreurs[] = "La confirmation de mot de passe est obligatoire";
        }
        if($motdepasse !== $motdepasse2) {
            $erreurs[] = "Les deux mots de passe ne correspondent pas";
        }
        if($this->existingadress($identifiant)) {
            $erreurs[] = "L'adresse existe déjà";
        }

        if(empty($erreurs)) {
            $utilisateur = [
                "login" => $identifiant,
                "pwd" => password_hash($motdepasse, PASSWORD_DEFAULT)
            ];
            $this->ajouterUtilisateur($utilisateur);
        }
    }
    }

    // gere la page de connexion
    public function LogIn() {
        if(isset($_SESSION["identifiant"])) {
            header('Location: dashboard.php');
            exit();
        }

    $erreurs = [];
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $identifiant = filter_input(INPUT_POST, "identifiant", FILTER_VALIDATE_EMAIL);
        $motdepasse = filter_input(INPUT_POST, "motdepasse");
        
        // liste de messages d'erreurs
        if(empty($identifiant)) {
            $erreurs[] = "L'identifiant est obligatoire";
        }
        if(empty($motdepasse)) {
            $erreurs[] = "Le mot de passe est obligatoire";
        }
        
        $utilisateur = $this->getUsersbyid($identifiant);
        if(empty($utilisateur)) {
            $erreurs[] = "Le compte n'existe pas";
        } else {    
            $hash = $utilisateur["pwd"];
            if(!password_verify($motdepasse, $hash)) {
                $erreurs[] = "Le mot de passe est incorrect";
            }
        }

        if(empty($erreurs)) {
            $_SESSION["identifiant"] = $identifiant;
            header('Location: dashboard.php');
            exit();
        }
    }
}
}
?>