<?php
/**
 * Report page asset helpers.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gc_theme_is_parallax_report_page( $post = null, $allowed_slugs = array() ) {
	if ( ! is_page_template( 'page-parallax.php' ) || ! function_exists( 'gc_theme_static_html_resolve_slug_for_post' ) ) {
		return false;
	}

	$post = $post instanceof WP_Post ? $post : get_post();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	$page_slug = gc_theme_static_html_resolve_slug_for_post( $post );
	$allowed_slugs = $allowed_slugs ? $allowed_slugs : array( 'automation-anxiety-report', 'trust-in-hiring-report' );

	return in_array( $page_slug, $allowed_slugs, true );
}

add_filter(
	'wp_resource_hints',
	static function ( $urls, $relation_type ) {
		if ( 'preconnect' !== $relation_type || ! gc_theme_is_parallax_report_page() ) {
			return $urls;
		}

		$cdnjs_origin = 'https://cdnjs.cloudflare.com';
		if ( ! in_array( $cdnjs_origin, $urls, true ) ) {
			$urls[] = $cdnjs_origin;
		}

		return $urls;
	},
	10,
	2
);

function gc_theme_enqueue_report_core_page_style( $dependency_files = array() ) {
	$core_page_css  = get_template_directory() . '/assets/css/core-page-new.css';
	$core_page_scss = get_template_directory() . '/assets/css/core-page-new.scss';
	$page_hero_scss = get_template_directory() . '/core-pages/page-hero/css/_page-hero.scss';

	wp_enqueue_style(
		'page-style',
		get_template_directory_uri() . '/assets/css/core-page-new.css',
		array( 'global-style' ),
		gc_theme_asset_version(
			$core_page_css,
			array_merge(
				array(
					$core_page_scss,
					$page_hero_scss,
				),
				$dependency_files
			)
		),
		'screen'
	);
}

function gc_theme_enqueue_report_motion_scripts( $graph_handle, $animations_handle ) {
	$report_graph_js         = get_template_directory() . '/assets/js/report-graph.js';
	$report_graph_js_version = gc_theme_asset_version( $report_graph_js );
	$report_anim_js          = get_template_directory() . '/assets/js/report-animations.js';
	$report_anim_js_version  = gc_theme_asset_version( $report_anim_js );

	wp_enqueue_script(
		'gsap',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
		array(),
		null,
		true
	);
	wp_script_add_data( 'gsap', 'strategy', 'defer' );

	wp_enqueue_script(
		'gsap-scroll-trigger',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
		array( 'gsap' ),
		null,
		true
	);
	wp_script_add_data( 'gsap-scroll-trigger', 'strategy', 'defer' );

	wp_enqueue_script(
		$graph_handle,
		get_template_directory_uri() . '/assets/js/report-graph.js',
		array( 'gsap', 'gsap-scroll-trigger' ),
		$report_graph_js_version,
		true
	);
	wp_script_add_data( $graph_handle, 'strategy', 'defer' );

	wp_enqueue_script(
		$animations_handle,
		get_template_directory_uri() . '/assets/js/report-animations.js',
		array( 'gsap' ),
		$report_anim_js_version,
		true
	);
	wp_script_add_data( $animations_handle, 'strategy', 'defer' );
}

function gc_theme_enqueue_automation_anxiety_report_assets() {
	$report_bundle_dir  = get_template_directory() . '/partials/reports/automation-anxiety';
	$report_bundle_css  = get_template_directory() . '/assets/css/automation-anxiety-report.css';
	$report_bundle_scss = get_template_directory() . '/assets/css/automation-anxiety-report.scss';
	$report_graph_scss  = $report_bundle_dir . '/shared/css/_report-graph.scss';

	gc_theme_enqueue_report_core_page_style(
		array(
			get_template_directory() . '/core-pages/custom-whitepaper/css/_custom-whitepaper-hero.scss',
			get_template_directory() . '/core-pages/cards/css/_cards.scss',
		)
	);

	$report_bundle_version = gc_theme_asset_version(
		$report_bundle_css,
		array(
			$report_bundle_scss,
			$report_bundle_dir . '/shared/css/_report-data-table.scss',
			$report_bundle_dir . '/shared/css/_report-content-shared.scss',
			$report_graph_scss,
			$report_bundle_dir . '/executive-summary/css/_executive-summary.scss',
			$report_bundle_dir . '/page-hero/css/_page-hero.scss',
			$report_bundle_dir . '/content-ai-anxiety/css/_content-ai-anxiety.scss',
		)
	);

	wp_enqueue_style(
		'report-automation-anxiety',
		get_template_directory_uri() . '/assets/css/automation-anxiety-report.css',
		array( 'global-style', 'page-style' ),
		$report_bundle_version,
		'screen'
	);

	gc_theme_enqueue_report_motion_scripts(
		'report-automation-anxiety-graph',
		'report-automation-anxiety-animations'
	);
}

function gc_theme_enqueue_trust_in_hiring_report_assets() {
	$trust_report_dir  = get_template_directory() . '/partials/reports/trust-in-hiring';
	$trust_report_css  = get_template_directory() . '/assets/css/trust-in-hiring-report.css';
	$trust_report_scss = get_template_directory() . '/assets/css/trust-in-hiring-report.scss';

	gc_theme_enqueue_report_core_page_style();

	$trust_report_version = gc_theme_asset_version(
		$trust_report_css,
		array(
			$trust_report_scss,
			$trust_report_dir . '/page-hero/css/_page-hero.scss',
			get_template_directory() . '/partials/reports/automation-anxiety/shared/css/_report-content-shared.scss',
			get_template_directory() . '/partials/reports/automation-anxiety/shared/css/_report-graph.scss',
			get_template_directory() . '/partials/reports/automation-anxiety/executive-summary/css/_executive-summary.scss',
			$trust_report_dir . '/executive-summary/css/_executive-summary.scss',
			$trust_report_dir . '/content/css/_content.scss',
		)
	);

	wp_enqueue_style(
		'report-trust-in-hiring',
		get_template_directory_uri() . '/assets/css/trust-in-hiring-report.css',
		array( 'global-style', 'page-style' ),
		$trust_report_version,
		'screen'
	);

	gc_theme_enqueue_report_motion_scripts(
		'report-trust-in-hiring-graph',
		'report-trust-in-hiring-animations'
	);
}

function gc_theme_enqueue_parallax_report_assets( $post ) {
	if ( ! gc_theme_is_parallax_report_page( $post ) ) {
		return false;
	}

	$page_slug = gc_theme_static_html_resolve_slug_for_post( $post );

	if ( $page_slug === 'automation-anxiety-report' ) {
		gc_theme_enqueue_automation_anxiety_report_assets();
		return true;
	}

	if ( $page_slug === 'trust-in-hiring-report' ) {
		gc_theme_enqueue_trust_in_hiring_report_assets();
		return true;
	}

	return false;
}
