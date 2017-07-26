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

    /* Handles the interface for the file tree *//*
    $(".Dir").first().children().find(".Dir").each(function(){
        $(this).css("display", "none");
    });
    $('.DirName').click(function(){
        //The directory we clicked
        $parent = $(this).parent();
        //If clicked dir's contents are being shown, then hide them
        if($("> .Dir", $parent).children().css("display") == "block"){
            $("> .Dir", $parent).children().css("display", "none");//Hide all child dirs
            $(".files", $parent).css("display", "none");//Hide all child files 
        } 
        //If clicked dirs contents are not being shown, then show them
        else if($(".Dir", $parent).children().css("display") == "none"){
            $(".Dir", $parent).children().css("display", "block");//Show this dir's content
            if($($parent).children().find("> .files").length > 0){
                $($parent).children().find("> .files").css("display", "block");
            }
        }
    });*/

    $(".deleteAd").click(function(){
        if(confirm("Delete this ad?")){
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
        var nickName = $(".nickName", $hostWrapper).text();
        var wayfindingName = "";
        var paramString = "hostName=" + hostName + "&nickName=" + nickName + "&hostGroups=" + hostGroups + "&useWayfinding=" + useWayfinding;
        if(useWayfinding == "true"){
            wayfindingName = $(".right", $hostWrapper).text();
            paramString += "&wayfindingName=" + wayfindingName
        }
        window.location.href =  "PlayerRegistration?edit=true&" + paramString;
    });

    $('.deleteHost').click(function(){
        $hostWrapper = $(this).parent().parent();        
        var hostName = $(".hostName", $hostWrapper).text();
        if(confirm("Delete the host " + hostName + "?")){
            window.location.href = "deletePlayer?name=" + hostName;
        }
    });

    $('.deleteContent').click(function(){
        $parent = $(this).parent();
        var fileName = $('.file_path', $parent).text();
        if(confirm("Delete this content?")){
            window.location.href = "deleteContent.php?name=" + fileName;
        }
    });
    
    $("input[name='groupName']").change(function(){
        if($("input[name='groupName']").val().indexOf(" ") > 0) {}
        console.log("Check Validity of group name here");  
    });
});