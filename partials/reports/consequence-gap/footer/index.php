<?php
/**
 * Post-report CTA: same layout as an ungated custom whitepaper hero without image,
 * plus the research-cadence note and media-inquiry line this report adds.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_cta_bg = get_template_directory_uri() . '/assets/images/custom-whitepaper-bg.webp';

$hero_img_url         = '';
$cwp_hero_dim_attrs   = '';
$cwp_pdf_registry_key = function_exists( 'gc_secure_pdf_consequence_gap_report_key' )
	? gc_secure_pdf_consequence_gap_report_key()
	: 'consequence_gap_report';
$snippet              = '';
$details              = sprintf(
	'<h2 class="aar-report-footer-cta__title"><span class="aar-report-footer-cta__accent">%1$s</span> <br class="cgr-report-br-mobile" aria-hidden="true">%2$s</h2><p>%3$s</p>',
	esc_html__( 'The Data Is Free.', 'gc-v2' ),
	esc_html__( 'The Finding Is Uncomfortable.', 'gc-v2' ),
	wp_kses(
		__(
			'The Consequence Gap gives HR leaders, researchers, and journalists the full national benchmark of who<br class="cgr-report-br-desktop" aria-hidden="true">absorbs workplace pressure, who escapes it, and what unaccountable behavior costs a team. This report <br class="cgr-report-br-desktop" aria-hidden="true">sells nothing. Cite it, share it, and build on it.',
			'gc-v2'
		),
		array(
			'br' => array(
				'class'       => array(),
				'aria-hidden' => array(),
			),
		)
	)
);

$cwp_cta_note     = esc_html__(
	'This research re-fields annually. The 2027 wave measures whether the consequence gap narrows, and whether what it spreads recedes.',
	'gc-v2'
);
$cwp_cta_footnote = sprintf(
	esc_html__( 'For media inquiries, email: %s', 'gc-v2' ),
	'<a href="mailto:press@gcheck.com">press@gcheck.com</a>'
);
?>
<section class="custom-whitepaper-hero aar-report-footer-cta cgr-report-footer-cta" id="download" aria-label="<?php esc_attr_e( 'Download the Consequence Gap Report', 'gc-v2' ); ?>" style="background-image: url(<?php echo esc_url( $footer_cta_bg ); ?>);">
	<div class="custom-whitepaper-hero__inner">
		<?php require get_template_directory() . '/core-pages/custom-whitepaper/hero-default.php'; ?>
	</div>
</section>
