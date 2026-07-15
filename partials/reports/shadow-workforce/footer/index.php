<?php
/**
 * Post-report CTA: same layout as an ungated custom whitepaper hero without image.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_cta_bg = get_template_directory_uri() . '/assets/images/custom-whitepaper-bg.webp';

$hero_img_url         = '';
$cwp_hero_dim_attrs   = '';
$cwp_pdf_registry_key = function_exists( 'gc_secure_pdf_shadow_workforce_report_key' )
	? gc_secure_pdf_shadow_workforce_report_key()
	: 'shadow_workforce_report';
$snippet              = '';
$details              = sprintf(
	'<h2 class="aar-report-footer-cta__title">%1$s<span class="aar-report-footer-cta__accent">%2$s</span></h2><p class="aar-report-footer-cta__accent">%3$s</p>',
	esc_html__( 'Ghost Workers Are Real. ', 'gc-v2' ),
	esc_html__( 'The Data Is Free.', 'gc-v2' ),
	wp_kses(
		__(
			'The Rise of the Shadow Workforce gives HR leaders the research, the framework, and the practical tools<br class="swr-report-br-desktop" aria-hidden="true"> for closing the Verification Half-Life™ before it costs the business.',
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
?>
<section class="custom-whitepaper-hero aar-report-footer-cta" id="download" aria-label="<?php esc_attr_e( 'Download the Shadow Workforce Report', 'gc-v2' ); ?>" style="background-image: url(<?php echo esc_url( $footer_cta_bg ); ?>);">
	<div class="custom-whitepaper-hero__inner">
		<?php require get_template_directory() . '/core-pages/custom-whitepaper/hero-default.php'; ?>
	</div>
</section>
