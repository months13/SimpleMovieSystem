<?php

// 영화 찾을 때 사용됨

$keyword = validateInput($_POST["keyword"]);

echo json_encode(readData($keyword));

function readData($keyword) {
    $file = fopen("./data/movie.json", "r");
    $returnData = array();

    while(!feof($file)) {
        $line = fgets($file);
        $decoded = json_decode($line);

        $isAdd = false;

        if(strpos($decoded->movie_name, $keyword) !== false) {
            $isAdd = true;
        }

        if(strpos($decoded->director, $keyword) !== false) {
            $isAdd = true;
        }
        
        // $num = count($decoded->actors);
        // $num = (int)$num;

        for ($i = 0; $i < 3; $i++) {
            $cmp = $decoded->actors[$i];
            if(strpos($cmp, $keyword) !== false) {
                $isAdd = true;
            }  
        }

        if ($isAdd) {
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