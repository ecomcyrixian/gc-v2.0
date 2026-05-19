<?php
/**
 * Template Name: Static HTML
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/static-html-helpers.php';

while ( have_posts() ) :
	the_post();
	$post = get_post();
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
