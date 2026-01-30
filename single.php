<?php
/**
 * Single Post Template
 * Blog V2 layout is the default for all single posts.
 * No ACF; content from Gutenberg only.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        get_template_part( 'partials/blog-v2/page-hero' );
        get_template_part( 'partials/blog-v2/progress-bar' );
        get_template_part( 'partials/blog-v2/layout' );
    endwhile;
endif;

?>
<div class="blog-v2-footer-sections">
    <section class="blog-v2-cta">
        <div class="blog-v2-cta__inner">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/home-header-bg.jpg' ); ?>" alt="" class="blog-v2-cta__bg-image">
            <div class="blog-v2-cta__content">
                <h2>Need Fast Background Checks Without Compromising Accuracy?</h2>
                <p><span>Contact us today</span> for efficient, FCRA-compliant screening solutions<br/> designed to keep your hiring process moving safely and smoothly.</p>
                <div class="blog-v2-cta__buttons">
                    <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="button blue">Start Free Trial</a>
                    <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="button white">Book A Demo</a>
                </div>
            </div>
        </div>
    </section>

    <div class="latest-articles blog-v2-related">
        <div class="container">
            <div class="heading">
                <h2>
                    <span>From the blog</span>
                    Related Articles
                </h2>
            </div>
            <div class="cards">
                <div class="card-cont cols3">
                    <?php
                    $current_post_id = get_the_ID();
                    $recent_posts = null;

                    $categories = get_the_category( $current_post_id );
                    if ( ! empty( $categories ) ) {
                        $category_ids = array_map( function( $cat ) { return $cat->term_id; }, $categories );
                        $args = array(
                            'posts_per_page' => 3,
                            'post_type'      => 'post',
                            'post__not_in'   => array( $current_post_id ),
                            'category__in'   => $category_ids,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );
                        $recent_posts = new WP_Query( $args );
                    }

                    if ( ! $recent_posts || ! $recent_posts->have_posts() ) {
                        $tags = get_the_tags( $current_post_id );
                        if ( ! empty( $tags ) ) {
                            $tag_ids = array_map( function( $tag ) { return $tag->term_id; }, $tags );
                            $args = array(
                                'posts_per_page' => 3,
                                'post_type'      => 'post',
                                'post__not_in'   => array( $current_post_id ),
                                'tag__in'        => $tag_ids,
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                            );
                            $recent_posts = new WP_Query( $args );
                        }
                    }

                    if ( ! $recent_posts || ! $recent_posts->have_posts() ) {
                        $args = array(
                            'posts_per_page' => 3,
                            'post_type'      => 'post',
                            'post__not_in'   => array( $current_post_id ),
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        );
                        $recent_posts = new WP_Query( $args );
                    }

                    if ( $recent_posts->have_posts() ) :
                        while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
                            $post_date = get_the_date( 'j M, Y' );
                            $word_count = str_word_count( strip_tags( get_the_content() ) );
                            $reading_time = ceil( $word_count / 200 );
                    ?>
                        <div>
                            <span class="featured-image">
                                <img src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title(); ?>">
                            </span>
                            <div class="articles-info">
                                <span class="category">
                                    <?php
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) {
                                        $category = $categories[0];
                                        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" rel="category tag">';
                                        echo esc_html( $category->name );
                                        echo '</a>';
                                    }
                                    ?>
                                </span>
                                <h4>
                                    <a class="title" href="<?php echo get_permalink(); ?>" aria-label="<?php the_title(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <span class="read-time">
                                    <span class="post-date"><?php echo $post_date; ?></span>
                                    <strong>•</strong>
                                    <span class="reading-time"><?php echo $reading_time; ?> min read</span>
                                </span>
                                <div class="description">
                                    <?php echo wp_trim_words( get_the_excerpt(), 50, '...' ); ?>
                                </div>
                                <span class="btn">
                                    <a class="button readmore" href="<?php echo get_permalink(); ?>">Read More</a>
                                </span>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="legal-disclaimer">
        <p><strong>LEGAL DISCLAIMER: </strong>The information provided in this article is for general informational and educational purposes only and should not be construed as legal advice or a substitute for consultation with qualified legal counsel. While we strive to ensure accuracy, employment screening laws and regulations—including but not limited to the Fair Credit Reporting Act (FCRA), Equal Employment Opportunity Commission (EEOC) guidelines, state and local ban-the-box laws, industry-specific requirements, and other applicable federal, state, and local statutes—are subject to frequent changes, varying interpretations, and jurisdiction-specific applications that may affect their implementation in your organization. Employers and screening decision-makers are solely responsible for ensuring their background check policies, procedures, and practices comply with all applicable laws and regulations relevant to their specific industry, location, and circumstances. We strongly recommend consulting with qualified employment law attorneys and compliance professionals before making hiring, tenant screening, or other decisions based on background check information.</p>
    </div>
</div>

<?php get_footer(); ?>
