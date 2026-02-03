<?php
/**
 * Template Part: Blog V2 Right Sidebar
 * About The Creator, About The Reviewer, whitepaper card (related or random), compliance CTA.
 * No ACF; no card.php.
 */

// Whitepaper card: query pages in category "whitepapers", pick one related to current post title or random.
$current_post_title = wp_strip_all_tags( get_the_title() );
$whitepaper_post    = null;

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

        $whitepaper_post = $best_score > 0 ? $whitepapers[ $best_index ] : $whitepapers[ array_rand( $whitepapers ) ];
    }
}
?>

<aside class="blog-v2-sidebar blog-v2-sidebar--right">
    <div class="blog-v2-sidebar__author">
        <div class="blog-v2-sidebar__card">
            <h3 class="blog-v2-sidebar__title">About The Creator</h3>
            <?php
            $author = blog_v2_author_display_data();
            $author_linkedin = '#';
            if ( isset( $author['avatar'] ) && $author['avatar'] === 'pat' ) {
                $author_id_for_linkedin = (int) get_post_field( 'post_author', get_the_ID() );
                if ( $author_id_for_linkedin ) {
                    $author_linkedin = get_the_author_meta( 'linkedin', $author_id_for_linkedin );
                    $author_linkedin = is_string( $author_linkedin ) ? trim( $author_linkedin ) : '';
                }
                if ( empty( $author_linkedin ) ) {
                    $author_linkedin = '#';
                }
            }
            ?>
            <div class="blog-v2-sidebar__author-container">
                <?php if ( ! empty( $author['avatar'] ) && $author['avatar'] === 'pat' && ! empty( $author['url'] ) ) : ?>
                    <img src="<?php echo esc_url( $author['url'] ); ?>" alt="<?php echo esc_attr( $author['name'] ); ?>" class="blog-v2-sidebar__avatar">
                <?php else : ?>
                    <span class="blog-v2-sidebar__initials blog-v2-sidebar__avatar" aria-hidden="true"<?php echo ! empty( $author['color'] ) ? ' style="background-color:' . esc_attr( $author['color'] ) . '; color: #fff;"' : ''; ?>><?php echo esc_html( $author['initials'] ); ?></span>
                <?php endif; ?>
                <div class="blog-v2-sidebar__author-info">
                    <div class="blog-v2-sidebar__author-name-wrapper">
                        <span><?php echo esc_html( $author['name'] ); ?></span>
                        <?php if ( $author_linkedin !== '' ) : ?>
                            <a href="<?php echo esc_url( $author_linkedin ); ?>" class="blog-v2-sidebar__linkedin" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/linkedin.png' ); ?>" alt="LinkedIn">
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $author['job'] ) ) : ?>
                        <span><?php echo esc_html( $author['job'] ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="blog-v2-sidebar__reviewer">
        <div class="blog-v2-sidebar__card">
            <div class="blog-v2-sidebar__title">About The Reviewer</div>
            <?php
            $reviewer_name = 'Charm Paz, CHRP';
            $reviewer_job = 'Recruiter and Editor, GCheck';
            $reviewer_avatar = get_template_directory_uri() . '/assets/images/charm-paz.png';
            ?>
            <div class="blog-v2-sidebar__author-container">
                <img src="<?php echo esc_url( $reviewer_avatar ); ?>" alt="<?php echo esc_attr( $reviewer_name ); ?>" class="blog-v2-sidebar__avatar">
                <div class="blog-v2-sidebar__author-info">
                    <div class="blog-v2-sidebar__author-name-wrapper">
                        <span><a href="https://gcheck.com/blog/author/charm/" style="text-decoration: none; color: inherit;"> <?php echo esc_html( $reviewer_name ); ?></a></span>
                        <a href="https://www.linkedin.com/in/charm-paz-554380203/" class="blog-v2-sidebar__linkedin" aria-label="LinkedIn">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/linkedin.png' ); ?>" alt="LinkedIn">
                        </a>
                    </div>
                    <span><?php echo esc_html( $reviewer_job ); ?></span>
                </div>
            </div>
        </div>
    </div>

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
