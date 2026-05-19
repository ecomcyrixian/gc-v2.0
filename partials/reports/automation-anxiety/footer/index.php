<?php
/**
 * Post-report CTA: same layout as an ungated custom whitepaper hero without image
 * (headline, download, social row). Sits before the global theme footer.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_cta_bg = get_template_directory_uri() . '/assets/images/custom-whitepaper-bg.webp';

// Required by core-pages/custom-whitepaper/hero-default.php (no hero image on this band).
$hero_img_url       = '';
$cwp_hero_dim_attrs = '';
$cwp_pdf_registry_key = gc_aar_report_pdf_registry_key();
$snippet            = '';
$details            = sprintf(
	'<h2 class="aar-report-footer-cta__title">%1$s<br><span class="aar-report-footer-cta__accent">%2$s</span></h2><p>%3$s</p>',
	esc_html__( 'The AI Skills Bubble Is Real.', 'gc-v2' ),
	esc_html__( 'The Data Is Free.', 'gc-v2' ),
	esc_html__(
		'The 2026 Automation Anxiety Report gives HR leaders the research, the framework, and the practical tools for catching up to a workforce that has already started inflating AI claims faster than verification can keep up.',
		'gc-v2'
	)
);
?>
<section class="custom-whitepaper-hero aar-report-footer-cta" id="download" aria-label="<?php esc_attr_e( 'Download the Automation Anxiety Report', 'gc-v2' ); ?>" style="background-image: url(<?php echo esc_url( $footer_cta_bg ); ?>);">
	<div class="custom-whitepaper-hero__inner">
		<?php require get_template_directory() . '/core-pages/custom-whitepaper/hero-default.php'; ?>
	</div>
</section>
