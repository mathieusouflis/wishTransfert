<?php
require_once './controllers/LinkAuth.php';
require_once './config/database.php';
require_once './Models/File.Model.php';

if(session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_GET['token']) || empty($_GET['token'])) {
    header('Location: index.php');
    exit;
}

$token = $_GET['token'];

// Récupérer les informations du lien
$linkInfo = LinkAuthController::getLinkInfoForDownload($token);

if (!$linkInfo) {
    header('Location: index.php?error=invalid_link');
    exit;
}

// Vérifier s'il y a des restrictions d'email
if (!empty($linkInfo['emails'])) {
    $hasAccess = false;
    
    // Si l'utilisateur est connecté, vérifier son email
    if (isset($_SESSION['email'])) {
        foreach ($linkInfo['emails'] as $email) {
            if ($_SESSION['email'] === $email) {
                $hasAccess = true;
                break;
            }
        }
    }
    
    // Si accès refusé, rediriger vers la page de connexion
    if (!$hasAccess) {
        header('Location: login.php?redirect=' . urlencode('download.php?token=' . $token));
        exit;
    }
}

// Si une demande de téléchargement spécifique
if (isset($_GET['file_id']) && !empty($_GET['file_id'])) {
    $fileId = intval($_GET['file_id']);
    
    // Vérifier que le fichier fait partie du lien
    $fileFound = false;
    $fileToDownload = null;
    
    foreach ($linkInfo['files'] as $file) {
        if ($file->fileid == $fileId) {
            $fileFound = true;
            $fileToDownload = $file;
            break;
        }
    }
    
    if (!$fileFound) {
        header('Location: download.php?token=' . $token . '&error=file_not_found');
        exit;
    }
    
    // Incrémenter le compteur de téléchargement
    incrementDownloadCount($fileId);
    
    // Envoyer le fichier au navigateur
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $fileToDownload->type);
    header('Content-Disposition: attachment; filename="' . $fileToDownload->title . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($fileToDownload->filedata));
    echo $fileToDownload->filedata;
    exit;
}

// Si demande de téléchargement en ZIP
if (isset($_GET['download_all']) && count($linkInfo['files']) > 1) {
    $zip = new ZipArchive();
    $zipName = tempnam(sys_get_temp_dir(), 'zip');
    
    if ($zip->open($zipName, ZipArchive::CREATE) === true) {
        foreach ($linkInfo['files'] as $file) {
            $zip->addFromString($file->title, $file->filedata);
            incrementDownloadCount($file->fileid);
        }
        $zip->close();
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="wishtransfert_' . date('Y-m-d') . '.zip"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zipName));
        readfile($zipName);
        unlink($zipName);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger - WishTransfert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .file-list {
            margin-top: 20px;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #eee;
            align-items: center;
        }
        .file-info {
            flex: 1;
        }
        .file-actions {
            text-align: right;
        }
        .download-all {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Télécharger des fichiers</h1>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error">
            <?php if ($_GET['error'] === 'file_not_found'): ?>
                <p>Le fichier demandé n'a pas été trouvé.</p>
            <?php else: ?>
                <p>Une erreur s'est produite.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="container">
        <?php if (!empty($linkInfo['files'])): ?>
            <h2>Fichiers disponibles :</h2>
            <div class="file-list">
                <?php foreach ($linkInfo['files'] as $index => $file): ?>
                    <div class="file-item">
                        <div class="file-info">
                            <strong><?= htmlspecialchars($file->title) ?></strong>
                            <p>Type: <?= htmlspecialchars($file->type) ?></p>
                            <p>Téléchargé <?= $file->downloadcount ?> fois</p>
                        </div>
                        <div class="file-actions">
                            <a href="download.php?token=<?= $token ?>&file_id=<?= $file->fileid ?>" class="btn">Télécharger</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (count($linkInfo['files']) > 1): ?>
                <div class="download-all">
                    <a href="download.php?token=<?= $token ?>&download_all=1" class="btn">Télécharger tous les fichiers (ZIP)</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Aucun fichier n'est disponible pour ce lien.</p>
        <?php endif; ?>
    </div>
    
    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>