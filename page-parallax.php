<?php
/**
 * Template Name: Parallax
 *
 * Loads a report composition from partials/reports/{report-folder}/{page-slug}.php.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/static-html-helpers.php';

$gc_parallax_post = get_post();
$gc_parallax_slug = gc_theme_static_html_resolve_slug_for_post( $gc_parallax_post );
$gc_parallax_reports = array(
	'automation-anxiety-report' => array(
		'folder'   => 'automation-anxiety',
		'template' => 'automation-anxiety-report',
	),
	'trust-in-hiring-report'   => array(
		'folder'   => 'trust-in-hiring',
		'template' => 'trust-in-hiring',
	),
	'shadow-workforce-report'      => array(
		'folder'   => 'shadow-workforce',
		'template' => 'shadow-workforce-report',
	),
	'rise-of-the-shadow-workforce-report' => array(
		'folder'   => 'shadow-workforce',
		'template' => 'shadow-workforce-report',
	),
);
$gc_parallax_report = isset( $gc_parallax_reports[ $gc_parallax_slug ] )
	? $gc_parallax_reports[ $gc_parallax_slug ]
	: array(
		'folder'   => $gc_parallax_slug,
		'template' => $gc_parallax_slug,
	);
$gc_parallax_report_folder = isset( $gc_parallax_report['folder'] )
	? $gc_parallax_report['folder']
	: $gc_parallax_slug;
$gc_parallax_report_template = isset( $gc_parallax_report['template'] )
	? $gc_parallax_report['template']
	: $gc_parallax_slug;
$gc_parallax_template = $gc_parallax_slug
	? locate_template( 'partials/reports/' . $gc_parallax_report_folder . '/' . $gc_parallax_report_template . '.php', false, false )
	: '';

if ( in_array( $gc_parallax_slug, array( 'automation-anxiety-report', 'shadow-workforce-report', 'rise-of-the-shadow-workforce-report' ), true ) ) {
	require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content.php';
}

get_header();

if ( $gc_parallax_template ) {
	require $gc_parallax_template;
} else {
	?>
	<main id="gc-parallax-page" class="gc-parallax-page">
		<div class="container">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;
			?>
		</div>
	</main>
	<?php
}

get_footer();
