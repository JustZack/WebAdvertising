<?php
    /*
        Attributes the images should have in the tag:
        (req)src (obivously)
        (opt)data-specific-time : The time(s?) which this ad MUST play 
        (opt)data-duration : A custom duration other than the globally specified one.
    */
    /* 
        Ensures all of our date and time calculations are relative to Denver time.
    */
    date_default_timezone_set("America/Denver");
    /*
        Store the information associated with the current host
    */
    $Host_Info;
    $HostName_SERVER = array_key_exists( 'REMOTE_HOST', $_SERVER) ? $_SERVER['REMOTE_HOST'] : gethostbyaddr($_SERVER["REMOTE_ADDR"]);
    /*
        These are the headers used in the the creation of files
    */
    $AdContentInfoHeader = "Path,Start Date,End Date,Duration,Specific Day,Specific Time,Condition for showing";
    $PlayersInformationHeader = "Hostname,Nick Name,Use-Wayfinding,Ad-Content-Groups,Wayfinding Name";
    
    /*
        Variables which contain the paths for some important folders / files
    */
    $Content_Path = getcwd() . DIRECTORY_SEPARATOR . "Content" . DIRECTORY_SEPARATOR;
    $Ad_Content_Path = $Content_Path . "Ads" . DIRECTORY_SEPARATOR;
    $Ad_Pages_Content_Path = $Content_Path . "Ads_Pages" . DIRECTORY_SEPARATOR;

    $Player_Path = getcwd() . DIRECTORY_SEPARATOR . "Players" . DIRECTORY_SEPARATOR;
    $Player_Info_Path = $Player_Path . "Players-info.csv";    
    $Groups_Path =  $Player_Path . "Groups" . DIRECTORY_SEPARATOR;   
    $Default_Group_Path = $Groups_Path . "Default" .  DIRECTORY_SEPARATOR;    
    $Default_Group_Info_Path = $Default_Group_Path . "AdContent-info.csv";    
    /* Paths array so checking for file existance is simple. */
    $PathsArray = array(
        $Content_Path,
        $Ad_Content_Path,
        $Ad_Pages_Content_Path,
        $Player_Path,
        $Player_Info_Path,
        $Groups_Path//,
        //$Default_Group_Path,
        //$Default_Group_Info_Path
    );
    fileCheck();
    /*
        Function for checking that the nessasary files exist.
    */
    function fileCheck(){
        //Include the nessasary globally scoped variables.
        global $PathsArray, $AdContentInfoHeader, $PlayersInformationHeader;
        for($i = 0;$i < count($PathsArray);$i++)
        {
            if(!file_exists($PathsArray[$i]))
            {
                $index_of_last_dot = strrpos($PathsArray[$i], ".");
                $index_of_last_slash = strrpos($PathsArray[$i], DIRECTORY_SEPARATOR);
                if($index_of_last_dot > $index_of_last_slash){
                    //This is a file!
                    if($i == 4){ //Players info file!
                        $PlayersFile = fopen($PathsArray[$i], "w");
                        fwrite($PlayersFile, $PlayersInformationHeader);
                        fclose($PlayersFile);
                    } else if($i == 6){ //Default group info file!
                        $DefaultsFile = fopen($PathsArray[$i], "w");
                        fwrite($DefaultsFile, $AdContentInfoHeader);
                        fwrite($DefaultsFile, "\r\nhttps://www.youtube.com/embed/aWmkuH1k7uA,07/1/2017,07/1/2025,219,,,,");
                        fclose($DefaultsFile);
                    }
                } else {
                    //This is a directory
                    mkdir($PathsArray[$i]);
                    chmod($PathsArray[$i], 0777);
                }
                
            }
        }
    }
    /*
        Function for checking if we know of the hostname requesting useage of the site
    */
    function isHostRegistered($HostName){
        global $Player_Info_Path;
        if(file_exists($Player_Info_Path))
        {
            $FileContents = file($Player_Info_Path , FILE_IGNORE_NEW_LINES);
            for($i = 0;$i < count($FileContents);$i++){
                $line = explode(",", $FileContents[$i]);
                if($line[0] == $HostName){
                    //This is a 'registered' hostname!
                    return true;
                }
                else { continue; }
            }
            /* If we made it out here then no hostnames matched */
            errorMessage("Your hostname, " . $HostName . ", is not recognized! (hostname missing)");
        } else {
            //Error, the file doesnt exist on the server!
            errorMessage("Your hostname, " . $HostName . ", is not recognized! (file missing)");
            /*
                TODO:
                Systematically determine if the parent folders exist
                Try to create the file and then go to : SOMEWHERE?
            */
        }
        return false;
    }

    /*
        Function for getting the url arguments that should be used for this LCD.
    */
    function getHostParameters($HostName){
        global $Player_Info_Path;        
        if(file_exists($Player_Info_Path))
        {
            $FileContents = file($Player_Info_Path , FILE_IGNORE_NEW_LINES);
            for($i = 0;$i < count($FileContents);$i++){
                $line = explode(",", $FileContents[$i]);
                if($line[0] == $HostName){
                    $toReturn = "hostname=" . $line[0];
                    if(!empty($line[4])) $toReturn .= "&hostLCDname=" . $line[4];
                    return $toReturn;
                }
                else { continue; }
            }
            /* If we made it out here then no hostnames matched */
            errorMessage("Your hostname, " . $HostName . ", is not recognized! (hostname missing)");
        } 
    }
    /* From here down is functions that I think are globally usefull */
    /* 
        Prints an error message to the screen.
    */
    function errorMessage($Message){
        printf("\t\t\t\t<div class=\"error-message\">" . $Message . "</div>");        
    }
    /* 
        Function used to make code more readable in Write_Image_Data.php
        Removes the spaces from the string sent to it.
    */
    function removeSpaces($str){
        return str_replace(' ', '', $str);
    }
    /* 
        Custom function to parse a date formated like so: mm/dd/yy hh:mm:ss
        Returns the unix timestamp associated with this date
        $DateTime: The string containg the date and time (mm/dd/yy hh:mm:ss)
        $When: Either "Start" or "End", Determines how to check validity of the date.
        Currently this function ignores the hours minutes and seconds. 
            Currently doesnt seem needed.
    */
    function isDateValid($DateTime, $When){
        $DateTimeArray = array();
        $DateArray = explode("/", $DateTime);

        $DateTimeArray['month'] = (int)trim($DateArray[0]);
        $DateTimeArray['day'] = (int)trim($DateArray[1]);
        $DateTimeArray['year'] = (int)trim($DateArray[2]);

        $When = strtolower($When);
        if($When == "start")
        {
           return startDate($DateTimeArray); 
        }
        else if($When == "end") {
            return endDate($DateTimeArray);
        }
        else
        {
            errorMessage("Function: isDateValid(DateTime, When) Expected \$When == 'start' || 'end'. Recieved \$When = $When");
            return null;
        }
        //We should never get here. Returns false indicating an invalid date anyways.
        return false;
    }
    function startDate($DateTimeArray){
        if($DateTimeArray['year'] < date("Y")){
            return true;
        }
        else if($DateTimeArray['year'] == date("Y") && $DateTimeArray['month'] < date("m")){
            return true;
        }
        else if($DateTimeArray['year'] == date("Y") && $DateTimeArray['month'] == date("m") && $DateTimeArray['day'] <= date('d')){
            return true;
        }
        else{
            return false;
        }        
    }
    function endDate($DateTimeArray){
        if($DateTimeArray['year']  > date("Y")){
            return true;
        }
        else if($DateTimeArray['year']  == date("Y") && $DateTimeArray['month'] > date("m")){
            return true;
        }
        else if($DateTimeArray['year']  == date("Y") && $DateTimeArray['month'] == date("m") && $DateTimeArray['day']  >= date("d")){;            
            return true;
        }
        else{          
            return false;
        }
    }
    /* Determine if the specific day is today! */
    function isDayValid($Day){
        if(strtolower($Day) == strtolower(date('D'))){
            return true;
        } else {
            return false;
        }
    }
    /* Determine if the specific time is within the next 15 minutes */
    function isTimeValid($Time){
        $CurrentDate = date('H:i');
        $CurrentTime = strtotime($CurrentDate);
        $SpecificTime = strtotime($Time);
        $diff = round(($SpecificTime - $CurrentTime) / 60,2);
        if($diff <= 15 && $diff > 0)
            return true; //Only true if the specific time is within the next 15 minutes
        else
            return false;
    }
    include_once "Conditions.php";
    /*
        Checks if any condition is true according to the array which contains the possible conditions.
    */
    function isConditionTrue($Condition){
        if(strpos($Condition, "TEMP") !== false)
            return tempCondition($Condition);
        
        return false;
    }
    /*
        Check if the path given is an image
        This is agnostic to the resource being on a server or local.
    */
    function isImage($ImagePath){
        $ImagePath = strtolower($ImagePath);
        $ImageFileEndings = 
        array
        (
            0 => 'jpg',
            1 => 'gif',
            2 => 'jpeg',
            3 => 'bmp',
            4 => 'png'
        );
        for($i = 0;$i < count($ImageFileEndings);$i++)
            if(strrpos($ImagePath, '.' . $ImageFileEndings[$i]) !== false)
                return true;
        return false;
    }

    /*
        Readability method for adding data to group.
    */
    function addToGroup($Group, $ContentDataString){
        $PathToGroupFile = $Groups_Path . $Group . DIRECTORY_SEPARATOR . "AdContent-info.csv";
        file_put_contents($PathToGroupFile, $ContentDataString, FILE_APPEND | LOCK_EX);
    }
?>