<?php  
    include_once "globals.php";
    $PathToGroupFile = $Groups_Path . $_GET['group'] . DIRECTORY_SEPARATOR . "AdContent-info.csv";
    $NameToRemove = $_GET['name'];

    $FileContents = file($PathToGroupFile);
    for($i = 0;$i < count($FileContents);$i++){
        $CurrentInfo = explode(",", $FileContents[$i]);
        if($CurrentInfo[0] == $NameToRemove){
            unset($FileContents[$i]);
        }
    }
    file_put_contents($PathToGroupFile, implode("",$FileContents));
    header("location: status#" . $_GET['group']);
?>