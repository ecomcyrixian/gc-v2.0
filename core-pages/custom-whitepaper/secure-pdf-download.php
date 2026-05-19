<?php
/**
 * Secure PDFs: signed stream URLs proxy the file. True upload paths stay server-side only.
 *
 * @package gc-v2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'GC_SECURE_PDF_REWRITE_VERSION' ) ) {
	define( 'GC_SECURE_PDF_REWRITE_VERSION', '3' );
}

/**
 * @return array<string, array{url:string, filename:string, slug:string}>
 */
function gc_secure_pdf_registry() {
	return array(
		'trust_in_hiring_report_2026' => array(
			'url'      => 'https://gcheck.com/wp-content/uploads/resources/pdf-documents/gcheck-trust-in-hiring-report-2026.pdf',
			'filename' => 'gcheck-trust-in-hiring-report-2026.pdf',
			'slug'     => 'trust-in-hiring',
		),
		'automation_anxiety_report'   => array(
			'url'      => 'https://gcheck.com/wp-content/uploads/resources/pdf-documents/automation-anxiety-report.pdf',
			'filename' => 'automation-anxiety-report.pdf',
			'slug'     => 'automation-anxiety',
		),
	);
}

/**
 * @param string $key Registry key.
 * @return string
 */
function gc_secure_pdf_slug_for_key( $key ) {
	$registry = gc_secure_pdf_registry();
	return isset( $registry[ $key ]['slug'] ) ? sanitize_title( (string) $registry[ $key ]['slug'] ) : '';
}

/**
 * @param string $slug Public slug.
 * @return string Registry key or ''.
 */
function gc_secure_pdf_key_for_slug( $slug ) {
	$slug = sanitize_title( (string) $slug );
	foreach ( gc_secure_pdf_registry() as $key => $meta ) {
		if ( isset( $meta['slug'] ) && sanitize_title( (string) $meta['slug'] ) === $slug ) {
			return (string) $key;
		}
	}
	return '';
}

/**
 * Registry key for the Trust in Hiring report.
 *
 * @return string
 */
function gc_secure_pdf_primary_trust_report_key() {
	return 'trust_in_hiring_report_2026';
}

/**
 * Registry key for the Automation Anxiety Report.
 *
 * @return string
 */
function gc_secure_pdf_automation_anxiety_report_key() {
	return 'automation_anxiety_report';
}

/**
 * Suggested filename for a registry key.
 *
 * @param string $key Registry key.
 * @return string
 */
function gc_secure_pdf_filename_for_key( $key ) {
	$registry = gc_secure_pdf_registry();
	return isset( $registry[ $key ]['filename'] ) ? (string) $registry[ $key ]['filename'] : 'report.pdf';
}

/**
 * data-gc-pdf-* attributes for GTM tracking (used with secure-pdf-download.js).
 *
 * @param string $key Registry key.
 * @return string HTML attribute fragment (leading space), or empty if key invalid.
 */
function gc_secure_pdf_download_data_attrs( $key ) {
	$key = sanitize_key( (string) $key );
	if ( $key === '' || ! isset( gc_secure_pdf_registry()[ $key ] ) ) {
		return '';
	}
	return sprintf(
		' data-gc-pdf-key="%1$s" data-gc-pdf-filename="%2$s"',
		esc_attr( $key ),
		esc_attr( gc_secure_pdf_filename_for_key( $key ) )
	);
}

/**
 * Signed URL that opens the PDF in the browser viewer (Edge/Chrome/Adobe). Uploads path hidden.
 *
 * @param string $key      Registry key.
 * @param string $back_url Optional return URL (stored in query for reference).
 * @return string
 */
function gc_secure_pdf_view_url( $key, $back_url = '' ) {
	$url = gc_secure_pdf_stream_url( $key );
	if ( $url === '' ) {
		return '';
	}
	if ( $back_url !== '' ) {
		$url = add_query_arg( 'back', rawurlencode( $back_url ), $url );
	}
	return $url;
}

/**
 * Whether permalinks use pretty paths (not plain ?p=).
 *
 * @return bool
 */
function gc_secure_pdf_uses_pretty_urls() {
	return (bool) get_option( 'permalink_structure' );
}

/**
 * Signed stream URL — server proxies PDF bytes; address bar never shows /wp-content/uploads/.
 *
 * @param string $key Registry key.
 * @return string
 */
