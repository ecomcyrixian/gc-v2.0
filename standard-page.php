<?php
/*
 * Template Name: Standard Page
 * Description: Custom Single Page Template for all core website pages
 * Version: 2.0
 */
?>
<?php get_header(); ?>
<div id="standard-page">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                ?>
                    <div><?php the_content(); ?></div> 
                <?php
            endwhile;
        else :
            echo '<p>No posts found.</p>';
        endif;
        ?>
    </div>
</div>

<!-- ACF Configuration Widgets -->
<?php get_template_part( 'core-pages/config' ); ?>

<?php get_footer(); ?>