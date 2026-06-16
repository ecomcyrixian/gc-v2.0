<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gc_pp_attachment_url_to_postid_lenient( $url ) {
	$url = is_string( $url ) ? trim( $url ) : '';
	if ( $url === '' ) {
		return 0;
	}
	$url = strtok( $url, '?' );
	$id  = (int) attachment_url_to_postid( $url );
	if ( $id > 0 ) {
		return $id;
	}
	if ( preg_match( '#^(.+)-\d+x\d+(\.[^.]+)$#i', $url, $m ) ) {
		$id = (int) attachment_url_to_postid( $m[1] . $m[2] );
		if ( $id > 0 ) {
			return $id;
		}
	}
	return 0;
}

function gc_pp_user_meta_fallback_avatar_id( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 ) {
		return 0;
	}
	$all = get_user_meta( $user_id );
	if ( ! is_array( $all ) ) {
		return 0;
	}
	foreach ( $all as $values ) {
		foreach ( (array) $values as $v ) {
			if ( ! is_string( $v ) || strlen( $v ) < 15 ) {
				continue;
			}
			if ( ! preg_match( '#^https?://#i', $v ) ) {
				continue;
			}
			if ( strpos( $v, 'uploads' ) === false && strpos( $v, '/wp-content/' ) === false ) {
				continue;
			}
			$id = (int) attachment_url_to_postid( $v );
			if ( $id < 1 ) {
				$id = (int) gc_pp_attachment_url_to_postid_lenient( $v );
			}
			if ( $id > 0 && wp_attachment_is_image( $id ) ) {
				return $id;
			}
		}
	}
	foreach ( $all as $key => $values ) {
		if ( ! preg_match( '/avatar|photo|profile|picture|image|upload/i', (string) $key ) ) {
			continue;
		}
		foreach ( (array) $values as $v ) {
			if ( ! is_numeric( $v ) ) {
				continue;
			}
			$aid = (int) $v;
			if ( $aid > 0 && 'attachment' === get_post_type( $aid ) && wp_attachment_is_image( $aid ) ) {
				return $aid;
			}
		}
	}
	return 0;
}

function gc_pp_resolve_user_avatar_attachment_id( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 ) {
		return 0;
	}

	$keys = apply_filters(
		'gc_pp_user_avatar_meta_keys',
		array(
			'simple_local_avatar',
			'wp_user_avatar',
			'user_avatar',
			'metabox_avatar_id',
			'mepr_avatar',
			'profile_photo',
			'author_profile_image',
			'user_profile_photo',
			'upload_photo',
			'profile_picture',
		)
	);

	foreach ( $keys as $key ) {
		$val = get_user_meta( $user_id, $key, true );
		$id  = 0;

		if ( is_array( $val ) ) {
			if ( isset( $val['media_id'] ) ) {
				$id = (int) $val['media_id'];
			} elseif ( isset( $val['full'] ) && is_numeric( $val['full'] ) ) {
				$id = (int) $val['full'];
			}
		} elseif ( is_numeric( $val ) ) {
			$id = (int) $val;
		} elseif ( is_string( $val ) && preg_match( '#^https?://#i', $val ) ) {
			$id = (int) attachment_url_to_postid( $val );
			if ( $id < 1 ) {
				$id = (int) gc_pp_attachment_url_to_postid_lenient( $val );
			}
		}

		if ( $id > 0 && 'attachment' === get_post_type( $id ) ) {
			return $id;
		}
	}

	$fallback = gc_pp_user_meta_fallback_avatar_id( $user_id );
	if ( $fallback > 0 ) {
		return $fallback;
	}

	return (int) apply_filters( 'gc_pp_user_avatar_attachment_id', 0, $user_id );
}

