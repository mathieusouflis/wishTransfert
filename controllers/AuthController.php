<?php
session_start();
class AuthC {
    // si je suis connecter ca doit me rediriger vers le dashboard
    // fonction a garder
    public function existingadress($adresse) {
        $utilisateurs = $this->getUsers();

        foreach($utilisateurs as $utilisateur) {
            if($utilisateur["login"] == $adresse) {
                return true;
            }
        }
        return false;
    }
    // a supp car appel de user controller
    public function getUsers() {
        if(!file_exists("utilisateurs.json")) {
            file_put_contents("utilisateurs.json", "[]");
        }

        $utilisateursTxt = file_get_contents("utilisateurs.json");
        $utilisateurs = json_decode($utilisateursTxt, true);
        return $utilisateurs;
    }
    // a supp car appel de user controller
    public function sauvegarderLesUtilisateurs($utilisateurs) {
        $utilisateursTxt = json_encode($utilisateurs);
        file_put_contents("utilisateurs.json", $utilisateursTxt);
    }
    // a supp car appel de user controller
    public function getUsersbyid($adresse) {
        $utilisateurs = $this->getUsers();
        foreach($utilisateurs as $utilisateur) {
            if($utilisateur["login"] == $adresse) {
                return $utilisateur;
            }
        }
        return null;
    }
    // a supp car appel de user controller
    public function ajouterUtilisateur($utilisateur) {
        $utilisateurs = $this->getUsers();
        $utilisateurs[] = $utilisateur;
        $this->sauvegarderLesUtilisateurs($utilisateurs);
    }

    public function isLog() {
        if(isset($_SESSION["identifiant"])) {
            return true;
        }
        return false;
    }

    // gere la page d'inscription
    public function Register($identifiant, $motdepasse, $motdepasse2) {
        $erreurs = [];
        
        // liste de messages d'erreurs
        if(!$identifiant) {
            $erreurs[] = "L'identifiant est absent ou incorrect";
        }
        if(!$motdepasse) {
            $erreurs[] = "Le mot de passe est obligatoire";
        }
        if(!$motdepasse2) {
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

    // gere la page de connexion
    public function LogIn($identifiant, $motdepasse) {
        if(isset($_SESSION["identifiant"])) {
            header('Location: dashboard.php');
            exit();
        }

    $erreurs = [];
        
        // liste de messages d'erreurs
        if(!$identifiant) {
            $erreurs[] = "L'identifiant est obligatoire";
        }
        if(!$motdepasse) {
            $erreurs[] = "Le mot de passe est obligatoire";
        }
        
        $utilisateur = $this->getUsersbyid($identifiant);
        if(!$utilisateur) {
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
?>