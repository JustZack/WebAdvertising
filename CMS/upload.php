<?php
    include_once "globals.php";
    $uploaddir = $Ad_Content_Path;
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if($ext == 'php'){
        $uploaddir = $Ad_Pages_Content_Path;
    } else {
        $Current_Year = date("Y");
        $Current_Month = date("M");
        if(!file_exists($uploaddir . $Current_Year . "/" . $Current_Month)){
            mkdir($uploaddir . $Current_Year);
            mkdir($uploaddir . $Current_Year . "/" . $Current_Month);
        }
        $uploaddir = $uploaddir . $Current_Year . "/" . $Current_Month . "/";
    }
    $uploadfile = $uploaddir . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        $check = getimagesize($uploadfile);
        if ($check !== false) {
            $UploadOk = 1;
        } else {
            $UploadOk = 0;
        }
    }
?>