function gc_pp_url_from_attachment_id( $attachment_id ) {
	$attachment_id = (int) $attachment_id;
	if ( $attachment_id < 1 ) {
		return '';
	}
	$url = wp_get_attachment_image_url( $attachment_id, array( 156, 156 ) );
	if ( ! $url ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'medium_large' );
	}
	if ( ! $url ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'full' );
	}
	return $url ? $url : '';
}

function gc_pp_resolve_mapped_user_id_for_author( $ppma_author, $queried_term ) {
	if ( method_exists( $ppma_author, 'get_user_object' ) ) {
		$u = $ppma_author->get_user_object();
		if ( $u instanceof WP_User ) {
			return (int) $u->ID;
		}
	}
	if ( $queried_term instanceof WP_Term ) {
		$from_term = (int) get_term_meta( (int) $queried_term->term_id, 'user_id', true );
		if ( $from_term > 0 ) {
			return $from_term;
		}
	}
	if ( is_object( $ppma_author ) && isset( $ppma_author->user_id ) ) {
		$uid = (int) $ppma_author->user_id;
		if ( $uid > 0 ) {
			return $uid;
		}
	}
	return 0;
}

function gc_pp_resolve_user_job_title_for_display( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 ) {
		return '';
	}
	$keys = apply_filters(
		'gc_pp_user_job_title_meta_keys',
		array( 'job_title', 'employer_name', 'position', 'title', 'job', 'occupation' )
	);
	foreach ( $keys as $key ) {
		$v = get_user_meta( $user_id, $key, true );
		if ( is_string( $v ) && trim( $v ) !== '' ) {
			return trim( wp_unslash( $v ) );
		}
	}
	if ( function_exists( 'get_field' ) ) {
		$acf_keys = apply_filters(
			'gc_pp_user_job_title_acf_fields',
			array( 'job_title', 'employer_name', 'employer_title', 'job' )
		);
		foreach ( $acf_keys as $field ) {
			$v = get_field( $field, 'user_' . $user_id );
			if ( is_string( $v ) && trim( $v ) !== '' ) {
				return trim( $v );
			}
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
                    'phrase' => 'FCRA Advanced certification',
                    'url'    => 'https://credential.thepbsa.org/b3c23763-fb8a-4478-93bb-e8630f5cf451#acc.WEhM9fLe',
                ),
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
		$pp_by_user = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( (int) $queried->ID );
		if ( is_object( $pp_by_user ) && ! empty( $pp_by_user->term_id ) ) {
			$author_term = get_term( (int) $pp_by_user->term_id, 'author' );
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

		if ( trim( (string) $out['user_job'] ) === '' && $queried instanceof WP_Term ) {
			$out['user_job'] = (string) get_term_meta( (int) $queried->term_id, 'job_title', true );
		}

		if ( $out['user_description'] === '' && method_exists( $ppma_author, 'get_user_object' ) ) {
			$u = $ppma_author->get_user_object();
			if ( $u instanceof WP_User ) {
				$out['user_description'] = (string) $u->description;
			}
		}

		$mapped = gc_pp_resolve_mapped_user_id_for_author( $ppma_author, $queried instanceof WP_Term ? $queried : null );

		if ( trim( (string) $out['user_job'] ) === '' && $mapped > 0 ) {
			$job = gc_pp_resolve_user_job_title_for_display( $mapped );
			if ( $job === '' ) {
				$job = (string) get_user_meta( $mapped, 'job_title', true );
			}
			$out['user_job'] = $job;
		}

		$avatar_url = '';
		if ( $queried instanceof WP_Term ) {
			$att_id = (int) get_term_meta( (int) $queried->term_id, 'avatar', true );
			if ( $att_id > 0 ) {
				$avatar_url = gc_pp_url_from_attachment_id( $att_id );
			}
		}
		if ( $avatar_url === '' && $mapped > 0 ) {
			$uid_att = (int) gc_pp_resolve_user_avatar_attachment_id( $mapped );
			if ( $uid_att > 0 ) {
				$avatar_url = gc_pp_url_from_attachment_id( $uid_att );
			}
		}
		if ( $avatar_url === '' && $mapped > 0 ) {
			$ad = get_avatar_data(
				$mapped,
				array(
					'size' => 156,
					'alt'  => trim( $out['first_name'] . ' ' . $out['last_name'] ),
				)
			);
			if ( is_array( $ad ) && ! empty( $ad['url'] ) ) {
				$avatar_url = (string) $ad['url'];
			}
		}
		if ( $avatar_url === '' && method_exists( $ppma_author, 'get_avatar_url' ) ) {
			$av = $ppma_author->get_avatar_url( 156 );
			if ( is_array( $av ) && ! empty( $av['url'] ) ) {
				$avatar_url = (string) $av['url'];
			} elseif ( is_string( $av ) ) {
				$avatar_url = trim( $av );
			}
		}
		if ( $avatar_url === '' && $out['user_email'] !== '' ) {
			$avatar_url = get_avatar_url( $out['user_email'], array( 'size' => 156 ) );
		}

		$out['avatar_url'] = $avatar_url;

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
		'user_job'         => get_the_author_meta( 'job_title', $uid ),
		'user_facebook'    => get_the_author_meta( 'facebook', $uid ),
		'user_twitter'     => get_the_author_meta( 'twitter', $uid ),
		'user_instagram'   => get_the_author_meta( 'instagram', $uid ),
		'user_LinkedIn'    => get_the_author_meta( 'linkedin', $uid ),
		'user_description' => get_the_author_meta( 'user_description', $uid ),
		'avatar_url'       => '',
	);

	$avatar_url = '';
	$ad         = get_avatar_data(
		$uid,
		array(
			'size' => 156,
			'alt'  => trim( $out['first_name'] . ' ' . $out['last_name'] ),
		)
	);
	if ( is_array( $ad ) && ! empty( $ad['url'] ) ) {
		$avatar_url = (string) $ad['url'];
	}
	if ( $avatar_url === '' && $out['user_email'] !== '' ) {
		$ad = get_avatar_data( $out['user_email'], array( 'size' => 156 ) );
		if ( is_array( $ad ) && ! empty( $ad['url'] ) ) {
			$avatar_url = (string) $ad['url'];
		}
	}

	if ( $queried instanceof WP_User && is_callable( array( '\MultipleAuthors\Classes\Objects\Author', 'get_by_term_slug' ) ) ) {
		$pp_for_slug = \MultipleAuthors\Classes\Objects\Author::get_by_term_slug( $queried->user_nicename );
		if ( is_object( $pp_for_slug ) && isset( $pp_for_slug->term_id ) ) {
			$tid     = (int) $pp_for_slug->term_id;
			$has_att = ( (int) get_term_meta( $tid, 'avatar', true ) ) > 0;
			$has_pp  = $has_att || ( method_exists( $pp_for_slug, 'has_custom_avatar' ) && $pp_for_slug->has_custom_avatar() );
			if ( $has_pp ) {
				$pp_img = '';
				if ( method_exists( $pp_for_slug, 'get_avatar_url' ) ) {
					$pv = $pp_for_slug->get_avatar_url( 156 );
					if ( is_array( $pv ) && ! empty( $pv['url'] ) ) {
						$pp_img = (string) $pv['url'];
					} elseif ( is_string( $pv ) ) {
						$pp_img = trim( $pv );
					}
				}
				if ( $pp_img === '' && $has_att ) {
					$aid = (int) get_term_meta( $tid, 'avatar', true );
					if ( $aid > 0 ) {
						$pp_img = gc_pp_url_from_attachment_id( $aid );
					}
				}
				if ( $pp_img !== '' ) {
					$avatar_url = $pp_img;
				}
			}
		}
	}

	$out['avatar_url'] = $avatar_url;

	return apply_filters( 'gc_pp_author_template_data', $out, $queried );
}

