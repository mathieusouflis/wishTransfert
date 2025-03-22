<?php

if(session_status() === PHP_SESSION_NONE) session_start();

$root_path = dirname(dirname(dirname(dirname(__FILE__))));

if (file_exists($root_path . "../../../Models/File.Model.php")) {
    require_once $root_path . "../../../Models/File.Model.php";
    require_once $root_path . "../../../config/database.php";
    $using_real_files = true;
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $files = File::getByUserId($user_id);
    } else {
        $files = [];
        $using_real_files = false;
    }
} else {
    $using_real_files = false;
    
    // Données factices pour les tests
    $sample_files = [
        [
            'fileid' => 1,
            'title' => 'File Name',
            'size' => '10Go',
            'type' => 'application/pdf',
            'filedata' => 'Contenu factice pour le test'
        ],
        [
            'fileid' => 2,
            'title' => 'File Name',
            'size' => '10Go',
            'type' => 'image/jpeg',
            'filedata' => 'Contenu factice pour le test'
        ],
        [
            'fileid' => 3,
            'title' => 'File Name',
            'size' => '10Go',
            'type' => 'application/zip',
            'filedata' => 'Contenu factice pour le test'
        ]
    ];
    
    $files = [];
    foreach ($sample_files as $file_data) {
        $file = new stdClass();
        $file->fileid = $file_data['fileid'];
        $file->title = $file_data['title'];
        $file->size = $file_data['size'];
        $file->type = $file_data['type'];
        $file->filedata = $file_data['filedata'];
        $files[] = $file;
    }
}

$backgroundImage = '../../assets/images/background.png';

if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    $file_id = intval($_GET['remove']);
    
    if ($using_real_files && isset($_SESSION['user_id'])) {
        File::deleteFile($file_id);
        
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        foreach ($files as $key => $file) {
            if ($file->fileid == $file_id) {
                unset($files[$key]);
                break;
            }
        }
        $files = array_values($files);
    }
}

if (isset($_GET['download_file']) && !empty($_GET['download_file'])) {
    $file_id = intval($_GET['download_file']);
    
    if ($using_real_files) {
        $file = File::getByFileId($file_id);
        
        if ($file && isset($_SESSION['user_id']) && $file->userid == $_SESSION['user_id']) {
            if (function_exists('incrementDownloadCount')) {
                incrementDownloadCount($file_id);
            }
            
            // Télécharger le fichier
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $file->type);
            header('Content-Disposition: attachment; filename="' . $file->title . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($file->filedata));
            echo $file->filedata;
            exit;
        }
    } else {
        foreach ($files as $file) {
            if ($file->fileid == $file_id) {
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $file->type);
                header('Content-Disposition: attachment; filename="' . $file->title . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . strlen($file->filedata));
                echo $file->filedata;
                exit;
            }
        }
    }
}

if (isset($_GET['download_all']) && !empty($files)) {
    $zip = new ZipArchive();
    $zipName = 'wishtransfert_files_' . date('Y-m-d') . '.zip';
    $zipPath = sys_get_temp_dir() . '/' . $zipName;
    
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
            $zip->addFromString($file->title, $file->filedata);
            
            if ($using_real_files && function_exists('incrementDownloadCount')) {
                incrementDownloadCount($file->fileid);
            }
        }
        $zip->close();
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);
        unlink($zipPath);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Files</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('<?php echo $backgroundImage; ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
        }
        
        .page-container {
            width: 100%;
            height: 100vh;
            position: relative;
        }
        
        .download-box {
            background-color: white;
            border-radius: 10px;
            width: 242px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            padding: 0;
            position: absolute;
            top: 180px;
            left: 40px;
        }
        
        .download-button {
            background-color: #FF4B4B;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border: none;
            width: 100%;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            font-weight: normal;
            border-radius: 0;
            text-decoration: none;
            box-sizing: border-box;
        }
        
        .download-icon {
            margin-right: 10px;
            display: inline-flex;
        }
        
        .files-title {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0 10px 15px;
            color: #333;
        }
        
        .file-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-top: 1px solid #f0f0f0;
        }
        
        .file-name {
            font-size: 14px;
            color: #333;
        }
        
        .file-info {
            display: flex;
            align-items: center;
        }
        
        .file-size {
            font-size: 14px;
            color: #666;
            margin-right: 10px;
        }
        
        .icon-button {
            cursor: pointer;
            color: #777;
            display: flex;
            width: 14px;
            height: 14px;
            margin-left: 6px;
        }
        
        .demo-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(255, 100, 0, 0.8);
            color: white;
            text-align: center;
            padding: 5px 0;
            font-size: 12px;
            z-index: 100;
        }
    </style>
</head>
<body>
    <?php if (!$using_real_files): ?>
    <div class="demo-banner">
        Mode démonstration - Données factices
    </div>
    <?php endif; ?>
    
    <div class="page-container">
        <div class="download-box">
            <a href="?download_all=1" class="download-button">
                <span class="download-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </span>
                Download All
            </a>
            
            <div class="files-title">Files</div>
            
            <ul class="file-list">
                <?php foreach ($files as $file): ?>
                <li class="file-item">
                    <span class="file-name"><?php echo htmlspecialchars($file->title); ?></span>
                    <div class="file-info">
                        <span class="file-size"><?php echo htmlspecialchars($file->size); ?></span>
                        
                        <a href="?download_file=<?php echo $file->fileid; ?>" class="icon-button" title="Télécharger ce fichier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </a>
                        
                        <a href="?remove=<?php echo $file->fileid; ?>" class="icon-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier?');" title="Supprimer ce fichier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </a>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>