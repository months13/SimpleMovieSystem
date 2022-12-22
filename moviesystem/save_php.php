<?php

$date = validateInput($_POST["date"]);

$file = fopen("./data/screening.json", "a");
fclose($file);

echo json_encode(readData($date));

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    return htmlspecialchars($input);
}

function readData($date) {
    $returnData = array();
    
    $file = fopen("./data/screening.json", "r");
    
    while(!feof($file)) {
        $line = fgets($file);
        $decoded = json_decode($line);

        if(strcmp($date, $decoded->date) == 0) {
            array_push($returnData, $decoded->screening_id);
        }
    }

    return $returnData;
}



?>