function gc_secure_pdf_stream_url( $key ) {
	$key  = sanitize_key( (string) $key );
	$slug = gc_secure_pdf_slug_for_key( $key );
	if ( $slug === '' ) {
		return '';
	}
	$args = array(
		'token' => gc_secure_pdf_stream_token( $key ),
	);
	if ( gc_secure_pdf_uses_pretty_urls() ) {
		return add_query_arg( $args, home_url( '/report-pdf/' . $slug . '/file/' ) );
	}
	return add_query_arg(
		array_merge(
			array(
				'gc_pdf_slug' => $slug,
				'gc_pdf_file' => '1',
			),
			$args
		),
		home_url( '/' )
	);
}

/**
 * Parse report-pdf request from rewrite rules, query args, or REQUEST_URI.
 *
 * @return array{slug:string, is_file:bool}
 */
function gc_secure_pdf_parse_request() {
	$slug    = get_query_var( 'gc_pdf_slug' );
	$is_file = (string) get_query_var( 'gc_pdf_file' ) === '1';

	if ( ( ! is_string( $slug ) || $slug === '' ) && isset( $_GET['gc_pdf_slug'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$slug    = sanitize_title( wp_unslash( (string) $_GET['gc_pdf_slug'] ) );
		$is_file = isset( $_GET['gc_pdf_file'] ) && '1' === (string) wp_unslash( $_GET['gc_pdf_file'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	if ( ( ! is_string( $slug ) || $slug === '' ) && ! empty( $_SERVER['REQUEST_URI'] ) ) {
		$path = (string) wp_parse_url( wp_unslash( (string) $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( is_string( $path ) && preg_match( '#/(?:index\.php/)?report-pdf/([^/]+)/file/?$#i', $path, $matches ) ) {
			$slug    = sanitize_title( $matches[1] );
			$is_file = true;
		} elseif ( is_string( $path ) && preg_match( '#/(?:index\.php/)?report-pdf/([^/]+)/?$#i', $path, $matches ) ) {
			$slug    = sanitize_title( $matches[1] );
			$is_file = false;
		}
	}

	return array(
		'slug'    => is_string( $slug ) ? $slug : '',
		'is_file' => $is_file,
	);
}

/**
 * Token validity window (seconds). Matches signed URL cache lifetime.
 *
 * @return int
 */
function gc_secure_pdf_token_ttl() {
	return 12 * HOUR_IN_SECONDS;
}

/**
 * Seconds until the current token bucket ends (for Cache-Control max-age).
 *
 * @return int
 */
function gc_secure_pdf_cache_max_age() {
	$ttl    = gc_secure_pdf_token_ttl();
	$bucket = (int) floor( time() / $ttl );
	$expires = ( $bucket + 1 ) * $ttl;

	return max( 60, $expires - time() );
}

/**
 * @param string $key Registry key.
 * @return string
 */
function gc_secure_pdf_stream_token( $key ) {
	$key     = sanitize_key( (string) $key );
	$bucket  = (int) floor( time() / gc_secure_pdf_token_ttl() );
	$payload = $key . '|' . $bucket;

	return hash_hmac( 'sha256', $payload, wp_salt( 'gc_secure_pdf_stream' ) );
}

/**
 * @param string $key   Registry key.
 * @param string $token Token from query string.
 * @return bool
 */
function gc_secure_pdf_verify_stream_token( $key, $token ) {
	$key   = sanitize_key( (string) $key );
	$token = (string) $token;
	if ( $key === '' || $token === '' ) {
		return false;
	}
	$ttl            = gc_secure_pdf_token_ttl();
	$current_bucket = (int) floor( time() / $ttl );
	for ( $bucket = $current_bucket; $bucket >= $current_bucket - 1; $bucket-- ) {
		$payload  = $key . '|' . $bucket;
		$expected = hash_hmac( 'sha256', $payload, wp_salt( 'gc_secure_pdf_stream' ) );
		if ( hash_equals( $expected, $token ) ) {
			return true;
		}
	}
	return false;
}

/**
 * PDF response headers: cacheable for the current token window; uploads path stays hidden.
 *
 * @param string $disposition inline|attachment segment value.
 * @param string $filename    Suggested filename.
 * @param int    $length      Content-Length in bytes.
 * @param string $local_path  Optional local file for Last-Modified / ETag.
 * @return void
 */
function gc_secure_pdf_send_stream_headers( $disposition, $filename, $length, $local_path = '' ) {
	$max_age = gc_secure_pdf_cache_max_age();

	header( 'Content-Type: application/pdf' );
	header( 'Content-Disposition: ' . $disposition . '; filename="' . sanitize_file_name( $filename ) . '"' );
	header( 'Content-Length: ' . (string) $length );
	header( 'Accept-Ranges: bytes' );
	header( 'Cache-Control: public, max-age=' . $max_age );
	header( 'X-Robots-Tag: noindex, nofollow' );
	header( 'X-Content-Type-Options: nosniff' );

	if ( $local_path !== '' && is_readable( $local_path ) ) {
		$mtime = filemtime( $local_path );
		if ( false !== $mtime ) {
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $mtime ) . ' GMT' );
			header( 'ETag: "' . md5( $local_path . '|' . (string) $mtime . '|' . (string) $length ) . '"' );
		}
	}
}

/**
 * @param string $url Source URL from registry.
 * @return string
 */
function gc_secure_pdf_local_path_from_url( $url ) {
	$path = wp_parse_url( $url, PHP_URL_PATH );
	if ( ! is_string( $path ) || $path === '' ) {
		return '';
	}
	$local = ABSPATH . ltrim( $path, '/' );
	return ( is_readable( $local ) && filesize( $local ) > 0 ) ? $local : '';
}

/**
 * @param string $body Raw bytes.
 * @return bool
 */
function gc_secure_pdf_is_valid_pdf( $body ) {
	return is_string( $body ) && strlen( $body ) >= 4 && 0 === strncmp( $body, '%PDF', 4 );
}

/**
 * Temp file path for remote PDF fetch (wp_tempnam is admin-only unless loaded).
 *
 * @param string $filename Suggested basename for the temp file.
 * @return string|false
 */
function gc_secure_pdf_temp_file( $filename ) {
	if ( ! function_exists( 'wp_tempnam' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	if ( function_exists( 'wp_tempnam' ) ) {
		return wp_tempnam( $filename );
	}
	$dir = function_exists( 'wp_get_temp_dir' ) ? wp_get_temp_dir() : sys_get_temp_dir();
	$tmp = tempnam( $dir, 'gc-pdf-' );
	return is_string( $tmp ) && $tmp !== '' ? $tmp : false;
}

/**
 * Stream PDF to the client (local file or temp download for remote).
 *
 * @param string $key        Registry key.
 * @param bool   $attachment Content-Disposition attachment when true.
 * @return void
 */
function gc_secure_pdf_serve( $key, $attachment = false ) {
	$registry = gc_secure_pdf_registry();
	if ( ! isset( $registry[ $key ] ) ) {
		wp_die( esc_html__( 'Document not found.', 'gc-v2' ), '', array( 'response' => 404 ) );
	}

	$source_url = (string) apply_filters( 'gc_secure_pdf_source_url', $registry[ $key ]['url'], $key );
	$filename   = (string) $registry[ $key ]['filename'];
	if ( $source_url === '' || $filename === '' ) {
		wp_die( esc_html__( 'Document not found.', 'gc-v2' ), '', array( 'response' => 404 ) );
	}

	$disposition = $attachment ? 'attachment' : 'inline';
	$local       = gc_secure_pdf_local_path_from_url( $source_url );

	if ( $local !== '' ) {
		$length = (int) filesize( $local );
		gc_secure_pdf_send_stream_headers( $disposition, $filename, $length, $local );
		readfile( $local );
		exit;
	}

	$tmp = gc_secure_pdf_temp_file( $filename );
	if ( ! $tmp ) {
		wp_die( esc_html__( 'Unable to load document.', 'gc-v2' ), '', array( 'response' => 502 ) );
	}

	$response = wp_remote_get(
		$source_url,
		array(
			'timeout'     => 120,
			'sslverify'   => true,
			'redirection' => 5,
			'stream'      => true,
			'filename'    => $tmp,
			'user-agent'  => 'GCheck-SecurePDF/1.0; ' . home_url( '/' ),
		)
	);

	if ( is_wp_error( $response ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		wp_die( esc_html__( 'Unable to load document.', 'gc-v2' ), '', array( 'response' => 502 ) );
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 || ! is_readable( $tmp ) || filesize( $tmp ) < 4 ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		wp_die( esc_html__( 'Unable to load document.', 'gc-v2' ), '', array( 'response' => 502 ) );
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- validate header only.
	$head = file_get_contents( $tmp, false, null, 0, 4 );
	if ( ! gc_secure_pdf_is_valid_pdf( $head ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		wp_die( esc_html__( 'Unable to load document.', 'gc-v2' ), '', array( 'response' => 502 ) );
	}

	$length = (int) filesize( $tmp );
	gc_secure_pdf_send_stream_headers( $disposition, $filename, $length );
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_readfile
	readfile( $tmp );
	@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	exit;
}

/**
 * Register rewrite rules for /report-pdf/{slug}/ and /report-pdf/{slug}/file/
 */
function gc_secure_pdf_register_rewrites() {
	add_rewrite_tag( '%gc_pdf_slug%', '([^/]+)' );
	add_rewrite_tag( '%gc_pdf_file%', '([0-9]+)' );
	add_rewrite_rule( '^report-pdf/([^/]+)/file/?$', 'index.php?gc_pdf_slug=$matches[1]&gc_pdf_file=1', 'top' );
	add_rewrite_rule( '^report-pdf/([^/]+)/?$', 'index.php?gc_pdf_slug=$matches[1]', 'top' );
}
add_action( 'init', 'gc_secure_pdf_register_rewrites' );

/**
 * @param string[] $vars Query vars.
 * @return string[]
 */
function gc_secure_pdf_query_vars( $vars ) {
	$vars[] = 'gc_pdf_slug';
	$vars[] = 'gc_pdf_file';
	return $vars;
}
add_filter( 'query_vars', 'gc_secure_pdf_query_vars' );

/**
 * Flush rewrites once after deploy.
 */
function gc_secure_pdf_maybe_flush_rewrites() {
	if ( GC_SECURE_PDF_REWRITE_VERSION === get_option( 'gc_secure_pdf_rewrite_version', '' ) ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'gc_secure_pdf_rewrite_version', GC_SECURE_PDF_REWRITE_VERSION );
}
add_action( 'init', 'gc_secure_pdf_maybe_flush_rewrites', 99 );

/**
 * Route signed PDF stream (native browser viewer) and short /report-pdf/{slug}/ redirects.
 */
function gc_secure_pdf_template_redirect() {
	$request = gc_secure_pdf_parse_request();
	$slug    = $request['slug'];
	if ( $slug === '' ) {
		return;
	}

	$key = gc_secure_pdf_key_for_slug( $slug );
	if ( $key === '' ) {
		wp_die( esc_html__( 'Document not found.', 'gc-v2' ), '', array( 'response' => 404 ) );
	}

	if ( ! $request['is_file'] ) {
		$target = gc_secure_pdf_stream_url( $key );
		if ( isset( $_GET['back'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$target = add_query_arg( 'back', rawurlencode( esc_url_raw( wp_unslash( (string) $_GET['back'] ) ) ), $target );
		}
		wp_safe_redirect( $target, 302 );
		exit;
	}

	$token = isset( $_GET['token'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['token'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! gc_secure_pdf_verify_stream_token( $key, $token ) ) {
		wp_die( esc_html__( 'Invalid or expired link.', 'gc-v2' ), '', array( 'response' => 403 ) );
	}
	gc_secure_pdf_serve( $key, false );
}
add_action( 'template_redirect', 'gc_secure_pdf_template_redirect', 0 );

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
 * Enqueue click-tracking for secure PDF download links (dataLayer file_download).
 */
function gc_secure_pdf_enqueue_tracking_script() {
	if ( is_admin() ) {
		return;
	}
	$path = get_template_directory() . '/assets/js/secure-pdf-download.js';
	if ( ! is_readable( $path ) ) {
		return;
	}
	$version = function_exists( 'gc_theme_asset_version' ) ? gc_theme_asset_version( $path ) : (string) filemtime( $path );
	wp_enqueue_script(
		'gc-secure-pdf-download',
		get_template_directory_uri() . '/assets/js/secure-pdf-download.js',
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'gc_secure_pdf_enqueue_tracking_script', 20 );
