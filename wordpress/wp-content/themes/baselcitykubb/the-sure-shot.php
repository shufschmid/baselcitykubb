<?php

/**
 * Template-File für die Sure-Shot-Seite.
 * Template Name: the-sure-shot
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package baselcitykubb
 */

get_header(); ?>

    <div id="primary" class="content-area<?php if ( is_admin_bar_showing() ) { ?> wp-toolbar-active<?php } ?>">
        <main id="main" class="site-main" role="main">

            <?php
            while ( have_posts() ) : the_post();

                get_template_part( 'template-parts/content', 'page' );

            endwhile; // End of the loop.

            ?>

            <h3>Hall of Fame:</h3>
            <script src="<?php bloginfo('template_directory'); ?>/inc/js/swiper.jquery.min.js"></script>
            <!-- Slider main container -->
            <div class="swiper-container" style="height:60%;">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <?php
                    query_posts('tag=sureshot&posts_per_page=-1');
                    while (have_posts()) : the_post();?>
                        <div class="swiper-slide">
                            <a href="<?php echo esc_url( get_permalink() );?>"rel="bookmark" style="color:black;text-decoration: none">
                                <?php
                                $key_1_value = get_post_meta( get_the_ID(), 'sureshot', true );
                                the_post_thumbnail();
                                ?><div style="width:100%;position:relative;top:-30px;background-color: #029DD6;text-align: center"><?php
                                    echo $key_1_value;
                                    ?></div>
                            </a>
                        </div>
                    <?php
                    endwhile;
                    ?>
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
                    paginationClickable: true,
                    spaceBetween: 1,
                    // If we need pagination
                    pagination: '.swiper-pagination',

                    // Navigation arrows
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',

                    // And if we need scrollbar
                    scrollbar: '.swiper-scrollbar'
                });
            </script>

            <h3>Aktuelle Beiträge:</h3><?php
            $aktuellesjahr = date("Y");


            $codeaktuelleposts = "cat=6&year=".$aktuellesjahr;
            query_posts($codeaktuelleposts);
while (have_posts()) : the_post();
    get_template_part( 'template-parts/content_teasersmall');
endwhile;

            ?>


            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