function gc_pp_copy_user_fields_to_author_term( $term_id, $user_id ) {
	$term_id = (int) $term_id;
	$user_id = (int) $user_id;
	if ( $term_id < 1 || $user_id < 1 ) {
		return;
	}

	$user = get_userdata( $user_id );
	if ( ! $user ) {
		return;
	}

	$fields = array(
		'first_name'  => $user->first_name,
		'last_name'   => $user->last_name,
		'description' => get_user_meta( $user_id, 'description', true ),
		'job_title'   => get_user_meta( $user_id, 'job_title', true ),
	);

	$fields = apply_filters( 'gc_pp_sync_user_to_author_term_fields', $fields, $term_id, $user_id );

	foreach ( $fields as $meta_key => $value ) {
		if ( $value === null || $value === '' ) {
			continue;
		}
		if ( is_string( $value ) ) {
			$value = wp_unslash( $value );
		}
		update_term_meta( $term_id, $meta_key, $value );
	}

	$avatar_id = gc_pp_resolve_user_avatar_attachment_id( $user_id );
	if ( $avatar_id > 0 ) {
		update_term_meta( $term_id, 'avatar', $avatar_id );
	}

	do_action( 'gc_pp_after_copy_user_fields_to_author_term', $term_id, $user_id );
}

function gc_pp_sync_author_term_from_mapped_user( $term_id ) {
	$term_id = (int) $term_id;
	if ( $term_id < 1 ) {
		return;
	}
	if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}
	$user_id = (int) get_term_meta( $term_id, 'user_id', true );
	if ( $user_id < 1 ) {
		return;
	}
	if ( ! get_userdata( $user_id ) ) {
		return;
	}
	if ( method_exists( '\MultipleAuthors\Classes\Objects\Author', 'update_author_from_user' ) ) {
		\MultipleAuthors\Classes\Objects\Author::update_author_from_user( $term_id, $user_id );
	}
	gc_pp_copy_user_fields_to_author_term( $term_id, $user_id );
}

