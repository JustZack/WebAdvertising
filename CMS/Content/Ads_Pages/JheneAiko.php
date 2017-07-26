<div id="JheneWrapper">
    <script src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../../../WebAdvertising/CMS/Styles/Css_Reset.css">
    <script>
        /*$(document).ready(function(){
            var videoLength = 267;
            var iframeSRC;
            setTimeout(function() {
                iframeSRC = $("iframe").attr('src');
                resetIframe(); 
            }, 1000);

            function resetIframe(){
                $("iframe").attr('src', iframeSRC);
                $("iframe").attr('src', iframeSRC  + "?rel=0&autoplay=1");   
                setTimeout(function() {
                    resetIframe();
                }, videoLength * 1000);           
            }
        });*/
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
        #JheneWrapper{
            width: 100%;
            height: 100%;
        }
        iframe, h1, img{
            position: absolute;
        }
        iframe{
            width: 100%;
            height: 100%;
        }
        h1{
            text-align: center;
            bottom: 0;
            width: 100%;
            height: 250px;
            font-size: 50px;
            color: green;
        }
        img{
            width: 100%;
            object-fit: cover;
            bottom: 0;
        }
    </style>
    <?php 
        $play;
        $toAdd = "?autoplay=";
        if(isset($_GET['play'])){
            $toAdd .= $_GET['play'];
        } else {
            $toAdd .= '0';
        }
    ?>
    <!-- the youtube video itself -->
    <iframe src=<?php echo "https://www.youtube.com/embed/LOmFqEHUMvo" . $toAdd . "" ?> frameborder="0"></iframe>
    <!-- A text heading for the image, if we want it -->
    <h1></h1>
    <!-- The image overlay we want on the image -->
    <img src="" alt="">
</div>