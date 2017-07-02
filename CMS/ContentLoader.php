<?php
    /*
        This file is meant to be used where globals.php is present!
    */
    /*
        Used to track the number of ads
    */
    $Ad_Count = 0;
    /*
        Function used to load all content that is associated with an array of groups.
        Takes a string
    */
    function loadByGroups($GroupNameStringList){
        $Groups = explode(" ", $GroupNameStringList);
        for($i = 0;$i < count($Groups);$i++){
            if($Groups !== ' ' || $Groups !== ''){
                loadByGroup($Groups[$i]);
            }
        }
    }
    /*
        Function used to load all content that is associated with a group.
    */
    function loadByGroup($GroupNameString){
        global $Groups_Path;
        $CurrentGroupInfoPath = $Groups_Path . $GroupNameString . "\\AdContent-info.csv";
        $GroupInfoFileData = file($CurrentGroupInfoPath, FILE_IGNORE_NEW_LINES);
        for($i = 1;$i < count($GroupInfoFileData);$i++){
            //Load the content
            loadContent($GroupInfoFileData[$i], $GroupInfoFileData);
        }
    }
    /*
        Function used to load the content stored in a content data string
        This also checks the validity of the content being passed:
            Start/End Date, Specific Time, Conditions for displaying.
    */
    function loadContent($ContentDataString){
        global $Ad_Count;
        $ContentInfo = explode(",", $ContentDataString);
        $CurrentContentString;
        $EndCurrentContentString;
        if(isDateValid($ContentInfo[1], "start")){
            if(isDateValid($ContentInfo[2], "end")){
                if($ContentInfo[4] == "" || isTimeValid($ContentInfo[4])){
                    if($ContentInfo[5] == "" || isConditionTrue($ContentInfo[5])){
                        if(isImage($ContentInfo[0])){            
                            $CurrentContentString = "\t\t\t<img id=\"Ad_" . $Ad_Count++ .
                            "\"class=\"Ad_Content\"src=\"" . $ContentInfo[0] .
                            "\"data-duration=\"" . $ContentInfo[3] . "\"";
                            $EndCurrentContentString = ">\n";                            
                        } else{                      
                            $CurrentContentString = "\n\t\t\t\t<iframe id=\"Ad_" . $Ad_Count++ .
                            "\"class=\"Ad_Content\"src=\"" . $ContentInfo[0] .
                            "\"data-duration=\"" . $ContentInfo[3] . "\"";
                            $EndCurrentContentString = "></iframe>\n";
                        }
                        if($ContentInfo[4] !== ''){
                            $CurrentContentString .= " data-specific-time=\"" . $ContentInfo[4] . "\"";
                        }
                        printf($CurrentContentString . $EndCurrentContentString);
                    }
                }
            }
        }
    }

    /*
        Function used to laod all content in a folder.
        This is a recursive method, which loads ALL content found from the root folder down,
        So be carefull!
    */
    function loadByFolder($FolderPath){
        //This will hold all of the directorys and files!
        printf("\t<div class='Dir'>\n");
        printf("\t\t\t\t<p class='DirName'>" . getName($FolderPath) . "</p>\n");        
        $SubFolders = array_filter(glob($FolderPath . "\*"), 'is_dir');
        $Files = array_filter(glob($FolderPath . "\*"), 'is_file');
        for($i = 0;$i < count($SubFolders);$i++){
            loadByFolder($SubFolders[$i]);
        }
        if(count($Files) > 0){
            printf("\t\t\t\t<div class='files'>\n");
            for($j = 0;$j < count($Files);$j++){              
                loadContentByName(AbsoluteToRelative($Files[$j]));
            }
            printf("</div>");
        }                       
        printf("</div>");
        
    }
    /*
        Load content without any checks.
        This loads any file name / path / resource handed to it
    */
    function loadContentByName($PathString){
        $CurrentContentString = "";
        if(isImage($PathString)){          
            $CurrentContentString = "<img class='Ad_Content'src=\"" . $PathString . "\">\n";                         
        } else{                
            $CurrentContentString = "<iframe class='Ad_Content'src=\"" . $PathString . "\"></iframe>\n";
        }
        printf($CurrentContentString);
    }
    /*
        Returns a path which is relative to the server instead of absolute.
    */
    function AbsoluteToRelative($Path){
        return str_replace("C:\\xampp\\htdocs", "", $Path);
    }
    /*
        Returns the actual name of the folder or file.
    */
    function getName($FileOrFolder){
        $IndexOfLastSlash = strrpos($FileOrFolder, "\\");
        if($IndexOfLastSlash == strlen($FileOrFolder) - 1){
            $IndexOfLastSlash = strrpos($FileOrFolder, "\\", -2);         
            return substr($FileOrFolder, $IndexOfLastSlash);
        }
        return substr($FileOrFolder, $IndexOfLastSlash);
    }

?>