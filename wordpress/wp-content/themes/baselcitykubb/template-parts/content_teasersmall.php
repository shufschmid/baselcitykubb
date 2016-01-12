<?php ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="entry-header"><h3 class="entry-title"><a href="<?php echo esc_url( get_permalink() );?> "rel="bookmark">
            <?php the_post_thumbnail( 'thumbnail' );  the_title( '', '</h1></a>');?>
</header><!-- .entry-header -->
</article><!-- #post-## -->