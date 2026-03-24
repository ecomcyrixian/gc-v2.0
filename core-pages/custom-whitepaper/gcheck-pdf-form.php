<?php
/**
 * GCheck PDF request form helpers for gated custom whitepaper hero.
 *
 * Shortcode must remain in post_content (block editor) so the plugin’s has_shortcode() enqueue runs.
 * page.php does not call the_content(); the hero outputs the form via gc_render_post_pdf_request_form_in_hero().
 *
 * @package gc-v2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * First instance in page content gets id="gcheck-pdf-request-form" for CTAs (e.g. #gcheck-pdf-request-form).
 *
 * @param string $content Rendered post content.
 * @return string
 */
function gc_gcheck_pdf_request_form_anchor_id( $content ) {
	if ( ! is_singular( 'page' ) || is_admin() ) {
		return $content;
	}
	if ( strpos( $content, 'gcheckpdf-request-container' ) === false ) {
		return $content;
	}
	if ( strpos( $content, 'id="gcheck-pdf-request-form"' ) !== false || strpos( $content, "id='gcheck-pdf-request-form'" ) !== false ) {
		return $content;
	}
	$pattern = '/<div(\s+)class=(["\'])gcheckpdf-request-container\2/';
	$replace = '<div$1id="gcheck-pdf-request-form" class=$2gcheckpdf-request-container$2';

	return preg_replace( $pattern, $replace, $content, 1 );
}
add_filter( 'the_content', 'gc_gcheck_pdf_request_form_anchor_id', 12 );

/**
 * Print the PDF form in the gated whitepaper hero using the shortcode from post_content.
 */
function gc_render_post_pdf_request_form_in_hero() {
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return;
	}
	$content = (string) $post->post_content;
	if ( ! has_shortcode( $content, 'gcheck_pdf_request_form' ) ) {
		return;
	}
	if ( ! preg_match( '/\[gcheck_pdf_request_form[^\]]*]/', $content, $m ) ) {
		return;
	}
	echo do_shortcode( $m[0] );
}

/**
 * When the_content() runs (e.g. Landing Pages template), hide marker blocks so the form is not duplicated.
 *
 * @param string               $block_content Block HTML.
 * @param array<string, mixed> $block         Parsed block.
 */
function gc_hide_gcheck_pdf_form_marker_block( $block_content, $block ) {
	$name = isset( $block['blockName'] ) ? (string) $block['blockName'] : '';
	if ( 'core/html' === $name || 'core/shortcode' === $name ) {
		$inner    = isset( $block['innerHTML'] ) && is_string( $block['innerHTML'] ) ? $block['innerHTML'] : $block_content;
		$stripped = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $inner ) ) );
		if ( preg_match( '/^\[gcheck_pdf_request_form[^\]]*]$/', $stripped ) ) {
			return '';
		}
	}
	if ( 'core/paragraph' === $name ) {
		$inner = isset( $block['innerHTML'] ) && is_string( $block['innerHTML'] ) ? trim( $block['innerHTML'] ) : '';
		if ( preg_match( '/^\s*<p[^>]*>\s*\[gcheck_pdf_request_form[^\]]*]\s*<\/p>\s*$/i', $inner ) ) {
			return '';
		}
	}
	return $block_content;
}
add_filter( 'render_block', 'gc_hide_gcheck_pdf_form_marker_block', 10, 2 );
