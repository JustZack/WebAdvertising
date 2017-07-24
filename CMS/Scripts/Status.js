$(document).ready(function(){
    if(window.location.hash){
        $(window.location.hash + " .groupWrapper").css("display", "block");
    }
    $(".groupName").click(function(){
        if($(".groupWrapper", $(this).parent()).css("display") == "none"){
            $(".groupWrapper").each(function(){
                if($(this).css("display") == "block")
                    $(this).css("display", "none");
            });
            $(".groupWrapper", $(this).parent()).css("display", "block");

        } else if($(".groupWrapper", $(this).parent()).css("display") == "block"){
            $(".groupWrapper", $(this).parent()).css("display", "none");                      
        }
    });

    $(".editGroup").click(function(e){
        //Make the name an input field.
        $("form.editGroupName", $(this).parent().parent()).css("display","inline-block");
        $("form.editGroupName input[type='submit']", $(this).parent().parent()).prop("disabled", false);
        $(this).parent().css("display","none");       
        e.stopPropagation();//ensures we dont click through the edit button
    });

    $("input[name='editGroupName']").keyup(function(e){
        var action = "editGroupName.php?old="
         + $(".groupName", $(this).parent().parent()).clone().children().remove().end().text() 
         + "&new=" + $(this).val();
        console.log(action);
        $(this).parent().attr("action", action);
        if(e.keyCode === 27){
            $("input[type='submit']", $(this).parent()).prop("disabled", true);
            $(this).parent().css("display", "none");
            $(".groupName", $(this).parent().parent()).css("display", "block");
        }
    });

    $(".deleteGroup").click(function(e){
        var groupName = $(this).parent().clone().children().remove().end().text();
        if(confirm("Delete " + groupName + "?")){
            window.location.href = "deleteGroup.php?name=" + groupName;
        }
        e.stopPropagation();//Ensures we dont click through the delete button
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
        if(confirm("Delete this content?")){
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
        if(confirm("Are you sure you want to delete the host " + hostName + "?")){
            window.location.href = "deletePlayer?name=" + hostName;
        }
    });

    $("input[name='groupName']").change(function(){
        if($("input[name='groupName']").val().indexOf(" ") > 0) {}
        console.log("Check Validity of group name here");  
    });
});