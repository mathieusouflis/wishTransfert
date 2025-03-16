<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'Models/Model.php';
require_once 'Models/User.Model.php';  // Incluez d'abord User.Model.php
require_once 'Models/File.Model.php';  // Ensuite File.Model.php
require_once 'Models/Link.Model.php';
require_once 'controllers/FileController.php';
require_once 'controllers/LinkAuth.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function displayResult($test, $success, $message = '') {
    echo "<div style='margin: 10px; padding: 10px; border: 1px solid " . ($success ? 'green' : 'red') . ";'>";
    echo "<strong>" . ($success ? '✅ ' : '❌ ') . $test . "</strong>";
    if (!empty($message)) {
        echo "<p>$message</p>";
    }
    echo "</div>";
}

function cleanupTestData() {
    try {
        $pdo = getDBConnection();
        
        $testUser = dbQuerySingle("SELECT user_id FROM USERS WHERE email = ?", ['test@test.com']);
        if ($testUser) {
            dbExecute("DELETE FROM USERS WHERE user_id = ?", [$testUser['user_id']]);
        }
        
        echo "<p>Nettoyage des données de test effectué.</p>";
    } catch (Exception $e) {
        echo "<p>Erreur lors du nettoyage: " . $e->getMessage() . "</p>";
    }
}

echo "<h1>Test des fonctionnalités WishTransfert</h1>";

echo "<h2>1. Test de connexion à la base de données</h2>";
try {
    $pdo = getDBConnection();
    displayResult("Connexion à la base de données", true);
    
    // Vérifier que les tables existent
    $tables = ['USERS', 'files', 'links', 'links_files', 'email_links'];
    $missingTables = [];
    
    echo "<h3>Vérification des tables</h3>";
    echo "<ul>";
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT 1 FROM $table LIMIT 1");
            echo "<li>Table $table : Existe ✅</li>";
        } catch (PDOException $e) {
            echo "<li>Table $table : N'existe pas ❌</li>";
            $missingTables[] = $table;
        }
    }
    
    echo "</ul>";
    
    if (!empty($missingTables)) {
        echo "<p style='color: red;'>Certaines tables sont manquantes. Veuillez exécuter le script SQL create_tables.sql</p>";
    }
    
} catch (Exception $e) {
    displayResult("Connexion à la base de données", false, $e->getMessage());
    die("Impossible de continuer les tests sans connexion à la base de données.");
}

echo "<h2>2. Test de création d'un utilisateur</h2>";
$testUsername = 'tesasatausdzder';
$testEmail = 'teassaqsdat@test.com';
$testPassword = 'Teaqsdasst@12a3445';

// Suppression préalable si l'utilisateur existe déjà
$existingUser = User::get(['email' => $testEmail]);
if ($existingUser) {
    // Utilisation du getter pour obtenir l'ID
    User::delete($existingUser->getId());
    echo "<p>Utilisateur de test précédent supprimé.</p>";
}

// Test de validation individuelle
echo "<h3>Vérification des validations</h3>";
echo "<ul>";
echo "<li>Username valide : " . (User::isUsernameValid($testUsername) ? "Oui ✅" : "Non ❌") . "</li>";
echo "<li>Username unique : " . (User::isUsernameUnique($testUsername) ? "Oui ✅" : "Non ❌") . "</li>";
echo "<li>Email unique : " . (User::isEmailUnique($testEmail) ? "Oui ✅" : "Non ❌") . "</li>";
echo "<li>Mot de passe valide : " . (User::isPasswordValid($testPassword) ? "Oui ✅" : "Non ❌") . "</li>";
echo "</ul>";

$createUserResult = User::create($testUsername, password_hash($testPassword, PASSWORD_DEFAULT), $testEmail);

