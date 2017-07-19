$(document).ready(function(){
    if(window.location.hash){
        $(window.location.hash + " .groupWrapper").css("display", "block");
    }
    $(".groupName").click(function(){
        if($(".groupWrapper", $(this).parent()).css("display") == "none"){
            $(".groupWrapper", $(this).parent()).css("display", "block");

        } else if($(".groupWrapper", $(this).parent()).css("display") == "block"){
            $(".groupWrapper", $(this).parent()).css("display", "none");                      
        }
    });

    $('.DirName').click(function(){
        if($(".files", $(this).parent()).css("display") == "block"){
            $(".files", $(this).parent()).css("display", "none");
        }
        else if($(".files", $(this).parent()).css("display") == "none"){
            $(".files", $(this).parent()).css("display", "block");            
        }
    });

    $('.editHost').click(function(){
        //Transform the host 'card' into a form.
        
    });

    $("input[name='groupName']").change(function(){
        if($("input[name='groupName']").val().indexOf(" ") > 0) {}
        console.log("Check Validity of group name here");  
    });
});