<?php

// Open the file to get existing content
//$ticker = file_get_contents('ticker.txt');
?>
<script src="<?php bloginfo('template_directory'); ?>/inc/js/jquery.li-scroller.1.0.js"></script>
<ul id="ticker01">
    <?php include(get_template_directory()."/ticker.txt");?>
</ul>


    <script type="text/javascript">
    jQuery(function($) {
            $("ul#ticker01").liScroll();
    });
</script>
