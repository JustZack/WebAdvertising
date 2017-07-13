<?php 
    include_once "globals.php";
    $PathToGroupFile = $Groups_Path . $_GET['group'] . DIRECTORY_SEPARATOR . "AdContent-info.csv";
    $FullImagePath = "";
    $isLink = false;
    $uploadOk = false;
    if(!empty($_FILES['File']['name'])){
        include_once "Add_Images.php";

    } else if (!empty($_POST['Link'])){
        $FullImagePath = $_POST['Link'];
        $isLink = true;
    }

    if($isLink || $uploadOk){
        include_once "Write_Image_Data.php";
        header("location: status#". $_GET['group']);
    }
    else{
        errorMessage("Ad could not be uploaded!");
    }
?>