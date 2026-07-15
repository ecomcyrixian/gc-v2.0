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
	$allowed_slugs = $allowed_slugs ? $allowed_slugs : array( 'automation-anxiety-report', 'trust-in-hiring-report', 'shadow-workforce-report', 'rise-of-the-shadow-workforce-report' );

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

function gc_theme_get_parallax_report_scss_dependencies() {
	$theme_dir = get_template_directory();

	return array(
		$theme_dir . '/assets/css/parallax-report.scss',
		$theme_dir . '/partials/reports/automation-anxiety/shared/css/_report-data-table.scss',
		$theme_dir . '/partials/reports/automation-anxiety/shared/css/_report-content-shared.scss',
		$theme_dir . '/partials/reports/automation-anxiety/shared/css/_report-graph.scss',
		$theme_dir . '/partials/reports/automation-anxiety/executive-summary/css/_executive-summary.scss',
		$theme_dir . '/partials/reports/automation-anxiety/page-hero/css/_page-hero.scss',
		$theme_dir . '/partials/reports/automation-anxiety/content-ai-anxiety/css/_content-ai-anxiety.scss',
		$theme_dir . '/partials/reports/trust-in-hiring/page-hero/css/_page-hero.scss',
		$theme_dir . '/partials/reports/trust-in-hiring/executive-summary/css/_executive-summary.scss',
		$theme_dir . '/partials/reports/trust-in-hiring/content/css/_content.scss',
		$theme_dir . '/partials/reports/shadow-workforce/page-hero/css/_page-hero.scss',
		$theme_dir . '/partials/reports/shadow-workforce/content/css/_content.scss',
		$theme_dir . '/partials/reports/shadow-workforce/content/css/_figure-card-graph.scss',
	);
}

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

function gc_theme_enqueue_parallax_report_assets( $post ) {
	if ( ! gc_theme_is_parallax_report_page( $post ) ) {
		return false;
	}

	$page_slug   = gc_theme_static_html_resolve_slug_for_post( $post );
	$theme_dir   = get_template_directory();
	$report_css  = $theme_dir . '/assets/css/parallax-report.css';
	$core_deps   = array();

	if ( in_array( $page_slug, array( 'automation-anxiety-report', 'shadow-workforce-report', 'rise-of-the-shadow-workforce-report' ), true ) ) {
		$core_deps = array(
			$theme_dir . '/core-pages/custom-whitepaper/css/_custom-whitepaper-hero.scss',
			$theme_dir . '/core-pages/cards/css/_cards.scss',
		);
	}

	gc_theme_enqueue_report_core_page_style( $core_deps );

	$report_version = gc_theme_asset_version(
		$report_css,
		gc_theme_get_parallax_report_scss_dependencies()
	);

	wp_enqueue_style(
		'report-parallax',
		get_template_directory_uri() . '/assets/css/parallax-report.css',
		array( 'global-style', 'page-style' ),
		$report_version,
		'screen'
	);

	gc_theme_enqueue_report_motion_scripts(
		'report-parallax-graph',
		'report-parallax-animations'
	);

	return true;
}
