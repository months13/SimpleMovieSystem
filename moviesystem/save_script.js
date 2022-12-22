function createData() {
    let sendData = {date:$(".display-date").val()};
    return sendData;
}

$(document).ready(function(){

    $(".add-actor").click(function(){
        let num = $(".actor-list").children().length;        

        if(num < 3){
            let newInput = document.createElement("input");            
            newInput.setAttribute("type", "text");
            newInput.setAttribute("name", "actor" + (parseInt(num) + 1));
            newInput.setAttribute("class", "actor" + (parseInt(num) + 1));
            
            $(".actor-list").append(newInput);
        }
    });

    $(".remove-actor").click(function(){
        let num = $(".actor-list").children().length;
        
        if(num > 1){                                                            
            $(".actor" + (parseInt(num))).remove();                        
        }
    });

    $(".search-theater").click(function(){
        let dateValue = $(".display-date").val();            
        
        if(dateValue != "") {                        
            $(".add-button").attr("disabled", false);
            
            // 날짜에 해당하는 상영관도 disabled 풀어줘야 함
            // 그런데 상영관에서는 하루에 하나의 영화만 상영할 수 있음
            
            $.ajax(
                {
                    url:"save_php.php",
                    type:"post",
                    data:createData(),
                    dataType:"json",
                    success:function(data){
                        // console.log(data);
                        // let returnData = JSON.parse(data);
                        // console.log("d");
                        // data = JSON.parse(data);
                        
                        // 이미 js객체로 전달돼서 변환할 필요 없음

                        let arr = [1, 1, 1];

                        if(data.includes("상영관1")) {
                            arr[0] = 0;    
                        }

                        if(data.includes("상영관2")) {
                            arr[1] = 0;
                        }

                        if(data.includes("상영관3")) {
                            arr[2] = 0;
                        }

                        for(let i=0; i<3; i++) {
                            if(arr[i] == 1) {
                                console.log("theater" + (i+1));                                
                                $(".theater" + (i + 1)).attr("disabled", false);
                            }
                        }
                    },
                    error:function(){
                        console.log("error");
                    }
                }
            );                        
            
        } else {
            // alert("날짜를 입력하세요.");
            console.log("날짜를 입력하세요.");
        }

    });

    $(".add-button").click(function(){
        let dateValue = $(".display-date").val();           
        let checkArr = $(".result-set").children();

        for(let i =0; i<checkArr.length; i++) {
            let cmp = checkArr[i].textContent;

            if(cmp.includes(dateValue)) {
                alert("같은 날짜에 이미 추가되었습니다.");
                $(".add-button").attr("disabled", true);
                return;
            }
        }

        $(".add-button").attr("disabled", true);
        
        let addText = dateValue + "," + $("input[name='locate']:checked").val();
        console.log(addText);

        let addElement = document.createElement("div");
        addElement.setAttribute("class", "result-text");
        addElement.textContent = addText;

        $(".display-result").attr("hidden", false);
        $(".result-set").append(addElement);

        let tempVal = $(".screen-info").attr("value");

        if(tempVal == undefined) {
            tempVal = "";
        }

        tempVal = tempVal + addText + "|";
        $(".screen-info").attr("value", tempVal);
        
        // console.log("dd");
        console.log($(".screen-info").attr("value"));
    });    
    

});
