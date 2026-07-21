<?php
/**
 * Custom Whitepaper Hero
 */
$type    = get_sub_field( 'type' );
$snippet = get_sub_field( 'snippet' );
$details = get_sub_field( 'details' );
$image   = get_sub_field( 'image' );

$is_gated        = ( strtolower( (string) $type ) === 'gated' );
$is_default      = ( strtolower( (string) $type ) === 'default' );
$is_industry     = ( strtolower( (string) $type ) === 'industry' );
$is_industry_row = $is_industry && is_string( $details ) && false !== stripos( $details, 'industry-row' );

$bg_asset     = get_template_directory_uri() . '/assets/images/custom-whitepaper-bg.webp';
$hero_img_url = '';
if ( function_exists( 'gc_get_acf_image_src' ) ) {
	$hero_src     = gc_get_acf_image_src( $image );
	$hero_img_url = $hero_src['url'] ?? '';
} else {
	$hero_img_url = is_array( $image ) ? ( $image['url'] ?? '' ) : (string) $image;
}

$cwp_hero_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $image ) : '';

$cwp_default_card_icon_svg = '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="custom-whitepaper-hero__card-icon-svg"><rect width="48" height="48" rx="3.42857" fill="#F2F3FF"/><path d="M29.8059 18.7355C29.8059 18.5882 29.6854 18.4677 29.538 18.4677L27.3282 18.4777L24.0001 22.4453L20.6754 18.481L18.4622 18.471C18.3149 18.471 18.1943 18.5882 18.1943 18.7389C18.1943 18.8025 18.2178 18.8627 18.258 18.913L22.614 24.1027L18.258 29.2891C18.2175 29.3382 18.195 29.3996 18.1943 29.4632C18.1943 29.6105 18.3149 29.731 18.4622 29.731L20.6754 29.721L24.0001 25.7534L27.3249 29.7177L29.5347 29.7277C29.682 29.7277 29.8026 29.6105 29.8026 29.4598C29.8026 29.3962 29.7791 29.336 29.7389 29.2857L25.3896 24.0993L29.7456 18.9096C29.7858 18.8627 29.8059 18.7991 29.8059 18.7355Z" fill="#4F51FD"/><path d="M24 9.03357C15.7165 9.03357 9 15.7501 9 24.0336C9 32.3171 15.7165 39.0336 24 39.0336C32.2835 39.0336 39 32.3171 39 24.0336C39 15.7501 32.2835 9.03357 24 9.03357ZM24 36.4889C17.1228 36.4889 11.5446 30.9108 11.5446 24.0336C11.5446 17.1563 17.1228 11.5782 24 11.5782C30.8772 11.5782 36.4554 17.1563 36.4554 24.0336C36.4554 30.9108 30.8772 36.4889 24 36.4889Z" fill="#4F51FD"/></svg>';

$cwp_section_classes = array( 'custom-whitepaper-hero' );
if ( $is_industry ) {
	$cwp_section_classes[] = 'custom-whitepaper-hero--industry';
}
if ( $is_industry_row ) {
	$cwp_section_classes[] = 'custom-whitepaper-hero--industry-row';
}
?>
<section class="<?php echo esc_attr( implode( ' ', $cwp_section_classes ) ); ?>"<?php echo $is_industry ? '' : ' style="background-image: url(' . esc_url( $bg_asset ) . ');"'; ?>>
	<div class="custom-whitepaper-hero__inner">
		<?php
		$cwp_hero_variant_template = 'hero-ungated.php';
		if ( $is_gated ) {
			$cwp_hero_variant_template = 'hero-gated.php';
		} elseif ( $is_industry ) {
			$cwp_hero_variant_template = 'hero-industry.php';
		} elseif ( $is_default ) {
			$cwp_hero_variant_template = 'hero-default.php';
		}
		include __DIR__ . '/' . $cwp_hero_variant_template;
		?>

		<?php if ( ! $is_industry && ! $is_default && have_rows( 'cards' ) ) : ?>
			<div class="custom-whitepaper-hero__cards">
				<?php
				while ( have_rows( 'cards' ) ) :
					the_row();
					$h4           = get_sub_field( 'h4' );
					$details_card = get_sub_field( 'details' );
					?>
					<div class="custom-whitepaper-hero__card">
						<div class="custom-whitepaper-hero__card-head">
							<?php if ( $h4 ) : ?><span class="custom-whitepaper-hero__card-percent"><?php echo esc_html( $h4 ); ?></span><?php endif; ?>
							<span class="custom-whitepaper-hero__card-icon"><?php echo $cwp_default_card_icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</div>
						<?php if ( $details_card ) : ?><div class="custom-whitepaper-hero__card-desc"><?php echo wp_kses_post( $details_card ); ?></div><?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
