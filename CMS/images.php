        
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
        $CurrentAdString;
        $EndCurrentAdString;
        /* Get the data associated with the current ad in the file */
        $CurrentAdInfo = explode(",", $FileContents[$pos]);
        $FileContents[$pos] .= "\n";
        //The start date is not in the future.
        if(isDateValid($CurrentAdInfo[1], "start")){
            if(isDateValid($CurrentAdInfo[2], "end")){
                if($CurrentAdInfo[4] == "" || isTimeValid($CurrentAdInfo[4])){
                    if($CurrentAdInfo[5] == "" || isConditionTrue($CurrentAdInfo[5])){
                        if(isImage($CurrentAdInfo[0])){
                            $CurrentAdString = "\t\t\t<img id=\"Ad_" . $Ad_Count++ .
                            "\"class=\"Ad_Content\"src=\"" . $CurrentAdInfo[0] .
                            "\"data-duration=\"" . $CurrentAdInfo[3] . "\"";
                            $EndCurrentAdString = ">\n";                            
                        } else{
                            $CurrentAdString = "\n\t\t\t\t<iframe id=\"Ad_" . $Ad_Count++ .
                            "\"class=\"Ad_Content\"src=\"" . $CurrentAdInfo[0] .
                            "\"data-duration=\"" . $CurrentAdInfo[3] . "\"";
                            $EndCurrentAdString = "></iframe>\n";
                        }
                        if($CurrentAdInfo[4] == ""){} 
                        else {
                            $CurrentAdString .= " data-specific-time=\"" . $CurrentAdInfo[4] . "\"";
                        }
                        printf($CurrentAdString . $EndCurrentAdString);
                    }
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