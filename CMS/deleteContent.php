<?php 
    include_once "globals.php";
    $contentName = $_GET['name'];

    //In essence, deletes the file
    unlink(getcwd() . DIRECTORY_SEPARATOR . $contentName);

    header("location: status");
?>