<?php
/**
 * Template Part: Blog V2 Right Sidebar
 * About The Creator, About The Reviewer, whitepaper card (related or default page), compliance CTA.
 * No ACF; no card.php.
 */

// Whitepaper card: query pages in category "whitepapers", pick one related to current post title; if no match, use default page ID.
$blog_v2_whitepaper_fallback_id = 22046;
$current_post_title             = wp_strip_all_tags( get_the_title() );
$whitepaper_post                = null;

$wpq = new WP_Query( array(
    'post_type'      => 'page',
    'posts_per_page' => 30,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
    'tax_query'      => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'whitepapers',
        ),
    ),
) );

if ( $wpq->have_posts() ) {
    $whitepapers = array();
    while ( $wpq->have_posts() ) {
        $wpq->the_post();
        $whitepapers[] = get_post();
    }
    wp_reset_postdata();

    if ( ! empty( $whitepapers ) ) {
        $current_words = array_filter( array_map( 'strtolower', preg_split( '/\s+/', $current_post_title, -1, PREG_SPLIT_NO_EMPTY ) ) );
        $best_score    = 0;
        $best_index    = 0;

        foreach ( $whitepapers as $i => $wp_post ) {
            $wp_title = strtolower( wp_strip_all_tags( get_the_title( $wp_post ) ) );
            $score    = 0;
            foreach ( $current_words as $word ) {
                if ( strlen( $word ) > 2 && strpos( $wp_title, $word ) !== false ) {
                    $score++;
                }
            }
            if ( $score > $best_score ) {
                $best_score = $score;
                $best_index = $i;
            }
        }

        if ( $best_score > 0 ) {
            $whitepaper_post = $whitepapers[ $best_index ];
        } else {
            $fallback_post = get_post( $blog_v2_whitepaper_fallback_id );
            if ( $fallback_post && $fallback_post->post_status === 'publish' ) {
                $whitepaper_post = $fallback_post;
            }
        }
    }
}
?>

<aside class="blog-v2-sidebar blog-v2-sidebar--right">
    <div class="blog-v2-sidebar__author">
        <div class="blog-v2-sidebar__card">
            <h3 class="blog-v2-sidebar__title">About The Creator</h3>
            <?php
            $creator = function_exists( 'blog_v2_author_display_data' ) ? blog_v2_author_display_data() : array( 'name' => 'Pat Hartonian', 'job' => 'VP of Operations, GCheck', 'url' => get_template_directory_uri() . '/assets/images/pat-hat.png', 'link' => '#' );
            $creator_avatar_url = ! empty( $creator['url'] ) ? $creator['url'] : '';
            $creator_avatar_src = $creator_avatar_url && function_exists( 'blog_v2_avatar_url_for_display' ) ? blog_v2_avatar_url_for_display( $creator_avatar_url, 100 ) : $creator_avatar_url;
            ?>
            <div class="blog-v2-sidebar__author-container">
                <?php if ( $creator_avatar_src ) : ?>
                    <img src="<?php echo esc_url( $creator_avatar_src ); ?>" alt="<?php echo esc_attr( $creator['name'] ); ?>" class="blog-v2-sidebar__avatar" width="50" height="50" loading="lazy" fetchpriority="low">
                <?php else : ?>
                    <div class="blog-v2-sidebar__avatar blog-v2-sidebar__avatar--initials" style="background-color:<?php echo esc_attr( isset( $creator['color'] ) ? $creator['color'] : '#6B7280' ); ?>"><?php echo esc_html( isset( $creator['initials'] ) ? $creator['initials'] : '' ); ?></div>
                <?php endif; ?>
                <div class="blog-v2-sidebar__author-info">
                    <div class="blog-v2-sidebar__author-name-wrapper">
                        <?php $creator_link = ! empty( $creator['link'] ) ? $creator['link'] : '#'; ?>
                        <span><a href="<?php echo esc_url( $creator_link ); ?>" style="text-decoration: none; color: inherit;"><?php echo esc_html( $creator['name'] ); ?></a></span>
                        <a href="<?php echo esc_url( ! empty( $creator['link'] ) ? $creator['link'] : '#' ); ?>" class="blog-v2-sidebar__linkedin" aria-label="<?php echo esc_attr( $creator['name'] . ' LinkedIn profile' ); ?>">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/linkedin.png' ); ?>" alt="LinkedIn" width="16" height="16" loading="lazy">
                        </a>
                    </div>
                    <?php if ( ! empty( $creator['job'] ) ) : ?><span><?php echo esc_html( $creator['job'] ); ?></span><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    $reviewer = function_exists( 'blog_v2_reviewer_display_data' ) ? blog_v2_reviewer_display_data() : null;
    if ( $reviewer ) :
        if ( empty( $reviewer['avatar'] ) ) {
            $reviewer['avatar'] = get_template_directory_uri() . '/assets/images/charm-paz.png';
        }
        $reviewer_avatar_src = function_exists( 'blog_v2_avatar_url_for_display' ) ? blog_v2_avatar_url_for_display( $reviewer['avatar'], 100 ) : $reviewer['avatar'];
        $reviewer_link = ! empty( $reviewer['link'] ) ? $reviewer['link'] : '#';
        $reviewer_linkedin = ! empty( $reviewer['linkedin'] ) ? $reviewer['linkedin'] : '';
    ?>
    <div class="blog-v2-sidebar__reviewer">
        <div class="blog-v2-sidebar__card">
            <h3 class="blog-v2-sidebar__title">About The Reviewer</h3>
            <div class="blog-v2-sidebar__author-container">
                <img src="<?php echo esc_url( $reviewer_avatar_src ); ?>" alt="<?php echo esc_attr( $reviewer['name'] ); ?>" class="blog-v2-sidebar__avatar" width="50" height="50" loading="lazy" fetchpriority="low">
                <div class="blog-v2-sidebar__author-info">
                    <div class="blog-v2-sidebar__author-name-wrapper">
                        <span><a href="<?php echo esc_url( $reviewer_link ); ?>" style="text-decoration: none; color: inherit;"><?php echo esc_html( $reviewer['name'] ); ?></a></span>
                        <?php if ( $reviewer_linkedin !== '' ) : ?>
                        <a href="<?php echo esc_url( $reviewer_linkedin ); ?>" class="blog-v2-sidebar__linkedin" aria-label="<?php echo esc_attr( $reviewer['name'] . ' LinkedIn profile' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/linkedin.png' ); ?>" alt="LinkedIn" width="16" height="16" loading="lazy">
                        </a>
                        <?php endif; ?>
                    </div>
                    <span><?php echo esc_html( $reviewer['job'] ); ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ( $whitepaper_post ) : ?>
    <div class="blog-v2-cards-container cols1 blog-v2-cards-container--whitepaper">
        <div class="blog-v2-card blog-v2-card--whitepaper">
            <div class="blog-v2-card__content">
                <span class="blog-v2-card_whitepaper-heading-prefix">Whitepaper</span>
                <h4 class="blog-v2-card__whitepaper-heading"><?php echo esc_html( get_the_title( $whitepaper_post ) ); ?></h4>
                <a href="<?php echo esc_url( get_permalink( $whitepaper_post ) ); ?>" class="blog-v2-card__btn" aria-label="Download PDF">Download PDF</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</aside>
