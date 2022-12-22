function createData() {        
    let sendData = {id:$(".id-input").val(),password:$(".password-input").val()};
    return sendData;
}

function createData2() {        
    let sendData = {keyword:$(".search-input").val()};
    return sendData;
}

function createData3() {            
    let sendData = {id:$(':radio[name="select2"]:checked').val()};
    return sendData;
}

function createData4() {            
    let sendData = {id:$(':radio[name="select"]:checked').val()};
    return sendData;
}

function createData5() {           
    let user_id2 = $(".id-display").text();            
    let reservation_id2 = $(':radio[name="select"]:checked').val();
    let movie_id2 = $("." + reservation_id2 + "Q").attr("id");
    let reservation_num2 = $(".reservation-number").val();

    let sendData = {user_id:user_id2,movie_id:movie_id2,reservation_id:reservation_id2,reservation_num:reservation_num2};
    return sendData;
}

$(document).ready(function(){

    $(".login-button").click(function(){
        let buttonText = $(".login-button").text();
        
        if(buttonText == "로그인") {
            $(".login-form").css("display", "block");           
        } else {
            alert("로그아웃 되었습니다");
            $(".login-button").text("로그인");
            $(".id-display").text("");
        }

    });

    $(".submit-button").click(function(){
        let idValue = $(".id-input").val();
        let passwordValue = $(".password-input").val();

        let idReg = new RegExp(/^([A-Za-z0-9]){6,15}$/);
        let passwordReg = new RegExp(/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/);        

        if(idValue == "") {
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");
            return;
        }

        if(passwordValue == "") {            
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");            
            return;            
        }

        if(!idReg.test(idValue)) {
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");
            $(".login-form").css("display", "none");
            return;     
        }

        if(!passwordReg.test(passwordValue)) {
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");
            $(".login-form").css("display", "none");
            return;     
        }

        $.ajax(
            {
                url:"search_php2.php",
                type:"post",
                data:createData(),
                dataType:"text",
                success:function(data){                                   
                    if(data == 0) {
                        // fail
                        alert("아이디와 비밀번호를 확인해주세요.");
                    } else {
                        // success
                        $(".login-button").text("로그아웃");
                        $(".login-form").css("display", "none");  
                        $(".id-display").text($(".id-input").val());
                    }
                },
                error:function(){
                    console.log("error");
                }
            }
        );

    });

    $(".search-button").click(function(){
        
        $.ajax(
            {
                url:"search_php3.php",
                type:"post",
                data:createData2(),
                dataType:"json",
                success:function(data){
                    // let useData = JSON.parse(data);
                    
                    $(".result-table").empty();
                    $(".theater-search").css("display", "block");

                    let tr = document.createElement("tr");
                    tr.setAttribute("class", "result-row");
                    
                    let th1 = document.createElement("th");
                    th1.setAttribute("class", "result-data");
                    th1.textContent = "선택";
                    tr.append(th1);                    

                    let th2 = document.createElement("th");
                    th2.setAttribute("class", "result-data");
                    th2.textContent = "영화 제목";
                    tr.append(th2);

                    let th3 = document.createElement("th");
                    th3.setAttribute("class", "result-data");
                    th3.textContent = "장르";
                    tr.append(th3);

                    let th4 = document.createElement("th");
                    th4.setAttribute("class", "result-data");
                    th4.textContent = "감독";
                    tr.append(th4);

                    let th5 = document.createElement("th");
                    th5.setAttribute("class", "result-data");
                    th5.textContent = "배우";
                    tr.append(th5);

                    let th6 = document.createElement("th");
                    th6.setAttribute("class", "result-data");
                    th6.textContent = "화일";
                    tr.append(th6);

                    $(".result-table").append(tr);


                    let useData = data;                    

                    for(let k of useData) {
                        let tr = document.createElement("tr");
                        tr.setAttribute("class", "result-row");

                        let td1 = document.createElement("td");
                        let inputRadio = document.createElement("input");
                        inputRadio.setAttribute("type", "radio");
                        inputRadio.setAttribute("name", "select2");
                        inputRadio.setAttribute("value", k.id);
                        td1.append(inputRadio);

                        tr.append(td1);
                        // {"id":"m2","movie_name":"마바","genre":"action","director":"대","actors":["매배","미비","므브"],"file_name":"3199222_green_nature_square_tree_icon.png"}
                        let td2 = document.createElement("td");
                        td2.textContent = k.movie_name;
                        tr.append(td2);

                        let td3 = document.createElement("td");
                        td3.textContent = k.genre;
                        tr.append(td3);

                        let td4 = document.createElement("td");
                        td4.textContent = k.director;
                        tr.append(td4);

                        let td5 = document.createElement("td");
                        let actorText = "";
                        
                        for(let i=0; i<k.actors.length; i++) {
                            actorText = actorText + k.actors[i] + ",";
                        }
                        actorText = actorText.substring(0, actorText.length - 1);
                        td5.textContent = actorText;
                        tr.append(td5);

                        let td6 = document.createElement("td"); // 미리보기라서 연결 해 줘야 함
                        let imageName = k.file_name;
                        let hyperLink = document.createElement("a");
                        hyperLink.setAttribute("href", "./uploads/" + imageName);
                        hyperLink.setAttribute("target", "_blank");
                        hyperLink.textContent = "미리보기";
                        td6.append(hyperLink);
                        tr.append(td6);
                        
                        $(".result-table").append(tr);
                        
                    }
                },
                error:function(){
                    console.log("error");
                }
            }
        );


    });


    $(".sign-button").click(function(){
        let idValue = $(".id-input").val();
        let passwordValue = $(".password-input").val();

        let idReg = new RegExp(/^([A-Za-z0-9]){6,15}$/);
        let passwordReg = new RegExp(/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/);

        console.log(idValue);

        if(idValue == "") {
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");
            return;
        }

        if(passwordValue == "") {            
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");            
            return;            
        }

        if(!idReg.test(idValue)) {
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");
            $(".login-form").css("display", "none");
            return;     
        }

        if(!passwordReg.test(passwordValue)) {
            alert("아이디 또는 패스워드의 입력 양식을 체크해주세요.");
            $(".login-form").css("display", "none");
            return;     
        }        

        $.ajax(
            {
                url:"search_php.php",
                type:"post",
                data:createData(),
                dataType:"text",
                success:function(data){
                    alert(data);
                },
                error:function(){
                    console.log("error");
                }
            }
        );
        
    });

    $(".theater-search").click(function(){        
        let checkValue = $(':radio[name="select2"]:checked').val();
        console.log(checkValue);        

        if (checkValue == undefined) {
            alert("영화를 선택해주세요.");
            return;
        } else {                       
            
            $.ajax({
                url:"search_php4.php",
                type:"post",
                data:createData3(),
                dataType:"json",
                success:function(data) {
                    $(".result-table2").empty();
                    $(".make-reservation").css("display", "block");

                    let tr = document.createElement("tr");
                    tr.setAttribute("class", "result-row");
                    
                    let th1 = document.createElement("th");
                    th1.setAttribute("class", "result-data");
                    th1.textContent = "선택";
                    tr.append(th1);                    

                    let th2 = document.createElement("th");
                    th2.setAttribute("class", "result-data");
                    th2.textContent = "상영 날짜";
                    tr.append(th2);

                    let th3 = document.createElement("th");
                    th3.setAttribute("class", "result-data");
                    th3.textContent = "상영관";
                    tr.append(th3);

                    let th4 = document.createElement("th");
                    th4.setAttribute("class", "result-data");
                    th4.textContent = "예약수";
                    tr.append(th4);                    

                    $(".result-table2").append(tr);

                    // let useData = JSON.parse(data);
                    let useData = data;
                    // console.log(data);

                    for(let k of useData) {
                        let tr = document.createElement("tr");
                        tr.setAttribute("class", "result-row");

                        let td1 = document.createElement("td");
                        let inputRadio = document.createElement("input");
                        inputRadio.setAttribute("type", "radio");
                        inputRadio.setAttribute("name", "select");
                        inputRadio.setAttribute("value", k.id);                        
                        td1.append(inputRadio);
                        tr.append(td1);

                        // {"id":"r0","date":"2022-11-10","movie_id":"m0","screening_id":"상영관1","reserve_seat":0}
                        let td2 = document.createElement("td");
                        td2.textContent = k.date;
                        tr.append(td2);

                        let td3 = document.createElement("td");
                        td3.textContent = k.screening_id;
                        td3.setAttribute("class", k.id + "Q");
                        td3.setAttribute("id", k.movie_id);
                        tr.append(td3);

                        let td4 = document.createElement("td");
                        td4.textContent = k.reserve_seat;
                        td4.setAttribute("class", k.id);
                        tr.append(td4);                                                                   
                        
                        $(".result-table2").append(tr);                        
                    }
                    
                },
                error:function() {
                    console.log("error");
                }

            });

        }
        
        
    });

    $(".cancel-button").click(function(){
        $(".make-reservation").css("display", "none");        
    });

    $(".reservation-button").click(function(){
        let loginCheck = $(".login-button").text();

        console.log(loginCheck);

        if(loginCheck == "로그인") {
            alert("로그인 후 영화 예약이 가능합니다.");
            return;
        }

        let reservationNumber = $(".reservation-number").val();
        console.log(reservationNumber);

        if(reservationNumber == "") {
            alert("예약할 인원을 입력해주세요.");
        }
        
        reservationNumber = parseInt(reservationNumber);

        if(reservationNumber > 10) {
            alert("한 번에 예약 가능한 인원은 최대 10명 입니다.");
            return;
        }

        let reservationScreen = $(':radio[name="select"]:checked').val();

        let originNum = $("." + reservationScreen).text();
        originNum = parseInt(originNum);

        let num = reservationNumber + originNum;

        console.log(num);

        if(reservationNumber + originNum > 20) {            
            alert("하나의 상영관의 최대 수용 인원은 20명까지입니다.");
            return;
        }

        console.log(reservationScreen);     
        console.log(createData5());   

        $.ajax({
            url:"search_php5.php",
            type:"post",
            data:createData5(),
            dataType:"text",
            success:function(data) {
                $("." + reservationScreen).text(data);
                alert("예약되었습니다.");
            },
            error:function() {
                console.log("error");
            }
        });

        
    });

    $(".reservation-info").click(function(e){

        let buttonText = $(".login-button").text();

        if(buttonText == "로그인") {
            alert("로그인 후 예약 정보 보기가 가능합니다.");   
            e.preventDefault();
            return;
        }        

        e.preventDefault();

        let idValue2 = $(".id-display").text();        
        $(".hidden-input").val(idValue2);
        console.log($(".hidden-input").val());        
        $(".form-b").submit();        
        
    });

});
