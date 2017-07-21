<?php 
    include_once "globals.php";

    $playerFile = file($Player_Info_Path, FILE_IGNORE_NEW_LINES);
    $lineToSkip;
    for($i = 1;$i < count($playerFile);$i++){
        $line = explode(",", $playerFile[$i]);
        if($line[0] == $_GET['name']){
            $lineToSkip = $i;
            break;
        }
    }
    file_put_contents($Player_Info_Path, $PlayersInformationHeader);
    for($i = 1;$i < count($playerFile);$i++){
        if($i !== $lineToSkip){
            file_put_contents($Player_Info_Path, "\r\n" . $playerFile[$i],  FILE_APPEND | LOCK_EX);
        }
    }
    header("location: status");
?>