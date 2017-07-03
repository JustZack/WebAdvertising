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
            for($i = 1;$i < count($PlayerData);$i++)
            {
                $CurrentPlayer = explode(",", $PlayerData[$i]);
                printf("\n\t\t\t<div class='hostData'>\n");
                printf("\t\t\t\t<div class='hostNameWrapper'><div class='hostName'>" . $CurrentPlayer[0] . "</div></div>\n");
                $CurrentPlayerGroups = explode(" ", $CurrentPlayer[2]);
                printf("\t\t\t\t\t<div class='hostGroups'>\n");                    
                for($j = 0;$j < count($CurrentPlayerGroups);$j++){
                    printf("\t\t\t\t\t\t<div class='hostGroup'>" . $CurrentPlayerGroups[$j] . "</div>\n");
                }
                printf("\t\t\t\t</div>\n");
                printf("\t\t\t\t<div class='hostWayfinding'>" . $CurrentPlayer[1] . "</div>\n");
                printf("\t\t\t\t<a href = 'DisplayAdContent.php?hostname=" . $CurrentPlayer[0] . "'><div class='viewhost'>View Player</div></a>");
                printf("\t\t\t</div>\n");
            }
        ?>
        </div>
        <div id="GroupInformation">
        <?php
            $Groups = array_values(array_filter(glob($Groups_Path . "*"), 'is_dir'));
            for($i = 0;$i < count($Groups);$i++){
                $Group = substr($Groups[$i], strrpos($Groups[$i], DIRECTORY_SEPARATOR) + 1);
                printf("\n\t\t\t<div class='groupData'>\n");
                printf("\t\t\t\t<div class='groupName'>" . $Group . "</div>\n");
                //Print out everything this group refrences
                printf("\t\t\t\t<div class='groupWrapper'>\n");
                loadByGroup($Group);
                printf("\t\t\t\t</div>\n");                
                printf("\t\t\t</div>\n");
            }
        ?>
        </div>
        <div id="ContentInformation">
        <?php
            loadByFolder($Content_Path);
        ?>
        </div>
    </body>

</html>