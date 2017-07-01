<html>
    <head>
        <link href="Styles/Notify.css" rel="stylesheet">
    </head>
    <body>   
        <?php

            include_once "globals.php";
            function isHostRegistered($HostName){
                if(file_exists(getcwd() . "/Players/Players-info.csv"))
                {
                    $FileContents = file(getcwd() . "/Players/Players-info.csv" , FILE_IGNORE_NEW_LINES);
                    for($i = 0;$i < count($FileContents);$i++){
                        $line = explode(",", $FileContents[$i]);
                        if($line[0] == $HostName){
                            //This is a 'registered' hostname!
                            //Redirect to the ad content display page.
                            //URL parameter is not required, but is handy.
                            header("location: DisplayAdContent.php?hostname=" . $HostName);
                        }
                        else { continue; }
                    }
                    /* If we made it out here then no hostnames matched */
                    printf("<div class=\"error-message\">Your hostname, " . $HostName . ", is not recognized! (hostname missing)</div>");
                } else {
                    //Error, the file doesnt exist on the server!
                    printf("<div class=\"error-message\">Your hostname, " . $HostName . ", is not recognized! (file missing)</div>");
                    /*
                        TODO:
                        Systematically determine if the parent folders exist
                        Try to create the file and then go to : SOMEWHERE?
                    */
                }
            }
            isHostRegistered($_SERVER['REMOTE_HOST']);

        ?>
    </body>
</html>