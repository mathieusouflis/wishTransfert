<?php
require_once ("Models/Link.Model.php");
require_once ("Models/FileLink.Model.php");
require_once ("Models/File.Model.php");

class LinkController{

    public function delete($id){
        if($_SERVER["REQUEST_METHOD"] === "DELETE"){
            // Connexion à la base de données
            $pdo = new PDO('mysql:host=localhost;dbname=wishtransfert', 'username', 'password');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparation de la requête de suppression
            $stmt = $pdo->prepare('DELETE FROM links WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Exécution de la requête
            if($stmt->execute()){
                echo json_encode(['status' => 'success', 'message' => 'Link deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete link']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }

    public function getFiles($link_token){
        $link = Links::getByToken($link_token);
        $filesIds = FileLink::getByLink_id($link->linkid);
        $files = [];
        foreach($filesIds as $id){
            $files[] = File::getByFileId( $id );
        }
    }

}

// COMMENT ON FAIT POUR LIER L'HTML ET LE PHP POUR LE DELETE ?
