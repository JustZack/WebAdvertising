
<html>
    <head>
<?php include_once "generichead.php" ?>
    </head>
    <body style="background-color: black;"> 
<?php
    include_once "globals.php";
    $NewGroupName = $_GET['groupName'];
    $newGroupPath = $Groups_Path . $NewGroupName;
    if(!file_exists($newGroupPath)){
        mkdir($newGroupPath);
        chmod($newGroupPath, 0777);
        $AdContentPath = $newGroupPath . DIRECTORY_SEPARATOR . "AdContent-info.csv";
        $AdContentFile = fopen($AdContentPath, "w");
        fwrite($AdContentFile, $AdContentInfoHeader);
        fclose($AdContentFile);
        header("location: status");
    } else {
        errorMessage("Group already exists!");
    }
?>     
    </body>
</html>