<?php
session_start();
require_once 'config/database.php';
require_once 'Models/Link.Model.php';
require_once 'Models/FileLink.Model.php';

class LinkAuthC {
    public function verifyLinkToken($token) {
        $token = trim($token);
        
        if (empty($token)) {
            return false;
        }
        $link = Links::getByToken($token);
        if (empty($link)) {
            return false;
        }

        $emailRestriction = EmailLink::getByLink_id($link->linkid);

        if (empty($emailRestriction)) {
            return false;
        }
        
        return true;
    }
    
    private function generateToken() {
        return bin2hex(random_bytes(16));
    }
    
    public function createShareLink($fileId, $userId, $restrictedEmail = null) {
        $token = $this->generateToken();
        
        dbExecute("INSERT INTO links (user_id, token) VALUES (?, ?)", 
                 [$userId, $token]);
        
        $linkId = dbLastInsertId();
        
        dbExecute("INSERT INTO links_files (link_id, file_id) VALUES (?, ?)", 
                 [$linkId, $fileId]);
        
        if ($restrictedEmail) {
            dbExecute("INSERT INTO email_links (email, link_id) VALUES (?, ?)", 
                     [$restrictedEmail, $linkId]);
        }
        
        return $token;
    }
    
    public function processLinkRequest() {
        $erreurs = [];
        
        if (!isset($_GET['token']) || empty($_GET['token'])) {
            $erreurs[] = "Aucun token fourni";
            header("Location: error.php?message=" . urlencode("Lien invalide ou expiré"));
            exit();
        }
        
        $token = $_GET['token'];
        $linkInfo = $this->verifyLinkToken($token);
        
        if (!$linkInfo) {
            $erreurs[] = "Token invalide ou expiré";
            header("Location: error.php?message=" . urlencode("Lien invalide ou expiré"));
            exit();
        }
        
        header("Location: download.php?token=" . urlencode($token));
        exit();
    }
    
    public function getLinkInfoForDownload($token) {
        $linkInfo = $this->verifyLinkToken($token);
        if (!$linkInfo) {
            return false;
        }
        
        return $linkInfo;
    }
}