function gc_pp_sync_author_from_user( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 ) {
		return;
	}
	if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}
	$author = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( $user_id );
	if ( ! is_object( $author ) || empty( $author->term_id ) ) {
		return;
	}
	$term_id = (int) $author->term_id;

	if ( method_exists( '\MultipleAuthors\Classes\Objects\Author', 'update_author_from_user' ) ) {
		\MultipleAuthors\Classes\Objects\Author::update_author_from_user( $term_id, $user_id );
	}

	gc_pp_copy_user_fields_to_author_term( $term_id, $user_id );
}

add_action( 'profile_update', 'gc_pp_sync_author_from_user', 99, 1 );

function gc_pp_sync_on_author_term_saved( $term_id, $tt_id, $taxonomy ) {
	if ( 'author' !== $taxonomy ) {
		return;
	}

	$term_id = (int) $term_id;

	$run = function () use ( $term_id ) {
		gc_pp_sync_author_term_from_mapped_user( $term_id );
	};

	add_action( 'shutdown', $run, 999 );
}

add_action( 'created_term', 'gc_pp_sync_on_author_term_saved', 99, 3 );

function gc_pp_author_slug_from_user_name( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 ) {
		return '';
	}
	$first = trim( (string) get_user_meta( $user_id, 'first_name', true ) );
	$last  = trim( (string) get_user_meta( $user_id, 'last_name', true ) );
	if ( $first === '' || $last === '' ) {
		return '';
	}
	return sanitize_title( $first . '-' . $last );
}

function gc_pp_find_user_id_by_preferred_author_slug( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( $slug === '' ) {
		return 0;
	}
	static $cache = array();
	if ( isset( $cache[ $slug ] ) ) {
		return (int) $cache[ $slug ];
	}
	$users = get_users(
		array(
			'number' => 500,
			'fields' => array( 'ID' ),
		)
	);
	foreach ( $users as $u ) {
		$uid = isset( $u->ID ) ? (int) $u->ID : 0;
		if ( $uid < 1 ) {
			continue;
		}
		if ( gc_pp_author_slug_from_user_name( $uid ) === $slug ) {
			$cache[ $slug ] = $uid;
			return $uid;
		}
	}
	$cache[ $slug ] = 0;
	return 0;
}

