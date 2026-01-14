<?php
/**
 * Template Part: Blog V2 Content
 * Renders the blog V2 layout structure
 * Used by both single-post-v2.php and page-blog-v2-preview.php
 */

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>

        <header class="blog-v2-hero">
            <h1 class="blog-v2-hero__title"><?php the_title(); ?></h1>
            <time class="blog-v2-hero__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                <?php echo get_the_date(); ?>
            </time>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="blog-v2-hero__image">
                    <?php the_post_thumbnail( 'full' ); ?>
                </div>
            <?php endif; ?>
            <div class="blog-v2-progress">
                <span></span>
            </div>
        </header>

        <main class="blog-v2-layout">
            <aside class="blog-v2-sidebar-left">
                <!-- Table of Contents placeholder -->
            </aside>

            <section class="blog-v2-main">
                <?php the_content(); ?>
            </section>

            <aside class="blog-v2-sidebar-right">
                <!-- Author widget placeholder -->
                <!-- Reviewer widget placeholder -->
            </aside>
        </main>

        <?php
    endwhile;
endif;
?>
