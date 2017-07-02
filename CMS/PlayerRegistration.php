<html>
    <head>
    <?php include_once "generichead.php" ?>
        <link href="Styles/HostNameRegistration.css" rel="stylesheet">
        <script src="Scripts/HostNameValidate.js"></script>
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
                $Groups = array_filter(glob($Groups_Path . "*"), 'is_dir');
                for($i = 0;$i < count($Groups);$i++){
                    $Group = substr($Groups[$i], strrpos($Groups[$i], "\\") + 1);
                    printf("<div>" . $Group . "</div>");
                }
            ?>
            </div>
            <br>
            <form action="registerPlayer.php" method="post">
                <p>Host Name:</p><input type="text" value=<?php echo "\"" . $HostName_SERVER . "\"" ?> name="hostname"><br>
                <p>Groups:</p><input type="text" name="groups"><br>
                <p>Use Wayfinding:</p><input type="checkbox" name="useWayfinding" checked><br>
                <input type="submit" value="Submit New Host Name">
            </form>
        </div>
    </body>
</html>