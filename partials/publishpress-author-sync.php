<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gc_pp_early_detect_author_term_save() {
	if ( ! is_admin() || empty( $_POST ) ) {
		return;
	}
	$is_editedtag = isset( $_POST['action'] ) && 'editedtag' === $_POST['action']
		&& isset( $_POST['taxonomy'] ) && 'author' === $_POST['taxonomy'];
	$is_pp_ajax = wp_doing_ajax()
		&& isset( $_POST['taxonomy'] ) && 'author' === $_POST['taxonomy'];
	if ( ! $is_editedtag && ! $is_pp_ajax ) {
		return;
	}

	global $gc_pp_author_term_saving;
	$gc_pp_author_term_saving = true;

	$term_id = ! empty( $_POST['tag_ID'] ) ? (int) $_POST['tag_ID'] : 0;
	if ( $term_id < 1 ) {
		return;
	}
	$current_user_id = (int) get_term_meta( $term_id, 'user_id', true );
	if ( $current_user_id < 1 ) {
		return;
	}

	global $gc_pp_protect_mapped_user;
	$gc_pp_protect_mapped_user = array(
		'term_id' => $term_id,
		'user_id' => $current_user_id,
	);
}

add_action( 'admin_init', 'gc_pp_early_detect_author_term_save', 0 );

function gc_pp_restore_mapped_user_after_save() {
	global $gc_pp_protect_mapped_user;
	if ( empty( $gc_pp_protect_mapped_user ) ) {
		return;
	}
	$term_id     = $gc_pp_protect_mapped_user['term_id'];
	$expected_id = $gc_pp_protect_mapped_user['user_id'];
	$current_id  = (int) get_term_meta( $term_id, 'user_id', true );

	if ( $current_id < 1 && $expected_id > 0 ) {
		update_term_meta( $term_id, 'user_id', $expected_id );
	}
}

add_action( 'shutdown', 'gc_pp_restore_mapped_user_after_save', 0 );

function gc_pp_desired_author_slug_from_user( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 ) {
		return '';
	}
	$first = trim( (string) get_user_meta( $user_id, 'first_name', true ) );
	$last  = trim( (string) get_user_meta( $user_id, 'last_name', true ) );
	if ( $first !== '' || $last !== '' ) {
		return sanitize_title( trim( $first . '-' . $last ) );
	}
	$user = get_userdata( $user_id );
	if ( $user instanceof WP_User && trim( (string) $user->display_name ) !== '' ) {
		return sanitize_title( $user->display_name );
	}
	return '';
}

function gc_pp_get_display_slug( $term_id ) {
	$term_id = (int) $term_id;
	if ( $term_id < 1 ) {
		return '';
	}
	$display = get_term_meta( $term_id, 'gc_display_slug', true );
	if ( is_string( $display ) && $display !== '' ) {
		return $display;
	}
	$user_id = (int) get_term_meta( $term_id, 'user_id', true );
	if ( $user_id > 0 ) {
		$desired = gc_pp_desired_author_slug_from_user( $user_id );
		if ( $desired !== '' ) {
			return $desired;
		}
	}
	$slug = get_term_field( 'slug', $term_id, 'author', 'raw' );
	return ( ! is_wp_error( $slug ) && is_string( $slug ) ) ? $slug : '';
}

function gc_pp_set_display_slug( $term_id, $user_id ) {
	$term_id = (int) $term_id;
	$user_id = (int) $user_id;
	if ( $term_id < 1 || $user_id < 1 ) {
		return;
	}
	$desired = gc_pp_desired_author_slug_from_user( $user_id );
	if ( $desired !== '' ) {
		update_term_meta( $term_id, 'gc_display_slug', $desired );
	}
}

function gc_pp_url_from_attachment_id( $attachment_id ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id < 1 ) {
		return '';
	}
	foreach ( array( array( 156, 156 ), 'medium_large', 'full' ) as $size ) {
		$url = wp_get_attachment_image_url( $attachment_id, $size );
		if ( $url ) {
			return $url;
		}
	}
	return '';
}

