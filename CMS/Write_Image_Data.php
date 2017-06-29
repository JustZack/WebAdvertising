<?php
    /* Get all of the variables associated with the image */
    $StartTime = removeSpaces($_POST['AdStart']);
    $EndTime = removeSpaces($_POST['AdEnd']);
    $Duration = removeSpaces($_POST['AdDuration']);
    $SpecificTime = removeSpaces($_POST['AdTime']);
    $Condition = removeSpaces($_POST['AdCondition']);
    /* This is the line that will be written to our CSV file */
    $DataToBeWritten = "\r\n" . $FullImagePath . "," . $StartTime . "," . $EndTime . "," . $Duration . "," . $SpecificTime . "," . $Condition;
    file_put_contents($Path_To_AdInfo, $DataToBeWritten, FILE_APPEND | LOCK_EX);
?>