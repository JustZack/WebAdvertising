<html>
    <head>
        <link href="Styles/Css_Reset.css" rel="stylesheet">
        <link href="Styles/Edit.css" rel="stylesheet">
        
    </head>
    <body>
        <?php include_once "globals.php" ?>
        <form action="AddContent.php" method="post" enctype="multipart/form-data">
            <br><p>* = Required Field</p>
            <br><p>Select the Image for the Ad*</p>
            <input id="AdImage" name="AdImage" type="file" required enctype="multipart/form-data" method="post">
            <br><p>When do you want the Ad to start playing (defaults to today)*</p>
            <input id="AdStart" name="AdStart" placeholder="mm/dd/yy" value=<?php echo "\"".date('m/d/Y ')."\""; ?> type="text" required method="post" pattern="\d{1,2}\/\d{1,2}\/\d{2,4}">
            <br><p>When do you want the Ad to stop playing (Defaults to a week from today)*</p>
            <input id="AdEnd" name="AdEnd" placeholder="mm/dd/yy" value=<?php echo "\"".date('m/d/Y ', strtotime("+7 days"))."\""; ?> type="text" required method="post" pattern="\d{1,2}\/\d{1,2}\/\d{2,4}}"> 
            <br><p>How long do you want the Ad to play? (Defaults to 15 seconds)*</p>
            <input id="AdDuration" name="AdDuration" placeholder="Seconds" value="15" type="text" method="post">
            <br><p>Should the ad play at a specific time during the day? (24 hour)</p>
            <input id="AdTime" name="AdTime" placeholder="hh:mm" pattern="\d{1,2}:\d{1,2}" type="text" method="post">
            <br><p>Condition for showing the Ad (Advanced)</p>
            <input id="AdCondition" name="AdCondition" placeholder="VAR OPERATOR VALUE" type="text" method="post">
            <br><br><input value="Add Content" name="submit" type="submit">
        </form>
    </body>
</html>