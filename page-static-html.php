<?php
/**
 * Template Name: Static HTML
 *
 * Renders static/{page-slug}/{page-slug}.php inside the theme header and footer when it exists,
 * otherwise prints static/{page-slug}.html as-is.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/static-html-helpers.php';

$gc_static_php_template = gc_theme_static_php_file_path(
	gc_theme_static_html_resolve_slug_for_post( get_post() )
);

if ( $gc_static_php_template ) {
	get_header();
	require $gc_static_php_template;
	get_footer();
	return;
}

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
