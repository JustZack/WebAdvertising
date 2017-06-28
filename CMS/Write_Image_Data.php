<?php

    /* Get all of the variables associated with the image */
    $StartTime = $_POST['AdStart'];
    $EndTime = $_POST['AdEnd'];
    $Condition = str_replace(' ', '', $_POST['AdCondition']);
    /* This is the line that will be written to our CSV file */
    $DataToBeWritten = $FullImagePath . ", " . $StartTime . ", " . $EndTime . ", " . $Condition . "\n";
    file_put_contents($Path_To_AdInfo, $DataToBeWritten, FILE_APPEND | LOCK_EX);
?>