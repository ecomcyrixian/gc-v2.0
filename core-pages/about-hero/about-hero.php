<?php
/**
 * About Hero — ACF layout `about_hero`.
 *
 * Tagline + image layout matches Figma: outer frame (≈1440×960) → text frame (max 1091px,
 * vertical stack, 16px gap) → image fills the remaining height inside that same frame (no
 * separate “strip” that gets clipped by the next section).
 */
$with_header     = get_sub_field( 'with_header' ) === 'Yes';
$snippet         = get_sub_field( 'snippet' );
$h2_content      = get_sub_field( 'h2' );
$details         = get_sub_field( 'details' );
$image           = get_sub_field( 'image' );
$with_quote      = get_sub_field( 'with_quote' ) === 'Yes';
$quote_content   = get_sub_field( 'quote' );

$details = is_string( $details ) ? $details : '';

$hero_tagline_inner  = '';
$details_for_mission = $details;

if ( $details !== '' ) {
	$has_tagline_class = ( false !== stripos( $details, 'class="tagline"' ) ) || ( false !== stripos( $details, "class='tagline'" ) );
	if ( $has_tagline_class && preg_match( '/<div\s+class=["\']tagline["\']\s*>(.*?)<\/div>/is', $details, $tagline_match ) ) {
		$hero_tagline_inner  = trim( $tagline_match[1] );
		$details_for_mission = trim( str_replace( $tagline_match[0], '', $details ) );
	}
}

$mission_img_url = is_array( $image ) ? ( $image['url'] ?? '' ) : $image;
$mission_img_alt = is_array( $image ) ? (string) ( $image['alt'] ?? '' ) : '';
$mission_img_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $image ) : '';

$has_hero_tagline = $hero_tagline_inner !== '';
$use_tagline_bg   = $has_hero_tagline && $mission_img_url !== '';

$has_header  = $with_header && ( $snippet || $h2_content || $has_hero_tagline );
$has_mission = ( $details_for_mission !== '' ) || ( $mission_img_url !== '' && ! $use_tagline_bg );
$has_quote   = $with_quote && $quote_content;

if ( ! $has_header && ! $has_mission && ! $has_quote ) {
	return;
}

$heading_id = 'about-hero-heading-' . ( function_exists( 'get_row_index' ) ? (int) get_row_index() : 0 );

$mission_overlap = ! $use_tagline_bg && $mission_img_url && $details_for_mission !== '';

$section_labelledby = '';
if ( $has_header && ( $h2_content || $has_hero_tagline ) ) {
	$section_labelledby = $heading_id;
}

$section_classes = array( 'about-hero' );
if ( $has_hero_tagline ) {
	$section_classes[] = 'about-hero--tagline';
}
if ( $use_tagline_bg ) {
	$section_classes[] = 'about-hero--tagline-photo';
}

$section_style_attr = '';
if ( $use_tagline_bg ) {
	$section_style_attr = '--about-hero-bg-url: url(' . esc_url( $mission_img_url ) . ');';
}
?>
<section
	class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>"
	<?php echo $section_labelledby !== '' ? ' aria-labelledby="' . esc_attr( $section_labelledby ) . '"' : ''; ?>
	<?php echo $section_style_attr !== '' ? ' style="' . esc_attr( $section_style_attr ) . '"' : ''; ?>
>
	<div class="about-hero__inner container">
		<?php if ( $has_header ) : ?>
			<?php if ( $use_tagline_bg ) : ?>
				<div class="about-hero__tagline-layout">
					<div class="about-hero__tagline-layout-inner">
						<div class="about-hero__hero about-hero__tagline-content">
							<?php if ( $snippet ) : ?>
								<div class="about-hero__eyebrow"><?php echo esc_html( $snippet ); ?></div>
							<?php endif; ?>
							<?php if ( $h2_content ) : ?>
								<div id="<?php echo esc_attr( $heading_id ); ?>" class="about-hero__heading">
									<h1><?php echo wp_kses_post( $h2_content ); ?></h1>
								</div>
							<?php endif; ?>
							<?php if ( $has_hero_tagline ) : ?>
								<div class="tagline"<?php echo ! $h2_content ? ' id="' . esc_attr( $heading_id ) . '"' : ''; ?>><?php echo wp_kses_post( $hero_tagline_inner ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php else : ?>
				<div class="about-hero__hero">
					<?php if ( $snippet ) : ?>
						<div class="about-hero__eyebrow"><?php echo esc_html( $snippet ); ?></div>
					<?php endif; ?>
					<?php if ( $h2_content ) : ?>
						<div id="<?php echo esc_attr( $heading_id ); ?>" class="about-hero__heading">
							<h1><?php echo wp_kses_post( $h2_content ); ?></h1>
						</div>
					<?php endif; ?>
					<?php if ( $has_hero_tagline ) : ?>
						<div class="tagline"<?php echo ! $h2_content ? ' id="' . esc_attr( $heading_id ) . '"' : ''; ?>><?php echo wp_kses_post( $hero_tagline_inner ); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $has_mission ) : ?>
			<?php
			$mission_class = 'about-hero__mission';
			if ( $mission_overlap ) {
				$mission_class .= ' about-hero__mission--overlap';
			}
			?>
			<div class="<?php echo esc_attr( $mission_class ); ?>">
				<?php if ( $details_for_mission !== '' ) : ?>
					<div class="about-hero__mission-copy">
						<div class="about-hero__mission-body">
							<?php echo wp_kses_post( $details_for_mission ); ?>
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
