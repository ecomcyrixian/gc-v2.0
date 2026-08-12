<?php
/**
 * Template Part: Blog V2 Layout
 * Main content area with 3-column structure (left sidebar, main, right sidebar).
 * No ACF; always renders for single posts.
 */
$toc_items = function_exists( 'blog_v2_get_toc_items' ) ? blog_v2_get_toc_items( get_the_ID() ) : array();
$has_toc   = ! empty( $toc_items );
?>

<div class="blog-v2-layout<?php echo $has_toc ? '' : ' blog-v2-layout--no-left'; ?>">
    <?php if ( $has_toc ) : ?>
        <?php get_template_part( 'partials/blog-v2/sidebar-left' ); ?>
    <?php endif; ?>

    <main class="blog-v2-content">
        <?php the_content(); ?>
        <?php get_template_part( 'partials/blog-v2/about-creator-inline' ); ?>
    </main>

    <?php get_template_part( 'partials/blog-v2/sidebar-right' ); ?>
</div>
