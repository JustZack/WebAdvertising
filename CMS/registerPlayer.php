<?php
    include_once "globals.php";

    function checkLCDInUse(){
        global $Player_Info_Path;
        //Get all the LCD's
        $LCDFile = file(getcwd() . DIRECTORY_SEPARATOR . "Wayfinding_Files" . DIRECTORY_SEPARATOR . "WayfindingLCDs.csv");
        //Get all the players, so we can determine which LCD's are in use.
        $playersFile = file($Player_Info_Path);
        $playerList = array();
        $playerCount = 0;
        for($i = 1;$i < count($playersFile);$i++){
            $player = explode(",", $playersFile[$i]);
            if(isset($player[4]) && $player[4] !== ""){
                $playerList[$playerCount++] = $player[4];
            }
        }

        for($i = 1;$i < count($LCDFile);$i++){
            $lcd = explode(",", $LCDFile[$i]);
            for($j = 0;$j < count($playerList);$j++){
                if($lcd[0] == trim($playerList[$j])){
                    $lcd[1] = "true\n";
                }
            }
            $LCDFile[$i] = implode(",", $lcd);
        }
        file_put_contents(getcwd() . DIRECTORY_SEPARATOR . "Wayfinding_Files" . DIRECTORY_SEPARATOR . "WayfindingLCDs.csv", $LCDFile);
    }

    $wayfinding = "false";
    if(isset($_POST['useWayfinding'])){
        $wayfinding = "true";
    }
    $wayfindingName = $_POST['wayfindingName'];
    if($wayfindingName == "lcd.") { $wayfindingName = ""; }

    $DataToBeWritten = $_POST['hostname'] . "," . $_POST['nickname'] . "," . $wayfinding . "," . $_POST['groups'] . "," . $wayfindingName;
    printf($DataToBeWritten . " -> " . $Player_Info_Path);    

    /* Check if we are editing (deleting) a host */
    if(isset($_GET['deleteHost'])){
        /* If so replace the line in the file which contains the old host with the new one */
        $playerFile = file($Player_Info_Path, FILE_IGNORE_NEW_LINES);
        for($i = 1;$i < count($playerFile);$i++){
            $line = explode(",", $playerFile[$i]);
            if($line[0] == $_GET['deleteHost']){
                $playerFile[$i] = $DataToBeWritten;             
                break;
            }
        }
        file_put_contents($Player_Info_Path, $PlayersInformationHeader);
        for($i = 1;$i < count($playerFile);$i++){
            file_put_contents($Player_Info_Path, "\r\n" . $playerFile[$i],  FILE_APPEND | LOCK_EX);
        }
    } else {
        //Write the data to our player file!
        file_put_contents($Player_Info_Path, "\r\n" . $DataToBeWritten,  FILE_APPEND | LOCK_EX);
    }
    //Check to see which LCD's are in use by players 
    checkLCDInUse();
      //Then take us to the display content page.
     //My thought here is that an error will display if no groups were chosen.
    //When status page is up I will redirect there.
    header("location: status");
?>