<?php

// 로그인 시 사용됨
$id = validateInput($_POST["id"]);
$password = validateInput($_POST["password"]);

$file = fopen("./data/person.json", "a");
fclose($file);

$file = fopen("./data/person.json", "r");

while(!feof($file)) {
    $line = fgets($file);
    $decoded = json_decode($line);

    $cmpId = $decoded->Name;
    $cmpPassword = $decoded->Password;

    if (strcmp($cmpId, $id) == 0 && strcmp($cmpPassword, $password) == 0) {
        echo "1";
    }

}

echo "0";

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    return htmlspecialchars($input);
}

?>