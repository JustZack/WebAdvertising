<?php 
    include_once "globals.php";
    $old = $_GET['old'];
    $new = $_GET['new'];

    //Rename the folder which holds the group information
    rename($Groups_Path . $old, $Groups_Path . $new);

    //Rename any refrence to the group <t></t>o the new name.
    $players = file($Player_Info_Path);
    for($i = 1;$i < count($players);$i++){
        $line = explode(",", $players[$i]);
        $groups = explode(" ",$line[2]);
        for($j = 0;$j < count($groups);$j++){
            if($groups[$j] == $old){
                $groups[$j] = $new;
                $line[2] = implode(" ", $groups);
                $players[$i] = implode(",", $line);     
            }
        }
    }

    file_put_contents($Player_Info_Path, implode("",$players));
    header("location: status");
?>