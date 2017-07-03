<html>
    <head>
        <link href="Styles/Notify.css" rel="stylesheet">
    </head>
    <body>   
        <?php
            include_once "globals.php";
            $HostName = array_key_exists( 'REMOTE_HOST', $_SERVER) ? $_SERVER['REMOTE_HOST'] : gethostbyaddr($_SERVER["REMOTE_ADDR"]);
            if(isHostRegistered($HostName)){
                header("location: DisplayAdContent.php?hostname=" . $HostName);
            } else {
                  /*
                    This is where i would consider redirecting somewhere else.
                    I would prefer to just throw the error.
                    Keep other people out of the site as much as possible.
                  */
            }
        ?>
    </body>
</html>