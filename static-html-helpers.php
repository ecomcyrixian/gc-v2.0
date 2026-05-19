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
}
