<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="search6_script.js?ver=5"></script>
    <link rel="stylesheet" href="search_style.css?ver=5">
</head>
<body>



    <div class="header">
        <span></span>
        <span></span>
        <span class="login-section">
            <span class="id-display2">
                <?php

                $id = validateInput($_POST["id"]);
                echo($id);            

                function validateInput($input) {
                    $input = trim($input);
                    $input = stripslashes($input);
                    return htmlspecialchars($input);
                }

                ?>
            </span>
            <span>회원</span>                        
        </span>
    </div>

    <div class="search-result">
        <table class="result-table">
            <tr class="result-row">
                <th class="result-data3">체크</th>
                <th class="result-data3">예약 번호</th>
                <th class="result-data3">영화 제목</th>
                <th class="result-data3">상영 날짜</th>
                <th class="result-data3">상영 장소</th>
                <th class="result-data3">예매 수</th>
            </tr>

            <!-- <tr class="result-row">
                <td><input type="checkbox" name="select3"></td>
                <td>u0</td>
                <td>정준모의영화</td>
                <td>2022-12-12</td>
                <td>상영관1</td>
                <td>3</td>
            </tr> -->

            <?php
        
                $file = fopen("./data/" . $id . ".json", "r");
                // {"id":"u0","movie_id":"m0","s_id":"r0","reserve_num":"3"}
                while(!feof($file)) {
                    $line = fgets($file);
                    $decoded = json_decode($line);

                    $movieName = $decoded->id;
                    $movieDate = "";
                    $movieTheater = "";

                    $movieId = $decoded->movie_id;
                    $screenId = $decoded->s_id;

                    $file2 = fopen("./data/movie.json", "r");
                    while(!feof($file2)) {
                        $line2 = fgets($file2);
                        $decoded2 = json_decode($line2);
                        
                        if(strcmp($decoded2->id, $movieId) == 0) {
                            $movieName = $decoded2->movie_name;                            
                            break;
                        }
                    }
                    fclose($file2);

                    $file3 = fopen("./data/screening.json", "r");
                    while(!feof($file3)) {
                        $line3 = fgets($file3);
                        $decoded3 = json_decode($line3);

                        if(strcmp($decoded3->id, $screenId) == 0) {
                            $movieDate = $decoded3->date;                            
                            $movieTheater = $decoded3->screening_id;                            
                            break;
                        }
                    }
                    fclose($file3);

                    echo "<tr class='result-row";
                    echo " " . $decoded->id . "'";
                    echo ">";
                    echo "<td><input type='checkbox' name='select3' ";
                    echo "value='";
                    echo $decoded->id;
                    echo "'";
                    echo "></td>";                    

                    echo "<td>";
                    echo $decoded->id;
                    echo "</td>";

                    echo "<td>"; // movie_id 로 영화 이름
                    echo $movieName;
                    echo "</td>";

                    echo "<td>"; // screen_id 로 상영 날짜
                    echo $movieDate;
                    echo "</td>";

                    echo "<td>"; // screen_id 로 상영관
                    echo $movieTheater;
                    echo "</td>";

                    echo "<td>";
                    echo $decoded->reserve_num;
                    echo "</td>";

                    echo "</tr>";
                }


            ?>

        </table>        

    </div>

    <button class="cancel-button">취소하기</button>

    
</body>
</html>