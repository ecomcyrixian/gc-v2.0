<?php
/**
 * Template Part: Blog V2 About The Creator (inline at end of content)
 * Renders after the_content() in the main column.
 */
$creator = function_exists( 'blog_v2_author_display_data' ) ? blog_v2_author_display_data() : array( 'name' => 'Pat Hartonian', 'job' => 'VP of Operations, GCheck', 'url' => get_template_directory_uri() . '/assets/images/pat-hat.png', 'initials' => 'PH', 'color' => '#6B7280' );
$creator_avatar_url = ! empty( $creator['url'] ) ? $creator['url'] : '';
$creator_bio       = function_exists( 'blog_v2_creator_bio' ) ? blog_v2_creator_bio() : ( function_exists( 'blog_v2_default_gcheck_editorial_bio' ) ? blog_v2_default_gcheck_editorial_bio() : '' );
?>
<div class="wp-block-group _article-about-creator">
    <div class="blog-v2-about-creator__header">
        <div class="blog-v2-about-creator__avatar">
            <?php if ( $creator_avatar_url ) : ?>
                <img src="<?php echo esc_url( $creator_avatar_url ); ?>" alt="<?php echo esc_attr( $creator['name'] ); ?>">
            <?php else : ?>
                <div class="blog-v2-about-creator__initials" style="background-color:<?php echo esc_attr( isset( $creator['color'] ) ? $creator['color'] : '#6B7280' ); ?>"><?php echo esc_html( isset( $creator['initials'] ) ? $creator['initials'] : '' ); ?></div>
            <?php endif; ?>
        </div>
        <div class="blog-v2-about-creator__info">
            <div class="blog-v2-about-creator__label">ABOUT THE CREATOR</div>
            <div class="blog-v2-about-creator__name-wrapper">
                <h3 class="blog-v2-about-creator__name"><?php echo esc_html( $creator['name'] ); ?></h3>
            </div>
            <?php if ( ! empty( $creator['job'] ) ) : ?><p class="blog-v2-about-creator__job"><?php echo esc_html( $creator['job'] ); ?></p><?php endif; ?>
        </div>
    </div>
    <?php if ( $creator_bio !== '' ) : ?>
    <div class="blog-v2-about-creator__bio">
        <p><?php echo $creator_bio; ?></p>
    </div>
    <?php endif; ?>
</div>