function gc_author_bio_format_pbsa_fcra_link( $plain_text ) {
	$plain_text = (string) $plain_text;
	if ( $plain_text === '' ) {
		return '';
	}

	$credentials = apply_filters(
		'gc_author_bio_pbsa_credential_phrases',
		array(
			array(
				'phrase' => 'Advanced FCRA certification from PBSA',
				'url'    => 'https://credential.thepbsa.org/135098ec-8c34-46c3-aea6-16fa553d86aa#acc.TUb86aAu',
			),
			array(
				'phrase' => 'PBSA FCRA Advanced Certified',
				'url'    => 'https://credential.thepbsa.org/841ef2e0-e6d2-478b-a646-f758d3843dd5#acc.9A8Ca2j5',
			),
		)
	);

	$book_title = apply_filters(
		'gc_author_bio_book_title_italic',
		'Decoding Humans: How Fear, Happiness, and AI Shape Every Decision We Make'
	);

	$chunks = array( array( 't' => 'text', 'c' => $plain_text ) );

	foreach ( $credentials as $cred ) {
		$phrase = isset( $cred['phrase'] ) ? (string) $cred['phrase'] : '';
		$url    = isset( $cred['url'] ) ? (string) $cred['url'] : '';
		if ( $phrase === '' || $url === '' ) {
			continue;
		}
		$next = array();
		foreach ( $chunks as $ch ) {
			if ( $ch['t'] !== 'text' || strpos( $ch['c'], $phrase ) === false ) {
				$next[] = $ch;
				continue;
			}
			$parts = explode( $phrase, $ch['c'] );
			$n     = count( $parts );
			foreach ( $parts as $i => $part ) {
				if ( $part !== '' ) {
					$next[] = array( 't' => 'text', 'c' => $part );
				}
				if ( $i < $n - 1 ) {
					$next[] = array( 't' => 'cred', 'phrase' => $phrase, 'url' => $url );
				}
			}
		}
		$chunks = $next;
	}

	if ( is_string( $book_title ) && $book_title !== '' ) {
		$next = array();
		foreach ( $chunks as $ch ) {
			if ( $ch['t'] !== 'text' || strpos( $ch['c'], $book_title ) === false ) {
				$next[] = $ch;
				continue;
			}
			$parts = explode( $book_title, $ch['c'] );
			$n     = count( $parts );
			foreach ( $parts as $i => $part ) {
				if ( $part !== '' ) {
					$next[] = array( 't' => 'text', 'c' => $part );
				}
				if ( $i < $n - 1 ) {
					$next[] = array( 't' => 'book', 'title' => $book_title );
				}
			}
		}
		$chunks = $next;
	}

	$out = '';
	foreach ( $chunks as $ch ) {
		if ( $ch['t'] === 'text' ) {
			$out .= esc_html( $ch['c'] );
		} elseif ( $ch['t'] === 'cred' ) {
			$out .= sprintf(
				'<span class="author-bio-credential author-bio-credential--nowrap"><a href="%s" class="author-bio-credential__link" target="_blank" rel="noopener noreferrer">%s</a></span>',
				esc_url( $ch['url'] ),
				esc_html( $ch['phrase'] )
			);
		} elseif ( $ch['t'] === 'book' ) {
			$out .= '<em class="author-bio-book-title">' . esc_html( $ch['title'] ) . '</em>';
		}
	}

	return $out;
}

