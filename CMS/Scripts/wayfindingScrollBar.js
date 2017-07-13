$(document).ready(function(){
    function setupRoomButtonsConstrainer(){
        $("#RoomButtonsContstrainer").css("position", "absolute");                
        $("#RoomButtonsContstrainer").css("top", $("#RoomButtons").position().top);                                //You may notice the * 1's here. It seems to fix the padding-left number  
        $("#RoomButtonsContstrainer").css("left", -$("#RoomButtons").width() + $("#ScrollBar").width() - ($(".roomContainer").css("padding-left").replace(/[^\d.]/g, '') * 1)); 
        $("#RoomButtonsContstrainer").css("width", (($("#RoomButtons").width() * 2) - ($("#ScrollBar").width())) + ($(".roomContainer").css("padding-left").replace(/[^\d.]/g, '') * 1));
        $("#RoomButtonsContstrainer").css("height", $("#RoomButtons").height());  
    }
    /* Do some intial setting up of certain items on the page. */
    function initalSetup(){
        /* Inital call to the function to ensure all of the elements are propperly sized */
        resize();
        setupRoomButtonsConstrainer();
        /* Make our scroll bar draggable */
        $("#ScrollButton").draggable({axis: "x", containment: "#ScrollBar", scroll: false, drag: setScrollLocation});
        /* Make the rooms div draggable */
        $("#RoomButtons").draggable({axis: "x", containment: "#RoomButtonsContstrainer", scroll: false, drag: setScrollButtonLocation});
    }
    initalSetup();
    /* Event handler for when the window is resized */
    $(window).resize(function(){
        resize();
    });
    /* Ensures the scroll button is not pushed of the screen */
    function confineScrollButton(){
        if($("#ScrollButton").position().left + $("#ScrollButton").width() > $("#ScrollBar").width()){
            $("#ScrollButton").css("left", $("#ScrollBar").width() - $("#ScrollButton").width());
        } else if ($("#ScrollButton").position().left < 0) {
            $("#ScrollButton").css("left","0px");
        }
    }
    /* Set the width of the scroll button, based on how wide the scroll area is */
    function setScrollButtonWidth(){
        var scrollButtonWidth = $("#ScrollBar").width() / $("#RoomButtons").width();
        if(scrollButtonWidth < 20) scrollButtonWidth = 60;
        $("#ScrollButton").css("width", scrollButtonWidth);
    }
    /* Function called everytime the window is resized, and once when the window is loaded */
    function resize(){
        $("#myMaps").css("width", $("#MapWrapper img").width());
        setScrollButtonWidth();
        confineScrollButton();
        setupRoomButtonsConstrainer();
    }

    /* Set the location of the room button area so it scrolls to the correct location */
    function setScrollLocation(){
        /* This line ensures the room scrolling area is not offset by any amount for any reason. */
        $("#RoomButtons").css("left", 0);
        $("#RoomButtons").css("margin-left", 0);
        
        var scrollPercentage = $("#ScrollButton").position().left / ($("#ScrollBar").width() - $("#ScrollButton").width());
        $("#RoomButtons").css("margin-left", -(scrollPercentage * ($("#RoomButtons").width() - ($("#ScrollBar").width() - $(".roomContainer").css("padding-left").replace(/[^\d.]/g, '')))));
    }
     /* This function works the opposite way of the above function */
    /* It gets the position of the rooms container and sets the position of the scroll bar accordingly*/
    function setScrollButtonLocation(){
        /* Ensures we always start from square one when setting the scroll bars position     */
        $("#ScrollButton").css("left", 0);        
        $("#ScrollButton").css("margin-left", 0);        
        
        var scrollButtonPosition = ($("#ScrollBar").width() - $("#ScrollButton").width()) * Math.abs($("#RoomButtons").position().left / ($("#RoomButtons").width() - $("#ScrollBar").width()));
        console.log(scrollButtonPosition + " | " + Math.abs($("#RoomButtons").position().left / ($("#RoomButtons").width() - $("#ScrollBar").width())));
        $("#ScrollButton").css("left", scrollButtonPosition);
    }
    /* For changing the scroll amount when clicking on the scroll bar */
    $("#ScrollBar").click(function(e){
        $("#ScrollButton").css("left", e.pageX);
        confineScrollButton();
        setScrollLocation();
    });

    /* JS for ensuring the color of the scroll button is correct when hovered AND clicked */
    $("#ScrollButton").hover(
        function(){ //Mouse in
            $(this).css("background-color", "#333333");
        },
        function(){ //Mouse out
            $(this).css("background-color", "#666666");
        });
    $("#ScrollButton").mousedown(function(){
        $(this).css("background-color", "#666666");
    });
    $("#ScrollButton").mouseup(function(){
        $(this).css("background-color", "#333333");
    });
});