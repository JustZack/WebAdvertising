<div id="FlickrWrapper">
    <script src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../Styles/Css_Reset.css">
    <script>
        $(document).ready(function(){

            var flickrCount = $(".flickr_img").length;
            var current = -1;


            $(window).on('load', function(){
                setImgSizes();
            });
            $(window).resize(function(){
                setImgSizes(true);
            });
            function setImgSizes(resize = false){
                $(".flickr_img").each(function(){
                    var w,h;
                    if(resize){
                        $(this).attr({'width' : ''});
                        $(this).attr({'height' : ''});
                    }
                    w = $(this).width();
                    h = $(this).height();
                    var docW = $(document).width();
                    var docH = $(document).height();

                    wPercent = w / docW;
                    hPercent = h / docH;
                    
                    if(wPercent > hPercent){
                        //Use the height as our main scalar
                        $(this).attr('height', docH);
                    } else if(hPercent > wPercent){
                        //Use the width as our main scalar 
                        $(this).attr('width', docW);                                    
                    }
                    
                });
            }

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
        background-color: black;
        overflow: hidden;
    }
    div#FlickrWrapper{
        height: 100%;
        width: 100%;
    }
    img.flickr_img{
        opacity: 0;
        position: absolute;
    }
</style>
<?php
    include_once "../../phpflickr/phpFlickr.php";

    $key = "896d1118c1152cc3920ed92cbaabc5bd";
    $secret = "b77404c58fb85a28";
    $photoCount = $_GET['photoCount'];

    $flickr = new phpFlickr($key, $secret);
    $userID = $flickr->people_findByUsername("coloradostateuniversity")['id'];
    $photos = $flickr->people_getPhotos($userID, array('tags'=>'LSC, Lory Student Center','tag_mode'=>'any','per_page'=>500, 'min_taken_date'=>'2015-9-1 00:00:00'));
    /* Shuffle the array of 500 images */
    shuffle($photos['photos']['photo']);
    $slicedPhotos = array_slice($photos['photos']['photo'], 0, $photoCount);
    
    for($i = 0;$i < count($slicedPhotos);$i++){
        $link = "https://farm" . $slicedPhotos[$i]['farm'] . ".staticflickr.com/" . $slicedPhotos[$i]['server'] . "/" . $slicedPhotos[$i]['id'] . "_" . $slicedPhotos[$i]['secret'] . "_b.jpg";
        printf("<img class='flickr_img' id='flickr_" . $i . "'src='" . $link . "' alt='" . $slicedPhotos[$i]['title'] . "' style='display: none;'>");
    }
?>
</div>