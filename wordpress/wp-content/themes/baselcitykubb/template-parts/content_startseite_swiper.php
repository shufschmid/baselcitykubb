<?php ?><script src="<?php bloginfo('template_directory'); ?>/inc/js/swiper.jquery.min.js"></script>
    <!-- Slider main container -->
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">

            <!-- Slides -->
            <div class="swiper-slide">
                <?php get_template_part( 'template-parts/content_startseite_kubbtour-ranking');?>
            </div>
            <div class="swiper-slide">
                <?php get_template_part( 'template-parts/content_startseite_liga-ranking');?>

            </div>
            <div class="swiper-slide">
                <?php include(get_template_directory()."/startseite_stats.txt");?>
            </div>
            <div class="swiper-slide">
                 <table><tr><td colspan="3" class="swipertitle"><a href="/kalender/">Turniere</a></td> </tr></table>
                 <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=278&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=baselcitykubb%40gmail.com&amp;color=%231B887A&amp;ctz=Europe%2FZurich" style="border-width:0" width="250" height="255" frameborder="0" scrolling="no"></iframe>
            </div>

            ...
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- If we need scrollbar -->

    </div>



    <script type="text/javascript" charset="utf-8">// lädt startseiten-swiper
        var mySwiper = new Swiper ('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            slidesPerView: 2,
            paginationClickable: true,
            spaceBetween: 4,
            // If we need pagination
            pagination: '.swiper-pagination',

            // Navigation arrows
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',


        });
    </script>

<?php
/**
 * Created by PhpStorm.
 * User: shufschmid
 * Date: 15.01.2016
 * Time: 21:34
 */ 