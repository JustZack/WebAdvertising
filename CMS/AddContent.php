<?php
    include_once "globals.php";

    include_once "Add_Images.php";

    if($UploadOk == 1)
    {   
        /* If the file could not be uploaded then there is no reason to write its data to our CSV */
        include_once "Write_Image_Data.php";
        header("location: edit");
    }
    else {
        printf("<link href=\"Styles/Digital_Signage.css\" rel=\"stylesheet\">");
        printf("<div class=\"error-message\">Ad could not be uploaded!</div>");
    }
?>