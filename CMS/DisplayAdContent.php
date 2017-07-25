<html>  
    <head>
        <?php include_once "generichead.php" ?>
        <script src="Scripts/Display_Ads.js"      rel="javascript"></script>
        <link   href="Styles/Digital_Signage.css" rel="stylesheet">
    </head>
    <body>
        <div id="Uninteractable_Wrapper">
            <div id="Uninteractable_cover"></div>
<?php   include_once "LoadContent.php" ?>
            <!-- Display some extra information here -->
            <div id="SideBar">
                <!-- Show the weather -->
                <div id="Weather">
                <?php
                    ini_set("allow_url_fopen", 1);
                    $json = file_get_contents("https://api.apixu.com/v1/current.json?key=de89ed0d36ca4255b6224022172706&q=80523");
                    $jsonDECODED = json_decode($json, true);
                    $temp = $jsonDECODED['current']['temp_f'];
                    $weatherIcon = $jsonDECODED['current']['condition']['icon'];
                    printf("\t\t\t<center><img src='" . $weatherIcon . "' alt='Weather Icon'>");
                    printf("\t\t\t<h1>" . $temp . " &deg;F</h1></center>");                    
                ?>
                </div>
                <!-- Show the time -->
                <div id="clock">
                    
                </div>
                <!-- Tappable div for switching to wayfinding -->                
            </div>
        </div>
    </body>
</html>