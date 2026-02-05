<?php
/**
 * Template Part: Blog V2 Related Article (inline above References/About The Creator)
 * Queries one related post only: same category + keyword match, else any recent + keyword, else random.
 * Reuses article-card markup.
 */

$current_post_id   = get_the_ID();
$current_post_title = wp_strip_all_tags( get_the_title() );
$related_post       = null;

$base_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 30,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
    'post__not_in'   => array( $current_post_id ),
);

// 1) Same category
$categories = get_the_category( $current_post_id );
if ( ! empty( $categories ) ) {
    $category_ids = array_map( function( $c ) { return $c->term_id; }, $categories );
    $args         = array_merge( $base_args, array( 'category__in' => $category_ids ) );
    $q            = new WP_Query( $args );
    if ( $q->have_posts() ) {
        $candidates = array();
        while ( $q->have_posts() ) {
            $q->the_post();
            $candidates[] = get_post();
        }
        wp_reset_postdata();
        $related_post = blog_v2_pick_related_post( $candidates, $current_post_title );
    }
}

// 2) No same-category match: any recent posts, score by title
if ( ! $related_post ) {
    $q = new WP_Query( $base_args );
    if ( $q->have_posts() ) {
        $candidates = array();
        while ( $q->have_posts() ) {
            $q->the_post();
            $candidates[] = get_post();
        }
        wp_reset_postdata();
        $related_post = blog_v2_pick_related_post( $candidates, $current_post_title );
    }
}

if ( ! $related_post ) {
    return;
}

set_query_var( 'article_post_id', $related_post->ID );
?>

<section class="blog-v2-related-article-inline" aria-label="Related Article">
    <?php get_template_part( 'partials/blog-v2/article-card' ); ?>
</section>
