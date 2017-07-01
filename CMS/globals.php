<?php
    /*
        Attributes the images should have in the tag:
        (req)src (obivously)
        (opt)data-specific-time : The time(s?) which this ad MUST play 
        (opt)data-duration : A custom duration other than the globally specified one.
    */
    $AdContentInfoHeader = "Name,Start Date,End Date,Duration,Specific Time,Condition for showing";
    if(!file_exists(getcwd() . "\\Content\\"))
    {
        mkdir(getcwd() . "\\Content\\");
        mkdir(getcwd() . "\\Content\\Ads\\");
        $AdContentInfoFile = fopen(getcwd() . "/Content/Ads/AdContent-info.csv", "w");
        fwrite($AdContentInfoFile, $AdContentInfoHeader);
        fclose($AdContentInfoFile);
    }
    $Path_To_AdInfo = getcwd() . "/Content/Ads/AdContent-info.csv";

    /* 
        Function used to make code more readable in Write_Image_Data.php
        Removes the spaces from the string sent to it.
    */
    function removeSpaces($str){
        return str_replace(' ', '', $str);
    }

    //Ensures all of our date and time calculations are relative to Denver time.
    date_default_timezone_set("America/Denver");
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
        //$Time = substr($DateTime, $IndexOfSpace + 1);
        
        $DateArray = explode("/", $DateTime);
       // $TimeArray = explode(":", $Time);

        $DateTimeArray['month'] = (int)trim($DateArray[0]);
        $DateTimeArray['day'] = (int)trim($DateArray[1]);
        $DateTimeArray['year'] = (int)trim($DateArray[2]);

        /*
        $DateTimeArray['hours'] = (int)trim($TimeArray[0]);
        $DateTimeArray['minutes'] = (int)trim($TimeArray[1]);
        $DateTimeArray['seconds'] = (int)trim($TimeArray[2]);
        */
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
            printf("Function: isDateValid(DateTime, When) Expected \$When == 'start' || 'end'. Recieved \$When = $When");
            return null;
        }
        //We should never get here. Returns false indicating an invalid date anyways.
        return false;
    }
    function startDate($DateTimeArray){
        if($DateTimeArray['year']  <= date("Y") &&
           $DateTimeArray['month'] <= date("m") &&
           $DateTimeArray['day']   <= date("d"))
           {return true;} 
        else{return false;}        
    }
    function endDate($DateTimeArray){
        if($DateTimeArray['year']  >= date("Y"))
        {
            if($DateTimeArray['month'] > date("m")){
                return true;
            }
            else if($DateTimeArray['month'] == date("m")){
                if($DateTimeArray['day']   >  date("d")){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{return false;}
    }

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
    //Checks if any condition is true according to the array which contains the possible conditions.
    function isConditionTrue($Condition){
        if(strpos($Condition, "TEMP") !== false)
            return tempCondition($Condition);
        
        return false;
    }

    function isImage($ImagePath)
    {
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
?>