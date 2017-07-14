<html>
    <head>
    <?php include_once "generichead.php" ?>
        <link href="Styles/Status.css" rel="stylesheet">
        <script src="Scripts/Status.js" rel="javascript"></script>
    </head>
    <body>
    <?php
        include_once "globals.php";
        include_once "ContentLoader.php";
        /*
            Display information about the entire enviroment
            Information such as:
                Player / Hosts:
                    Host name
                    If the host uses wayfinding (+be able to turn on / off)
                    The hosts groups (+be able to add / remove groups)
                Groups
                    Group name
                    All group content (expose all content)
                Content
                    Show each folder (Reprented by expandable tabs)
                    Show the path to each File and the file itself (as a thumbnail)
        */
    ?>
        <div id="HostInformation">    
        <?php
            $PlayerData = file($Player_Info_Path, FILE_IGNORE_NEW_LINES);
            if(count($PlayerData) == 1)
            {
                echo "\n\t\t\t<p style='width: 100%;text-align: center;font-size: 18px;'>No Hosts Registered!</p>";
            }
            for($i = 1;$i < count($PlayerData);$i++)
            {
                $CurrentPlayer = explode(",", $PlayerData[$i]);
                printf("\n\t\t\t<div class='hostData'>\n");
                printf("\t\t\t\t<div class='hostNameWrapper'><div class='hostName'>" . $CurrentPlayer[0] . "</div></div>\n");
                $CurrentPlayerGroups = explode(" ", $CurrentPlayer[2]);
                printf("\t\t\t\t\t<div class='hostGroups'>\n");                    
                for($j = 0;$j < count($CurrentPlayerGroups);$j++){
                    if($CurrentPlayerGroups[$j]){
                        printf("\t\t\t\t\t\t<div class='hostGroup'>" . $CurrentPlayerGroups[$j] . "</div>\n");
                    }
                }
                printf("\t\t\t\t</div>\n");
                if(!empty($CurrentPlayer[3])){
                    printf("\t\t\t\t<div class='hostWayfinding'><div id='left'>" . $CurrentPlayer[1] . "</div><div id='right'>" .  $CurrentPlayer[3] . "</div></div>\n");
                } else {
                    printf("\t\t\t\t<div class='hostWayfinding'>" . $CurrentPlayer[1] . "</div>\n");                    
                }
                printf("\t\t\t\t<a href = 'DisplayAdContent.php?hostname=" . $CurrentPlayer[0] . "'><div class='viewhost'>View Player</div></a>");
                printf("\t\t\t</div>\n");
            }
        ?>
        </div>
        <div id="GroupInformation">
        <?php
            /* TODO: show all of the relevant information about each entry in the group. */
            $Groups = array_values(array_filter(glob($Groups_Path . "*"), 'is_dir'));
            for($i = 0;$i < count($Groups);$i++){
                $Group = substr($Groups[$i], strrpos($Groups[$i], DIRECTORY_SEPARATOR) + 1);
                printf("\n\t\t\t<div class='groupData' id='" . $Group . "'>\n");
                printf("\t\t\t\t<div class='groupName'>" . $Group . "</div>\n");
                //Print out everything this group refrences
                printf("\t\t\t\t<div class='groupWrapper'>\n");
                loadByGroup($Group, true);//Load each ad from this group
                
                //Add content 'card'
                $today = date('m/d/Y');
                $oneWeekAwayFromToday = date('m/d/Y', strtotime("+7 days")); 
                printf("\t\t\t\t\t<div class='AdContentWrapper AddContent'>\n");
                printf("\t\t\t\t\t\t<form method='post' action='AddToGroup.php?group=" . $Group . "'>\n");
                printf("\t\t\t\t\t\t\t<input name='Link' class='fullWidth' type='text' placeholder='https://' value='https://'>\n");//Link to video or image
                printf("\t\t\t\t\t\t\t<br><input name='Start' class='fullWidth' type='text' placeholder='mm/dd/yyyy' value='" . $today . "'>\n");//Start date (today)
                printf("\t\t\t\t\t\t\t<br><input name='End' class='fullWidth' type='text' placeholder='mm/dd/yyyy' value='" . $oneWeekAwayFromToday . "'>\n");//End date, one week from today
                printf("\t\t\t\t\t\t\t<br><input name='Duration' class='fullWidth' type='text' placeholder='Duration (seconds)' value='" . 15 . "'>\n"); //Duration of the Ad
                printf("\t\t\t\t\t\t\t<br><input name='Specific-Day' class='fullWidth' type='text' placeholder='(Optional) Specific Day (Sun, Mon, Tue, Wed, Thu, Fri, Sat)'>\n"); //The specific day you want the ad to play
                printf("\t\t\t\t\t\t\t<br><input name='Specific-Time' class='fullWidth' type='text' placeholder='(Optional) Specific Time (24hr:mm)'>\n"); //the specific time of day you want the ad to play
                printf("\t\t\t\t\t\t\t<br><input name='Condition' class='fullWidth' type='text' placeholder='(Optional) Var Operator Value'>\n"); //A condition for when the ad should be shown
                printf("\t\t\t\t\t\t\t<br><input class='fullWidth' type='submit' value='Add Content To " . $Group . "'>\n"); //Submit button              
                printf("\t\t\t\t\t\t</form>");
                printf("\t\t\t\t\t</div>\n");                
                printf("\t\t\t\t</div>\n");                
                printf("\t\t\t</div>\n");
            }
        ?>
            <div class='groupData' id='createNewWrapper' style='background-color: #3aa800;'>
                <form action="CreateGroup.php">
                    <p>
                        <input type="text" placeholder="New Group (One Word only)" name="groupName">
                    </p>
                    <input type="submit" style="display:none;">
                </form>
            </div>
        </div>
        <div id="ContentInformation">   
        <?php
            loadByFolder($Content_Path);
        ?>
        </div>
    </body>

</html>