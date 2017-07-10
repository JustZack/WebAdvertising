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
            width: 3,
            color: 'cyan',
            radius: 8,
            speed: 8
        },
        /* This is where we would return the starting point for this player  */
        /* this value should NEVER change */
        'startpoint': function(){
            return 'lcd.FirstFloorHallWay';
            //return $('#YouAreHere').val();
        },
        /* Set the default map to show */
        /* Once again, one map or multiple? */
        'defaultMap': 'floor1',
    });

    /* Make all buttons on the bottom clickable */
    /* What this really means is make all the buttons wayfinding buttons */
    $('#roomNavigation .room').click(function(){
        $('#myMaps').wayfinding('currentMap',$('.roomNumber',this).val());
    });

    /* Make each button take us somewhere in the map */
    $('#roomNavigation .room').click(function(){
        $('#myMaps').wayfinding('routeTo', $('.roomNumber', this).val());
    });
    /* Does the same thing as the method above */
    $('#Rooms a').click(function(){
        $('#myMaps').wayfinding('routeTo', $(this).val());
    });
});