<?php
    include_once "globals.php";

    $wayfinding = "true";
    if($_POST['useWayfinding'] !== "on"){
        $wayfinding = "false";
    }

    $DataToBeWritten = "\r\n" . $_POST['hostname'] . "," . $wayfinding . "," . $_POST['groups'] . "," . $_POST['wayfindingName'];
    
    echo $DataToBeWritten . " -> " . $Player_Info_Path;
    //Write the data to our player file!
    file_put_contents($Player_Info_Path, $DataToBeWritten,  FILE_APPEND | LOCK_EX);
      //Then take us to the display content page.
     //My thought here is that an error will display if no groups were chosen.
    //When status page is up I will redirect there.
    header("location: status);
?>