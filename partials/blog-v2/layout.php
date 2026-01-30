<?php
/**
 * Template Part: Blog V2 Layout
 * Main content area with 3-column structure (left sidebar, main, right sidebar).
 * No ACF; always renders for single posts.
 */
?>

<div class="blog-v2-layout">
    <?php get_template_part( 'partials/blog-v2/sidebar-left' ); ?>

    <main class="blog-v2-content">
        <?php the_content(); ?>
        <?php get_template_part( 'partials/blog-v2/about-creator-inline' ); ?>
    </main>

    <?php get_template_part( 'partials/blog-v2/sidebar-right' ); ?>
</div>
