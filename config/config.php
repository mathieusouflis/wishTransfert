<?php
// config.php - Configuration globale de l'application

// Informations sur l'application
define('APP_NAME', 'WishTransfert');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost:80/Wishtransfert/wishtransfert'); // Ajusté selon votre URL

// Configuration des chemins
define('ROOT_PATH', dirname(__DIR__));
// Pour le moment, utilisons la racine du projet pour les uploads/downloads
define('ASSETS_PATH', ROOT_PATH . '/assets');
// Ces chemins pourront être modifiés plus tard quand la structure évoluera
define('UPLOADS_DIR', ROOT_PATH . '/uploads');
define('DOWNLOADS_DIR', ROOT_PATH . '/downloads');

// Configuration des sessions
define('SESSION_LIFETIME', 3600); // Durée de vie de la session en secondes (1 heure)
define('SESSION_NAME', 'wishTransfert_session');

// Configuration des téléchargements
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024 * 1024); // 5 GB en octets
define('ALLOWED_FILE_TYPES', '*'); // Tous types de fichiers acceptés

// Configuration de sécurité
define('SECURE_SALT', 'wishtransfert_secure_salt_2024'); // À changer pour la production
define('DEBUG_MODE', true); // Mode débogage activé

// Configuration d'affichage d'erreurs (à désactiver en production)
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
?>