$(document).ready(function(){
    $(".groupData").click(function(){
        if($(".groupWrapper", this).css("display") == "none"){
            $(".groupWrapper", this).css("display", "block");
        } else if($(".groupWrapper", this).css("display") == "block"){
            $(".groupWrapper", this).css("display", "none");            
        }
    });
});