<?php 
    include_once "globals.php";

    //The group in which we want to reorder content.
    $group = $_GET['group'];
    //ensure our group doesnt have any empty lines
    removeEmptyEntries($group);

    //The new order for the group.
    //Ex 4,1,5,6,3,2
    $order = $_GET['newOrder'];
    $positions = explode(",", $order);

    //The current file, which we must reorder
    $oldGroupFile = file($Groups_Path . $group . DIRECTORY_SEPARATOR . "AdContent-info.csv", FILE_IGNORE_NEW_LINES);

    $newGroupFile = array();
    $newGroupFile[0] = $oldGroupFile[0] . "\r\n";
    for($i = 0;$i < count($positions);$i++){
        $newGroupFile[$i + 1] = $oldGroupFile[$positions[$i]] . "\r\n";
    }

    file_put_contents($Groups_Path . $group . DIRECTORY_SEPARATOR . "AdContent-info.csv", $newGroupFile, LOCK_EX );

    header("location: status");
?>