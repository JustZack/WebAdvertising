<html>
    <head>
        <link href="Styles/Edit.css" rel="stylesheet">
        <script src="Scripts/EditFormValidation.js"></script>
    </head>
    <body>
        <?php include_once "globals.php" ?>
        <form action="AddContent.php" method="post" enctype="multipart/form-data">
            <input id="AdImage" name="AdImage" type="file" enctype="multipart/form-data" method="post">
            <br><input id="AdOnlineResource" name="AdOnlineResource" placeholder="https://" type="text" method="post">            
            <br><input id="AdStart" name="AdStart" placeholder="mm/dd/yy" value=<?php echo "\"".date('m/d/Y')."\""; ?> type="text" method="post" pattern="\d{1,2}\/\d{1,2}\/\d{2,4}">
            <br><input id="AdEnd" name="AdEnd" placeholder="mm/dd/yy" value=<?php echo "\"".date('m/d/Y', strtotime("+7 days"))."\""; ?> type="text" method="post" pattern="\d{1,2}\/\d{1,2}\/\d{2,4}}"> 
            <br><input id="AdDuration" name="AdDuration" placeholder="Seconds" value="15" type="text" method="post">
            <br><input id="AdTime" name="AdTime" placeholder="hh:mm" pattern="\d{1,2}:\d{1,2}" type="text" method="post">
            <br><input id="AdCondition" name="AdCondition" placeholder="VAR OPERATOR VALUE" type="text" method="post">
            <br><input value="Add Content" name="submit" type="submit">
        </form>
    </body>
</html>