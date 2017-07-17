$(document).ready(function()
{
    var Ad_Count;           //How many ads are there?
    var Ad_Position;        //Which image are we on?   
    
    var Player_Update_Interval_Minutes;  
    
    //Sets up the variables for the enviroment
    function initialStartup(){
        //These should be received via meta-data on the page or from a file
        Player_Update_Interval_Minutes = 15;

        Ad_Count = $('.Ad_Content').length;
        if(Ad_Count > 0){
            Ad_Position = Ad_Count;
            advanceAds();
        } 
        //This interval will refresh the content 
        setInterval(refreshContent, Player_Update_Interval_Minutes * 60 * 1000);                
    }
    //Advances the ad content
    function advanceAds(){
        //Hide the previous ad. 
        $('#Ad_' + Ad_Position).css('display','none'); 
        progressAdNumber(); //Progress the ad number             
        $('#Ad_' + Ad_Position).css('display','block'); //Display the current ad.
        setTimeout(advanceAds, $('#Ad_' + Ad_Position).data('duration') * 1000);
    }
    //Progress the ad number forward to the next valid number
    function progressAdNumber(){
        iframeReset(); 
        if(Ad_Position == Ad_Count){
            Ad_Position = 1;}
        else{
            Ad_Position++;}
        iframeAdvancement();
    }

    //Is called everytime our update interval for the player is up.
    function refreshContent(){
        location.reload();
    }

    //Ensures all iframe content has stopped playing
    function iframeReset(){
        if($('#Ad_' + Ad_Position).is("iframe") == true)
        {
            //Youtube: Stop playing of video
            if($('#Ad_' + Ad_Position).attr('src').indexOf('youtube') >= 0)
            {
                var src = $('#Ad_' + Ad_Position).attr('src');
                if(src.indexOf('?') >= 0)
                {
                    var firstQMark = src.indexOf('?');
                    var newSrc = src.substring(0, firstQMark);
                    $('#Ad_' + Ad_Position).attr('src', newSrc);
                }
            }
        }
    }
    //Ensures all iframe content has started playing
    function iframeAdvancement(){
        if($('#Ad_' + Ad_Position).is("iframe") == true)
        {
            //Youtube: Start playback of video
            if($('#Ad_' + Ad_Position).attr('src').indexOf('youtube') >= 0)
            {
                var toAdd = "";
                var src = $('#Ad_' + Ad_Position).attr('src');          
                if(src.indexOf("?") >= 0){
                    toAdd += "&autoplay=1";
                } else {
                    toAdd += "?autoplay=1";
                }
                $('#Ad_' + Ad_Position).attr('src', src + toAdd);
            }
        }
    }

    initialStartup();


    /* Redirects to the wayfinding screen on tap. */
    $(document).click(function(){
        var url = location.href;
        var params = url.substring(url.indexOf("?"));
        window.location.href = "wayfinding" + params;
    });
});