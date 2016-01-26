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
<div id="primary" class="content-area<?php if ( is_admin_bar_showing() ) { ?> wp-toolbar-active<?php } ?>">
	<main id="main" class="site-main" role="main">
    <?php
    //live - am Tag des Turniers wird ein spezifischer Twitter-Feed eingeblendet
    get_template_part( 'template-parts/content_startseite_live');

    if ( have_posts() ) :
		/* Start the Loop */
		while ( have_posts() ) : the_post();
            //erster Eintrag
            if( $wp_query->current_post == 0) {
                //wenn der aktuellste Beitrag = "#kubblive" ist:
                if($post->post_name == "kubblive"){
                    ?><a class="twitter-timeline" href="https://twitter.com/hashtag/kubblive" data-widget-id="685860130982871041">#kubblive-Tweets</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    <?php
                    }
                else{
                    //grosses Vorschaubild + Titel gross
                    get_template_part('template-parts/content_teaserbig');
                }
            }
            //div einblenden für "weitere beiträge laden"
            if($wp_query->current_post == 2){?>
                <div style="clear:both;width:100%;text-align: center">
                <a onclick="toggle_visibility('weiterebeitraege');">weitere Beiträge laden</a></div>
                <div id="weiterebeitraege" style="display:none"><?php
                }
            //weitere Einträge anzeigen (aktuell: 2)
            elseif ($wp_query->current_post < 9){
                get_template_part( 'template-parts/content_teasersmall');
            }
            //versteckte elemente laden
            //swiper für kubbtour- & liga-statistiken
            elseif($wp_query->current_post == 9){
                //Beiträge-Archiv-Link + div-element für versteckte beiträge schliessen
                ?>
                <div style="clear:both;width:100%;text-align: center">
                    <a href="category/turnier-report/">Zum Archiv</a></div>
                <div id="weiterebeitraege" style="display:none">
                </div>
                </div>
                <?php
                get_template_part( 'template-parts/content_startseite_swiper');
            }
        endwhile;

	else :
		get_template_part( 'template-parts/content', 'none' );

	endif;

    get_template_part('template-parts/kauftipp_kubbsets');
    ?>


        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- baselcitykubb_2016 -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-0452836655226597"
             data-ad-test="on"
             data-ad-slot="7417708037"
             data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLpEndZeRoN89bDThQltSufOM922v3vTeq" frameborder="0" allowfullscreen></iframe>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();