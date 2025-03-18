<?php

require_once 'config/config.php';
require_once 'config/database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Test de la configuration de base de données WishTransfert</h1>";

// Test 1: Connexion à la base de données
echo "<h2>Test 1: Connexion à la base de données</h2>";
try {
    $pdo = getDBConnection();
    echo "<p style='color: green;'>✓ Connexion à la base de données réussie!</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur de connexion à la base de données: " . $e->getMessage() . "</p>";
    die("Les tests suivants ne peuvent pas être effectués sans connexion à la base de données.");
}

// Test 2: Informations sur la base de données
echo "<h2>Test 2: Informations sur la base de données</h2>";
echo "<ul>";
echo "<li>Hôte: " . DB_HOST . "</li>";
echo "<li>Base de données: " . DB_NAME . "</li>";
echo "<li>Utilisateur: " . DB_USER . "</li>";
echo "<li>Port: " . DB_PORT . "</li>";
echo "<li>Charset: " . DB_CHARSET . "</li>";
echo "</ul>";

// Test 3: Structure de la base de données
echo "<h2>Test 3: Vérification des tables</h2>";
$tables = ['users', 'files', 'links', 'links_files', 'email_links', 'comments'];
$missingTables = [];

try {
    $stmt = $pdo->query("SHOW TABLES");
    $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Table</th><th>Statut</th></tr>";
    
    foreach ($tables as $table) {
        if (in_array($table, $existingTables)) {
            echo "<tr><td>$table</td><td style='color: green;'>Existe</td></tr>";
        } else {
            echo "<tr><td>$table</td><td style='color: red;'>Manquante</td></tr>";
            $missingTables[] = $table;
        }
    }
    
    echo "</table>";
    
    if (!empty($missingTables)) {
        echo "<p style='color: orange;'>⚠️ Certaines tables sont manquantes. Si cette base de données est nouvelle, vous devrez les créer.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur lors de la vérification des tables: " . $e->getMessage() . "</p>";
}

// Test 4: Test des fonctions de base de données
echo "<h2>Test 4: Test des fonctions de base de données</h2>";

echo "<h3>Test de dbQuery()</h3>";
try {
    if (in_array('users', $existingTables)) {
        $result = dbQuery("SELECT COUNT(*) as count FROM users", []);
        echo "<p>Nombre d'utilisateurs dans la base de données: " . $result[0]['count'] . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Test ignoré: la table 'users' n'existe pas encore.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur lors du test de dbQuery(): " . $e->getMessage() . "</p>";
}

echo "<h3>Test de dbQuerySingle()</h3>";
try {
    if (in_array('users', $existingTables)) {
        $result = dbQuerySingle("SELECT COUNT(*) as count FROM users", []);
        echo "<p>Résultat du test dbQuerySingle(): " . print_r($result, true) . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Test ignoré: la table 'users' n'existe pas encore.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur lors du test de dbQuerySingle(): " . $e->getMessage() . "</p>";
}

echo "<h2>Résumé des tests</h2>";
if (empty($missingTables)) {
    echo "<p style='color: green;'>✓ Tous les tests sont passés avec succès.</p>";
} else {
    echo "<p>La base de données est accessible, mais il manque certaines tables. Si vous démarrez un nouveau projet, vous devrez créer les tables manquantes.</p>";
}

echo "<h2>Informations supplémentaires</h2>";
echo "<p>Version PHP: " . phpversion() . "</p>";
echo "<p>Extensions PHP chargées: " . implode(', ', get_loaded_extensions()) . "</p>";
echo "<p>Mode débogage: " . (DEBUG_MODE ? "Activé" : "Désactivé") . "</p>";
echo "<p>Date et heure du test: " . date('Y-m-d H:i:s') . "</p>";
?>