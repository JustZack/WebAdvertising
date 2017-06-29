<html>
    <head>
        <?php include_once "generichead.php" ?>
        <link href="Styles/Wayfinding.css" rel="stylesheet">
    </head>
    <body>
        <div id="wayfinding_container">
            <div id="left">
                <div id="maps">
                    <div class="svg_map" id="level_1" style="display: none;"></div>
                    <div class="svg_map" id="level_2" style="display: none;"></div>
                    <div class="svg_map" id="level_3" style="display: none;"></div>
                </div>
                <div id="controls">
                    <div class="lower_controls" id="eat_selection"></div>
                    <div class="lower_controls" id="play_selection"></div>
                    <div class="lower_controls" id="shop_selection"></div>
                    <div class="lower_controls" id="relax_selection"></div>
                    <div class="lower_controls" id="gather_selection"></div>
                    <div class="lower_controls" id="learn_selection"></div>   
                </div>
            </div>
            <div id="right">
                <div class="right_controls button" id="eat_button"></div>
                <div class="right_controls button" id="play_button"></div>
                <div class="right_controls button" id="shop_button"></div>
                <div class="right_controls button" id="relax_button"></div>
                <div class="right_controls button" id="gather_button"></div>
                <div class="right_controls button" id="learn_button"></div>   
            </div>
        </div>
    </body>
</html> 