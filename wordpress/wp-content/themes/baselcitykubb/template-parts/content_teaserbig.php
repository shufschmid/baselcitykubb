<?php
/**
 * Template part for displaying the big teaser
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package baselcitykubb
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header"><h1 class="entry-title"><a href="<?php echo esc_url( get_permalink() );?> "rel="bookmark">
                <?php
                the_post_thumbnail();
                the_title( '', '</h1></a>');
                ?>
    </header><!-- .entry-header -->


</article><!-- #post-## -->