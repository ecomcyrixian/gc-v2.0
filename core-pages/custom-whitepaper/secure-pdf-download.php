<?php
/**
 * Proxied PDFs: POST admin-ajax.php (nonce) + server-side URL map. Optional: hourly rate limit per IP.
 *
 * @package gc-v2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'GC_SECURE_PDF_NONCE_ACTION' ) ) {
	define( 'GC_SECURE_PDF_NONCE_ACTION', 'gc_secure_pdf' );
}

/**
 * @return array<string, array{url:string, filename:string}>
 */
function gc_secure_pdf_registry() {
	return array(
		'trust_in_hiring_report_2026' => array(
			'url'      => 'https://gcheck.com/wp-content/uploads/resources/pdf-documents/gcheck-trust-in-hiring-report-2026.pdf',
			'filename' => 'gcheck-trust-in-hiring-report-2026.pdf',
		),
	);
}

/**
 * Registry key for the Trust in Hiring report (ungated hero + default hero download).
 *
 * @return string
 */
function gc_secure_pdf_primary_trust_report_key() {
	return 'trust_in_hiring_report_2026';
}

/**
 * Attachment filename for a registry key.
 *
 * @param string $key Registry key.
 * @return string
 */
function gc_secure_pdf_filename_for_key( $key ) {
	$registry = gc_secure_pdf_registry();
	return isset( $registry[ $key ]['filename'] ) ? (string) $registry[ $key ]['filename'] : '';
}

/**
 * Hero wrapper: ajax URL + nonce (same for ungated + default heroes).
 *
 * @return string Safe HTML fragment (leading space before attributes).
 */
function gc_secure_pdf_hero_content_data_attrs() {
	return ' data-gc-pdf-ajax="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" data-gc-pdf-nonce="' . esc_attr( wp_create_nonce( GC_SECURE_PDF_NONCE_ACTION ) ) . '"';
}

/**
 * Primary trust-report button: key + filename from registry.
 *
 * @return string Safe HTML fragment (leading space before attributes).
 */
function gc_secure_pdf_primary_download_data_attrs() {
	$key = gc_secure_pdf_primary_trust_report_key();
	return ' data-gc-pdf-key="' . esc_attr( $key ) . '" data-gc-pdf-filename="' . esc_attr( gc_secure_pdf_filename_for_key( $key ) ) . '"';
}

/**
 * Registry key for a URL, or ''.
 *
 * @param string $url URL.
 * @return string
 */
function gc_secure_pdf_registry_key_for_url( $url ) {
	$url = trim( (string) $url );
	if ( $url === '' ) {
		return '';
	}
	$norm = untrailingslashit( $url );
	foreach ( gc_secure_pdf_registry() as $key => $meta ) {
		$src = untrailingslashit( (string) $meta['url'] );
		if ( $src !== '' && ( $url === $meta['url'] || $norm === $src ) ) {
			return (string) $key;
		}
	}
	return '';
}

/**
 * Best-effort client IP (first X-Forwarded-For hop, else REMOTE_ADDR).
 *
 * @return string
 */
function gc_secure_pdf_request_ip() {
	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$parts = explode( ',', sanitize_text_field( wp_unslash( (string) $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );
		return trim( $parts[0] );
	}
	return ! empty( $_SERVER['REMOTE_ADDR'] )
		? sanitize_text_field( wp_unslash( (string) $_SERVER['REMOTE_ADDR'] ) )
		: '0';
}

/**
 * Hourly bucket rate limit (transient per IP + UTC hour).
 *
 * @return bool
 */
function gc_secure_pdf_rate_limit_allow() {
	$max = (int) apply_filters( 'gc_secure_pdf_max_downloads_per_hour', 48 );
	if ( $max < 1 ) {
		return true;
	}
	$key = 'gc_spdf_' . md5( gc_secure_pdf_request_ip() . '|' . gmdate( 'YmdH' ) );
	$n   = (int) get_transient( $key );
	if ( $n >= $max ) {
		return false;
	}
	set_transient( $key, $n + 1, 3700 );
	return true;
}

/**
 * AJAX: nonce + rate limit, then stream PDF binary.
 */
function gc_ajax_secure_pdf_download() {
	check_ajax_referer( GC_SECURE_PDF_NONCE_ACTION, 'nonce' );
	if ( ! gc_secure_pdf_rate_limit_allow() ) {
		wp_send_json_error(
			array( 'message' => __( 'Too many download attempts. Try again later.', 'gc-v2' ) ),
			429
		);
	}

	$key = isset( $_POST['key'] ) ? sanitize_key( wp_unslash( $_POST['key'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	if ( $key === '' ) {
		wp_send_json_error( null, 400 );
	}

	$registry = gc_secure_pdf_registry();
	if ( ! isset( $registry[ $key ] ) ) {
		wp_send_json_error( null, 404 );
	}

	$source_url = (string) $registry[ $key ]['url'];
	$filename   = (string) $registry[ $key ]['filename'];
	if ( $source_url === '' ) {
		wp_send_json_error( null, 400 );
	}

	$response = wp_remote_get(
		$source_url,
		array(
			'timeout'   => 120,
			'sslverify' => true,
		)
	);

	if ( is_wp_error( $response ) ) {
		wp_send_json_error( null, 502 );
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 ) {
		wp_send_json_error( null, 502 );
	}

	$body = wp_remote_retrieve_body( $response );
	if ( $body === '' ) {
		wp_send_json_error( null, 502 );
	}

	nocache_headers();
	header( 'Content-Type: application/pdf' );
	header( 'Content-Disposition: attachment; filename="' . sanitize_file_name( $filename ) . '"' );
	header( 'Content-Length: ' . (string) strlen( $body ) );
	header( 'X-Robots-Tag: noindex, nofollow' );

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- binary PDF.
	echo $body;
	exit;
}

add_action( 'wp_ajax_gc_secure_pdf', 'gc_ajax_secure_pdf_download' );
add_action( 'wp_ajax_nopriv_gc_secure_pdf', 'gc_ajax_secure_pdf_download' );

/**
 * Load script only on pages (hero is page-only); defer for CWV.
 */
function gc_enqueue_secure_pdf_download_script() {
	if ( is_admin() || ! is_page() ) {
		return;
	}
	$path = get_template_directory() . '/assets/js/secure-pdf-download.js';
	if ( ! is_readable( $path ) ) {
		return;
	}
	$handle = 'gc-secure-pdf';
	$ver    = function_exists( 'gc_theme_asset_version' ) ? gc_theme_asset_version( $path ) : (string) filemtime( $path );
	wp_enqueue_script(
		$handle,
		get_template_directory_uri() . '/assets/js/secure-pdf-download.js',
		array(),
		$ver,
		true
	);
	wp_script_add_data( $handle, 'strategy', 'defer' );
}
add_action( 'wp_enqueue_scripts', 'gc_enqueue_secure_pdf_download_script', 20 );

/**
 * Defer fallback when `strategy` is not supported (older WordPress).
 *
 * @param string $tag    Tag.
 * @param string $handle Handle.
 * @return string
 */
function gc_secure_pdf_defer_script_tag( $tag, $handle ) {
	if ( 'gc-secure-pdf' !== $handle || is_admin() || preg_match( '/\bdefer\b/', $tag ) ) {
		return $tag;
	}
	return preg_replace( '/^<script\s+/i', '<script defer ', $tag, 1 );
}
add_filter( 'script_loader_tag', 'gc_secure_pdf_defer_script_tag', 10, 2 );
