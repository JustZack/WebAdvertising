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
    
    /* Temperature conditional methods */
    function tempCondition($Condition){
        $CurrentTemp = getTEMP();
        $ConditionalTemp; preg_match_all('/\d+/', $Condition, $ConditionalTemp);
        $Operator = getOperator($Condition);
        return determineCondition_numericalOperator($CurrentTemp, $ConditionalTemp[0][0], $Operator);
    }
    function getTEMP(){
        ini_set("allow_url_fopen", 1);
        $json = file_get_contents("https://api.apixu.com/v1/current.json?key=de89ed0d36ca4255b6224022172706&q=80523");
        $jsonDECODED = json_decode($json, true);
        return $jsonDECODED['current']['temp_f'];
    }
    /* End of temperature conditionals */
?>