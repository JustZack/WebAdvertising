        <div class="content-container">
<?php
    include_once "globals.php";
    
    $FileContents = file($Path_To_AdInfo, FILE_IGNORE_NEW_LINES);
    $Ad_Count = 1; //Keeps track of how many ads we have added.
    /* Starts after the first line, 
    because the first line is just the format of the file 
    incase a human wants to edit it. */
    $FileContents[0] .= "\n";
    for($pos = 1;$pos < count($FileContents);$pos++){
        /* Get the data associated with the current ad in the file */
        $CurrentAdInfo = explode(",", $FileContents[$pos]);
        $FileContents[$pos] .= "\n";
        //The start date is not in the future.
        if(isDateValid($CurrentAdInfo[1], "start")){
            if(isDateValid($CurrentAdInfo[2], "end")){
                if($CurrentAdInfo[3] == " " || isConditionTrue($CurrentAdInfo[3]))
                {
                    //The ad is 100% okay to be shown!
                    printf("\t\t\t<img id=\"Ad_" . $Ad_Count++ .
                    "\"class=\"Ad_Content\"src=\"" . $CurrentAdInfo[0] ."\">\n");
                }
            }
            else {//The ad has already ended
                 //Remove the ad from the file
                unset($FileContents[$pos]);
            }
        }
    }
    //Rewrite the file so the correct images are shown.
    file_put_contents($Path_To_AdInfo, $FileContents, LOCK_EX);

    if($Ad_Count == 1) // This means there were no ads
    {
        printf("<div class=\"error-message\">No Ad content to display!</div>");
    }
?>
        </div>