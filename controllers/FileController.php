<?php

class fileController {
    public $user;
    public $refused_extension = ["php","exe","mathieu","leoFaitlHabit",'Bananjara'] ;
    public $max_size; 
    
    
    
    public function uploadFile($user, $refused_extension, $max_size, $fichier,$fileName,$extension,$errors){
        
        if(in_array($extension, $refused_extension)){
            echo "Vous ne pouvez pas upload des fichiers de type .$extension";
            $errors = true;
        }
        
        if($fichier["size"] > $max_size){
            echo "Fichier trop volumineux, vous ne pouvez upload qu'un fichier de max"." ".$max_size." "."Mo";
            $errors = true;
            
        }
        if($errors === false){
            $uploadDir = "controllers/Uploads/";
            if (move_uploaded_file($fichier["tmp_name"], $uploadDir . $fileName)) {
                echo "Fichier uploadé avec succès ! <br>";
                echo "Nom : $fileName <br>";
                echo "Taille : " . round($fichier["size"] / 1024, 2) . " Ko <br>";
                echo "Type : $extension <br>";
                echo "<a href='$uploadDir/$fileName' download>télécharger</a>";
            }
        }
        
    }
    public function deleteFile($user, $fichier,$fileName){
        if($user["connected"] && $fichier["createdBy"] === $user["id"]){
            if(file_exists("Uploads/".$fileName)){
                $recycleBinDir = "controllers/RecycleBin/";
                move_uploaded_file($fichier["tmp_name"],$recycleBinDir.$fileName);
                echo "Un fichier a été déplacé vers la corbeille";
            } 
        }
    }
    
}

if($_SERVER["REQUEST_METHOD"]=== "POST"){
    
    $fichier = $_FILES["file"];
    $fichier["id"] = bin2hex(random_bytes(10));
    $fichier["createdBy"] = $user["id"];
    $extension = pathinfo($fichier["name"], PATHINFO_EXTENSION);
    $fileName = $fichier["id"].".".$extension;

    $fileController = new FileController();
    if(isset($_POST["create"])) $fileController->uploadFile($user,$refused_extension,$max_size, $fichier, $fileName, $extension,$errors);
    if(isset($_POST["delete"])) $fileController ->deleteFile($user,$fichier,$fileName);
}



?>