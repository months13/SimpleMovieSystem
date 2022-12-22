<?php

$movieName = validateInput($_POST["title"]);
$movieGenre = validateInput($_POST["genre"]);
$movieDirector = validateInput($_POST["director"]);
$movieActor = array();
$movieActor1 = validateInput($_POST["actor1"]);
$movieActor2 = validateInput($_POST["actor2"]);
$movieActor3 = validateInput($_POST["actor3"]);
$movieTime = validateInput($_POST["screen-info"]);


$movieTimeArr = explode("|", $movieTime);

if(!empty($movieActor1)) {
    array_push($movieActor, $movieActor1);
}

if(!empty($movieActor2)) {
    array_push($movieActor, $movieActor2);
}

if(!empty($movieActor3)) {
    array_push($movieActor, $movieActor3);
}

// $moviePoster = $_POST["poster"];
$moviePoster = $_FILES["poster"]["name"];
$index = -1;

$file = fopen("./data/movie.json", "a");
fclose($file);

$file = fopen("./data/movie.json", "r");
while(!feof($file)) {
    $line = fgets($file);
    $index = $index + 1;
}
fclose($file);

$movieInfo = new stdClass();
$movieInfo->id = "m" . (string)$index;
$movieInfo->movie_name = $movieName;
$movieInfo->genre = $movieGenre;
$movieInfo->director = $movieDirector;
$movieInfo->actors = $movieActor;
$movieInfo->file_name = $moviePoster;

saveMovie($movieInfo);

function saveMovie($movie) {
    $movieEncode = json_encode($movie, JSON_UNESCAPED_UNICODE);
    $file = fopen("./data/movie.json", "a");
    fwrite($file, $movieEncode . "\n");
    fclose($file);
}

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    return htmlspecialchars($input);
}

$curMovie = "m" . (string)$index;

echo "저장되었습니다.";

///////

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["poster"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file);     

//////

$index2 = -1;

$file = fopen("./data/screening.json", "r");
while(!feof($file)) {
    $line = fgets($file);
    $index2 = $index2 + 1;
}
fclose($file);

for($i = 0; $i < count($movieTimeArr) - 1; $i++) {    
    $timeInfo2 = explode(",", $movieTimeArr[$i]);

    $dateInfo = $timeInfo2[0];
    $screenInfo = $timeInfo2[1];    

    $timeInfo = new stdClass();
    $timeInfo->id = "r" . (string)$index2;
    $timeInfo->date = $dateInfo;
    $timeInfo->movie_id = $curMovie;
    $timeInfo->screening_id = $screenInfo;
    $timeInfo->reserve_seat = 0;

    SaveTime($timeInfo); 
    $index2 = $index2 + 1;   
}


function saveTime($time) {
    $timeEncode = json_encode($time, JSON_UNESCAPED_UNICODE);
    $file = fopen("./data/screening.json", "a");
    fwrite($file, $timeEncode . "\n");
    fclose($file);
}

//////


?>