if ($createUserResult) {
    $user = User::get(['email' => $testEmail]);
    if ($user) {
        // Utilisation du getter pour obtenir l'ID
        displayResult("Création d'utilisateur", true, "Utilisateur créé avec l'ID: " . $user->getId());
        $testUserId = $user->getId();
    } else {
        displayResult("Création d'utilisateur", false, "Utilisateur créé mais impossible de le récupérer");
    }
} else {
    global $errors;
    $errorMsg = "Échec de la création de l'utilisateur";
    if (!empty($errors)) {
        $errorMsg .= "<br>Raisons : <ul>";
        foreach ($errors as $error) {
            $errorMsg .= "<li>" . htmlspecialchars($error) . "</li>";
        }
        $errorMsg .= "</ul>";
    }
    displayResult("Création d'utilisateur", false, $errorMsg);
}

echo "<h2>3. Test d'upload de fichier</h2>";
if (isset($testUserId)) {
    $fileController = new FileController();
    $testFileName = 'test_file.txt';
    $testFileContent = 'Ceci est un fichier de test pour WishTransfert.';
    $testFileType = 'text/plain';
    
    $uploadResult = $fileController->uploadFile($testUserId, $testFileName, $testFileType, $testFileContent);
    
    if ($uploadResult) {
        displayResult("Upload de fichier", true, "Fichier uploadé avec succès");
        
        $userFiles = File::getByUserId($testUserId);
        if (!empty($userFiles)) {
            $testFile = $userFiles[0];
            $testFileId = $testFile->getFileid();
            displayResult("Récupération du fichier", true, "Fichier récupéré avec l'ID: " . $testFileId);
            
            echo "<h2>4. Test de création de lien de partage</h2>";
            $linkAuth = new LinkAuthC();
            $shareToken = $linkAuth->createShareLink($testFileId, $testUserId);
            
            if ($shareToken) {
                displayResult("Création de lien de partage", true, "Lien créé avec le token: " . $shareToken);
                
                $linkInfo = $linkAuth->verifyLinkToken($shareToken);
                if ($linkInfo) {
                    displayResult("Vérification du token", true, "Token validé");
                    
                    echo "<p>Pour tester le téléchargement, accédez à: <a href='download.php?token=$shareToken'>download.php?token=$shareToken</a></p>";
                } else {
                    displayResult("Vérification du token", false, "Échec de la validation du token");
                }
                
            } else {
                displayResult("Création de lien de partage", false, "Échec de la création du lien");
            }
            
        } else {
            displayResult("Récupération du fichier", false, "Aucun fichier trouvé pour l'utilisateur");
        }
    } else {
        displayResult("Upload de fichier", false, "Échec de l'upload du fichier");
    }
} else {
    displayResult("Upload de fichier", false, "Impossible de tester sans utilisateur valide");
}

echo "<h2>5. Test de réservation de téléchargement</h2>";
if (isset($testUserId) && isset($testFileId) && isset($shareToken)) {
    $restrictedEmail = "restricted@example.com";
    $restrictedToken = $linkAuth->createShareLink($testFileId, $testUserId, $restrictedEmail);
    
    if ($restrictedToken) {
        displayResult("Création de lien avec restriction email", true, "Lien créé avec le token: " . $restrictedToken);
        
        $linkInfo = $linkAuth->verifyLinkToken($restrictedToken);
        if ($linkInfo && isset($linkInfo['email_restriction']) && $linkInfo['email_restriction'] === $restrictedEmail) {
            displayResult("Vérification de la restriction", true, "Restriction email correctement appliquée");
            
            echo "<p>Pour tester le téléchargement restreint, accédez à: <a href='download.php?token=$restrictedToken'>download.php?token=$restrictedToken</a></p>";
        } else {
            displayResult("Vérification de la restriction", false, "Échec de la vérification de la restriction email");
        }
    } else {
        displayResult("Création de lien avec restriction email", false, "Échec de la création du lien");
    }
} else {
    displayResult("Test de réservation", false, "Impossible de tester sans fichier ou utilisateur valide");
}

echo "<h2>Nettoyage des données de test</h2>";
echo "<form method='post'>";
echo "<input type='submit' name='cleanup' value='Nettoyer les données de test'>";
echo "</form>";

if (isset($_POST['cleanup'])) {
    cleanupTestData();
}
?>