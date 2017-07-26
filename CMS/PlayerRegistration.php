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
                    printf("<div class='host'>" . $PlayerInfo[0] . " (" . $PlayerInfo[1] . ")</div>");                
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
                <div style="width: 350px;">
                <?php 
                    $AllLCDs = file("Wayfinding_Files/WayfindingLCDs.csv", FILE_IGNORE_NEW_LINES);
                    for($i = 1;$i < count($AllLCDs);$i++){
                        $lcd = explode(",", $AllLCDs[$i]);
                        $inUse;
                        if($lcd[1] == "true"){ $inUse = " (In Use)"; } else { $inUse = ""; }
                        printf("<div class='WayfindingName' data-inUse=" . $lcd[1] . ">" . $lcd[0] . $inUse . "</div>");
                    }
                ?>
                </div>
            </div>
            <br>
            <?php
                $registrationParams = "";
                $hostName = "";
                $nickName = "";
                $hostGroups = "";
                $useWayfinding = "";
                $wayfindingName = "lcd.";
                $buttonMessage = "Submit New Player";

                if(isset($_GET['edit']))
                {
                    echo "<div id='meta' style='display: none;' data-edit='true'></div>";
                    $hostName = $_GET['hostName'];
                    $nickName = $_GET['nickName'];
                    $registrationParams = "?deleteHost=" . $hostName;
                    $buttonMessage = "Submit Edits To " . $nickName;
                    $hostGroups =  trim(preg_replace("/,/", " ", $_GET['hostGroups']));
                    $useWayfinding = $_GET['useWayfinding'];
                    if($useWayfinding == "true"){
                        $useWayfinding = "checked";
                    } else {
                        $useWayfinding = "unchecked";
                    }
                    if(isset($_GET['wayfindingName'])) {
                        $wayfindingName = $_GET['wayfindingName'];
                    }

                } else {
                    $hostName = $HostName_SERVER;
                }

                
            ?>
            <form action= <?php echo "registerPlayer.php" . $registrationParams ?> method="post">
                <p>Host Name (IP address) :</p><input type="text" value= <?php echo "\"" . $hostName . "\"" ?> name="hostname" required><br>
                <p>Nick Name:</p><input type="text" value= <?php echo "\"" . $nickName . "\"" ?> name="nickname" required><br>                
                <p>Groups:</p><input type="text"  value= <?php echo "\"" . $hostGroups . "\"" ?> name="groups" pattern="[A-Za-z]*{*}"><br>
                <p>Use Wayfinding:</p><input type="checkbox" name="useWayfinding" <?php echo $useWayfinding ?>><br>
                <div class="wayfindingNameWrapper"><p>Wayfinding Name:</p><input type="text" value= <?php echo "\"" . $wayfindingName . "\"" ?> name="wayfindingName" placeholder="lcd." value="lcd." pattern="lcd\.[A-Za-z]+"><br></div>                
                <input type="submit" value=<?php echo "\"" . $buttonMessage . "\"" ?>>
            </form>
        </div>
    </body>
</html>