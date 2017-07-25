<div id="FlickrWrapper">
    <script src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../../../WebAdvertising/CMS/Styles/Css_Reset.css">
    <script>
        $(document).ready(function(){

            var flickrCount = $(".flickr_img").length;
            var current = -1;

            advanceFlickr();
            function advanceFlickr(){
                //Hide the current picture
                $("#flickr_" + current++).fadeTo(500, 0);
                if(current == flickrCount){ current = 0; }
                //Show the next image
                $("#flickr_" + current).fadeTo(500, 1);
                setTimeout(function() {
                    advanceFlickr();
                }, 7000);
            }

        });
</script>
<style>
    body{
        /* 
            Black background color for visual pleasure, 
            and hides any thing that overflows on the sides or bottom.
        */
        background-color: black;
        overflow: hidden;
    }
    div#FlickrWrapper{
        /* Ensure the div fills the screen */
        height: 100%;
        width: 100%;
    }
    img.flickr_img{
        /* Forces the image to be centered */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* Forces the image to fill the div */
        height: 100%;
        width: 100%;
        /* Forces images to all be ontop of eachother, which is usefull for our image rotation */
        opacity: 0;
        position: absolute;
        object-fit: cover;
    }
</style>
<?php
    include_once "../../phpflickr/phpFlickr.php";

    /* The key and secret for my API calls */
    $key = "896d1118c1152cc3920ed92cbaabc5bd";
    $secret = "b77404c58fb85a28";

    $photoCount = $_GET['photoCount'];

    /* All the API calls I need to get the images from CSU's flickr */
    $flickr = new phpFlickr($key, $secret);
    $userID = $flickr->people_findByUsername("coloradostateuniversity")['id'];
    $photos = $flickr->people_getPhotos($userID, array('tags'=>'LSC, Lory Student Center','tag_mode'=>'any','per_page'=>500, 'min_taken_date'=>'2015-9-1 00:00:00'));
    
    /* Shuffle the array of 500 images */
    shuffle($photos['photos']['photo']);
    
    /* Slice off all the images we dont want */
    $slicedPhotos = array_slice($photos['photos']['photo'], 0, $photoCount);
    
    for($i = 0;$i < count($slicedPhotos);$i++){
        $link = "https://farm" . $slicedPhotos[$i]['farm'] . ".staticflickr.com/" . $slicedPhotos[$i]['server'] . "/" . $slicedPhotos[$i]['id'] . "_" . $slicedPhotos[$i]['secret'] . "_b.jpg";
        printf("<img class='flickr_img' id='flickr_" . $i . "'src='" . $link . "' alt='" . $slicedPhotos[$i]['title'] . "' style='display: none;'>");
    }
?>
</div>