<html>
    <head>
        <?php include_once "generichead.php" ?>
        <script src="Scripts/jquery.wayfinding.js" rel="javascript"></script>
        <link href="Styles/Wayfinding.css"       rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    </head>
    <body>
        <div id="wayfinding_container">
            <div id="top">
                <div id="maps">
                    <div class="svg_map" id="level_1" style="display: none;"></div>
                    <div class="svg_map" id="level_2" style="display: none;"></div>
                    <div class="svg_map" id="level_3" style="display: none;"></div>
                </div>
                <div id="legendWrapper">
                    <center><img id="LSC_Logo" src="Logos/LSC_Logo.png"></center>
                    <div id="HeadingWrapper">
                        <h1>Digital Touch Screen</h1>
                        <h4>INTERACTVIE WAY FINDING MAPS</h4>
                    </div>
                    <center>
                        <div id="EPSRGL_Logos">
                            <img src="Logos/Eat.png" alt="eat">
                            <img src="Logos/Play.png" alt="play">
                            <img src="Logos/Shop.png" alt="shop">
                            <img src="Logos/Relax.png" alt="relax">
                            <img src="Logos/Gather.png" alt="gather">
                            <img src="Logos/Learn.png" alt="learn">
                        </div>
                    </center>
                    <div id="legend">
                        <div>
                            <img src=""><p>RESTROOM</p>
                        </div>
                        <div>
                            <img src=""><p>ALL GENDER/FAMILY RESTROOM</p>
                        </div>
                        <div>
                            <img src=""><p>SHOWERS</p>
                        </div>
                        <div>
                            <img src=""><p>LACTATION ROOM</p>
                        </div>
                        <div>
                            <img src=""><p>AED LOCATION</p>
                        </div>
                        <div>
                            <img src=""><p>ELEVATOR</p>
                        </div>
                        <div>
                            <img src=""><p>WATER STATION</p>
                        </div>
                        <div>
                            <img src=""><p>COMPUTER STATION</p>
                        </div>
                        <div>
                            <img src=""><p>PRINTER STATION</p>
                        </div>
                        <div>
                            <img src=""><p>MICROWAVES</p>
                        </div>
                        <div>
                            <img src=""><p>PHONE CHARGING</p>
                        </div>
                    </div>
                </div>  
            </div>
            <div id="bottom">
                <div id="roomSelection">
                    <div id="roomNavigation"></div>
                    <?php  
                        /*
                            This is where we would output the name and room number
                            of each room in a .csv file.
                            Format:
                                Name, Number, Filter
                                    Name: The name of the room
                                    Number: The rooms number
                                    Filter: Which of the six filters this room fits into.

                        */
                        $AllRooms = file("Wayfinding_Files" . DIRECTORY_SEPARATOR . "master-wayfinding-data.csv", FILE_IGNORE_NEW_LINES);                                                    
                        for($i = 1;$i < count($AllRooms);$i++){
                            $RoomInfo = explode(",", $AllRooms[$i]);
                            if($i % 3 == 1)
                                printf("<div class='roomColumn'>");                                
                            printf("<div class='roomContainer' data-filter='" . $RoomInfo[1] . "'>");
                            if(strlen($RoomInfo[0]) > 30)
                                $RoomInfo[0] = trim(substr($RoomInfo[0], 0, 30)) . "...";
                            printf("<div class='room'>");
                            printf("<div class='roomName'>" . $RoomInfo[0] . "</div>");
                            printf("<div class='roomNumber'>" . $RoomInfo[2] . "</div>");  
                            printf("</div>");                                                                                                              
                            printf("</div>");                            
                            if($i % 3 == 0)
                                printf("</div>");                            
                        }                     
                    ?>
                </div>
                <div id="filters">
                    <div class="lower_controls" id="eat_selection">Eat</div>
                    <div class="lower_controls" id="play_selection">Play</div>
                    <div class="lower_controls" id="shop_selection">Shop</div>
                    <div class="lower_controls" id="gather_selection">Gather</div>
                    <div class="lower_controls" id="restroom_selection">Restrooms</div>
                    <div class="lower_controls" id="learn_selection">Learn</div>  
                </div>
            </div>
        </div>
    </body>
</html> 