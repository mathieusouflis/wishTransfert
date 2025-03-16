<?php
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

}

// COMMENT ON FAIT POUR LIER L'HTML ET LE PHP POUR LE DELETE ?
