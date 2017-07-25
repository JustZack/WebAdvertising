        
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
            //We have the hostname on record! Lets grab the group information.
            if($line[2] !== ''){
                $Groups = $line[3];
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

    printf("<div id='HostData' data-usewayfinding='" . $Host_Info[2] . "'></div>");

    include_once "ContentLoader.php";
    
    loadByGroups($Groups);
        
    if($Ad_Count == 0)//No ads associated with the group(s) this player is associated with
    {
        errorMessage("No Ad content to display!");
    }
?>

            </div>