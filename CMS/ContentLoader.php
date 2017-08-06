<?php
    /*
        This file is meant to be used where globals.php is present!
    */
    /*
        Used to track the number of ads.
        MUST start at 0!
        Ad count is increased before it is printed into an ID for the element.
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
    function loadByGroup($GroupNameString, $ShowData = false){
        global $Groups_Path;
        $CurrentGroupInfoPath = $Groups_Path . $GroupNameString . DIRECTORY_SEPARATOR . "AdContent-info.csv";
        if(!file_exists($CurrentGroupInfoPath)){
            return;
        }
        $GroupInfoFileData = file($CurrentGroupInfoPath, FILE_IGNORE_NEW_LINES);
        for($i = 1;$i < count($GroupInfoFileData);$i++){
            //Load the content
            if(!empty($GroupInfoFileData[$i]))
                loadContent($GroupInfoFileData[$i], $ShowData, $GroupNameString);
        }
    }
    /* 
        This is just a method to reduce redundancy
        It is only used in the function below.
    */
    function tableEntry($Field, $Value){
        printf("\t\t\t\t\t<tr>\n");
        printf("\t\t\t\t\t\t<td>" . $Field . "</td>\n");
        printf("\t\t\t\t\t\t<td>"); echo $Value; printf("</td>\n");                                              
        printf("\t\t\t\t\t</tr>\n");            
    }
    /*
        Function used to load the content stored in a content data string
        This also checks the validity of the content being passed:
            Start/End Date, Specific Time, Conditions for displaying.
    */
    function loadContent($ContentDataString, $ShowData = false,  $Group = ""){
        global $Ad_Count;
        $ContentInfo = explode(",", $ContentDataString);
        $CurrentContentString;
        if(!$ShowData)
        {
            $EndCurrentContentString;
            if(isDateValid($ContentInfo[1], "start")){
                if(isDateValid($ContentInfo[2], "end")){
                    if($ContentInfo[4] == "" || isDayValid($ContentInfo[4])){
                        if($ContentInfo[5] == "" || isTimeValid($ContentInfo[5])){
                            if($ContentInfo[6] == "" || isConditionTrue($ContentInfo[6])){
                                if(isImage($ContentInfo[0])){            
                                    $CurrentContentString = "\t\t\t\t<img id='Ad_" . ++$Ad_Count .
                                    "'class='Ad_Content'src='" . $ContentInfo[0] .
                                    "'data-duration='" . $ContentInfo[3] . "'";
                                    $EndCurrentContentString = ">\n";                            
                                } else if(isVideo($ContentInfo[0])){
                                    $CurrentContentString = "<video id='Ad_" . ++$Ad_Count . "' class='Ad_Content' data-duration='" . $ContentInfo[3] . "'";
                                    $EndCurrentContentString = "><source src='" . $ContentInfo[0] . "'></video>\n";
                                }else {                      
                                    $CurrentContentString = "\n\t\t\t\t<iframe id='Ad_" . ++$Ad_Count .
                                    "'class='Ad_Content'src='" . $ContentInfo[0] .
                                    "'data-duration='" . $ContentInfo[3] . "'";
                                    $EndCurrentContentString = "></iframe>\n";
                                }
                                if($ContentInfo[5] !== ''){
                                    $CurrentContentString .= " data-specific-time='" . $ContentInfo[5] . "'";
                                }
                                if(isset($ContentInfo[7]) && $ContentInfo[7] !== ''){
                                    $CurrentContentString .= " data-load-time='" . $ContentInfo[7] . "'";                                    
                                }
                                echo $CurrentContentString . $EndCurrentContentString;
                            }
                        }
                    }
                }
            }
        }
        else {
            printf("\t\t\t<li class='AdContentWrapper' draggble='true'>\n");       
            if(isImage($ContentInfo[0])){
                printf("\t\t\t\t<img id='Ad_" . ++$Ad_Count . "'class='Ad_Content'src='" . $ContentInfo[0] . "'>\n");                        
            } else if(isVideo($ContentInfo[0])){
                printf("\t\t\t\t<video controls><source id='Ad_" . ++$Ad_Count . "'class='Ad_Content'src='" . $ContentInfo[0] . "'></video>\n");                                                  
            } else {                      
                printf("\n\t\t\t\t<iframe id='Ad_" . ++$Ad_Count . "'class='Ad_Content'src='" . $ContentInfo[0] . "'></iframe>\n");
            }
            printf("\t\t\t\t<table>\n");
            //print_r($ContentInfo);
            tableEntry("Start Date", $ContentInfo[1]);
            tableEntry("End Date", $ContentInfo[2]);
            tableEntry("Duration", $ContentInfo[3]);
            tableEntry("Specific Day", $ContentInfo[4]);            
            tableEntry("Specific Time", $ContentInfo[5]);
            tableEntry("Condition", $ContentInfo[6]);
            if(isset($ContentInfo[7])) { tableEntry("LoadTime", $ContentInfo[7]); }
            else { tableEntry("LoadTime", ""); }
                       
            
            printf("\t\t\t\t</table>\n");      
            printf("\t\t\t\t<a data-link='removeContentFromGroup.php?group=" . $Group . "&name=" . $ContentInfo[0] . "'><div class='delete deleteAd'>Delete</div></a>");                  
            printf("\t\t\t</li>\n");       
             
        }
    }

    /*
        Function used to laod all content in a folder.
        This is a recursive method, which loads ALL content found from the root folder down,
        So be carefull!
    */
    function loadByFolder($FolderPath){
        //This will hold all of the directorys and files!
        $SubFolders = array_values(array_filter(glob($FolderPath . DIRECTORY_SEPARATOR . "*"), 'is_dir'));
        $Files = array_values(array_filter(glob($FolderPath . DIRECTORY_SEPARATOR . "*"), 'is_file'));
        printf("\t<div class='Dir'>\n");
        printf("\t\t\t\t<p class='DirName'>" . getName($FolderPath) . " | " . count($SubFolders) . " Folders | " . count($Files) . " Files</p>\n");        
        if(count($Files) > 0){
            printf("\t\t\t\t<div class='files'>\n");
            for($j = 0;$j < count($Files);$j++){              
                loadContentByName(AbsoluteToRelative($Files[$j]));
            }
            printf("</div>");
        }                       
        for($i = 0;$i < count($SubFolders);$i++){
            loadByFolder($SubFolders[$i]);
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
        } else if(isVideo($PathString)){
            $CurrentContentString = "<video controls muted>\n";
            $CurrentContentString .= "<source src='" . $PathString . "'>\n";
            $CurrentContentString .= "</video>\n";  
        }
        else{                
            $CurrentContentString = "<iframe class='Ad_Content'src=\"" . $PathString . "\"></iframe>\n";
        }
        //Ensure there is not any double slashes in the path.
        $PathString = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $PathString);
        printf("<div class='file_wrapper'>");
        printf("<div class='file_path'>" . $PathString . "</div>");
        printf($CurrentContentString);
        printf("<div class='delete deleteContent'>Delete</div>");
        printf("</div>");        
    }
    /*
        Returns a path which is relative to the server instead of absolute.
    */
    function AbsoluteToRelative($Path){
        $locationOfCMS = strrpos($Path, "CMS");
        $newPath = substr($Path, $locationOfCMS + 4);
        return $newPath;
    }
    /*
        Returns the actual name of the folder or file.
    */
    function getName($FileOrFolder){
        $IndexOfLastSlash = strrpos($FileOrFolder, DIRECTORY_SEPARATOR);
        if($IndexOfLastSlash == strlen($FileOrFolder) - 1){
            $IndexOfLastSlash = strrpos($FileOrFolder, DIRECTORY_SEPARATOR, -2);         
            return substr($FileOrFolder, $IndexOfLastSlash);
        }
        return substr($FileOrFolder, $IndexOfLastSlash);
    }

?>