<?php
session_start();
require_once 'config/database.php';

class LinkAuthC {
    /**
     * Vérifie si un token de lien est valide
     * 
     * @param string $token Le token du lien à vérifier
     * @return array|false Informations sur le lien si valide, false sinon
     */
    public function verifyLinkToken($token) {
        // Nettoyer le token
        $token = trim($token);
        
        if (empty($token)) {
            return false;
        }
        
        // Rechercher le lien dans la base de données
        $link = dbQuerySingle("SELECT l.*, u.username 
                              FROM links l
                              JOIN users u ON l.user_id = u.user_id
                              WHERE l.token = ?", [$token]);
        
        if (!$link) {
            // Token non trouvé
            return false;
        }
        
        
        // Récupérer les fichiers associés à ce lien
        $files = dbQuery("SELECT f.* 
                         FROM files f
                         JOIN file_links fl ON f.file_id = fl.file_id
                         WHERE fl.link_id = ?", [$link['link_id']]);
        
        // Ajouter les informations des fichiers au résultat
        $link['files'] = $files;
        
        return $link;
    }
    
    /**
     * Génère un token unique pour un lien de partage
     * 
     * @return string Token généré
     */
    private function generateToken() {
        return bin2hex(random_bytes(16));
    }
    
    /**
     * Crée un nouveau lien de partage pour un fichier
     * 
     * @param int $fileId ID du fichier à partager
     * @param int $userId ID de l'utilisateur qui partage
     * @return string Token du lien créé
     */
    public function createShareLink($fileId, $userId) {
        // Générer un token unique
        $token = $this->generateToken();
        
        dbExecute("INSERT INTO links (user_id, token) VALUES (?, ?)", 
                 [$userId, $token]);
        
        $linkId = dbLastInsertId();
        
        dbExecute("INSERT INTO file_links (link_id, file_id) VALUES (?, ?)", 
                 [$linkId, $fileId]);
        
        return $token;
    }
    
    /**
     * Vérifie un token dans l'URL et redirige en conséquence
     */
    public function processLinkRequest() {
        $erreurs = [];
        
        if (!isset($_GET['token']) || empty($_GET['token'])) {
            $erreurs[] = "Aucun token fourni";
            // Rediriger vers une page d'erreur
            header("Location: error.php?message=" . urlencode("Lien invalide ou expiré"));
            exit();
        }
        
        $token = $_GET['token'];
        $linkInfo = $this->verifyLinkToken($token);
        
        if (!$linkInfo) {
            $erreurs[] = "Token invalide ou expiré";
            // Rediriger vers une page d'erreur
            header("Location: error.php?message=" . urlencode("Lien invalide ou expiré"));
            exit();
        }
        
        // Si tout est ok, rediriger vers la page de téléchargement
        header("Location: download.php?token=" . urlencode($token));
        exit();
    }
    
    /**
     * Récupère les informations de lien par token pour affichage
     * À utiliser dans la page de téléchargement
     * 
     * @param string $token Token du lien
     * @return array Informations du lien et fichiers associés
     */
    public function getLinkInfoForDownload($token) {
        $linkInfo = $this->verifyLinkToken($token);
        if (!$linkInfo) {
            return false;
        }
        
        // Incrémenter le compteur de téléchargement pour chaque fichier
        if (isset($linkInfo['files']) && !empty($linkInfo['files'])) {
            foreach ($linkInfo['files'] as $file) {
                dbExecute("UPDATE files SET download_count = download_count + 1 WHERE file_id = ?", 
                         [$file['file_id']]);
            }
        }
        
        return $linkInfo;
    }
}
?>