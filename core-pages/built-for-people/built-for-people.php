<?php
/**
 * Built for People
 */
$display = get_sub_field( 'display_selection' );
if ( $display !== 'Show' ) {
	return;
}

$with_header = get_sub_field( 'with_header' ) === 'Yes';
$h2         = get_sub_field( 'h2' );
$details    = get_sub_field( 'details' );
$cards      = get_sub_field( 'cards' );

$theme_dir = get_template_directory();
$theme_uri = get_template_directory_uri();
$base     = file_exists( $theme_dir . '/assets/images/built-for-people-bg.webp' ) ? 'built-for-people-bg'
	: ( file_exists( $theme_dir . '/assets/images/built-for-peoplebg.webp' ) ? 'built-for-peoplebg' : '' );
$bg_url   = '';
if ( $base ) {
	$ext   = file_exists( $theme_dir . '/assets/images/' . $base . '.webp' ) ? 'webp' : 'jpg';
	$bg_url = $theme_uri . '/assets/images/' . $base . '.' . $ext;
}
?>
<section class="built-for-people">
	<div class="built-for-people__frame">
		<?php if ( $with_header && ! empty( $h2 ) ) : ?>
			<h2 class="built-for-people__title"><?php echo wp_kses_post( $h2 ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $details ) ) : ?>
			<div class="built-for-people__intro"><?php echo wp_kses_post( $details ); ?></div>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) && is_array( $cards ) ) : ?>
			<div class="built-for-people__grid">
				<?php foreach ( $cards as $card ) : ?>
					<?php
					$heading = isset( $card['h4'] ) ? $card['h4'] : '';
					$card_details = isset( $card['details'] ) ? $card['details'] : '';
					$svg_icon = isset( $card['svg_icon'] ) ? $card['svg_icon'] : '';
					$icon_img  = isset( $card['icon'] ) ? $card['icon'] : null;
					$icon_url  = '';
					if ( $icon_img && function_exists( 'gc_get_acf_image_src' ) ) {
						$_icon    = gc_get_acf_image_src( $icon_img );
						$icon_url = $_icon['url'] ?? '';
					}
					$icon_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $icon_img ) : '';
					if ( $icon_dim_attrs === '' ) {
						$icon_dim_attrs = 'width="40" height="40" ';
					}
					?>
					<div class="built-for-people__card">
						<div class="built-for-people__card-top">
							<?php if ( ! empty( $icon_url ) ) : ?>
								<div class="built-for-people__card-icon">
									<img src="<?php echo esc_url( $icon_url ); ?>" alt="" <?php echo $icon_dim_attrs; ?>loading="lazy" decoding="async">
								</div>
							<?php elseif ( ! empty( $svg_icon ) ) : ?>
								<div class="built-for-people__card-icon built-for-people__card-icon--svg">
									<?php echo wp_kses_post( $svg_icon ); ?>
								</div>
							<?php endif; ?>
							<?php if ( $heading ) : ?>
								<h3 class="built-for-people__card-header"><?php echo wp_kses_post( $heading ); ?></h3>
							<?php endif; ?>
						</div>
						<?php if ( $card_details ) : ?>
							<div class="built-for-people__card-details"><?php echo wp_kses_post( $card_details ); ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $bg_url ) : ?>
		<div class="built-for-people__bg-image">
			<img src="<?php echo esc_url( $bg_url ); ?>" alt="" loading="lazy" decoding="async">
		</div>
	<?php endif; ?>
</section>
