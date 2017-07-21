<?php
    /* Get all of the variables associated with the image */
    $StartTime = removeSpaces($_POST['Start']);
    $EndTime = removeSpaces($_POST['End']);
    $Duration = removeSpaces($_POST['Duration']);
    $SpecificDay = removeSpaces($_POST['Specific-Day']);    
    $SpecificTime = removeSpaces($_POST['Specific-Time']);
    $Condition = removeSpaces($_POST['Condition']);
    $SubContent = removeSpaces($_POST['SubContent']);
    /* This is the line that will be written to our CSV file */
    $DataToBeWritten = "\r\n" . $FullImagePath . "," . $StartTime . "," . $EndTime . "," . $Duration . "," . $SpecificDay . "," . $SpecificTime . "," . $Condition . "," . $SubContent;
    file_put_contents($PathToGroupFile, $DataToBeWritten, FILE_APPEND | LOCK_EX);
?>