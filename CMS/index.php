<html>
    <head>
        <link href="Styles/Notify.css" rel="stylesheet">
    </head>
    <body>   
        <?php
            include_once "globals.php";
            $HostName = $_SERVER['REMOTE_HOST'];
            if(isHostRegistered($_SERVER['REMOTE_HOST'])){
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