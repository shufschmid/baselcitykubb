<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package baselcitykubb
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/inc/css/swiper.min.css" type="text/css" media="screen" />
<?php wp_head(); ?>
<script type="text/javascript">
    <!--
    function toggle_visibility(id) {
        var e = document.getElementById(id);
        if(e.style.display == 'block')
            e.style.display = 'none';
        else
            e.style.display = 'block';
    }//-->
</script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <div id="content" class="site-content">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'baselcitykubb' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding<?php if ( is_admin_bar_showing() ) { ?> wp-toolbar-active<?php } ?>">
				<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

            <?php get_template_part( 'template-parts/content-liga-ticker');?></div>
			</div><!-- .site-branding -->
    </header><!-- #masthead -->


