<?php
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

	function gc_theme_static_html_strip_css_comments( $css ) {
		// Remove /* ... */ block comments (CSS has no line comments).
		$css = preg_replace( '/\/\*[\s\S]*?\*\//', '', $css );
		// Collapse runs of 3+ blank lines down to one.
		return preg_replace( '/\n{3,}/', "\n\n", $css );
	}

	/**
	 * Wrap CSS content in @scope (#gc-static-html-page) so that global reset
	 * rules (*, body, img, a, etc.) from the static HTML file cannot bleed into
	 * the theme header/footer. :root blocks are pulled out first so that CSS
	 * custom properties remain accessible to the whole page.
	 */
	function gc_theme_static_html_scope_style_content( $css ) {
		$root_css = '';
		$rest = preg_replace_callback(
			'/:root\s*\{((?:[^{}]|\{[^{}]*\})*)\}/s',
			function ( $m ) use ( &$root_css ) {
				$root_css .= $m[0] . "\n";
				return '';
			},
			$css
		);

		$scoped = "@scope (#gc-static-html-page) {\n" . trim( (string) $rest ) . "\n}";
		return $root_css !== '' ? $root_css . $scoped : $scoped;
	}

	function gc_theme_static_html_prepare_page_markup( $html ) {
		$html    = (string) $html;
		$assets  = '';
		$content = $html;

		if ( preg_match( '/<head[^>]*>(.*)<\/head>/is', $html, $head_match ) ) {
			$head = $head_match[1];
			if ( preg_match_all( '/(?:<link\b[^>]*>|<style\b[^>]*>.*?<\/style>|<script\b[^>]*>.*?<\/script>)/is', $head, $asset_matches ) ) {
			$tags = array_map( function ( $tag ) {
				if ( stripos( $tag, '<style' ) === 0 ) {
					return preg_replace_callback(
						'/(<style\b[^>]*>)([\s\S]*?)(<\/style>)/i',
						function ( $m ) {
							$css = gc_theme_static_html_strip_css_comments( $m[2] );
							$css = gc_theme_static_html_scope_style_content( $css );
							return $m[1] . $css . $m[3];
						},
						$tag
					);
				}
				return $tag;
			}, $asset_matches[0] );
				$assets = implode( "\n", $tags );
			}
		}

		if ( preg_match( '/<body[^>]*>(.*)<\/body>/is', $html, $body_match ) ) {
			$content = $body_match[1];
		}

		return array(
			'assets'  => $assets,
			'content' => $content,
		);
	}

	function gc_theme_static_html_wrapper_attrs( $html ) {
		return '';
	}

	/**
	 * Folder name for a static page. The public slug stays short when the folder
	 * name would collide or needs to say which page it is.
	 */
	function gc_theme_static_php_folder( $slug ) {
		$folders = array(
			'compare' => 'pricing-compare',
		);

		return isset( $folders[ $slug ] ) ? $folders[ $slug ] : $slug;
	}

	/**
	 * PHP pages live at static/{folder}/content/index.php and render inside
	 * <main id="{folder}" class="gc-static-page"> between the theme header and footer.
	 */
	function gc_theme_static_php_file_path( $slug ) {
		if ( $slug === '' ) {
			return null;
		}

		$dir       = gc_theme_static_html_directory();
		$folder    = gc_theme_static_php_folder( $slug );
		$real_file = realpath( $dir . '/' . $folder . '/content/index.php' );
		$real_dir  = realpath( $dir );

		if ( ! $real_file || ! $real_dir || ! is_file( $real_file ) || strpos( $real_file, $real_dir ) !== 0 ) {
			return null;
		}

		return $real_file;
	}

	function gc_theme_get_static_php_page_slug( $post = null ) {
		if ( ! is_page_template( 'page-static-html.php' ) ) {
			return '';
		}

		$post = $post instanceof WP_Post ? $post : get_post();
		$slug = gc_theme_static_html_resolve_slug_for_post( $post );

		return gc_theme_static_php_file_path( $slug ) ? $slug : '';
	}

	function gc_theme_enqueue_static_php_page_assets( $post ) {
		$slug = gc_theme_get_static_php_page_slug( $post );

		if ( $slug === '' ) {
			return;
		}

		$theme_dir  = get_template_directory();
		$static_css = $theme_dir . '/assets/css/static-page.css';
		$scss_files = array( $theme_dir . '/assets/css/static-page.scss' );

		foreach ( (array) glob( $theme_dir . '/static/*/*/css/*.scss' ) as $scss_file ) {
			$scss_files[] = $scss_file;
		}

		foreach ( (array) glob( $theme_dir . '/static/shared/css/*.scss' ) as $scss_file ) {
			$scss_files[] = $scss_file;
		}

		wp_enqueue_style(
			'static-page-style',
			get_template_directory_uri() . '/assets/css/static-page.css',
			array( 'global-style' ),
			gc_theme_asset_version( $static_css, $scss_files ),
			'screen'
		);

		if ( 'compare' === $slug ) {
			require_once get_template_directory() . '/static/pricing-compare/content.php';

			$compare_js = $theme_dir . '/static/pricing-compare/content/js/compare.js';

			wp_enqueue_script(
				'pricing-compare',
				get_template_directory_uri() . '/static/pricing-compare/content/js/compare.js',
				array(),
				gc_theme_asset_version( $compare_js ),
				true
			);

			wp_add_inline_script(
				'pricing-compare',
				'var gcPricingCompare = ' . wp_json_encode( gc_static_pricing_compare_config() ) . ';',
				'before'
			);
		}
	}

	function gc_theme_get_static_php_page_schema_builders() {
		return array(
			'verified-entry' => array(
				'file'     => 'static/verified-entry/schema.php',
				'function' => 'gc_static_verified_entry_schema',
			),
			'compare'        => array(
				'file'     => 'static/pricing-compare/schema.php',
				'function' => 'gc_static_pricing_compare_schema',
			),
		);
	}

	function gc_theme_static_php_page_has_schema( $post = null ) {
		$slug = gc_theme_get_static_php_page_slug( $post );

		return $slug !== '' && isset( gc_theme_get_static_php_page_schema_builders()[ $slug ] );
	}

	/**
	 * Static pages with their own schema builder replace Yoast's graph. Both use the same
	 * @id values (#breadcrumb, #organization), so Google merges them into one broken node.
	 */
	function gc_theme_disable_seo_schema_for_static_php_page( $data ) {
		return is_singular() && gc_theme_static_php_page_has_schema() ? false : $data;
	}
	add_filter( 'wpseo_json_ld_output', 'gc_theme_disable_seo_schema_for_static_php_page' );

	/**
	 * The Verified Entry hero is painted from a CSS background, so the browser
	 * cannot discover it until the stylesheet arrives. Preload it.
	 */
	function gc_theme_preload_verified_entry_hero() {
		if ( 'verified-entry' !== gc_theme_get_static_php_page_slug() ) {
			return;
		}

		echo '<link rel="preload" as="image" href="' . esc_url( get_template_directory_uri() . '/assets/images/new-header.webp' ) . '" type="image/webp" fetchpriority="high">' . "\n";
	}
	add_action( 'wp_head', 'gc_theme_preload_verified_entry_hero', 1 );

	/**
	 * jQuery is only needed by the footer script on these pages. Keep it out of the head.
	 */
	function gc_theme_static_php_page_footer_jquery() {
		if ( '' === gc_theme_get_static_php_page_slug() ) {
			return;
		}

		foreach ( array( 'jquery', 'jquery-core', 'jquery-migrate' ) as $handle ) {
			wp_script_add_data( $handle, 'group', 1 );
		}
	}
	add_action( 'wp_enqueue_scripts', 'gc_theme_static_php_page_footer_jquery', 100 );

	function gc_theme_render_static_php_page_schema() {
		$post     = get_post();
		$slug     = gc_theme_get_static_php_page_slug( $post );
		$builders = gc_theme_get_static_php_page_schema_builders();

		if ( ! gc_theme_static_php_page_has_schema( $post ) ) {
			return;
		}

		require_once get_template_directory() . '/' . $builders[ $slug ]['file'];

		if ( ! function_exists( $builders[ $slug ]['function'] ) ) {
			return;
		}

		$schema = call_user_func( $builders[ $slug ]['function'], $post );

		if ( empty( $schema ) ) {
			return;
		}

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
	add_action( 'wp_head', 'gc_theme_render_static_php_page_schema' );
}
