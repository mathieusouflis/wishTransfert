<?php
session_start();
require_once 'config/database.php';
require_once 'Models/Link.Model.php';
require_once 'Models/FileLink.Model.php';
require_once 'Models/EmailLinks.Model.php';

class LinkAuthController {
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
    
    /**
     * Crée un lien de partage pour un ou plusieurs fichiers
     * 
     * @param array|int $fileIds Un ID de fichier unique ou un tableau d'IDs de fichiers
     * @param int $userId L'ID de l'utilisateur qui crée le lien
     * @param string|null $email Email pour restriction (optionnel)
     * @return string|false Le token du lien créé ou false en cas d'échec
     */
    public static function createShareLink($fileIds, $userId, $email = null) {
        // Créer le lien
        $link = Links::createLink($userId);
        if (!$link) {
            return false;
        }
        
        // Convertir un ID unique en tableau pour traitement uniforme
        if (!is_array($fileIds)) {
            $fileIds = [$fileIds];
        }
        
        // Associer tous les fichiers au lien
        foreach ($fileIds as $fileId) {
            FileLink::createFilesLinks($link->linkid, $fileId);
        }
        
        // Si un email est spécifié, l'associer au lien
        if ($email !== null) {
            EmailLink::createEmailLinks($link->linkid, $email);
        }
        
        return $link->token;
    }
    
    /**
     * Récupère les informations complètes d'un lien de partage
     * 
     * @param string $token Le token du lien
     * @return array|false Les informations du lien ou false en cas d'échec
     */
    public static function getLinkInfoForDownload($token) {
        $link = Links::getByToken($token);
        if (!$link) {
            return false;
        }
        
        // Récupérer les fichiers associés au lien
        $fileLinks = FileLink::getByLink_id($link->linkid);
        $files = [];
        
        foreach ($fileLinks as $fileLink) {
            $file = File::getByFileId($fileLink->file_id);
            if ($file) {
                $files[] = $file;
            }
        }
        
        // Récupérer les restrictions d'email éventuelles
        $emailLinks = EmailLink::getByLink_id($link->linkid);
        $emailRestriction = null;
        
        if (!empty($emailLinks)) {
            $emailRestriction = $emailLinks[0]->email;
        }
        
        return [
            'link_id' => $link->linkid,
            'user_id' => $link->userid,
            'token' => $link->token,
            'created_at' => $link->createdat,
            'files' => $files,
            'email_restriction' => $emailRestriction
        ];
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