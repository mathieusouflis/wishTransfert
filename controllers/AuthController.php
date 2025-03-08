<?php
session_start();

function estCeQueLadresseExisteDeja($adresse) {
    $utilisateurs = recupererLesUtilisateurs();

    foreach($utilisateurs as $utilisateur) {
        if($utilisateur["login"] == $adresse) {
            return true;
        }
    }
    return false;
}

function recupererLesUtilisateurs() {
    if(!file_exists("utilisateurs.json")) {
        file_put_contents("utilisateurs.json", "[]");
    }

    $utilisateursTxt = file_get_contents("utilisateurs.json");
    $utilisateurs = json_decode($utilisateursTxt, true);
    return $utilisateurs;
}

function sauvegarderLesUtilisateurs($utilisateurs) {
    $utilisateursTxt = json_encode($utilisateurs);
    file_put_contents("utilisateurs.json", $utilisateursTxt);
}

function recupererUtilisateurParAdresse($adresse) {
    $utilisateurs = recupererLesUtilisateurs();
    foreach($utilisateurs as $utilisateur) {
        if($utilisateur["login"] == $adresse) {
            return $utilisateur;
        }
    }
    return null;
}

function ajouterUtilisateur($utilisateur) {
    $utilisateurs = recupererLesUtilisateurs();
    $utilisateurs[] = $utilisateur;
    sauvegarderLesUtilisateurs($utilisateurs);
}

function isLog() {
    if(isset($_SESSION["identifiant"])) {
        return true;
    }
    return false;
}

// gere la page d'inscription
function Register() {
    $erreurs = [];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = filter_input(INPUT_POST, "identifiant", FILTER_VALIDATE_EMAIL);
    $motdepasse = filter_input(INPUT_POST, "motdepasse");
    $motdepasse2 = filter_input(INPUT_POST, "motdepasse2");

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
    if(estCeQueLadresseExisteDeja($identifiant)) {
        $erreurs[] = "L'adresse existe déjà";
    }

    if(empty($erreurs)) {
        $utilisateur = [
            "login" => $identifiant,
            "pwd" => password_hash($motdepasse, PASSWORD_DEFAULT)
        ];
        ajouterUtilisateur($utilisateur);
    }
}
}

// gere la page de connexion
function LogIn() {
    if(isset($_SESSION["identifiant"])) {
        header('Location: dashboard.php');
        exit();
    }

$erreurs = [];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = filter_input(INPUT_POST, "identifiant");
    $motdepasse = filter_input(INPUT_POST, "motdepasse");

    if(!$identifiant) {
        $erreurs[] = "L'identifiant est obligatoire";
    }
    if(!$motdepasse) {
        $erreurs[] = "Le mot de passe est obligatoire";
    }
    
    $utilisateur = recupererUtilisateurParAdresse($identifiant);
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