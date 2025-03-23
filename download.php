<?php
global $errors;
$errors = [];
require_once "./controllers/AuthController.php";
AuthController::needLog();

require_once "./config/config.php";

require_once "./controllers/LinkAuth.php";
require_once "./Models/Link.Model.php";

if(!isset($_GET["token"])|| empty($_GET["token"])){
    header("Location: ".APP_URL."index.php");
    exit;
}
$token = $_GET['token'];
$linkInfo = LinkAuthController::getLinkInfoForDownload($token);

if (!isset($linkInfo) || empty($linkInfo)) {
    header("Location: ".APP_URL."index.php");
    exit;
}
$files = $linkInfo["files"];

$email = $_SESSION["email"];
if($linkInfo["email_restriction"] !== $email){
    header("Location: ".APP_URL."index.php");
    exit;
}

if(isset($_GET["download_file"])){
    $fileId = intval($_GET["download_file"]);
    if(isset($files[$fileId]) && !empty($files[$fileId])){
         if (ob_get_level()) {
    ob_clean();
}
        $file = $files[$fileId];
        $downloadCount = $linkInfo["download_count"] + 1;
        Links::updateLink(["link_id" => $linkInfo["link_id"]], ["download_count"=> $downloadCount]);
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

if(isset($_GET['download_all']) && !empty($files)){
    $zip = new ZipArchive();
    $zipName = 'wishtransfert_files_' . date('Y-m-d') . '.zip';
    $zipPath = sys_get_temp_dir() . '/' . $zipName;
    
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
            $zip->addFromString($file->title, $file->filedata);
        }
        $zip->close();
        
        $downloadCount = $linkInfo["download_count"] + 1;
        Links::updateLink(["link_id" => $linkInfo["link_id"]], ["download_count"=> $downloadCount]);

         if (ob_get_level()) {
    ob_clean();
}

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

require_once "./config/database.php";

require_once "./0 FRONT/base/header.php";
require_once "./0 FRONT/composents/icons.php";
require_once "./0 FRONT/composents/errorModal.php";
errorModal($errors);
?>

<div class="download-box bg-white radius-10 w-272 max-h-300 box-shadow absolute left-20 center-y flex flex-col gap-16 pb-15">
    <a href="?token=<?=$token?>&download_all=1" class="download-button bg-primary  flex items-center justify-center p-15 w-full text-center text-15 radius-t-10 gap-10">
        <?php icon('download', 'medium', 'white');?>
        <span>Download All</span>
    </a>
    <div class="flex flex-col mx-10 gap-10 overflow-hidden">
        <div class="file-title text-15 bold text-black">Files</div>
        <ul class="flex flex-col gap-10 file-list list-none overflow-y-scroll">
        <?php foreach ($linkInfo['files'] as $index => $file): ?>
            <li class="file-item flex flex-row justify-between items-center">
                <span class="file-name text-14 text-black w-1-2 text-wrap"><?=$file->title?></span>
                <div class="file-info flex flex-row gap-14 items-center">
                    <span class="file-size text-black text-14 text-gray">
<?php 
    $len = strlen($file->filedata);
    if ($len !== 0){
        $k = 1024;
        $sizes = array('B', 'KB', 'MB', 'GB', 'TB');
        $i = floor(log($len) / log($k));
        
        echo number_format($len / pow($k, $i), 2) . ' ' . $sizes[$i];
    } else{ 
        echo '0 B';
    }
    
?>
                    </span>
                    <div class="flex gap-8 flex-row items-center">
                        <a href="?token=<?=$token?>&download_file=<?=$index?>" class="icon-button" title="Télécharger ce fichier">                            
                            <?php icon("download", "small", "#777");?>
                        </a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php
require_once "./0 FRONT/base/footer.php";