function gc_pp_get_author_template_data( $queried ) {
	$defaults = array(
		'ppma_author'      => null,
		'display_name'     => '',
		'first_name'       => '',
		'last_name'        => '',
		'user_email'       => '',
		'user_url'         => '',
		'user_job'         => '',
		'user_facebook'    => '',
		'user_twitter'     => '',
		'user_instagram'   => '',
		'user_LinkedIn'    => '',
		'user_description' => '',
		'avatar_url'       => '',
	);

	if ( ! is_object( $queried ) ) {
		return apply_filters( 'gc_pp_author_template_data', $defaults, $queried );
	}

	if ( $queried instanceof WP_User && class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		$pp_try = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( (int) $queried->ID );
		if ( is_object( $pp_try ) && ! empty( $pp_try->term_id ) ) {
			$author_term = get_term( (int) $pp_try->term_id, 'author' );
			if ( $author_term instanceof WP_Term && ! is_wp_error( $author_term ) ) {
				return gc_pp_get_author_template_data( $author_term );
			}
		}
	}

	$ppma_author = null;
	if ( $queried instanceof WP_Term && isset( $queried->taxonomy ) && 'author' === $queried->taxonomy && class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		$candidate = \MultipleAuthors\Classes\Objects\Author::get_by_term_id( (int) $queried->term_id );
		if ( is_object( $candidate ) ) {
			$ppma_author = $candidate;
		}
	}

	if ( $ppma_author && method_exists( $ppma_author, 'get_meta' ) ) {
		$out = array(
			'ppma_author'      => $ppma_author,
			'display_name'     => isset( $ppma_author->display_name ) ? (string) $ppma_author->display_name : '',
			'first_name'       => (string) $ppma_author->get_meta( 'first_name' ),
			'last_name'        => (string) $ppma_author->get_meta( 'last_name' ),
			'user_email'       => isset( $ppma_author->user_email ) ? (string) $ppma_author->user_email : '',
			'user_url'         => isset( $ppma_author->user_url ) ? (string) $ppma_author->user_url : '',
			'user_job'         => (string) $ppma_author->get_meta( 'job_title' ),
			'user_facebook'    => (string) $ppma_author->get_meta( 'facebook' ),
			'user_twitter'     => (string) $ppma_author->get_meta( 'twitter' ),
			'user_instagram'   => (string) $ppma_author->get_meta( 'instagram' ),
			'user_LinkedIn'    => (string) $ppma_author->get_meta( 'linkedin' ),
			'user_description' => (string) $ppma_author->get_meta( 'description' ),
			'avatar_url'       => '',
		);

		if ( $out['user_description'] === '' && method_exists( $ppma_author, 'get_user_object' ) ) {
			$u = $ppma_author->get_user_object();
			if ( $u instanceof WP_User ) {
				$out['user_description'] = (string) $u->description;
			}
		}

		if ( $queried instanceof WP_Term ) {
			$att_id = (int) get_term_meta( (int) $queried->term_id, 'avatar', true );
			if ( $att_id > 0 ) {
				$out['avatar_url'] = gc_pp_url_from_attachment_id( $att_id );
			}
		}

		if ( $out['avatar_url'] === '' && $out['user_email'] !== '' ) {
			$out['avatar_url'] = get_avatar_url( $out['user_email'], array( 'size' => 156 ) );
		}

		return apply_filters( 'gc_pp_author_template_data', $out, $queried );
	}

	$uid = (int) get_queried_object_id();
	$out = array(
		'ppma_author'      => null,
		'display_name'     => get_the_author_meta( 'display_name', $uid ),
		'first_name'       => get_the_author_meta( 'first_name', $uid ),
		'last_name'        => get_the_author_meta( 'last_name', $uid ),
		'user_email'       => get_the_author_meta( 'user_email', $uid ),
		'user_url'         => get_the_author_meta( 'user_url', $uid ),
		'user_job'         => '',
		'user_facebook'    => get_the_author_meta( 'facebook', $uid ),
		'user_twitter'     => get_the_author_meta( 'twitter', $uid ),
		'user_instagram'   => get_the_author_meta( 'instagram', $uid ),
		'user_LinkedIn'    => get_the_author_meta( 'linkedin', $uid ),
		'user_description' => get_the_author_meta( 'user_description', $uid ),
		'avatar_url'       => '',
	);

	if ( $out['user_email'] !== '' ) {
		$out['avatar_url'] = get_avatar_url( $out['user_email'], array( 'size' => 156 ) );
	}

	return apply_filters( 'gc_pp_author_template_data', $out, $queried );
}

