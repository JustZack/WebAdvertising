<?php 
    include_once "globals.php";
    $groupName = $_GET['name'];

    $group_folder_path = $Groups_Path . $groupName;
    $group_file_path = $group_folder_path . DIRECTORY_SEPARATOR . "AdContent-info.csv";

    unlink($group_file_path);
    rmdir($group_folder_path);

    header("location: status");
?>