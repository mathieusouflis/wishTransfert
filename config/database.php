<?php
// database.php - Configuration de la base de données

// Inclure le fichier de configuration principal
require_once 'config.php';

// Paramètres de connexion à la base de données
define('DB_HOST', 'localhost');     
define('DB_NAME', 'wishtransfert'); 
define('DB_USER', 'root');          
define('DB_PASS', 'root');              
define('DB_PORT', '8889');          
define('DB_CHARSET', 'utf8mb4');    

/**
 * Fonction pour obtenir une connexion PDO à la base de données
 * 
 * @return PDO Instance de connexion PDO
 */
function getDBConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            // debug mod , afficher l'erreur
            if (DEBUG_MODE) {
                die('Erreur de connexion à la base de données: ' . $e->getMessage());
            }
        }
    }
    
    return $pdo;
}

/**
 * Exécute une requête SQL et retourne tous les résultats
 * 
 * @param string $sql La requête SQL à exécuter
 * @param array $params Paramètres pour la requête préparée
 * @return array Résultats de la requête
 */
function dbQuery($sql, $params = []) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die('Erreur SQL: ' . $e->getMessage());
        }
    }
}

/**
 * Exécute une requête SQL et retourne un seul résultat
 * 
 * @param string $sql
 * @param array $params
 * @return array|false 
 */
function dbQuerySingle($sql, $params = []) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die('Erreur SQL: ' . $e->getMessage());
        } else {
            die('Une erreur est survenue lors de l\'opération sur la base de données.');
        }
    }
}

/**
 * Exécute une requête SQL qui ne retourne pas de résultat (INSERT, UPDATE, DELETE)
 * 
 * @param string $sql
 * @param array $params
 * @return int Nombre de lignes affectées
 */
function dbExecute($sql, $params = []) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die('Erreur SQL: ' . $e->getMessage());
        } else {
            die('Une erreur est survenue lors de l\'opération sur la base de données.');
        }
    }
}

/**
 * Récupère le dernier ID inséré
 * 
 * @return string Le dernier ID inséré
 */
function dbLastInsertId() {
    try {
        $pdo = getDBConnection();
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die('Erreur: ' . $e->getMessage());
        } else {
            die('Une erreur est survenue lors de l\'opération sur la base de données.');
        }
    }
}

// Fonctions pour les utilisateurs

/**
 * Récupère un utilisateur par son ID
 * 
 * @param int $userId 
 * @return array|false Données de l'utilisateur
 */
function getUserById($userId) {
    return dbQuerySingle("SELECT * FROM users WHERE user_id = ?", [$userId]);
}

/**
 * Récupère un utilisateur par son email
 * 
 * @param string $email 
 * @return array|false 
 */
function getUserByEmail($email) {
    return dbQuerySingle("SELECT * FROM users WHERE email = ?", [$email]);
}

/**
 * Crée un nouvel utilisateur
 * 
 * @param string $username
 * @param string $email
 * @param string $password Mot de passe (haché)
 * @return int ID de l'utilisateur créé
 */
function createUser($username, $email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    dbExecute(
        "INSERT INTO users (username, email, password) VALUES (?, ?, ?)",
        [$username, $email, $hashedPassword]
    );
    
    return dbLastInsertId();
}

// Fonctions pour les fichiers

/**
 * Récupère un fichier par son ID
 * 
 * @param int $fileId 
 * @return array|false Données du fichier
 */
function getFileById($fileId) {
    return dbQuerySingle("SELECT * FROM files WHERE file_id = ?", [$fileId]);
}

/**
 * Récupère tous les fichiers d'un utilisateur
 * 
 * @param int $userId
 * @return array Liste des fichiers
 */
function getFilesByUserId($userId) {
    return dbQuery("SELECT * FROM files WHERE user_id = ? ORDER BY created_at DESC", [$userId]);
}

/**
 * Crée un nouveau fichier
 * 
 * @param int $userId 
 * @param string $title 
 * @param string $fileData 
 * @return int ID du fichier créé
 */
function createFile($userId, $title, $fileData) {
    dbExecute(
        "INSERT INTO files (user_id, title, file_data) VALUES (?, ?, ?)",
        [$userId, $title, $fileData]
    );
    
    return dbLastInsertId();
}

/**
 * Met à jour le compteur de téléchargements d'un fichier
 * 
 * @param int $fileId
 * @return bool True si succès
 */
function incrementDownloadCount($fileId) {
    return dbExecute(
        "UPDATE files SET download_count = download_count + 1 WHERE file_id = ?",
        [$fileId]
    ) > 0;
}

// Fonctions pour les liens

/**
 * Récupère un lien par son token
 * 
 * @param string $token 
 * @return array|false Données du lien
 */
function getLinkByToken($token) {
    return dbQuerySingle("SELECT * FROM links WHERE token = ?", [$token]);
}

/**
 * Crée un nouveau lien de partage
 * 
 * @param int $fileId 
 * @param int $userId 
 * @param string $token 
 * @return int ID du lien créé
 */
function createLink($fileId, $userId, $token = null) {
    if ($token === null) {
        $token = bin2hex(random_bytes(16)); // Génère un token aléatoire
    }
    
    dbExecute(
        "INSERT INTO links (file_id, user_id, token) VALUES (?, ?, ?)",
        [$fileId, $userId, $token]
    );
    
    $linkId = dbLastInsertId();
    
    // Ajouter l'entrée dans la table links_files
    dbExecute(
        "INSERT INTO links_files (link_id, file_id) VALUES (?, ?)",
        [$linkId, $fileId]
    );
    
    return $linkId;
}

/**
 * Envoie un lien par email
 * 
 * @param int $linkId 
 * @param string $email 
 * @return int ID de l'entrée email_links
 */
function sendLinkByEmail($linkId, $email) {
    dbExecute(
        "INSERT INTO email_links (email, link_id) VALUES (?, ?)",
        [$email, $linkId]
    );
    
    return dbLastInsertId();
}

// Fonctions pour les commentaires

/**
 * Récupère les commentaires d'un fichier
 * 
 * @param int $fileId
 * @return array Liste des commentaires
 */
function getCommentsByFileId($fileId) {
    return dbQuery(
        "SELECT c.*, u.username 
         FROM comments c
         JOIN users u ON c.user_id = u.user_id
         WHERE c.file_id = ? 
         ORDER BY c.created_at DESC", 
        [$fileId]
    );
}

/**
 * Ajoute un commentaire à un fichier
 * 
 * @param int $fileId 
 * @param int $userId 
 * @param string $content 
 * @return int ID du commentaire créé
 */
function addComment($fileId, $userId, $content) {
    dbExecute(
        "INSERT INTO comments (file_id, user_id, content) VALUES (?, ?, ?)",
        [$fileId, $userId, $content]
    );
    
    return dbLastInsertId();
}
?>