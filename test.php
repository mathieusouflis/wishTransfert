<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'Models/Model.php';
require_once 'Models/User.Model.php';  // Incluez d'abord User.Model.php
require_once 'Models/File.Model.php';  // Ensuite File.Model.php
require_once 'Models/Link.Model.php';
require_once 'Models/FileLink.Model.php';
require_once 'Models/EmailLinks.Model.php';
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
        
        $testUser = dbQuerySingle("SELECT user_id FROM users WHERE email LIKE 'test%@test.com'");
        if ($testUser) {
            // D'abord supprimez les données associées
            dbExecute("DELETE FROM files WHERE user_id = ?", [$testUser['user_id']]);
            dbExecute("DELETE FROM links WHERE user_id = ?", [$testUser['user_id']]);
            // Puis supprimez l'utilisateur
            dbExecute("DELETE FROM users WHERE user_id = ?", [$testUser['user_id']]);
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
    $tables = ['users', 'files', 'links', 'files_links', 'emails_links', 'comments'];
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
$testUsername = 'tesuser' . rand(1000, 9999);
$testEmail = 'test' . rand(1000, 9999) . '@test.com';
$testPassword = 'Test@12345';

// Test de validation individuelle
echo "<h3>Vérification des validations</h3>";
echo "<ul>";
echo "<li>Username valide : " . (User::isUsernameValid($testUsername) ? "Oui ✅" : "Non ❌") . "</li>";
echo "<li>Username unique : " . (User::isUsernameUnique($testUsername) ? "Oui ✅" : "Non ❌") . "</li>";
echo "<li>Email unique : " . (User::isEmailUnique($testEmail) ? "Oui ✅" : "Non ❌") . "</li>";
echo "<li>Mot de passe valide : " . (User::isPasswordValid($testPassword) ? "Oui ✅" : "Non ❌") . "</li>";
echo "</ul>";

// Important: Ne pas hasher le mot de passe ici, la méthode create() s'en charge
$createUserResult = User::create($testUsername, $testPassword, $testEmail);

if ($createUserResult) {
    $user = User::get(['email' => $testEmail]);
    if ($user) {
        displayResult("Création d'utilisateur", true, "Utilisateur créé avec l'ID: " . $user->id);
        $testUserId = $user->id;
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
    $testFileName = 'test_file.txt';
    $testFileContent = 'Ceci est un fichier de test pour WishTransfert.';
    $testFileType = 'text/plain';
    
    $uploadResult = FileController::uploadFile($testUserId, $testFileName, $testFileType, $testFileContent);
    
    if ($uploadResult) {
        displayResult("Upload de fichier", true, "Fichier uploadé avec succès");
        
        $userFiles = File::getByUserId($testUserId);
        if (!empty($userFiles)) {
            $testFile = $userFiles[0];
            $testFileId = $testFile->fileid;
            displayResult("Récupération du fichier", true, "Fichier récupéré avec l'ID: " . $testFileId);
            
            echo "<h2>4. Test de création de lien de partage</h2>";
            $shareToken = LinkAuthController::createShareLink($testFileId, $testUserId);
            
            if ($shareToken) {
                displayResult("Création de lien de partage", true, "Lien créé avec le token: " . $shareToken);
                
                // Ajout d'un test pour vérifier la récupération par token
                $link = Links::getByToken($shareToken);
                if ($link && $link->token === $shareToken) {
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
if (isset($testUserId) && isset($testFileId)) {
    $restrictedEmail = "restricted" . rand(1000, 9999) . "@example.com";
    
    // Créer un nouveau lien avec restriction par email
    $newLink = Links::createLink($testUserId);
    
    if ($newLink) {
        // Associer le fichier au lien
        $fileLink = FileLink::createFilesLinks($newLink->linkid, $testFileId);
        
        // Associer l'email au lien
        $emailLink = EmailLink::createEmailLinks($newLink->linkid, $restrictedEmail);
        
        if ($fileLink && $emailLink) {
            displayResult("Création de lien avec restriction email", true, "Lien créé avec restriction pour: " . $restrictedEmail);
            
            // Récupérer les emails associés au lien pour vérification
            $emailLinks = EmailLink::getByLink_id($newLink->linkid);
            
            $emailFound = false;
            foreach ($emailLinks as $link) {
                if ($link->email === $restrictedEmail) {
                    $emailFound = true;
                    break;
                }
            }
            
            if ($emailFound) {
                displayResult("Vérification de la restriction", true, "Restriction email correctement appliquée");
                echo "<p>Pour tester le téléchargement restreint, accédez à: <a href='download.php?token=" . $newLink->token . "'>download.php?token=" . $newLink->token . "</a></p>";
            } else {
                displayResult("Vérification de la restriction", false, "L'email n'a pas été correctement associé au lien");
            }
        } else {
            displayResult("Association fichier/email au lien", false, "Échec de l'association du fichier ou de l'email au lien");
        }
    } else {
        displayResult("Création de lien avec restriction email", false, "Échec de la création du lien");
    }
} else {
    displayResult("Test de réservation", false, "Impossible de tester sans utilisateur ou fichier valide");
}

echo "<h2>6. Test d'upload multiple de fichiers</h2>";
if (isset($testUserId)) {
    // Créer plusieurs fichiers de test
    $fileIds = [];
    
    // Premier fichier
    $testFileName1 = 'test_file1.txt';
    $testFileContent1 = 'Ceci est le premier fichier de test pour l\'upload multiple.';
    $testFileType1 = 'text/plain';
    
    // Second fichier
    $testFileName2 = 'test_file2.txt';
    $testFileContent2 = 'Ceci est le second fichier de test pour l\'upload multiple.';
    $testFileType2 = 'text/plain';
    
    // Upload des fichiers
    $uploadResult1 = FileController::uploadFile($testUserId, $testFileName1, $testFileType1, $testFileContent1);
    $uploadResult2 = FileController::uploadFile($testUserId, $testFileName2, $testFileType2, $testFileContent2);
    
    if ($uploadResult1 && $uploadResult2) {
        $fileIds[] = $uploadResult1->fileid;
        $fileIds[] = $uploadResult2->fileid;
        
        displayResult("Upload de fichiers multiples", true, "Deux fichiers uploadés avec succès: IDs " . implode(", ", $fileIds));
        
        // Création d'un lien partagé pour les deux fichiers
        $shareToken = LinkAuthController::createShareLink($fileIds, $testUserId);
        
        if ($shareToken) {
            displayResult("Création de lien pour fichiers multiples", true, "Lien créé avec le token: " . $shareToken);
            
            // Récupérer les informations du lien
            $link = Links::getByToken($shareToken);
            if ($link) {
                // Vérifier que les deux fichiers sont bien associés au lien
                $fileLinks = FileLink::getByLink_id($link->linkid);
                
                if (count($fileLinks) == 2) {
                    displayResult("Association des fichiers au lien", true, "Les deux fichiers sont correctement associés au lien");
                    
                    echo "<p>Pour tester le téléchargement multiple, accédez à: <a href='download.php?token=$shareToken'>download.php?token=$shareToken</a></p>";
                } else {
                    displayResult("Association des fichiers au lien", false, "Nombre incorrect de fichiers associés au lien: " . count($fileLinks) . " (attendu: 2)");
                }
            } else {
                displayResult("Récupération du lien", false, "Impossible de récupérer le lien créé");
            }
        } else {
            displayResult("Création de lien pour fichiers multiples", false, "Échec de la création du lien");
        }
    } else {
        displayResult("Upload de fichiers multiples", false, "Échec de l'upload d'un ou plusieurs fichiers");
    }
} else {
    displayResult("Test d'upload multiple", false, "Impossible de tester sans utilisateur valide");
}

// Affichage des résultats
echo "<h2>Résumé des tests</h2>";
echo "<p>Les tests ont été exécutés. Vérifiez les résultats ci-dessus pour voir si tous les tests ont réussi.</p>";

echo "<h2>Nettoyage des données de test</h2>";
echo "<form method='post'>";
echo "<input type='submit' name='cleanup' value='Nettoyer les données de test'>";
echo "</form>";

if (isset($_POST['cleanup'])) {
    cleanupTestData();
}
?>