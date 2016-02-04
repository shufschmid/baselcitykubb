<?php
/*
Template Name: Allebeitraege
*/
get_header(); ?>

    <div id="container">
        <div id="content" role="main">

            <?php the_post(); ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>

            <?php get_search_form(); ?>

            <h2>Monatsarchiv:</h2>
            <ul>
                <?php wp_get_archives('type=monthly'); ?>
            </ul>

            <h2>Einträge nach Kategorie:</h2>
            <ul>
                <?php wp_list_categories(); ?>
            </ul>

        </div><!-- #content -->
    </div><!-- #container -->

<?php get_footer(); ?>