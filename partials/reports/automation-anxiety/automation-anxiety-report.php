<?php
/**
 * Automation Anxiety Report parallax composition.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content.php';
?>
<main id="gc-report-automation-anxiety" class="gc-report-automation-anxiety">
	<?php get_template_part( 'partials/reports/automation-anxiety/page-hero/index' ); ?>
	<?php get_template_part( 'partials/reports/automation-anxiety/executive-summary/index' ); ?>
	<?php get_template_part( 'partials/reports/automation-anxiety/content-ai-anxiety/index' ); ?>
	<?php get_template_part( 'partials/reports/automation-anxiety/footer/index' ); ?>
</main>
