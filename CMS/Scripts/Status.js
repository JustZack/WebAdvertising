$(document).ready(function(){
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
});