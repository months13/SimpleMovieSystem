<?php

// 상영관 검색 시 사용됨

$id = validateInput($_POST["id"]);

echo json_encode(readData($id));

function readData($id) {
    $file = fopen("./data/screening.json", "r");
    $returnData = array();

    while(!feof($file)) {
        $line = fgets($file);
        $decoded = json_decode($line);     
        
        // if($id == $decoded->id) {
        //     array_push($returnData, $decoded);
        // }

        if(strcmp($id, $decoded->movie_id) == 0) {
            array_push($returnData, $decoded);
        }
        
    }

    fclose($file);

    return $returnData;

}

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    return htmlspecialchars($input);
}
?>