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

    $(".editHost").click(function(){
        $hostWrapper = $(this).parent().parent();
        var hostName = $(".hostName", $hostWrapper).text();
        var hostGroups = "";
        $(".hostGroup", $hostWrapper).each(function(){
            hostGroups += $(this).text() + ",";
        });
        var useWayfinding = $(".left", $hostWrapper).text();
        if(useWayfinding == ""){
            useWayfinding = $(".hostWayfinding", $hostWrapper).text();
        }
        var wayfindingName = "";
        var paramString = "hostName=" + hostName + "&hostGroups=" + hostGroups + "&useWayfinding=" + useWayfinding;
        if(useWayfinding == "true"){
            wayfindingName = $(".right", $hostWrapper).text();
            paramString += "&wayfindingName=" + wayfindingName
        }
        //console.log(paramString)
        window.location.href =  "PlayerRegistration?edit=true&" + paramString;
    });

    $("input[name='groupName']").change(function(){
        if($("input[name='groupName']").val().indexOf(" ") > 0) {}
        console.log("Check Validity of group name here");  
    });
});