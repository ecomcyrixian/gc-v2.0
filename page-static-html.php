<?php
/**
 * Template Name: Static HTML
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_theme_static_html_directory' ) ) {
	function gc_theme_static_html_directory() {
		return trailingslashit( get_template_directory() ) . 'static';
	}

	function gc_theme_static_html_file_path( $slug ) {
		if ( $slug === '' ) {
			return null;
		}

		$dir  = gc_theme_static_html_directory();
		$path = $dir . '/' . $slug . '.html';

		$real_file = realpath( $path );
		$real_dir  = realpath( $dir );

		if ( ! $real_file || ! $real_dir || ! is_file( $real_file ) ) {
			return null;
		}

		if ( strpos( $real_file, $real_dir ) !== 0 ) {
			return null;
		}

		return $real_file;
	}

	function gc_theme_static_html_sanitize_slug( $slug ) {
		$slug = strtolower( (string) $slug );
		return (string) preg_replace( '/[^a-z0-9_-]/', '', $slug );
	}

	function gc_theme_static_html_resolve_slug_for_post( $post ) {
		if ( ! $post instanceof WP_Post ) {
			return '';
		}
		$override = get_post_meta( $post->ID, '_gc_static_html_file', true );
		if ( $override !== '' && $override !== false ) {
			$s = gc_theme_static_html_sanitize_slug( (string) $override );
			if ( $s !== '' ) {
				return $s;
			}
		}
		if ( $post->post_name ) {
			return gc_theme_static_html_sanitize_slug( $post->post_name );
		}
		return '';
	}

	function gc_theme_static_html_get_contents_by_slug( $slug ) {
		if ( $slug === '' ) {
			return null;
		}
		$path = gc_theme_static_html_file_path( $slug );
		if ( ! $path ) {
			return null;
		}
		$html = file_get_contents( $path );
		return $html === false ? null : $html;
	}

	function gc_theme_static_html_missing_message( $message ) {
		if ( current_user_can( 'edit_pages' ) ) {
			return '<p class="gc-static-html-notice">' . esc_html( $message ) . '</p>';
		}
		return '';
	}
}

while ( have_posts() ) :
	the_post();
	global $post;
	if ( ! $post instanceof WP_Post ) {
		break;
	}
	$slug = gc_theme_static_html_resolve_slug_for_post( $post );
	if ( $slug === '' ) {
		echo gc_theme_static_html_missing_message( __( 'No slug for static HTML.', 'theme-slug' ) );
		break;
	}
	$html = gc_theme_static_html_get_contents_by_slug( $slug );
	if ( $html === null ) {
		echo gc_theme_static_html_missing_message(
			sprintf(
				__( 'Static HTML file not found: static/%s.html', 'theme-slug' ),
				$slug
			)
		);
		break;
	}
	echo $html;
endwhile;
