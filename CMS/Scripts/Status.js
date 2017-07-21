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

    /* TODO: Another time, this is takeing too much time */
    $(".editGroup").click(function(e){
        //Make the name an input field.
        $("form.editGroupName", $(this).parent().parent()).css("display","inline-block");
        $(this).parent().css("display","none");       
        e.stopPropagation();
        editGroupNameChange();
    });

    function editGroupNameChange(){
        var action = "editGroupName.php?old=" + $(".groupName", $(this).parent().parent()).clone().children().remove().end().text() + "&new=" + $(this).val();
        console.log(action);
        $(this).parent().attr("action", action);
    }
    $("input[name='editGroupName']").change(function(){
        editGroupNameChange();
    });

    $('.DirName').click(function(){
        if($(".files", $(this).parent()).css("display") == "block"){
            $(".files", $(this).parent()).css("display", "none");
        }
        else if($(".files", $(this).parent()).css("display") == "none"){
            $(".files", $(this).parent()).css("display", "block");            
        }
    });

    $(".removeContent").click(function(){
        if(confirm("Are you sure you want to delete this content?")){
            window.location.href = $(this).parent().data('link');
        }
    });

    $('.editHost').click(function(){
        //Transform the host 'card' into a form.
        //Maybe???
        
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

    $('.deleteHost').click(function(){
        $hostWrapper = $(this).parent().parent();        
        var hostName = $(".hostName", $hostWrapper).text();
        if(confirm("Are you sure you want to delete " + hostName + "?")){
            window.location.href = "deletePlayer?name=" + hostName;
        }
    });


    $("input[name='groupName']").change(function(){
        if($("input[name='groupName']").val().indexOf(" ") > 0) {}
        console.log("Check Validity of group name here");  
    });
});