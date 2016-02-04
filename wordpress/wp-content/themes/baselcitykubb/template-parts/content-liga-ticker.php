<?php

// Open the file to get existing content
//$ticker = file_get_contents('ticker.txt');
?>

<ul id="ticker01" style="visibility:hidden">
    <?php include(get_template_directory()."/ticker.txt");?>
</ul>


    <script type="text/javascript">
    jQuery(function($) {
            $("ul#ticker01").liScroll();
    });
    setTimeout(function(){document.getElementById('ticker01').style.visibility = 'visible';}, 1500);

    </script>
