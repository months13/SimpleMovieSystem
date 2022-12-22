<?php

// 회원가입 시 사용됨
$id = validateInput($_POST["id"]);
$password = validateInput($_POST["password"]);

writeData($id, $password);

echo("회원가입이 완료되었습니다.");

function writeData($id, $password) {
    $personInfo = new stdClass();
    $personInfo->Name = $id;
    $personInfo->Password = $password;

    $personInfo2 = json_encode($personInfo);

    $file = fopen("./data/person.json", "a");
    fwrite($file, $personInfo2 . "\n");
    fclose($file);
}

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    return htmlspecialchars($input);
}

?>