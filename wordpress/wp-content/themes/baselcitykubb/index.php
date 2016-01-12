<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package baselcitykubb
 */
get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
    <?php
    //live - am Tag des Turniers wird ein spezifischer Twitter-Feed eingeblendet
    get_template_part( 'template-parts/content_startseite_live');

    if ( have_posts() ) :
		/* Start the Loop */
		while ( have_posts() ) : the_post();
            //funktioniert noch nicht: saubere Abfrage, ggf. über function mit rückgabewert $live ???
            if( $wp_query->current_post == 0 && $live==false) {
                //grosses Vorschaubild + Titel gross
                get_template_part( 'template-parts/content_teaserbig');
            }
            //weitere Einträge anzeigen (aktuell: 2)
            elseif ($wp_query->current_post < 3){
                get_template_part( 'template-parts/content_teasersmall');
            }
            //swiper für kubbtour- & liga-statistiken
            elseif($wp_query->current_post == 3){
                get_template_part( 'template-parts/liga_startseite');
            }
        endwhile;

	else :
		get_template_part( 'template-parts/content', 'none' );

	endif; ?>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLpEndZeRoN89bDThQltSufOM922v3vTeq" frameborder="0" allowfullscreen></iframe>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();