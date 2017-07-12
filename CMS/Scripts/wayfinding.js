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
            return 'lcd.FirstFloorHallway';
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

    /* Do some intial setting up of certain items on the page. */
    initalSetup();
    $(window).resize(function(){
        resize();
    });
    function resize(){
        $("#myMaps").css("width", $("#MapWrapper img").width());
        var scrollButtonWidth = $("#ScrollBar").width() / $("#RoomButtons").width();
        if(scrollButtonWidth < 20) scrollButtonWidth = 20;
        $("#ScrollButton").css("width", scrollButtonWidth); 
    }

    function initalSetup(){
        /* Inital call to the function to ensure all of the elements are propperly sized */
        resize();
        /* Make our scroll bar a scrollbar */
        $("#ScrollButton").draggable({axis: "x"});
    }
    $("#ScrollButton").click(function(){
        if($("#ScrollButton").position().left + $("#ScrollButton").width() > $("#ScrollBar").width())
        {
            $("#ScrollButton").css("left", $("#ScrollBar").width() - $("#ScrollButton").width());
        }
    });
});