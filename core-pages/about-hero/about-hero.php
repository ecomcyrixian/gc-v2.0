<?php
/**
 * About Hero — ACF layout `about_hero`.
 * Mission + image: image on the right when both are present (no image_alignment).
 * Image URL: same as core-pages/page-hero/page-hero-image.php (`get_sub_field( 'image' )`).
 */
$with_header     = get_sub_field( 'with_header' ) === 'Yes';
$snippet         = get_sub_field( 'snippet' );
$h2_content      = get_sub_field( 'h2' );
$details         = get_sub_field( 'details' );
$image           = get_sub_field( 'image' );
$with_quote      = get_sub_field( 'with_quote' ) === 'Yes';
$quote_content   = get_sub_field( 'quote' );

$mission_img_url = is_array( $image ) ? ( $image['url'] ?? '' ) : $image;
$mission_img_alt = is_array( $image ) ? (string) ( $image['alt'] ?? '' ) : '';
$mission_img_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $image ) : '';

$has_header  = $with_header && ( $snippet || $h2_content );
$has_mission = $details || $mission_img_url;
$has_quote   = $with_quote && $quote_content;

if ( ! $has_header && ! $has_mission && ! $has_quote ) {
	return;
}

$heading_id = 'about-hero-heading-' . ( function_exists( 'get_row_index' ) ? (int) get_row_index() : 0 );

$mission_overlap = $mission_img_url && $details;
?>
<section class="about-hero"<?php echo $has_header ? ' aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
	<div class="about-hero__inner container">
		<?php if ( $has_header ) : ?>
			<div class="about-hero__hero">
				<?php if ( $snippet ) : ?>
					<div class="about-hero__eyebrow"><?php echo esc_html( $snippet ); ?></div>
				<?php endif; ?>
				<?php if ( $h2_content ) : ?>
					<div id="<?php echo esc_attr( $heading_id ); ?>" class="about-hero__heading">
						<h1><?php echo wp_kses_post( $h2_content ); ?></h1>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $has_mission ) : ?>
			<div class="about-hero__mission<?php echo $mission_overlap ? ' about-hero__mission--overlap' : ''; ?>">
				<?php if ( $details ) : ?>
					<div class="about-hero__mission-copy">
						<div class="about-hero__mission-body">
							<?php echo wp_kses_post( $details ); ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $mission_img_url ) : ?>
					<div class="about-hero__mission-visual">
						<img
							class="about-hero__mission-img"
							src="<?php echo esc_url( $mission_img_url ); ?>"
							alt="<?php echo esc_attr( $mission_img_alt ); ?>"
							<?php echo $mission_img_dim_attrs; ?>
							loading="eager"
							decoding="async"
							fetchpriority="high"
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
