<?php

$id = validateInput($_POST["id"]);
$userId = validateInput($_POST["userid"]);
$userId2 = $userId . "2";

$screenId = "";
$screenNum = "";

$file = fopen("./data/" . $userId . ".json", "r");
$file2 = fopen("./data/" . $userId2 . ".json", "w");
while(!feof($file)) {
    $line = fgets($file);
    if($line == null) {
        continue;
    }
    if($line == "null") {
        continue;
    }
    if($line == "") {
        continue;
    }
    $decoded = json_decode($line);

    if(strcmp($id, $decoded->id) == 0) {
        $screenId = $decoded->s_id;
        $screenNum = $decoded->reserve_num;
        continue;
    } 
    $decoded = json_encode($decoded, JSON_UNESCAPED_UNICODE);
    fwrite($file2, $decoded . "\n");
}
fclose($file);
fclose($file2);

$file3 = fopen("./data/" . $userId . ".json", "w");
$file4 = fopen("./data/" . $userId2 . ".json", "r");
while(!feof($file4)) {
    $line = fgets($file4);
    if($line == "null") {
        continue;
    }
    if($line == null) {
        continue;
    }
    if($line == "") {
        continue;
    }
    fwrite($file3, $line);
}
fclose($file3);
fclose($file4);

unlink("./data/" . $userId2 . ".json");

///

// $screenId = "";
$screenNum = (int)$screenNum;

$file5 = fopen("./data/screening.json", "r");
$file6 = fopen("./data/screening2.json", "w");
while(!feof($file5)) {
    $line = fgets($file5);
    $decoded = json_decode($line);
    if($line == null) {
        continue;
    }
    if($line == "null") {
        continue;
    }
    if($line == "") {
        continue;
    }
    if(strcmp($screenId, $decoded->id) == 0) {
        $tmpNum = $decoded->reserve_seat;
        $tmpNum = (int)$tmpNum;
        $tmpNum = $tmpNum - $screenNum;
        
        $decoded->reserve_seat = $tmpNum;

        $encoded = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        fwrite($file6, $encoded . "\n");
    } else {
        $encoded = json_encode($decoded, JSON_UNESCAPED_UNICODE);
        fwrite($file6, $encoded . "\n");
    }
}
fclose($file5);
fclose($file6);

$file7 = fopen("./data/screening.json", "w");
$file8 = fopen("./data/screening2.json", "r");
while(!feof($file8)) {
    $line = fgets($file8);
    if($line == null) {
        continue;
    }
    if($line == "null") {
        continue;
    }
    if($line == "") {
        continue;
    }
    fwrite($file7, $line);
}
fclose($file7);
fclose($file8);

unlink("./data/screening2.json");

echo("1");



function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    return htmlspecialchars($input);
}

?>