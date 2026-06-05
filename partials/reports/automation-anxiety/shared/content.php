<?php
/**
 * Shared report content helpers.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the Automation Anxiety report template is active.
 */
function gc_aar_report_is_active() {
	$post = get_post();
	$slug = ( $post instanceof WP_Post && function_exists( 'gc_theme_static_html_resolve_slug_for_post' ) )
		? gc_theme_static_html_resolve_slug_for_post( $post )
		: '';

	return is_page_template( 'page-parallax.php' ) && $slug === 'automation-anxiety-report';
}

/**
 * Secure PDF registry key for this report.
 *
 * @return string
 */
function gc_aar_report_pdf_registry_key() {
	return function_exists( 'gc_secure_pdf_automation_anxiety_report_key' )
		? gc_secure_pdf_automation_anxiety_report_key()
		: 'automation_anxiety_report';
}

/**
 * Signed URL — opens PDF in the browser viewer; uploads path is never exposed.
 *
 * @return string
 */
function gc_aar_report_pdf_view_url() {
	if ( ! function_exists( 'gc_secure_pdf_view_url' ) ) {
		return '';
	}
	$back = function_exists( 'get_permalink' ) ? (string) get_permalink() : '';
	return gc_secure_pdf_view_url( gc_aar_report_pdf_registry_key(), $back );
}

/**
 * GTM tracking attributes for proxied PDF download links.
 *
 * @return string
 */
function gc_aar_report_pdf_download_data_attrs() {
	return function_exists( 'gc_secure_pdf_download_data_attrs' )
		? gc_secure_pdf_download_data_attrs( gc_aar_report_pdf_registry_key() )
		: '';
}

/**
 * Core Web Vitals helpers for the report page (local Bebas preload, script defer).
 */
function gc_aar_report_register_cwv_hooks() {
	add_action(
		'wp_head',
		static function () {
			if ( ! gc_aar_report_is_active() ) {
				return;
			}
			$font_path = get_template_directory() . '/assets/fonts/bebas-neue-latin.woff2';
			if ( ! is_readable( $font_path ) ) {
				return;
			}
			$font_url = get_template_directory_uri() . '/assets/fonts/bebas-neue-latin.woff2';
			printf(
				'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
				esc_url( $font_url )
			);
		},
		1
	);

	add_action(
		'wp_enqueue_scripts',
		static function () {
			if ( ! gc_aar_report_is_active() ) {
				return;
			}
			if ( wp_script_is( 'report-automation-anxiety-graph', 'enqueued' ) ) {
				wp_script_add_data( 'report-automation-anxiety-graph', 'strategy', 'defer' );
			}
		},
		100
	);

	add_filter(
		'script_loader_tag',
		static function ( $tag, $handle ) {
			$report_handles = array(
				'report-automation-anxiety-graph',
				'report-automation-anxiety-animations',
				'report-trust-in-hiring-graph',
				'report-trust-in-hiring-animations',
			);
			if ( ! in_array( $handle, $report_handles, true ) || is_admin() || preg_match( '/\bdefer\b/', $tag ) ) {
				return $tag;
			}
			return preg_replace( '/^<script\s+/i', '<script defer ', $tag, 1 );
		},
		10,
		2
	);
}
gc_aar_report_register_cwv_hooks();

require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content-section-heading.php';
require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/data-table.php';
require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content-quote.php';
require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content-callout-card.php';
require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content-media-feature.php';
require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content-stat-cards.php';
require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content-graph.php';
