<?php
/*
Template Name: Two Column Page
 Template post Type: page, post
*/

get_header(); ?>

<div id="content" style="width: 70%; float: left;">

    <?php
    if ( have_posts() ) :
        while ( have_posts() : the_post();
            ?>
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
            <?php
        endwhile;
    else :
        echo '<p>No content found.</p>';
    endif;
    ?>

</div>

<aside id="sidebar" style="width: 28%; float: right; background: #f0f0f0; padding: 10px;">
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    <?php else : ?>
        <p>Add widgets to the sidebar in the admin area.</p>
    <?php endif; ?>
</aside>

<div style="clear: both;"></div>

<?php get_footer(); ?>