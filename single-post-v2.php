<?php
/**
 * Single Post V2 Template
 * New blog post design template with 3-column layout
 * All classes prefixed with blog-v2- for future CSS styling
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        
        if ( function_exists( 'have_rows' ) && have_rows( 'blog_v2_layout' ) ) :
            while ( have_rows( 'blog_v2_layout' ) ) : the_row();
                
                if ( get_row_layout() == 'page_hero' ) :
                    get_template_part( 'partials/blog-v2/page-hero' );
                
                elseif ( get_row_layout() == 'progress_bar' ) :
                    get_template_part( 'partials/blog-v2/progress-bar' );
                
                endif;
                
            endwhile;
        endif;
        
        get_template_part( 'partials/blog-v2/layout' );
        
    endwhile;
endif;

$right_sidebar_cards = '';
$current_post_id = get_the_ID();
if ( function_exists( 'have_rows' ) && function_exists( 'get_field' ) ) {
    if ( have_rows( 'blog_v2_layout', $current_post_id ) ) {
        ob_start();
        while ( have_rows( 'blog_v2_layout', $current_post_id ) ) : the_row();
            if ( get_row_layout() == 'card' ) {
                $card_position = get_sub_field( 'position' );
                if ( $card_position && strtolower( trim( $card_position ) ) == 'right' ) {
                    set_query_var( 'sidebar_position', 'right' );
                    get_template_part( 'partials/blog-v2/card' );
                }
            }
        endwhile;
        $right_sidebar_cards = ob_get_clean();
    }
}

// CTA Section, Related Articles, Disclaimer, and Footer wrapper
?>
<div class="blog-v2-footer-sections">
    <?php
    if ( ! empty( $right_sidebar_cards ) ) :
    ?>
    <div class="blog-v2-mobile-cards">
        <?php echo $right_sidebar_cards; ?>
    </div>
    <?php endif; ?>
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
                    $current_title = get_the_title();
                    $current_content = get_the_content();
                    
                    $text = $current_title . ' ' . strip_tags($current_content);
                    $text = strtolower($text);
                    
                    $common_words = array('the', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'a', 'an', 'is', 'are', 'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'should', 'could', 'may', 'might', 'must', 'can', 'this', 'that', 'these', 'those', 'i', 'you', 'he', 'she', 'it', 'we', 'they');
                    $words = str_word_count($text, 1);
                    $keywords = array_diff($words, $common_words);
                    $keywords = array_filter($keywords, function($word) {
                        return strlen($word) > 3; 
                    });
                    
                    $word_counts = array_count_values($keywords);
                    arsort($word_counts);
                    $top_keywords = array_slice(array_keys($word_counts), 0, 10);
                    
                    $search_terms = implode(' ', $top_keywords);
                    
                    $args = array(
                        'posts_per_page' => 3,
                        'post_type'      => 'post',
                        'orderby'        => 'relevance',
                        'order'          => 'DESC',
                        'post__not_in'   => array( get_the_ID() ),
                        's'              => $search_terms, 
                    );
                    $recent_posts = new WP_Query($args);
                    
                    if ($recent_posts->have_posts()) : 
                        while ($recent_posts->have_posts()) : $recent_posts->the_post();
                            $post_date = get_the_date('j M, Y');
                            $word_count = str_word_count(strip_tags(get_the_content()));
                            $reading_time = ceil($word_count / 200);
                    ?>
                        <div>
                            <span class="featured-image">
                                <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                            </span>
                            <div class="articles-info">
                                <span class="category">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        $category = $categories[0];
                                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" rel="category tag">';
                                        echo esc_html($category->name);
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
                                    <?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?>
                                </div>
                                <span class="btn">
                                    <a class="button readmore" href="<?php echo get_permalink(); ?>">Read More</a>
                                </span>
                            </div>
                        </div>
                    <?php 
                        endwhile; 
                        wp_reset_postdata();
                    else: 
                    ?>
                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
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
