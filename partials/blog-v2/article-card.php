<?php
/**
 * Template Part: Blog V2 Article Card
 * Displays a blog post card with featured image, category, title, date, and author
 * Accepts post ID via query var or ACF field
 */

$post_id = get_query_var( 'article_post_id', null );

if ( ! $post_id && function_exists( 'get_sub_field' ) ) {
    $post_id = get_sub_field( 'post_id' );
}

if ( ! $post_id && function_exists( 'get_sub_field' ) ) {
    $post_id = get_sub_field( 'article' );
}

if ( ! $post_id || ! is_numeric( $post_id ) ) {
    return;
}

$post = get_post( $post_id );

if ( ! $post || $post->post_status !== 'publish' ) {
    return;
}

setup_postdata( $post );

$title = get_the_title( $post_id );
$permalink = get_permalink( $post_id );
$has_thumbnail = has_post_thumbnail( $post_id );
$date = get_the_date( 'd M Y', $post_id );

$author_name = '';
$author_url = '#';
if ( function_exists( 'blog_v2_author_display_data' ) ) {
    $creator = blog_v2_author_display_data( $post_id );
    if ( ! empty( $creator['name'] ) ) {
        $author_name = $creator['name'];
        $author_url = ! empty( $creator['link'] ) ? $creator['link'] : '#';
    }
}
if ( $author_name === '' ) {
    $author_id = get_post_field( 'post_author', $post_id );
    $author_name = get_the_author_meta( 'display_name', $author_id );
    $author_url = get_author_posts_url( $author_id );
}

$categories = get_the_category( $post_id );
$category_name = '';
if ( ! empty( $categories ) ) {
    $category_name = $categories[0]->name;
    $category_name = html_entity_decode( $category_name, ENT_QUOTES, 'UTF-8' );
}

wp_reset_postdata();
?>

<article class="blog-v2-article-card">
    <?php if ( $has_thumbnail ) : ?>
        <div class="blog-v2-article-card__image">
            <a href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read article: %s', 'gc-v2' ), $title ) ); ?>">
                <?php echo get_the_post_thumbnail( $post_id, 'medium', array(
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'sizes'    => '(max-width: 768px) 92vw, 200px',
                ) ); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="blog-v2-article-card__content">
        <?php if ( $category_name ) : ?>
            <div class="blog-v2-article-card__category">
                <?php echo esc_html( mb_strtoupper( $category_name, 'UTF-8' ) ); ?>
            </div>
        <?php endif; ?>
        
        <h3 class="blog-v2-article-card__title">
            <a href="<?php echo esc_url( $permalink ); ?>">
                <?php echo esc_html( $title ); ?>
            </a>
        </h3>
        
        <div class="blog-v2-article-card__meta">
            <span class="blog-v2-article-card__date"><?php echo esc_html( $date ); ?></span>
            <?php if ( $author_name ) : ?>
                <span class="blog-v2-article-card__separator">•</span>
                <span class="blog-v2-article-card__author">
                    by <a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a>
                </span>
            <?php endif; ?>
        </div>
    </div>
</article>
