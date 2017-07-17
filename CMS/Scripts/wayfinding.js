$(document).ready(function(){

    /* This selector / function sets up the parameters for our wayfinding */
    $('#myMaps').wayfinding({
        /* This stores all the paths for the maps i wish to use: */
        /* Do one full map or three seperate maps? */
        'maps': [
            {'path': 'WayFinding_Files/Wayfinding.svg', 'id': 'floor1'},          
        ],
        /* This stores the data for how the path should be styled */
        'path': {
            width: 30,
            color: '#D9782D',
            radius: 30,
            speed: 1
        },
        /* This is where we would return the starting point for this player  */
        /* this value should NEVER change */
        'startpoint': function(){
            var url = document.location.href;
            if(url.indexOf('hostLCDname=') < 0){
                return 'lcd.RamTech'
            } else {
                var LCDName = url.substring(url.indexOf('hostLCDname=') + 12);
                return LCDName;
            }
            //return $('#YouAreHere').val();
        },
        /* Set the default map to show */
        /* Once again, one map or multiple? */
        'defaultMap': 'floor1',
    });

    /* Make each button take us somewhere in the map */
    $('div.roomContainer div.room').click(function(){
        $('#myMaps').wayfinding('routeTo', $('.roomNumber', this).attr('value'));
    });
    /* Does the same thing as the method above */
    $('#Rooms a').click(function(){
        $('#myMaps').wayfinding('routeTo', $(this).val());       
    });

    /* Button for refreshing the screen */
    $("#refresh_screen").click(function(){
        location.reload();
    });
});