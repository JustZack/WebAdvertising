<?php
    include_once "globals.php";

    $FullImagePath = "";
    $UploadOk = 0;
    $IsOnlineResource = 0;
    print_r($_POST);
    if(isset($_FILES['AdImage']['name'])){
        include_once "Add_Images.php";
    } 
    if(!empty($_POST['AdOnlineResource'])){
        $IsOnlineResource = 1;
        $FullImagePath = $_POST['AdOnlineResource'];
    }
    printf(isset($_POST['AdOnlineResource']) . " | " . $IsOnlineResource . " | " . $FullImagePath . " | " . $_POST['AdOnlineResource']);
    if($IsOnlineResource == 1 || $UploadOk == 1)
    {   
        /* If the file could not be uploaded then there is no reason to write its data to our CSV */
        include_once "Write_Image_Data.php";
        include_once "images.php";
        header("location: edit");
    }
    else {
        printf("<link href=\"Styles/Digital_Signage.css\" rel=\"stylesheet\">");
        printf("<div class=\"error-message\">Ad could not be uploaded!</div>");
    }
?>