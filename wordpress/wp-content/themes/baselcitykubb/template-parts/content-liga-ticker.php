<?php

// Open the file to get existing content
//$ticker = file_get_contents('ticker.txt');
?>
<script src="<?php bloginfo('template_directory'); ?>/inc/js/jquery.li-scroller.1.0.js"></script>
<ul id="ticker01">
    <li><span>10/10/2007</span><a href="#">The first thing ...</a></li>
    <li><span>10/10/2007</span><a href="#">End up doing is ...</a></li>
    <li><span>10/10/2007</span><a href="#">The code that you ...</a></li>
    <!-- eccetera -->
</ul>


    <script type="text/javascript">
    jQuery(function($) {
            $("ul#ticker01").liScroll();
    });
</script>
