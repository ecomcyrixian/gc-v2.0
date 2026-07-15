<?php
/**
 * Shadow Workforce report parallax composition.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content.php';
?>
<main id="gc-report-shadow-workforce" class="gc-report-parallax gc-report-shadow-workforce">
	<?php get_template_part( 'partials/reports/shadow-workforce/page-hero/index' ); ?>
	<?php get_template_part( 'partials/reports/shadow-workforce/content/index' ); ?>
	<?php get_template_part( 'partials/reports/shadow-workforce/footer/index' ); ?>
</main>
