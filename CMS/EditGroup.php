<html>
    <head>
        <?php include_once "generichead.php" ?>
        <link href="Styles/Status.css" rel="stylesheet">
      
    </head>
    <body>
        <!-- This is where the form should go for adding content -->
        <?php 
            include_once "globals.php";
            include_once "ContentLoader.php";
            $Group = $_GET['group'];
            printf("\n\t\t\t<div class='groupData'>\n");
            printf("\t\t\t\t<div class='groupName'>" . $Group . " <a class='editGroup' href='EditGroup.php?group=" . $Group . "'>Edit Group</a></div>\n");
            //Print out everything this group refrences
            printf("\t\t\t\t<div class='groupWrapper'>\n");
            loadByGroup($Group, true);
            printf("\t\t\t\t</div>\n");                
            printf("\t\t\t</div>\n");
            /*
                1. Display all of the content currently included in the group
                    loadByGroup($Group);
                    Also print out all data related to the content
                        Start Date
                        End Date
                        Duration
                        Specific Time
                        Condition
                        Make content editable...
                            Make edit button which takes us to a new page.
                            This will just be easier.
                2. Display all of the local content available
                    loadByFolder($Content_Path);
                    User should be able to click an ad to add its path to the form
                3. Add a form (in html) for adding stuff to the group
                    Path / URL field
                        Allow user to click a local resource to add it to the group, 
                        but only if it is not already in the group
                    Start Date
                        Defaults to today
                        MAYBE bring up a calendar for selecting a date
                    End Date
                        Defaults to a week from today
                        Once again MAYBE bring up a calendar for selecting date
                    Duration
                        User types in how many seconds they want the ad to play for.
                        MAYBE allow user to change unit to minutes
                    Specific Time
                        User types in the time the ad should play at daily in 24hr:mm format
                    Condition
                        This is an advanced field.
                        Perhaps have 3 different fields
                            Variable
                                The variable which we compare our value against
                            Operator
                                How the Variable is compared to our Value
                            Value
                                The value the Variable is compared against
            */
        ?>
    </body>
</html>