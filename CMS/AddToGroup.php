<?php 
    include_once "globals.php";
    $PathToGroupFile = $Groups_Path . $_GET['group'] . DIRECTORY_SEPARATOR . "AdContent-info.csv";
    $FullImagePath = "";
    $FullImagePath = $_POST['Link'];

    include_once "Write_Image_Data.php";
    header("location: status#". $_GET['group']);
?>