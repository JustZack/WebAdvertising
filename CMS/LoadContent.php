        
            <div class="content-container">
<?php
    include_once "globals.php";  
    
    $HostName;
    if(isset($_GET['hostname'])){
        $HostName = $_GET['hostname']; //Use URL argument hostname
    } else {
        $HostName = $_SERVER['REMOTE_HOST']; //Use hostname associated with this request
    }
    //One last check for valididy of host name
    if(!isHostRegistered($HostName)){
        exit();
    }

    //Now we can determine what this hostname is supposed to play
    $PlayerFileContents = file($Player_Info_Path, FILE_IGNORE_NEW_LINES);
    $Groups = "NONE";
    for($i = 1;$i < count($PlayerFileContents);$i++){
        $line = explode(",", $PlayerFileContents[$i]);
        if($line[0] == $HostName){
            //Store all the host info for this host, usefull later.
            $Host_Info = $line;
            //We have the hostname on record! Lets grab the group information.$_COOKIE
            if($line[2] !== ''){
                $Groups = $line['2'];
            }
            //Leave the for loop, we found what we were looking for!
            break;
        }
    }
    //Check if there were any groups associated with this hostname
    if($Groups == "NONE"){
        errorMessage("This hostname has no groups associated with it!");
        exit();
    }

    /*
        This is where content is loaded
    */
    $Ad_Count = 1; //Keeps track of how many ads we have added.
    $Groups_array = explode(" ", $Groups);
    for($i = 0;$i < count($Groups_array);$i++)
    {//Go through each group and get its associated ads
        //Get the path to the group
        $Path_To_Group_Info = $Groups_Path . $Groups_array[$i] . "\\AdContent-info.csv";
        $GroupFileContents = file($Path_To_Group_Info, FILE_IGNORE_NEW_LINES);
        $GroupFileContents[0] .= "\n";
        for($j = 1;$j < count($GroupFileContents);$j++)
        {//Go through each ad in the group
            $CurrentAdInfo = explode(",", $GroupFileContents[$j]);
            $GroupFileContents[$j] .= "\n";
            $CurrentAdString;
            $EndCurrentAdString;
            /* Get the data associated with the current ad in the file */
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
                            if($CurrentAdInfo[4] !== ''){
                                $CurrentAdString .= " data-specific-time=\"" . $CurrentAdInfo[4] . "\"";
                            }
                            printf($CurrentAdString . $EndCurrentAdString);
                        }
                    }
                }
                else {//The ad has already ended
                     //Remove the ad from the schedule file
                    unset($GroupFileContents[$j]);
                }         
            } 
        }
        //Rewrite the file so the correct images are shown.
        file_put_contents($Path_To_Group_Info, $GroupFileContents, LOCK_EX);    
    }
        
    if($Ad_Count == 1)//No ads associated with the group(s) this player is associated with
    {
        errorMessage("No Ad content to display!");
    }
?>

            </div>