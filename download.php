<?php
require_once './controllers/LinkAuth.php';
require_once './config/database.php';
require_once './Models/File.Model.php';

session_start();

if (!isset($_GET['token']) || empty($_GET['token'])) {
    header('Location: index.php');
    exit;
}

$token = $_GET['token'];
$linkAuth = new LinkAuthC();
$linkInfo = $linkAuth->getLinkInfoForDownload($token);

if (!$linkInfo) {
    header('Location: index.php?error=invalid_link');
    exit;
}

if (isset($linkInfo['email_restriction']) && !empty($linkInfo['email_restriction'])) {
    if (!isset($_SESSION['identifiant']) || $_SESSION['identifiant'] !== $linkInfo['email_restriction']) {
        header('Location: index.php?error=access_denied');
        exit;
    }
}

if (isset($_GET['file_id']) && !empty($_GET['file_id'])) {
    $fileId = intval($_GET['file_id']);
    
    $fileFound = false;
    foreach ($linkInfo['files'] as $file) {
        if ($file['file_id'] == $fileId) {
            $fileFound = true;
            $fileToDownload = $file;
            break;
        }
    }
    
    if (!$fileFound) {
        header('Location: index.php?error=file_not_found');
        exit;
    }
    
    incrementDownloadCount($fileId);
    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileToDownload['title'] . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($fileToDownload['file_data']));
    echo $fileToDownload['file_data'];
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger - WishTransfert</title>
</head>
<body>
    <h1>Télécharger des fichiers</h1>
    
    <?php if (isset($linkInfo['files']) && !empty($linkInfo['files'])): ?>
        <h2>Fichiers disponibles :</h2>
        <ul>
            <?php foreach ($linkInfo['files'] as $file): ?>
                <li>
                    <strong><?= htmlspecialchars($file['title']) ?></strong>
                    <p>Téléchargé <?= $file['download_count'] ?> fois</p>
                    <a href="download.php?token=<?= $token ?>&file_id=<?= $file['file_id'] ?>">
                        Télécharger
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun fichier n'est disponible pour ce lien.</p>
    <?php endif; ?>
    
    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>