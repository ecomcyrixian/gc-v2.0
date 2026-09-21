<?php
/**
 * Consequence Gap report parallax composition.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content.php';
?>
<main id="gc-report-consequence-gap" class="gc-report-parallax gc-report-consequence-gap">
	<?php get_template_part( 'partials/reports/consequence-gap/page-hero/index' ); ?>
	<?php get_template_part( 'partials/reports/consequence-gap/content/index' ); ?>
	<?php get_template_part( 'partials/reports/consequence-gap/footer/index' ); ?>
</main>
