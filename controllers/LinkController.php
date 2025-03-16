<?php

require_once("./Models/Link.Model.php");

class LinkController {
    public function generateLink(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            // $files = uploadFiles(); TODO: DOIT ÊTRE IMPLÉMENTÉ AVEC LE FILECONTROLLER
            $files = [
                1,2,3,4,5,6,7,8,9
            ];

            $userId = 1; // TODO: DOIT ÊTRE CHANGÉ PAR LE VRAI USERID
            Links::createLink($userId);
        }
    }
}

?>

<form action="dazdazd"></form>