<html>  
    <head>
        <?php include_once "generichead.php" ?>
        <script src="Scripts/Display_Ads.js"      rel="javascript"></script>
        <link   href="Styles/Digital_Signage.css" rel="stylesheet">
    </head>
    <body>
        <div id="Uninteractable_Wrapper">
            <div id="Uninteractable_cover"></div>
<?php   include_once "images.php" ?>
        </div>
    <!-- 
        Consider adding the wayfinding here 
        Just hide the div until the screen is tapped / clicked, 
        then hide the image display div. 

        Good reason to use seperate file is for mobile wayfinding.
    -->
    </body>
</html>