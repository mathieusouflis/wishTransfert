<?php
session_start();
require_once 'config/database.php';
require_once 'Models/Link.Model.php';
require_once 'Models/FileLink.Model.php';
require_once 'Models/EmailLinks.Model.php';

class LinkAuthC {
    public static function verifyLinkToken($token) {
        $token = trim($token);
        
        if (empty($token)) {
            return false;
        }
        $link = Links::getByToken($token);
        if (empty($link)) {
            return false;
        }

        $emailRestrictions = EmailLink::getByLink_id($link->linkid);

        if (empty($emailRestrictions)) {
            return false;
        }

        $emailMatch = false;
        foreach ($emailRestrictions as $emailRestriction) {
            if ($emailRestriction->email == $_SESSION["email"]) {
            $emailMatch = true;
            break;
            }
        }

        if (!$emailMatch) {
            return false;
        }
        
        return true;
    }
    
    private static function generateToken() {
        return bin2hex(random_bytes(16));
    }
    
    public static function createShareLink($files, $userId, $emails) {
        $link = Links::createLink($userId);
        
        foreach ($files as $file) {
            $result = File::createFile($_SESSION["user_id"], $file["name"], $file["type"], $file["filedata"]);
            FileLink::createFilesLinks($link->linkid, $file->fileid);
        }

        foreach ($emails as $email) {
            $result = EmailLink::createEmailLinks($link->linkid, $email);
        }
        
        return $link;
    }
    
    //TODO: Voir pour mettre ça dans le linkcontroller
    // public static function processLinkRequest() {
    //     $erreurs = [];
        
    //     if (!isset($_GET['token']) || empty($_GET['token'])) {
    //         $erreurs[] = "Aucun token fourni";
    //         header("Location: error.php?message=" . urlencode("Lien invalide ou expiré"));
    //         exit();
    //     }
        
    //     $token = $_GET['token'];
    //     $linkInfo = self::verifyLinkToken($token);
        
    //     if (!$linkInfo) {
    //         $erreurs[] = "Token invalide ou expiré";
    //         header("Location: error.php?message=" . urlencode("Lien invalide ou expiré"));
    //         exit();
    //     }
        
    //     header("Location: download.php?token=" . urlencode($token));
    //     exit();
    // }

}