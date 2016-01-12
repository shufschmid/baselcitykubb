<?php
/*
Template Name: develliga
*/


    chdir('wp-admin/liga');
    $file = 'ticker.txt';
    // Open the file to get existing content
    $ticker = file_get_contents($file);
    ?>

    <a href="http://www.baselcitykubb.ch/develliga" style="float: left;
    width: auto;
    color: #5d5d5d;
    font-size: 26px;
    font-family: 'Source Sans Pro', sans-serif;
    line-height: 30px;
    font-weight: lighter;
    -webkit-transition: color 120ms linear;
    -moz-transition: color 120ms linear;
    transition: color 120ms linear;">Kubb-Liga</a>
        <FORM NAME="marquee1">
            <INPUT NAME="text" SIZE=25
                   VALUE="
                   <?php
                   echo $ticker;
?>"
                >
        </FORM>
    <SCRIPT>
        <!--
        /*Text box marquee by Dave Methvin,
         Windows Magazine
         May be used/modified if credit line is
         retained*/
        ScrollSpeed = 100
        ScrollChars = 1
        function ScrollMarquee() {
            window.setTimeout('ScrollMarquee()',ScrollSpeed);

            var msg = document.marquee1.text.value;
            document.marquee1.text.value =
                msg.substring(ScrollChars) +
                msg.substring(0,ScrollChars);
        }
        ScrollMarquee()
        //-->
    </SCRIPT>