function gc_pp_copy_user_fields_to_author_term( $term_id, $user_id ) {
	$term_id = (int) $term_id;
	$user_id = (int) $user_id;
	if ( $term_id < 1 || $user_id < 1 || ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_term', $term_id ) && ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}

	$user = get_userdata( $user_id );
	if ( ! $user ) {
		return;
	}

	$fields = apply_filters( 'gc_pp_sync_user_to_author_term_fields', array(
		'first_name'  => $user->first_name,
		'last_name'   => $user->last_name,
		'description' => get_user_meta( $user_id, 'description', true ),
	), $term_id, $user_id );

	foreach ( $fields as $meta_key => $value ) {
		if ( $value === null || $value === '' ) {
			continue;
		}
		if ( is_string( $value ) ) {
			$value = wp_unslash( $value );
		}
		update_term_meta( $term_id, $meta_key, $value );
	}

	do_action( 'gc_pp_after_copy_user_fields_to_author_term', $term_id, $user_id );
}

function gc_pp_get_author_taxonomy_url( $term_id ) {
	$term_id = (int) $term_id;
	if ( $term_id < 1 ) {
		return '';
	}
	$tl = get_term_link( $term_id, 'author' );
	return ( ! is_wp_error( $tl ) && is_string( $tl ) ) ? $tl : '';
}

function gc_pp_unparse_url( $parts ) {
	if ( ! is_array( $parts ) ) {
		return '';
	}
	return ( isset( $parts['scheme'] ) ? $parts['scheme'] . '://' : '' )
		. ( isset( $parts['host'] ) ? $parts['host'] : '' )
		. ( isset( $parts['port'] ) ? ':' . (int) $parts['port'] : '' )
		. ( isset( $parts['path'] ) ? $parts['path'] : '' )
		. ( isset( $parts['query'] ) ? '?' . $parts['query'] : '' )
		. ( isset( $parts['fragment'] ) ? '#' . $parts['fragment'] : '' );
}

function gc_pp_author_url_rewrite_base_segment() {
	$tax = get_taxonomy( 'author' );
	if ( $tax && is_array( $tax->rewrite ) && ! empty( $tax->rewrite['slug'] ) ) {
		$slug = trim( (string) $tax->rewrite['slug'], '/' );
		if ( $slug !== '' ) {
			return $slug;
		}
	}
	return 'author';
}

function gc_pp_term_link_force_author_term_slug( $url, $term, $taxonomy ) {
	if ( 'author' !== $taxonomy || ! $term instanceof WP_Term || is_wp_error( $term ) ) {
		return $url;
	}
	$slug = gc_pp_get_display_slug( (int) $term->term_id );
	if ( $slug === '' ) {
		return $url;
	}
	$base   = gc_pp_author_url_rewrite_base_segment();
	$parsed = wp_parse_url( $url );
	if ( ! is_array( $parsed ) || empty( $parsed['path'] ) ) {
		return $url;
	}
	$pattern = '#(/' . preg_quote( $base, '#' ) . '/)([^/]+)(?=/|$)#';
	if ( ! preg_match( $pattern, $parsed['path'], $m ) || $m[2] === $slug ) {
		return $url;
	}
	$parsed['path'] = preg_replace( $pattern, '$1' . $slug, $parsed['path'], 1 );
	$fixed = gc_pp_unparse_url( $parsed );
	return $fixed !== '' ? $fixed : $url;
}

function gc_pp_sync_author_from_user( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 || ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}
	if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}
	$author = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( $user_id );
	if ( ! is_object( $author ) || empty( $author->term_id ) ) {
		return;
	}
	gc_pp_copy_user_fields_to_author_term( (int) $author->term_id, $user_id );
	gc_pp_set_display_slug( (int) $author->term_id, $user_id );
}

add_action( 'profile_update', 'gc_pp_sync_author_from_user', 99, 1 );

function gc_pp_on_author_term_edited_sync_from_user( $term_id, $tt_id, $taxonomy ) {
	if ( 'author' !== $taxonomy ) {
		return;
	}
	global $gc_pp_author_term_saving;
	$gc_pp_author_term_saving = true;
}

add_action( 'edited_term', 'gc_pp_on_author_term_edited_sync_from_user', 9999999, 3 );

function gc_pp_on_author_user_id_meta_set( $meta_id, $term_id, $meta_key, $meta_value ) {
	if ( 'user_id' !== $meta_key ) {
		return;
	}
	$term_id = (int) $term_id;
	$term    = get_term( $term_id );
	if ( ! $term instanceof WP_Term || 'author' !== $term->taxonomy ) {
		return;
	}
	$user_id = (int) $meta_value;
	if ( $user_id < 1 ) {
		return;
	}
	gc_pp_set_display_slug( $term_id, $user_id );
	global $gc_pp_author_term_saving;
	if ( ! empty( $gc_pp_author_term_saving ) ) {
		return;
	}
	gc_pp_copy_user_fields_to_author_term( $term_id, $user_id );
}

add_action( 'added_term_meta', 'gc_pp_on_author_user_id_meta_set', 20, 4 );
add_action( 'updated_term_meta', 'gc_pp_on_author_user_id_meta_set', 20, 4 );

