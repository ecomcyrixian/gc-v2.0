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
 * Whether the page uses the ACF flexible "Custom Whitepaper Hero" row with type Gated.
 * Only that layout prints the form in the hero (see hero.php); other pages must keep the shortcode in content.
 *
 * @param int|null $post_id Post ID; default current post when in the loop.
 * @return bool
 */
function gc_page_has_gated_custom_whitepaper_hero( $post_id = null ) {
	static $cache = array();

	if ( ! function_exists( 'get_field' ) ) {
		return false;
	}
	$post_id = $post_id ? (int) $post_id : (int) get_the_ID();
	if ( $post_id < 1 ) {
		$post_id = (int) get_queried_object_id();
	}
	if ( $post_id < 1 ) {
		return false;
	}
	if ( array_key_exists( $post_id, $cache ) ) {
		return $cache[ $post_id ];
	}

	$rows = get_field( 'page_content', $post_id );
	if ( ! is_array( $rows ) ) {
		$cache[ $post_id ] = false;
		return false;
	}

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$layout = isset( $row['acf_fc_layout'] ) ? (string) $row['acf_fc_layout'] : '';
		if ( 'custom_whitepaper_hero' !== $layout ) {
			continue;
		}
		$type = isset( $row['type'] ) ? strtolower( trim( (string) $row['type'] ) ) : '';
		if ( 'gated' === $type ) {
			$cache[ $post_id ] = true;
			return true;
		}
	}

	$cache[ $post_id ] = false;
	return false;
}

/**
 * Page IDs where the PDF form is shown in the custom whitepaper hero only; strip duplicate shortcode from Gutenberg.
 * Shortcode stays in post_content so the plugin can enqueue assets. Filter: gc_gcheck_pdf_hide_duplicate_in_content_page_ids.
 *
 * @return int[]
 */
function gc_gcheck_pdf_hide_duplicate_in_content_page_ids() {
	$ids = array( 22046 );
	return array_map( 'intval', (array) apply_filters( 'gc_gcheck_pdf_hide_duplicate_in_content_page_ids', $ids ) );
}

/**
 * Whether to remove [gcheck_pdf_request_form] blocks from the_content (hero already output the form).
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function gc_page_hides_gcheck_pdf_duplicate_in_content( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 ) {
		return false;
	}
	if ( gc_page_has_gated_custom_whitepaper_hero( $post_id ) ) {
		return true;
	}
	return in_array( $post_id, gc_gcheck_pdf_hide_duplicate_in_content_page_ids(), true );
}

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
 * When the_content() runs on a gated custom whitepaper page, hide marker blocks so the form is not duplicated
 * (hero already outputs it). Gutenberg-only pages and other layouts keep the shortcode in place.
 *
 * @param string               $block_content Block HTML.
 * @param array<string, mixed> $block         Parsed block.
 */
function gc_hide_gcheck_pdf_form_marker_block( $block_content, $block ) {
	if ( ! is_singular( 'page' ) ) {
		return $block_content;
	}
	$post_id = (int) get_the_ID();
	if ( $post_id < 1 ) {
		$post_id = (int) get_queried_object_id();
	}
	if ( $post_id < 1 || ! gc_page_hides_gcheck_pdf_duplicate_in_content( $post_id ) ) {
		return $block_content;
	}

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
