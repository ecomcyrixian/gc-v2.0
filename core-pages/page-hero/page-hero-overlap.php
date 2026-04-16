<?php
/**
 * Page Hero — Overlap
 */
$details = get_sub_field( 'details' );
$image   = get_sub_field( 'image' );

$hero_img_url = '';
if ( function_exists( 'gc_get_acf_image_src' ) ) {
	$hero_src     = gc_get_acf_image_src( $image );
	$hero_img_url = $hero_src['url'] ?? '';
} else {
	$hero_img_url = is_array( $image ) ? ( $image['url'] ?? '' ) : (string) $image;
}
$overlap_img_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $image ) : '';
?>
<div class="page-hero__overlap-wrap">
	<?php if ( $hero_img_url ) : ?>
		<div class="page-hero__overlap-image">
			<img src="<?php echo esc_url( $hero_img_url ); ?>" alt="" <?php echo $overlap_img_dim_attrs; ?>decoding="async" fetchpriority="high" loading="eager">
		</div>
	<?php endif; ?>
		<div class="page-hero__overlap-card">
			<?php echo do_shortcode( $details ); ?>
		</div>
</div>
