<?php
    /* Ensure the files are all organized */
    $Ad_Directory = "Content/Ads/";
    $Ad_Pages_Directory = "Content/Ads_Pages";
    $Current_Year = date("Y");
    $Current_Month = date("M");
    if(!file_exists($Ad_Directory . $Current_Year . "/" . $Current_Month)){
        mkdir($Ad_Directory . $Current_Year);
        mkdir($Ad_Directory . $Current_Year . "/" . $Current_Month);
    }
    if (!empty($_FILES) && isset($_FILES['AdImage'])) {
        switch ($_FILES['AdImage']["error"]) {
            case UPLOAD_ERR_OK:
                $Ad_Directory = $Ad_Directory . $Current_Year . "/" . $Current_Month . "/";
                $Ad_File = $Ad_Directory . basename($_FILES["AdImage"]["name"]);
                $FullImagePath = $Ad_File;
                if (move_uploaded_file($_FILES['AdImage']['tmp_name'], $FullImagePath)) {
                    $imageFileType = pathinfo($Ad_File, PATHINFO_EXTENSION);
                    $check = getimagesize($Ad_File);
                    if ($check !== false) {
                        $UploadOk = 1;
                    } else {
                        $UploadOk = 0;
                    }
                }
                break;
        }
    }
?>