function gc_pp_parse_author_request_slug( $path ) {
	$path = is_string( $path ) ? trim( $path, '/' ) : '';
	if ( $path === '' ) {
		return '';
	}
	$bases = array( gc_pp_author_url_rewrite_base_segment() );
	global $wp_rewrite;
	if ( $wp_rewrite instanceof WP_Rewrite ) {
		$ab = trim( (string) $wp_rewrite->author_base, '/' );
		if ( $ab !== '' && ! in_array( $ab, $bases, true ) ) {
			$bases[] = $ab;
		}
	}
	$parts = explode( '/', $path );
	$idx   = false;
	foreach ( $bases as $base ) {
		$found = array_search( $base, $parts, true );
		if ( false !== $found ) {
			$idx = $found;
			break;
		}
	}
	if ( false === $idx || ! isset( $parts[ $idx + 1 ] ) ) {
		return '';
	}
	$slug = (string) $parts[ $idx + 1 ];
	if ( in_array( $slug, array( 'feed', 'embed', 'trackback' ), true ) ) {
		return '';
	}
	return sanitize_title_for_query( $slug );
}

function gc_pp_current_request_path_normalized() {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	$path = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
	return is_string( $path ) ? untrailingslashit( $path ) : '';
}

function gc_pp_redirect_legacy_author_nicename_to_term() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}
	if ( is_feed() || is_trackback() || is_embed() || is_preview() ) {
		return;
	}
	if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}

	$current_path   = gc_pp_current_request_path_normalized();
	$slug_from_path = gc_pp_parse_author_request_slug( $current_path );
	if ( $slug_from_path === '' || $current_path === '' ) {
		return;
	}

	$term_id = 0;
	$term    = get_term_by( 'slug', $slug_from_path, 'author' );
	if ( $term instanceof WP_Term && ! is_wp_error( $term ) ) {
		$term_id = (int) $term->term_id;
	} else {
		$user = get_user_by( 'slug', $slug_from_path );
		if ( $user instanceof WP_User ) {
			$pp = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( (int) $user->ID );
			if ( is_object( $pp ) && ! empty( $pp->term_id ) ) {
				$term_id = (int) $pp->term_id;
			}
		}
	}

	if ( $term_id < 1 ) {
		return;
	}

	$target = gc_pp_get_author_taxonomy_url( $term_id );
	if ( $target === '' ) {
		return;
	}
	$tpath = wp_parse_url( $target, PHP_URL_PATH );
	if ( ! is_string( $tpath ) || untrailingslashit( $tpath ) === $current_path ) {
		return;
	}
	wp_safe_redirect( $target, 301 );
	exit;
}

add_action( 'template_redirect', 'gc_pp_redirect_legacy_author_nicename_to_term', 0 );

function gc_pp_resolve_display_slug_author_request() {
	if ( is_admin() || ! is_404() ) {
		return;
	}
	if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}
	$slug = gc_pp_parse_author_request_slug( gc_pp_current_request_path_normalized() );
	if ( $slug === '' ) {
		return;
	}
	$term = get_term_by( 'slug', $slug, 'author' );
	if ( $term instanceof WP_Term ) {
		return;
	}
	global $wpdb;
	$term_id = $wpdb->get_var( $wpdb->prepare(
		"SELECT term_id FROM {$wpdb->termmeta} WHERE meta_key = 'gc_display_slug' AND meta_value = %s LIMIT 1",
		$slug
	) );
	if ( ! $term_id ) {
		return;
	}
	$term = get_term( (int) $term_id, 'author' );
	if ( ! $term instanceof WP_Term || is_wp_error( $term ) ) {
		return;
	}
	global $wp_query;
	$wp_query = new WP_Query( array(
		'post_type' => 'post',
		'tax_query' => array( array(
			'taxonomy' => 'author',
			'field'    => 'term_id',
			'terms'    => (int) $term->term_id,
		) ),
	) );
	$wp_query->queried_object    = $term;
	$wp_query->queried_object_id = (int) $term->term_id;
	$wp_query->is_archive        = true;
	$wp_query->is_tax            = true;
	$wp_query->is_404            = false;
	status_header( 200 );
}

add_action( 'wp', 'gc_pp_resolve_display_slug_author_request', 1 );

