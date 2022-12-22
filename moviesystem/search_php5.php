<?php
// 회원 예약 정보 저장 시 사용됨

$user_id = validateInput($_POST["user_id"]);
$movie_id = validateInput($_POST["movie_id"]);
$reservation_id = validateInput($_POST["reservation_id"]);
$reservation_num = validateInput($_POST["reservation_num"]);

$file = fopen("./data/" . $user_id . ".json", "a");
fclose($file);

$index = -1;
$file = fopen("./data/" . $user_id . ".json", "r");
while(!feof($file)) {
    $line = fgets($file);
    $index = $index + 1;
}
fclose($file);

$userInfo = new StdClass();
$userInfo->id = "u" . (string)$index;
$userInfo->movie_id = $movie_id;
$userInfo->s_id = $reservation_id;
$userInfo->reserve_num = $reservation_num;

saveUser($userInfo, $user_id);

$file2 = fopen("./data/screening.json", "r");
$file3 = fopen("./data/screening2.json", "w");

$returnData;

while(!feof($file2)) {
    $line = fgets($file2);    
    $screenEncode = json_decode($line);    
    $cmp = $screenEncode->id;

    if($screenEncode == null) {
        continue;
    }
    
    if(strcmp($cmp, $reservation_id) == 0) {
        // 같으면
        $tmpNum = $screenEncode->reserve_seat;
        $tmpNum = (int)$tmpNum;
        $tmpNum2 = (int)$reservation_num;
        $tmpNum = $tmpNum + $tmpNum2;        
        $screenEncode->reserve_seat = $tmpNum;
        $returnData = $tmpNum;

        $screenEncode = json_encode($screenEncode, JSON_UNESCAPED_UNICODE);        
        fwrite($file3, $screenEncode . "\n");
    } else {
        $screenEncode = json_encode($screenEncode, JSON_UNESCAPED_UNICODE);
        fwrite($file3, $screenEncode . "\n");
    }
}

fclose($file2);
fclose($file3);

$file4 = fopen("./data/screening.json", "w");
$file5 = fopen("./data/screening2.json", "r");
while(!feof($file5)) {
    $line = fgets($file5);
    if($line == "null") {
        continue;
    }
    fwrite($file4, $line);
}
fclose($file4);
fclose($file5);

unlink("./data/screening2.json");

echo($returnData);


function saveUser($user, $user_id) {
    $userEncode = json_encode($user, JSON_UNESCAPED_UNICODE);
    $file = fopen("./data/" . $user_id . ".json", "a");
    fwrite($file, $userEncode . "\n");
    fclose($file);
}

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    return htmlspecialchars($input);
}



?>