<?php
    function getOperator($Condition){
        if(strpos($Condition, "<=") !== false)
            return "<=";
        if(strpos($Condition, ">=") !== false)
            return ">=";
        if(strpos($Condition, "<") !== false)
            return "<";
        if(strpos($Condition, ">") !== false)
            return ">";
        if(strpos($Condition, "=") !== false)
            return "=";
    }
    function determineCondition_numericalOperator($value, $conditionValue, $operator){
        switch($operator){
            case "<":
                return ($value < $conditionValue);
            case "<=":
                return ($value <= $conditionValue);
            case "=":
                return ($value == $conditionValue);
            case ">=":
                return ($value >= $conditionValue);
            case ">":
                return ($value > $conditionValue);

        }
    }
    
    /* Temperature global variable determining how often we should update the temperature stored in our file */
    $TEMP_UpdateInterval = 60 * 15;
    /* Temperature conditional methods */
    function tempCondition($Condition){
        $CurrentTemp = getTEMP();
        $ConditionalTemp; preg_match_all('/\d+/', $Condition, $ConditionalTemp);
        $Operator = getOperator($Condition);
        return determineCondition_numericalOperator($CurrentTemp, $ConditionalTemp[0][0], $Operator);
    }
    /* Get the current temperature, wether it be from our file or from the API */
    function retrieveTemperature(){
        global $Condition_variables_path, $TEMP_UpdateInterval;
        $FileContents = file($Condition_variables_path, FILE_IGNORE_NEW_LINES);
        $currentTemp = NULL;
        for($i = 1;$i < count($FileContents);$i++){
            $line = explode(",",$FileContents[$i]);
            if ($line[0] == "TEMP"){
                $now = time();
                //echo $now . " - " . $line[2] . " = " . ($now - $line[2]);
                if($now - $line[2] > $TEMP_UpdateInterval){
                    //Get the new Temperatrue and write it to the condition variables file
                    $newTemp = updateTemperature();
                    $line[1] = $newTemp;
                    $line[2] = $now;
                }
                //Return the temperature found in our file
                $FileContents[$i] = implode(",", $line);
                $currentTemp = $line[1];
                break;
            }
        }
        //If we never found the current temperature we will add it to the file.
        if($currentTemp == NULL){
            $currentTemp = updateTemperature();
            $toAppend = "TEMP," . $currentTemp . "," . time();
            //Append the temperature variable to the file
            file_put_contents($Condition_variables_path, $toAppend, FILE_APPEND);
        }
        else{
        /* Ensure each variable has its own line */
            for($i = 0;$i < count($FileContents);$i++){
                $FileContents[$i] .= "\r\n";
            }
            //Rewrite the file with our updated values.
            file_put_contents($Condition_variables_path, $FileContents);
        }
        return $currentTemp;
    }
    /* Pull the temperature from the weather API */
    function updateTemperature(){
        ini_set("allow_url_fopen", 1);
        $json = file_get_contents("https://api.apixu.com/v1/current.json?key=de89ed0d36ca4255b6224022172706&q=80523");
        $jsonDECODED = json_decode($json, true);
        return $jsonDECODED['current']['temp_f'];
    }
    function getTEMP(){
        return retrieveTemperature();
    }
    /* End of temperature conditionals */
?>