function gc_pp_fix_author_link_to_ppma_term( $link, $author_id, $author_nicename ) {
	$author_id = (int) $author_id;
	if ( $author_id < 1 || ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return $link;
	}
	$pp = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( $author_id );
	if ( ! is_object( $pp ) || empty( $pp->term_id ) ) {
		return $link;
	}
	$tl = gc_pp_get_author_taxonomy_url( (int) $pp->term_id );
	return $tl !== '' ? $tl : $link;
}

function gc_pp_ppma_author_attribute_link_use_term( $return, $term_id, $attribute, $author ) {
	if ( ! is_object( $author ) || ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return $return;
	}
	if ( ! method_exists( $author, 'is_guest' ) || $author->is_guest() || empty( $author->term_id ) ) {
		return $return;
	}
	$tid = (int) $author->term_id;

	if ( 'link' === $attribute && ! is_admin() ) {
		$tl = gc_pp_get_author_taxonomy_url( $tid );
		return $tl !== '' ? $tl : $return;
	}
	if ( 'slug' === $attribute && ! is_admin() ) {
		$display = gc_pp_get_display_slug( $tid );
		if ( $display !== '' ) {
			return $display;
		}
	}

	return $return;
}

function gc_pp_register_author_url_filters() {
	add_filter( 'publishpress_authors_author_attribute', 'gc_pp_ppma_author_attribute_link_use_term', 99999, 4 );
	add_filter( 'term_link', 'gc_pp_term_link_force_author_term_slug', 999999, 3 );
	add_filter( 'author_link', 'gc_pp_fix_author_link_to_ppma_term', PHP_INT_MAX, 3 );
}

add_action( 'wp_loaded', 'gc_pp_register_author_url_filters', 99999 );

function gc_pp_force_theme_author_template( $template ) {
	$theme_author = get_template_directory() . '/author.php';
	if ( ! file_exists( $theme_author ) ) {
		return $template;
	}
	if ( is_tax( 'author' ) ) {
		return $theme_author;
	}
	if ( is_author() && class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		$u = get_queried_object();
		if ( $u instanceof WP_User ) {
			$pp = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( (int) $u->ID );
			if ( is_object( $pp ) && ! empty( $pp->term_id ) ) {
				return $theme_author;
			}
		}
	}
	return $template;
}

add_filter( 'template_include', 'gc_pp_force_theme_author_template', 999 );

function gc_pp_fix_author_term_row_view_link( $actions, $tag ) {
	if ( ! is_array( $actions ) || ! isset( $actions['view'] ) || ! $tag instanceof WP_Term ) {
		return $actions;
	}
	$url = gc_pp_get_author_taxonomy_url( (int) $tag->term_id );
	if ( $url === '' ) {
		return $actions;
	}
	$actions['view'] = sprintf(
		'<a href="%s" aria-label="%s">%s</a>',
		esc_url( $url ),
		esc_attr( sprintf( __( 'View &#8220;%s&#8221; archive' ), $tag->name ) ),
		__( 'View' )
	);
	return $actions;
}

add_filter( 'author_row_actions', 'gc_pp_fix_author_term_row_view_link', 999, 2 );

function gc_pp_admin_fix_author_term_view_button_href() {
	if ( ! is_admin() ) {
		return;
	}
	if ( empty( $_GET['taxonomy'] ) || 'author' !== $_GET['taxonomy'] || empty( $_GET['tag_ID'] ) ) {
		return;
	}
	$term_id = (int) $_GET['tag_ID'];
	if ( $term_id < 1 || ! current_user_can( 'edit_term', $term_id ) ) {
		return;
	}
	$url = gc_pp_get_author_taxonomy_url( $term_id );
	if ( $url === '' ) {
		return;
	}
	$url_json = wp_json_encode( $url );
	?>
	<script>
	(function (u) {
		if (!u) return;
		function patch() {
			document.querySelectorAll('#wpbody-content a[href*="/author/"]').forEach(function (a) {
				a.setAttribute('href', u);
			});
		}
		patch();
		setTimeout(patch, 0);
		setTimeout(patch, 200);
	})(<?php echo $url_json; ?>);
	</script>
	<?php
}

add_action( 'admin_footer', 'gc_pp_admin_fix_author_term_view_button_href', 99 );
