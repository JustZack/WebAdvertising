<html>
    <head>
    <?php include_once "generichead.php" ?>
        <link href="Styles/PlayerRegistration.css" rel="stylesheet">
        <script src="Scripts/PlayerRegistration.js"></script>
    </head>
    <body>
        <div id="Errors">
            
        </div>
        <div id="RegistrationWrapper">
            <?php include_once "globals.php" ?>
            <p>All Registered Host Names:</p>
            <div id="RegisteredHosts">
            <?php
                $PlayersFile = file($Player_Info_Path);
                for($i = 1;$i < count($PlayersFile);$i++){
                    $PlayerInfo = explode(",", $PlayersFile[$i]);
                    printf("<div class='host'>" . $PlayerInfo[0] . "</div>");                
                }
            ?>
            </div>
            <p>All Groups: </p>
            <div id="Groups">
            <?php
                $Groups = array_values(array_filter(glob($Groups_Path . "*"), 'is_dir'));
                for($i = 0;$i < count($Groups);$i++){
                    if(isset($Groups[$i])){
                        $Group = substr($Groups[$i], strrpos($Groups[$i], DIRECTORY_SEPARATOR) + 1);
                        printf("<div>" . $Group . "</div>");
                    }
                }
            ?>
            </div>
            <div class="wayfindingNameWrapper">
                <p>All Wayfinding LCD Names: </p>
                <div style="width: 200px;">
                <?php 
                    $AllLCDs = file("Wayfinding_Files/WayfindingLCDs.txt", FILE_IGNORE_NEW_LINES);
                    for($i = 0;$i < count($AllLCDs);$i++){
                        printf("<div class='WayfindingName'>" . $AllLCDs[$i] . "</div>");
                    }
                ?>
                </div>
            </div>
            <br>
            <form action="registerPlayer.php" method="post">
                <p>Host Name:</p><input type="text" value=<?php echo "\"" . $HostName_SERVER . "\"" ?> name="hostname"><br>
                <p>Groups:</p><input type="text" name="groups"><br>
                <p>Use Wayfinding:</p><input type="checkbox" name="useWayfinding" unchecked><br>
                <div class="wayfindingNameWrapper"><p>Wayfinding Name:</p><input type="text" name="wayfindingName" placeholder="lcd." value="lcd."><br></div>                
                <input type="submit" value="Submit New Host Name">
            </form>
        </div>
    </body>
</html>