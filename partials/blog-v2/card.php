<?php
/**
 * Template Part: Blog V2 Card
 * Reusable card component for blog sidebars
 * Structure: Parent card with repeater of individual cards inside
 * Filters cards based on 'sidebar_position' query var
 */

// This template expects to be called from a flexible content loop
// where the parent card fields are available

// Get the sidebar position (left/right) passed from the calling template
$current_position = get_query_var( 'sidebar_position', '' );

// Get parent card fields
$card_position = get_sub_field( 'position' ); // Left or Right
$show_card = get_sub_field( 'with_background_image' ); // True/False
$columns = get_sub_field( 'columns' ); // 1, 2, 3, or 4

// Filter: Only show cards that match the current sidebar position (case-insensitive)
if ( $current_position && $card_position ) {
    $card_position_lower = strtolower( trim( $card_position ) );
    if ( $card_position_lower !== $current_position ) {
        return; // Skip this entire card layout
    }
}

// Check if background image should be shown (uses fixed blog-card-bg.png)
$has_bg_image = $show_card ? true : false;

// Check if cards repeater exists
if ( ! function_exists( 'have_rows' ) || ! have_rows( 'cards' ) ) {
    return;
}

// Determine column class
$col_class = 'cols1';
if ( $columns == 2 ) {
    $col_class = 'cols2';
} elseif ( $columns == 3 ) {
    $col_class = 'cols3';
} elseif ( $columns == 4 ) {
    $col_class = 'cols4';
}

// Start cards container
?>
<div class="blog-v2-cards-container <?php echo esc_attr( $col_class ); ?>">
    <?php while ( have_rows( 'cards' ) ) : the_row(); ?>
        <?php
        // Get individual card fields
        $heading = get_sub_field( 'h4' );
        $details = get_sub_field( 'details' );
        $icon = get_sub_field( 'svg_icon' );
        $button = get_sub_field( 'button' );
        
        // Process button
        $button_url = '#';
        $button_text = '';
        $button_target = '_self';
        
        if ( $button && is_array( $button ) ) {
            if ( isset( $button['url'] ) && ! empty( $button['url'] ) ) {
                $button_url = $button['url'];
            }
            if ( isset( $button['title'] ) && ! empty( $button['title'] ) ) {
                $button_text = $button['title'];
            }
            if ( isset( $button['target'] ) && ! empty( $button['target'] ) ) {
                $button_target = $button['target'];
            }
        }
        ?>
        
        <div class="blog-v2-card">
            <?php if ( $has_bg_image ) : ?>
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/blog-card-bg.png' ); ?>" alt="" class="blog-v2-card__bg-image">
            <?php endif; ?>
            <div class="blog-v2-card__content">
                <?php if ( $icon ) : ?>
                    <div class="blog-v2-card__icon">
                        <?php echo wp_kses_post( $icon ); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ( $heading ) : ?>
                    <h4 class="blog-v2-card__heading"><?php echo wp_kses_post( $heading ); ?></h4>
                <?php endif; ?>
                
                <?php if ( $details ) : ?>
                    <div class="blog-v2-card__details"><?php echo wp_kses_post( $details ); ?></div>
                <?php endif; ?>
                
                <?php if ( $button_text ) : ?>
                    <a href="<?php echo esc_url( $button_url ); ?>" class="blog-v2-card__btn" target="<?php echo esc_attr( $button_target ); ?>"<?php if ( $button_target === '_blank' ) : ?> rel="noopener noreferrer"<?php endif; ?>>
                        <?php echo esc_html( $button_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
    <?php endwhile; ?>
</div>
