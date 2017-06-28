$(document).ready(function()
{
    var Ad_Duration_Seconds; //How long does each ad run?
    var Ad_Count;           //How many ads are there?
    var Ad_Position;        //Which image are we on?   
    
    var Player_Update_Interval_Minutes;  
    
    //Sets up the variables for the enviroment
    function initialStartup(){
        //These should be received via meta-data on the page or from a file
        Player_Update_Interval_Minutes = 15;
        Ad_Duration_Seconds = 15;

        Ad_Count = $('.Ad_Content').length;
        if(Ad_Count > 0){
            Ad_Position = Ad_Count;
            advanceAds(); //Initially start by steping the first ad
        }
         //This interval will advance ads
        //This will be removed, in favor of just waiting with the delay specified in the ads tag
        setInterval(advanceAds, Ad_Duration_Seconds * 100);    
        //This interval will refresh the content 
        setInterval(refreshContent, Player_Update_Interval_Minutes * 60 * 1000);                
    }
    //Advances the ad content
    function advanceAds(){
        //Hide the previous ad.
        $('#Ad_' + Ad_Position).css('display','none');  
        progressAdNumber(); //Progress the ad number
        $('#Ad_' + Ad_Position).css('display','block'); //Display the current ad.
    }
    //Progress the ad number forward to the next valid number
    function progressAdNumber(){
        if(Ad_Position == Ad_Count){
            Ad_Position = 1;}
        else{
            Ad_Position++;}
    }

    //Is called everytime our update interval for the player is up.
    function refreshContent(){
        location.reload();
    }
    initialStartup();
});