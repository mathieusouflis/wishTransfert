<?php
require_once 'config/config.php';

echo "<h1>Test de configuration WishTransfert</h1>";
echo "<p>Le fichier config.php est correctement chargé.</p>";

echo "<h2>Paramètres configurés :</h2>";
echo "<ul>";
echo "<li>URL de l'application : " . APP_URL . "</li>";
echo "<li>Chemin racine : " . ROOT_PATH . "</li>";
echo "<li>Taille maximale de téléchargement : " . (MAX_UPLOAD_SIZE / 1024 / 1024 / 1024) . " GB</li>";
echo "<li>Mode débogage : " . (DEBUG_MODE ? "Activé" : "Désactivé") . "</li>";
echo "</ul>";
?>