function gc_pp_filter_author_link_slug( $link, $author_id, $author_nicename ) {
	$preferred_slug = gc_pp_author_slug_from_user_name( (int) $author_id );
	if ( $preferred_slug === '' ) {
		return $link;
	}
	if ( $preferred_slug === (string) $author_nicename ) {
		return $link;
	}
	remove_filter( 'author_link', 'gc_pp_filter_author_link_slug', 20 );
	$preferred_link = get_author_posts_url( (int) $author_id, $preferred_slug );
	add_filter( 'author_link', 'gc_pp_filter_author_link_slug', 20, 3 );
	return $preferred_link ? $preferred_link : $link;
}
add_filter( 'author_link', 'gc_pp_filter_author_link_slug', 20, 3 );

function gc_pp_map_preferred_author_slug_request( $request ) {
	if ( ! is_array( $request ) || empty( $request['author_name'] ) ) {
		return $request;
	}
	$author_name = sanitize_title( (string) $request['author_name'] );
	if ( $author_name === '' ) {
		return $request;
	}
	if ( get_user_by( 'slug', $author_name ) instanceof WP_User ) {
		return $request;
	}
	$mapped_user_id = gc_pp_find_user_id_by_preferred_author_slug( $author_name );
	if ( $mapped_user_id > 0 ) {
		$mapped_user = get_userdata( $mapped_user_id );
		if ( $mapped_user instanceof WP_User && ! empty( $mapped_user->user_nicename ) ) {
			$request['author_name'] = $mapped_user->user_nicename;
		}
	}
	return $request;
}
add_filter( 'request', 'gc_pp_map_preferred_author_slug_request', 20 );

function gc_pp_find_publishpress_author_term_by_slug( $slug ) {
	$slug = sanitize_title( (string) $slug );
	if ( $slug === '' || ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return null;
	}
	if ( ! method_exists( '\MultipleAuthors\Classes\Objects\Author', 'get_by_term_slug' ) ) {
		return null;
	}
	$pp_author = \MultipleAuthors\Classes\Objects\Author::get_by_term_slug( $slug );
	if ( ! is_object( $pp_author ) || empty( $pp_author->term_id ) ) {
		return null;
	}
	$term = get_term( (int) $pp_author->term_id, 'author' );
	if ( ! ( $term instanceof WP_Term ) || is_wp_error( $term ) ) {
		return null;
	}
	return $term;
}

function gc_pp_is_guest_publishpress_author_term( $term ) {
	if ( ! ( $term instanceof WP_Term ) || 'author' !== $term->taxonomy ) {
		return false;
	}
	return (int) get_term_meta( (int) $term->term_id, 'user_id', true ) < 1;
}

function gc_pp_get_raw_requested_author_slug() {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	$path = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
	if ( ! is_string( $path ) || $path === '' ) {
		return '';
	}
	$parts = array_values( array_filter( explode( '/', trim( $path, '/' ) ) ) );
	if ( count( $parts ) < 2 ) {
		return '';
	}
	$author_index = array_search( 'author', $parts, true );
	if ( $author_index === false ) {
		return '';
	}
	$slug_index = (int) $author_index + 1;
	if ( ! isset( $parts[ $slug_index ] ) ) {
		return '';
	}
	return sanitize_title( (string) $parts[ $slug_index ] );
}

