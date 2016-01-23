<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package baselcitykubb
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

            $post = $wp_query->post;
            if (in_category('7')) {
                include(TEMPLATEPATH.'/template-parts/content_turniere.php');
            }

            // If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
        <?php
        ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
