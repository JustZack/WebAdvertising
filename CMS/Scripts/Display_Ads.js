$(document).ready(function()
{
    var Ad_Count;            //How many ads are there?
    var Ad_Position;        //Which image are we on?   
    var Total_Elapsed_Time = 0;//How long have we been doing this?
    var fadeTime = 1000;

    var Player_Update_Interval_Minutes;  //How often should the player update?
    var Player_Update_Timeout;         //Stores the interval for when the player plans to reset.

    var Specific_Id;

    //bool to detemine if the current iframe has loaded
    var iframeLoaded = false;    
    var Timeout;
    
    //Sets up the variables for the enviroment
    function initialStartup(){
        //These should be received via meta-data on the page or from a file
        Player_Update_Interval_Minutes = 15;

        Ad_Count = $('.Ad_Content').length;
        if(Ad_Count > 0){
            Ad_Position = Ad_Count;
        } 
        
        $(".Ad_Content").each(function(){
            if($(this).attr("data-specific-time")){
                //Do stuff here
                var CurrentTime = new Date();
                var SpecificTime = new Date(CurrentTime.toDateString() + " " + $(this).data("specific-time") + ":00");
                var diff = SpecificTime - CurrentTime;
                Specific_Id = $(this).attr("id");
                setTimeout(playSpecificAd, diff);
                console.log(diff);
            }
        });
        //Start the loop for displaying ads
        advanceAds();
        //This interval will refresh the content 
        Player_Update_Timeout = setTimeout(refreshContent, Player_Update_Interval_Minutes * 60 * 1000);                
    }

    /* Work in progress */
    function playSpecificAd(){
        //Ensure any playing content is paused
        iframeReset();
        //Hide the current Ad
        $("#Ad_" + Ad_Position).css("display", "none");    
        //Show the ad which we want to play
        $("#" + Specific_Id).css("display", "block");
        //Play the ad (if it is an iframe)
        playSpecificIframe();
        //Calculate what the new timeout for the player should be.
        var playerUpdateTimeoutDiff = ((Player_Update_Interval_Minutes * 60 * 1000) - Total_Elapsed_Time) +  $("#" + Specific_Id).data('duration');
        clearTimeout(Player_Update_Timeout);
        clearTimeout(Timeout);
        Timeout = setTimeout(stopSpecificAd, $("#" + Specific_Id).data('duration'));
        Player_Update_Timeout = setTimeout(refreshContent, playerUpdateTimeoutDiff);

    }

    //Advances the ad content
    function advanceAds(){
        //Hide the previous ad. 
        $('#Ad_' + Ad_Position).fadeTo(fadeTime, 0); 
        progressAdNumber(); //Progress the ad number           
        $('#Ad_' + Ad_Position).fadeTo(fadeTime, 1);  //Display the current ad.
        Total_Elapsed_Time += $('#Ad_' + Ad_Position).data('duration') * 1000;
        Timeout = setTimeout(advanceAds, $('#Ad_' + Ad_Position).data('duration') * 1000);
        
    }

    //Progress the ad number forward to the next valid number
    function progressAdNumber(){
        iframeReset(); 
        videoReset();

        if(Ad_Position == Ad_Count){ Ad_Position = 1; }
        else{ Ad_Position++; }

        //Skip any ad which is set to play at a specific time. (for now)
        if($('#Ad_' + Ad_Position).attr("data-specific-time")){ progressAdNumber(); }

        videoAdvancement();
        iframeAdvancement();
        //Does the NEXT ad have a load time associated with it? 
        if($("#Ad_" + (Ad_Position + 1)).attr("data-load-time")){
            //If so, then we need to set a time out for the ad to load 3 seconds prior to it being shown.
            var duration = $("#Ad_" + Ad_Position).data("duration");
            var loadTimeOutTime = duration - ($("#Ad_" + (Ad_Position + 1)).data("load-time"));
            loadTimeOutTime *= 1000;
            //Set a timeout for the ad to be loaded
            if($("#Ad_" + (Ad_Position + 1)).is("iframe")){
                console.log("Setting NEXT ad to load in " + loadTimeOutTime + "ms");
                setTimeout(iframeAdvancement, loadTimeOutTime);
            } else if($("#Ad_" + (Ad_Position + 1)).is("video")) {
                setTimeout(videoAdvancement, loadTimeOutTime);                
            }
        }
    }

    //This Is called everytime our update interval for the player is up.
    function refreshContent(){
        location.reload();
    }

    //Ensures all iframe content has stopped playing
    function iframeReset(){
        if($('#Ad_' + Ad_Position).is("iframe") == true)
        {
            $('#Ad_' + Ad_Position).css("display", "none!important");            
            iframeLoaded = false;            
            var src;
            //Youtube: Stop playing of video
            if($('#Ad_' + Ad_Position).attr('src').indexOf('youtube') >= 0)
            {
                src = $('#Ad_' + Ad_Position).attr('src');
                if(src.indexOf('?') >= 0)
                {
                    var firstQMark = src.indexOf('?');
                    var newSrc = src.substring(0, firstQMark);
                    src = newSrc;
                }
            }
            else if($("#Ad_" + Ad_Position).attr('src').indexOf('.php') >= 0){
                src = $('#Ad_' + Ad_Position).attr('src');
                if(src.indexOf('?') >= 0)
                {
                    var firstQMark = src.indexOf('?');
                    var newSrc = src.substring(0, firstQMark);
                    src = newSrc;
                }
            } else {
                src = $('#Ad_' + Ad_Position).attr('src');
            }
            $('#Ad_' + Ad_Position).attr('src', src);  
            $('#Ad_' + Ad_Position).css("display", "");            
                      
        } 
        else {
            iframeLoaded = true; 
        }
    }
    //Ensures all iframe content has started playing
    function iframeAdvancement(){
        var ad_pos;
       if($("#Ad_" + (Ad_Position + 1)).attr("data-load-time")){
            if(Ad_Position == Ad_Count){ ad_pos = 1; }
            else{ ad_pos = Ad_Position + 1; }
            console.log("NEXT ad is loading!");
        } else {
            ad_pos = Ad_Position;            
        }
        if($('#Ad_' + ad_pos).is("iframe"))
        {
            $('#Ad_' + ad_pos).css("display", "none!important");
            iframeLoaded = false;
            var src;
            //Youtube: Start playback of video
            if($('#Ad_' + ad_pos).attr('src').indexOf('youtube') >= 0)
            {
                var toAdd = "";
                src = $('#Ad_' + ad_pos).attr('src');          
                if(src.indexOf("?") >= 0){
                    toAdd += "&autoplay=1";
                } else {
                    toAdd += "?autoplay=1";
                }
                src += toAdd;
            }
            //PHP script, start the script over
            //Note, this is setup for custom scripts which take a play parameter
            //The play parameter allows me to ensure a scripts contents are not loaded unless they need to be.
            if($("#Ad_" + ad_pos).attr('src').indexOf('.php') >= 0){
                var toAdd = "";
                src = $('#Ad_' + ad_pos).attr('src');          
                if(src.indexOf("?") >= 0){
                    toAdd += "&play=1";
                } else {
                    toAdd += "?play=1";
                }
                src += toAdd;
            } else { //Otherwise, just grab the src
                src = $('#Ad_' + ad_pos).attr('src');                                  
            }
            $iframe = $('#Ad_' + ad_pos);  

            /* Hide the iframe until it is loaded */
            $iframe.css("width", $(window).width());
            $iframe.css("height", $(window).height());
            
            /* Reload the iframe in a cross browser way */
            $iframe.attr('src', '');
            $iframe.attr('src', src);
        }
        else {
            iframeLoaded = true;            
        }
    }
    //Ensures the current video stops
    function videoReset(){
        if($("#Ad_" + Ad_Position).is("video")){
            $("#Ad_" + Ad_Position).get(0).pause();
            $("#Ad_" + Ad_Position).removeAttr("autoplay");
        }
    }
    function videoAdvancement(){

        if($("#Ad_" + Ad_Position).is("video") && $("#Ad_" + Ad_Position).attr("data-load-time") == undefined){
            $("#Ad_" + Ad_Position).get(0).load();            
            $("#Ad_" + Ad_Position).attr("autoplay", "");
        }
    }
    //Plays a specific iframe ad
    function playSpecificIframe(){
        if($('#' + Specific_Id).is("iframe") == true)
        {
            //Youtube: Start playback of video
            if($('#' + Specific_Id).attr('src').indexOf('youtube') >= 0)
            {
                var toAdd = "";
                var src = $('#' + Specific_Id).attr('src');          
                if(src.indexOf("?") >= 0){
                    toAdd += "&autoplay=1";
                } else {
                    toAdd += "?autoplay=1";
                }
                $('#' + Specific_Id).attr('src', src + toAdd);
            }
        }
    }
    //Stops a specific iframe ad
    function stopSpecificAd(){
        if($('#' + Specific_Id).is("iframe") == true)
        {
            //Youtube: Stop playing of video
            if($('#' + Specific_Id).attr('src').indexOf('youtube') >= 0)
            {
                var src = $('#' + Specific_Id).attr('src');
                if(src.indexOf('?') >= 0)
                {
                    var firstQMark = src.indexOf('?');
                    var newSrc = src.substring(0, firstQMark);
                    $('#' + Specific_Id).attr('src', newSrc);
                }
            }
        }
        advanceAds();
    }
    initialStartup();


    /* Redirects to the wayfinding screen on tap. */
    $(document).click(function(){
        /*  Checks if this screen does wayfinding. 
            Almost not needed as all touchscreens do wayfinding anyways
        */
        if($("#HostData").data("usewayfinding")){
            var url = location.href;
            var params = url.substring(url.indexOf("?"));
            window.location.href = "wayfinding" + params;
        }
    });
});