<?php
/*
Template Name: Full Width Page
Template post Type: page, post
*/

get_header(); ?>

<div id="content" style="width: 100%;">

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
            <?php
        endwhile;
    else :
        echo '<p>No content found.</p>';
    endif;
    ?>

    suport service group

</div>

<?php get_footer(); ?>