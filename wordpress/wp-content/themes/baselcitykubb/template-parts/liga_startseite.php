<?php ?><script src="<?php bloginfo('template_directory'); ?>/inc/js/swiper.jquery.min.js"></script>
<h2><a href="/liga/">Kubbliga</a></h2>
<!-- Slider main container -->
<div class="swiper-container">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide" style="background-color: #029DD6">

        <?php get_template_part( 'template-parts/content-liga-formular');?>

        </div>
        <div class="swiper-slide">
            <table>
            <?php
            $json_data = file_get_contents("http://kubbtour.ch/inc_content/api_rank2.php?data=tour&year=0&view=json");
            $json_data = json_decode(substr($json_data,1,-3), true);
            $index = 1;
            foreach($json_data["results"] as $data){
                echo "<tr><td class=\"ranking_cell\">".$index."</td><td class=\"ranking_cell\">".substr($data["teamname"],0,17)."</td><td class=\"ranking_cell\">".$data["points"]."</td></tr>";

                //var_dump($data[1]["teamname"]);
                $index++;
            }
            //var_dump($json_data);
            ?>
</table>
        </div>
        <div class="swiper-slide">Slide 3</div>
        ...
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

    <!-- If we need scrollbar -->
    <div class="swiper-scrollbar"></div>
</div>



<script type="text/javascript" charset="utf-8">// lädt startseiten-swiper
    var mySwiper = new Swiper ('.swiper-container', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 2,
        paginationClickable: true,
        spaceBetween: 30,
        // If we need pagination
        pagination: '.swiper-pagination',

        // Navigation arrows
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',

        // And if we need scrollbar
        scrollbar: '.swiper-scrollbar',
    })
</script>

