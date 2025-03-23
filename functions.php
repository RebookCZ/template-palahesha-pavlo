<?php

    function setResponses($dir){      //  take as an arguments where are located photos
        
    $files = glob($dir . "/*.jpg");   //   looking for every files with .png
    $json = file_get_contents("data/data.json");  //   reads the content of a file 
    $data = json_decode($json, true);   // decodes json file to $data
    $names = $data["trainer_name"]; //reads trainers names from json
    $quotes = $data["trainers_quotes"]; // reads quotes from json 
    $roles = $data["client_role"]; // reads quotes from json



    foreach ($files as $file) {        
        echo    '<div class="col-lg-4">';
        echo        '<div class="trainer-item">';
        echo            '<div class="image-thumb">';
        echo                '<img src="'.$file.'" alt="">';
        echo            '</div>';
        echo            '<div class="down-content">';
        echo                '<span>'.$roles[basename($file)].'</span>';
        echo                '<h4>' .$names[basename($file)].'</h4>';
        echo                '<p>'.$quotes[basename($file)].'</p>';
        echo            '</div>';
        echo        '</div>';
        echo    '</div>';
    }

}

?>