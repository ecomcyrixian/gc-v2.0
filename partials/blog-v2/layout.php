<?php
/**
 * Template Part: Blog V2 Layout
 * Main content area with 3-column structure
 * Only renders when use_blog_v2 is enabled
 */

if ( function_exists( 'get_field' ) ) {
    $use_blog_v2 = get_field( 'use_blog_v2' );
    if ( ! $use_blog_v2 ) {
        return;
    }
}
?>

<div class="blog-v2-layout">
    <?php get_template_part( 'partials/blog-v2/sidebar-left' ); ?>

    <main class="blog-v2-content">
        <?php the_content(); ?>
    </main>
    <?php get_template_part( 'partials/blog-v2/sidebar-right' ); ?>
</div>
