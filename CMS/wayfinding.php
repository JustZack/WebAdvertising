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
                    <img id="LSC_Logo" src="http://lsc.colostate.edu/wp-content/uploads/2016/06/lsc-email-logo.jpg">
                    <div id="HeadingWrapper">
                        <h1>Digital Touch Screen</h1>
                        <h4>INTERACTVIE WAY FINDING MAPS</h4>
                    </div>
                    <div id="EPSRGL_Logos">
                    </div>
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