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

function gc_pp_sync_author_from_user( $user_id ) {
	$user_id = (int) $user_id;
	if ( $user_id < 1 ) {
		return;
	}
	if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
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

function gc_pp_sync_on_author_term_created( $term_id, $tt_id, $taxonomy ) {
	if ( 'author' !== $taxonomy ) {
		return;
	}

	$term_id = (int) $term_id;

	$run = function () use ( $term_id ) {
		$user_id = (int) get_term_meta( $term_id, 'user_id', true );
		if ( $user_id < 1 ) {
			return;
		}
		if ( ! class_exists( '\MultipleAuthors\Classes\Objects\Author' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}
		if ( method_exists( '\MultipleAuthors\Classes\Objects\Author', 'update_author_from_user' ) ) {
			\MultipleAuthors\Classes\Objects\Author::update_author_from_user( $term_id, $user_id );
		}
		gc_pp_copy_user_fields_to_author_term( $term_id, $user_id );
	};

	add_action( 'shutdown', $run, 999 );
}

add_action( 'created_term', 'gc_pp_sync_on_author_term_created', 99, 3 );
