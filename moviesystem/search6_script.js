function sleep(ms) {
    const wakeUpTime = Date.now() + ms;
    while (Date.now() < wakeUpTime) {}
}  

$(document).ready(function(){
    
    // $(".result-table").last();        

    // let d = $("tbody").last();

    // for(let k of d) {
    //     console.log(k);
    // }
    // console.log($("tbody").last());
    $("tbody").children(":last").remove();


    $(".cancel-button").click(function(){

        let arr = [];

        $("input[name=select3]").each(function(){

            if($(this).is(":checked")) {
                let curId = $(this).val();                

                console.log("start : " + curId);   

                arr.push("." + curId);             

                $.ajax({
                    url:"search_php7.php",
                    type:"post",
                    data:{id:$(this).val(),userid:$(".id-display2").text()},
                    dataType:"text",
                    success:function() {                        
                        
                    },
                    error:function() {
                        console.log("error");
                    }
                });

                sleep(100);
                console.log("find : " + curId);
            }
        });        

        arr.forEach(element => $(element).remove());
        console.log(arr.length);
        alert("예약이 취소되었습니다.");
    });

});