function gc_pp_404_author_without_publishpress_profile() {
	if ( is_admin() || ! is_author() ) {
		return;
	}

	if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}

	$queried = get_queried_object();
	$user_id = 0;

	if ( $queried instanceof WP_User ) {
		$user_id = (int) $queried->ID;
	} elseif ( $queried instanceof WP_Term && isset( $queried->taxonomy ) && 'author' === $queried->taxonomy ) {
		$user_id = (int) get_term_meta( (int) $queried->term_id, 'user_id', true );
	}

	if ( $user_id > 0 ) {
		$pp_author = \MultipleAuthors\Classes\Objects\Author::get_by_user_id( $user_id );
		if ( is_object( $pp_author ) && ! empty( $pp_author->term_id ) ) {
			return;
		}
	}

	// WP user slug may match a guest PP author (no linked user account) — e.g. /marc.
	if ( $queried instanceof WP_User && ! empty( $queried->user_nicename ) ) {
		$guest_term = gc_pp_find_publishpress_author_term_by_slug( $queried->user_nicename );
		if ( $guest_term && gc_pp_is_guest_publishpress_author_term( $guest_term ) ) {
			global $wp_query;
			$wp_query->queried_object    = $guest_term;
			$wp_query->queried_object_id = (int) $guest_term->term_id;
			return;
		}
	}

	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();

	$template = get_404_template();
	if ( $template ) {
		include $template;
		exit;
	}

	wp_die( esc_html__( 'Page not found.' ), esc_html__( 'Not Found' ), array( 'response' => 404 ) );
	exit;
}
add_action( 'template_redirect', 'gc_pp_404_author_without_publishpress_profile', 5 );

function gc_pp_redirect_legacy_nicename_author_url() {
	if ( is_admin() || ! is_author() ) {
		return;
	}
	$queried = get_queried_object();
	if ( ! ( $queried instanceof WP_User ) ) {
		return;
	}
	$preferred_slug = gc_pp_author_slug_from_user_name( (int) $queried->ID );
	if ( $preferred_slug === '' || $preferred_slug === (string) $queried->user_nicename ) {
		return;
	}
	$requested_slug = gc_pp_get_raw_requested_author_slug();
	if ( $requested_slug === '' || $requested_slug !== sanitize_title( (string) $queried->user_nicename ) ) {
		return;
	}
	$target = get_author_posts_url( (int) $queried->ID, $preferred_slug );
	if ( $target ) {
		wp_safe_redirect( $target, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'gc_pp_redirect_legacy_nicename_author_url', 20 );

function gc_pp_capture_existing_mapped_user_before_author_edit( $term_id, $tt_id, $taxonomy ) {
	if ( 'author' !== $taxonomy ) {
		return;
	}
	$term_id = (int) $term_id;
	if ( $term_id < 1 ) {
		return;
	}
	$existing_user_id = (int) get_term_meta( $term_id, 'user_id', true );
	if ( $existing_user_id < 1 ) {
		return;
	}
	$GLOBALS['gc_pp_author_prev_user_map'][ $term_id ] = $existing_user_id;
}
add_action( 'edit_term', 'gc_pp_capture_existing_mapped_user_before_author_edit', 5, 3 );

function gc_pp_restore_mapped_user_if_cleared_on_author_edit( $term_id, $tt_id, $taxonomy ) {
	if ( 'author' !== $taxonomy ) {
		return;
	}
	$term_id = (int) $term_id;
	if ( $term_id < 1 ) {
		return;
	}
	$current_user_id = (int) get_term_meta( $term_id, 'user_id', true );
	if ( $current_user_id > 0 ) {
		return;
	}
	$previous_user_id = isset( $GLOBALS['gc_pp_author_prev_user_map'][ $term_id ] ) ? (int) $GLOBALS['gc_pp_author_prev_user_map'][ $term_id ] : 0;
	if ( $previous_user_id < 1 || ! get_userdata( $previous_user_id ) ) {
		return;
	}
	update_term_meta( $term_id, 'user_id', $previous_user_id );
}
add_action( 'edited_term', 'gc_pp_restore_mapped_user_if_cleared_on_author_edit', 110, 3 );