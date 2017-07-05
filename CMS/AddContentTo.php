<html>
    <head>
<?php include_once "generichead.php" ?>
    <link href="Styles/Status.css" rel="stylesheet">
    <link href="Styles/AddContentTo.css" rel="stylesheet">
    </head>
    <body>
        <form method="post" action="AddToGroup.php?group=<?php echo $_GET['group'] ?>" enctype="multipart/form-data">
            <div id="Errors"></div>
            <input name="File" id="File" type="file" style="display:none;"> 
            <label for="File">Select A File</label> OR <input placeholder="https://" name="Link" type="text">   
            <br><input class="fill" value=<?php echo ''.date('m/d/Y').''; ?> placeholder="Start Date" name="Start" type="text">
            <br><input class="fill" value=<?php echo '\''.date('m/d/Y', strtotime("+7 days")).'\'' ?> placeholder="End Date" name="End" type="text">
            <br><input class="fill" value="15" placeholder="Duration" name="Duration" type="text">
            <br><input class="fill" placeholder="Specific Time (24h:mm)" name="Specific-Time" type="text">
            <br><input class="fill" placeholder="Var Operator value (ex: TEMP > 60)" name="Condition" type="text">
            <br><input class="fill" type="submit" value=<?php echo "\"Add Content To " . $_GET['group'] . "\""?>>
        </form>
        <div id="ContentInformation">
        <?php 
        include_once "globals.php";
        include_once "ContentLoader.php";
            loadByFolder($Content_Path);
        ?>
        </div>
    </body>
</html>