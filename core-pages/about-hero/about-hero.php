<?php
/**
 * About Hero — matches ACF layout `about_hero`:
 * with_header, snippet, h2, details, image, image_alignment (optional), with_quote, quote.
 * Button groups `with_header` and `with_quote`: stored value must be exactly `Yes` or `No`.
 */
$with_header   = get_sub_field( 'with_header' ) === 'Yes';
$snippet       = get_sub_field( 'snippet' );
$h2_content    = get_sub_field( 'h2' );
$details       = get_sub_field( 'details' );
$acf_image     = get_sub_field( 'image' );
$image_align   = get_sub_field( 'image_alignment' );
$with_quote    = get_sub_field( 'with_quote' ) === 'Yes';
$quote_content = get_sub_field( 'quote' );

$image_left = false;
if ( is_string( $image_align ) ) {
	$a = strtolower( trim( $image_align ) );
	$image_left = ( $a === 'left' );
}

$mission_img_url = '';
$mission_img_alt = '';
if ( $acf_image && function_exists( 'gc_get_acf_image_src' ) ) {
	$src = gc_get_acf_image_src( $acf_image );
	if ( is_array( $src ) && ! empty( $src['url'] ) ) {
		$mission_img_url = $src['url'];
	}
}
if ( $mission_img_url === '' && is_array( $acf_image ) && ! empty( $acf_image['url'] ) ) {
	$mission_img_url = $acf_image['url'];
}
if ( is_array( $acf_image ) ) {
	$mission_img_alt = isset( $acf_image['alt'] ) ? (string) $acf_image['alt'] : '';
}
$mission_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $acf_image ) : '';

$has_header  = $with_header && ( $snippet || $h2_content );
$has_mission = $details || $mission_img_url;
$has_quote   = $with_quote && $quote_content;

if ( ! $has_header && ! $has_mission && ! $has_quote ) {
	return;
}

$heading_id = 'about-hero-heading-' . ( function_exists( 'get_row_index' ) ? (int) get_row_index() : 0 );
?>
<section class="about-hero"<?php echo $has_header ? ' aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
	<div class="about-hero__inner container">
		<?php if ( $has_header ) : ?>
			<header class="about-hero__hero">
				<?php if ( $snippet ) : ?>
					<p class="about-hero__eyebrow"><?php echo esc_html( $snippet ); ?></p>
				<?php endif; ?>
				<?php if ( $h2_content ) : ?>
					<div id="<?php echo esc_attr( $heading_id ); ?>" class="about-hero__heading">
						<?php echo wp_kses_post( $h2_content ); ?>
					</div>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php if ( $has_mission ) : ?>
			<?php
			$mission_classes = array( 'about-hero__mission' );
			if ( $image_left ) {
				$mission_classes[] = 'about-hero__mission--image-left';
			}
			if ( ! $mission_img_url ) {
				$mission_classes[] = 'about-hero__mission--text-only';
			} elseif ( ! $details ) {
				$mission_classes[] = 'about-hero__mission--image-only';
			}
			?>
			<div class="<?php echo esc_attr( implode( ' ', $mission_classes ) ); ?>">
				<?php if ( $details ) : ?>
					<div class="about-hero__mission-copy">
						<div class="about-hero__mission-body">
							<?php echo wp_kses_post( $details ); ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $mission_img_url ) : ?>
					<div class="about-hero__mission-visual">
						<div class="about-hero__mission-glow" aria-hidden="true"></div>
						<img
							class="about-hero__mission-img"
							src="<?php echo esc_url( $mission_img_url ); ?>"
							alt="<?php echo esc_attr( $mission_img_alt ); ?>"
							<?php echo $mission_dim_attrs; ?>
							loading="lazy"
							decoding="async"
						>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $has_quote ) : ?>
			<div class="about-hero__quote-wrap">
				<?php echo wp_kses_post( $quote_content ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
