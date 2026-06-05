<?php
/**
 * Trust in Hiring report parallax composition.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_cta_bg = get_template_directory_uri() . '/assets/images/custom-whitepaper-bg.webp';

$hero_img_url         = '';
$cwp_hero_dim_attrs   = '';
$cwp_pdf_registry_key = function_exists( 'gc_secure_pdf_primary_trust_report_key' )
	? gc_secure_pdf_primary_trust_report_key()
	: 'trust_in_hiring_report_2026';
$snippet              = '';
$details              = sprintf(
	'<h2 class="aar-report-footer-cta__title"><span class="aar-report-footer-cta__accent">%1$s</span>%2$s</h2><p>%3$s</p>',
	esc_html__( 'The Trust Gap Is Real. ', 'gc-v2' ),
	esc_html__( 'The Data Is Free.', 'gc-v2' ),
	esc_html__(
		'The 2026 Trust in Hiring Report provides the research, the context, and a practical framework for rethinking
how your organization verifies candidates and builds trust on both sides of the hiring process.',
		'gc-v2'
	)
);
?>
<main id="gc-report-trust-in-hiring" class="gc-report-parallax gc-report-trust-in-hiring">
	<div class="tih-report-intro">
		<?php get_template_part( 'partials/reports/trust-in-hiring/page-hero/index' ); ?>
		<?php get_template_part( 'partials/reports/trust-in-hiring/executive-summary/index' ); ?>
	</div>
	<?php get_template_part( 'partials/reports/trust-in-hiring/content/index' ); ?>
	<section class="custom-whitepaper-hero aar-report-footer-cta" id="download" aria-label="<?php esc_attr_e( 'Download the Trust in Hiring Report', 'gc-v2' ); ?>" style="background-image: url(<?php echo esc_url( $footer_cta_bg ); ?>);">
		<div class="custom-whitepaper-hero__inner">
			<?php require get_template_directory() . '/core-pages/custom-whitepaper/hero-default.php'; ?>
		</div>
	</section>
</main>
