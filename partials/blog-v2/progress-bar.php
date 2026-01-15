<?php
/**
 * Template Part: Blog V2 Progress Bar (Flexible Content)
 * Structural markup for scroll progress indicator
 * Designed to be used within a flexible content loop
 * Reads ACF fields: enable_progress_bar, progress_bar_color
 */

$enable_progress_bar = false;
$progress_bar_color = '';

if ( function_exists( 'get_sub_field' ) ) {
    $enable_progress_bar = get_sub_field( 'enable_progress_bar' );
    $progress_color = get_sub_field( 'progress_bar_color' );
    
    if ( $progress_color ) {
        $progress_bar_color = $progress_color;
    }
}

if ( $enable_progress_bar ) :
?>

<div id="blog-hero-progress-bar" class="blog-v2-progress"<?php if ( $progress_bar_color ) : ?> data-progress-color="<?php echo esc_attr( $progress_bar_color ); ?>"<?php endif; ?>>
    <span id="blog-hero-progress-fill" class="blog-v2-progress__bar"></span>
</div>

<?php endif; ?>
