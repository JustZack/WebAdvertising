$(document).ready(function(){
    if(window.location.hash){
        $(window.location.hash + " .groupWrapper").css("display", "block");
    }
    $(".groupWrapper").sortable({
        cancel: ".AddContent"
    });
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

    $(".saveOrder").click(function(e){
        var groupName = $(this).parent().clone().children().remove().end().text();
        
        //Selector for this groups Un ordered list, which has all the list items.
        $groupUL = $(this).parent().parent().find(".groupWrapper");

        //The URL we will make a GET request with!
        var URL = "http://" + location.hostname + "/WebAdvertising/CMS/reorderGroup.php?group=" + groupName + "&newOrder=";
        //The order of ads in this group
        var order = [];

        //Get the Id of the first ad in this group
        var lowest = Number.MAX_VALUE;
        $("li", $groupUL).find(".Ad_Content").each(function(){
            var number_ID = $(this).attr("id");
            var number = parseInt(number_ID.substring(number_ID.indexOf("_") + 1));
            if(number < lowest){
                lowest = number;
            }
        });
        //Get the number of the ID we just found (#Ad_<number>).
        
        var offset = lowest - 1;

        $groupUL.find(".Ad_Content").each(function(){
            var ID = $(this).attr("id");
            var number = parseInt(ID.substring(ID.indexOf("_") + 1));
            order.push(number - offset);
        });

        URL += order.join();

        var xmlHTTP = new XMLHttpRequest();
        xmlHTTP.open("GET", URL, true);
        xmlHTTP.send(null);

        console.log(URL);

        $this = $(this);
        $(this).fadeOut(250, function(){
            $(this).text("Saved!");
            $(this).fadeIn(250);
        });
        setTimeout(function() {
            $this.fadeOut(250, function(){
                $this.text("Save Order");
                $this.fadeIn(250);
            });
        }, 1500);

        e.stopPropagation();//Ensures we dont click through the delete button
        
    });

    $(".deleteGroup").click(function(e){
        var groupName = $(this).parent().clone().children().remove().end().text();
        if(confirm("Delete " + groupName + "?")){
            window.location.href = "deleteGroup.php?name=" + groupName;
        }
        e.stopPropagation();//Ensures we dont click through the delete button
    });

    $(".Dir").css("display", "none");
    $(".files").css("display", "none");    
    $(".Dir").first().css('display','block');
    $(".Dir").first().css('display','block');
    $(".Dir").first().find("> .Dir").each(function(){
        $(this).css('display','block');
    }); 
    $('.DirName').click(function(){
        //The directory we clicked
        $parent = $(this).parent();

        /* Show only immediate sub directories */
        $parent.find("> .Dir").each(function(){
            console.log(this);            
            if($(this).css("display") == "none"){
                $(this).css("display", "block");
            } else {
                $(this).css("display", "none"); 
                $(this).find(".Dir").each(function(){
                    $(this).css("display", "none");                    
                }); 
                $(this).find(".files").each(function(){
                    $(this).css("display", "none");
                });              
            }
        });

        $parent.find("> .files").each(function(){
            if($(this).css("display") == "none"){
                $(this).css("display", "block");
            } else {
                $(this).css("display", "none");                
            }
        });

        $("html, body").animate({
            scrollTop: $(document).height()
        }, 'slow');
    });

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