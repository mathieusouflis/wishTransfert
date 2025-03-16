<?php
session_start();
require_once 'config/database.php';

class LinkAuthC {
    public function verifyLinkToken($token) {
        $token = trim($token);
        
        if (empty($token)) {
            return false;
        }
        
        $link = dbQuerySingle("SELECT l.*, u.username 
                              FROM links l
                              JOIN users u ON l.user_id = u.user_id
                              WHERE l.token = ?", [$token]);
        
        if (!$link) {
            return false;
        }
        
        $files = dbQuery("SELECT f.* 
                         FROM files f
                         JOIN links_files fl ON f.file_id = fl.file_id
                         WHERE fl.link_id = ?", [$link['link_id']]);
        
        $link['files'] = $files;
        
        $emailRestriction = dbQuerySingle("SELECT el.email 
                                         FROM email_links el 
                                         WHERE el.link_id = ?", [$link['link_id']]);
        
        if ($emailRestriction) {
            $link['email_restriction'] = $emailRestriction['email'];
        }
        
        return $link;
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