<?php
/**
 * Blog V2: theme functions and hooks.
 * Loaded once from functions.php. All blog-v2 logic in one place: author display, content filters, related post, shortcode.
 */

// --- Author display (Created by / About The Creator) ---

/**
 * Return a smaller image URL when the given URL is a local attachment (e.g. for 50x50 avatar display).
 * Reduces download size when the original is large (e.g. 512x512).
 *
 * @param string $url Full image URL.
 * @param int    $size Width/height for the requested size (default 100 for 50x50 display at 2x).
 * @return string URL to use for img src (smaller when possible, otherwise original).
 */
function blog_v2_avatar_url_for_display( $url, $size = 100 ) {
    if ( empty( $url ) || ! is_string( $url ) ) {
        return $url;
    }
    $attachment_id = attachment_url_to_postid( $url );
    if ( ! $attachment_id ) {
        return $url;
    }
    $src = wp_get_attachment_image_src( $attachment_id, array( $size, $size ) );
    if ( is_array( $src ) && ! empty( $src[0] ) ) {
        return $src[0];
    }
    return $url;
}

/**
 * Default blog author when post has no author or for fallback (Pat).
 */
function blog_v2_default_author() {
    return array(
        'name'     => 'Pat Hartonian',
        'job'      => 'Chief Compliance Officer',
        'avatar'   => 'pat',
        'url'      => get_template_directory_uri() . '/assets/images/pat-hat.png',
        'initials' => 'PH',
        'link'     => '',
    );
}

/**
 * Registry of known reviewers (Expert Insight / Reviewed by). Key: author slug (URL path).
 */
function blog_v2_reviewers_registry() {
    $base = get_template_directory_uri() . '/assets/images/';
    return array(
        'charm-paz' => array(
            'name'   => 'Charm Paz, CHRP',
            'job'    => 'Recruiter and Editor, GCheck',
            'avatar' => $base . 'charm-paz.png',
            'link'   => home_url('/blog/author/charm/'),
        ),
        'charm' => array(
            'name'   => 'Charm Paz, CHRP',
            'job'    => 'Recruiter and Editor, GCheck',
            'avatar' => $base . 'charm-paz.png',
            'link'   => home_url('/blog/author/charm/'),
        ),
        'emile' => array(
            'name'   => 'Emile Garcia, SHRM-SCP, CHRP, CHRBP',
            'job'    => 'Recruiter and Editor, GCheck',
            'avatar' => $base . 'emile-garcia.png',
            'link'   => home_url('/blog/author/emile/'),
        ),
    );
}

/**
 * Get Authors and Reviewers from post settings (ACF group or top-level fields).
 *
 * Where the settings come from: The "Authors" / "Article Options" panel (with Authors and
 * Reviewers fields) is NOT defined in this theme. It is defined in WordPress Admin, either:
 * - Custom Fields (ACF) → Field Groups (stored in DB), or
 * - A plugin (e.g. PublishPress Authors). Check wp-content/plugins for author/reviewer meta boxes.
 * This function only READS the saved values; it tries common ACF group names and top-level fields.
 *
 * @param int $post_id Post ID.
 * @return array{ authors: mixed, reviewers: mixed }
 */
function blog_v2_get_article_options( $post_id ) {
    $out = array( 'authors' => null, 'reviewers' => null );
    if ( ! function_exists( 'get_field' ) ) {
        return $out;
    }
    // Try common ACF group names (the expandable "Article Options" / "Authors" section in the editor).
    $group_names = array( 'article_options', 'authors', 'post_options' );
    foreach ( $group_names as $name ) {
        $opts = get_field( $name, $post_id );
        if ( is_array( $opts ) ) {
            if ( isset( $opts['authors'] ) ) {
                $out['authors'] = $opts['authors'];
            }
            if ( isset( $opts['reviewers'] ) ) {
                $out['reviewers'] = $opts['reviewers'];
            }
            if ( $out['authors'] !== null || $out['reviewers'] !== null ) {
                return $out;
            }
        }
    }
    // Fallback: top-level ACF fields.
    if ( $out['authors'] === null ) {
        $out['authors'] = get_field( 'authors', $post_id );
    }
    if ( $out['reviewers'] === null ) {
        $out['reviewers'] = get_field( 'reviewers', $post_id );
    }
    return $out;
}

/**
 * Get all author user IDs from post's Article Options "Authors" field (order preserved).
 * Reads from Article Options group (authors/reviewers subfields) or top-level "authors", then post meta.
 *
 * @param int $post_id Post ID.
 * @return int[] Array of user IDs.
 */
function blog_v2_get_all_author_user_ids( $post_id ) {
    $ids = array();
    if ( function_exists( 'get_field' ) ) {
        $opts   = blog_v2_get_article_options( $post_id );
        $authors = $opts['authors'];
        if ( is_array( $authors ) && ! empty( $authors ) ) {
            foreach ( $authors as $a ) {
                $id = is_object( $a ) && isset( $a->ID ) ? (int) $a->ID : ( is_array( $a ) && isset( $a['ID'] ) ? (int) $a['ID'] : ( is_numeric( $a ) ? (int) $a : 0 ) );
                if ( $id > 0 ) {
                    $ids[] = $id;
                }
            }
        } elseif ( is_numeric( $authors ) && $authors > 0 ) {
            $ids[] = (int) $authors;
        }
    }
    if ( empty( $ids ) ) {
        $raw = get_post_meta( $post_id, 'authors', true );
        if ( is_array( $raw ) && ! empty( $raw ) ) {
            foreach ( $raw as $r ) {
                $id = is_numeric( $r ) ? (int) $r : 0;
                if ( $id > 0 ) {
                    $ids[] = $id;
                }
            }
        } elseif ( is_numeric( $raw ) && $raw > 0 ) {
            $ids[] = (int) $raw;
        }
    }
    return $ids;
}

/**
 * Get creator (author) user ID from post's Article Options "Authors" field.
 * When multiple authors exist, prefers GCheck Editorial Team as creator; otherwise first author.
 * Tries ACF field "authors", then post meta "authors". Returns 0 if none.
 *
 * @param int $post_id Post ID.
 * @return int User ID or 0.
 */
function blog_v2_get_creator_user_id( $post_id ) {
    $author_ids = blog_v2_get_all_author_user_ids( $post_id );
    if ( empty( $author_ids ) ) {
        return 0;
    }
    // Prefer GCheck Editorial Team when multiple authors.
    foreach ( $author_ids as $id ) {
        if ( blog_v2_is_gcheck_editorial_team( $id ) ) {
            return $id;
        }
    }
    return $author_ids[0];
}

/**
 * Get first reviewer user ID from post's Article Options "Reviewers" field.
 * Reads from Article Options group (reviewers subfield) or top-level "reviewers", then post meta.
 * Supports ACF return format User Object (single) or array of user IDs/objects.
 *
 * @param int $post_id Post ID.
 * @return int User ID or 0.
 */
function blog_v2_get_reviewer_user_id( $post_id ) {
    $reviewer_id = 0;

    if ( function_exists( 'get_field' ) ) {
        $opts     = blog_v2_get_article_options( $post_id );
        $reviewers = $opts['reviewers'];
        if ( is_array( $reviewers ) && ! empty( $reviewers ) ) {
            $reviewer_id = blog_v2_user_id_from_value( $reviewers[0] );
        } elseif ( $reviewers ) {
            $reviewer_id = blog_v2_user_id_from_value( $reviewers );
        }
    }

    if ( ! $reviewer_id ) {
        $raw = get_post_meta( $post_id, 'reviewers', true );
        if ( is_array( $raw ) && ! empty( $raw ) ) {
            $reviewer_id = blog_v2_user_id_from_value( $raw[0] );
        } elseif ( $raw ) {
            $reviewer_id = blog_v2_user_id_from_value( $raw );
        }
    }

    if ( ! $reviewer_id ) {
        $reviewer_id = blog_v2_user_id_from_value( get_post_meta( $post_id, 'reviewer', true ) );
    }
    if ( ! $reviewer_id ) {
        $reviewer_id = blog_v2_user_id_from_value( get_post_meta( $post_id, 'reviewers_0', true ) );
    }

    return $reviewer_id;
}

/**
 * Extract user ID from ACF/user value (WP_User, array with ID, or numeric).
 *
 * @param mixed $value WP_User object, array with 'ID' key, or user ID.
 * @return int User ID or 0.
 */
function blog_v2_user_id_from_value( $value ) {
    if ( is_numeric( $value ) && (int) $value > 0 ) {
        return (int) $value;
    }
    if ( is_object( $value ) && isset( $value->ID ) ) {
        return (int) $value->ID;
    }
    if ( is_array( $value ) && isset( $value['ID'] ) ) {
        return (int) $value['ID'];
    }
    return 0;
}

/**
 * Build reviewer display array from a PublishPress Author object (Reviewer category).
 *
 * @param object $author PublishPress Author object (from ppma_post_authors_categorized).
 * @return array|null Reviewer data (name, job, avatar, link, linkedin) or null if name empty.
 */
function blog_v2_reviewer_data_from_ppma_author( $author ) {
    if ( ! is_object( $author ) || empty( $author->display_name ) ) {
        return null;
    }
    $name = trim( wp_strip_all_tags( (string) $author->display_name ) );
    if ( $name === '' ) {
        return null;
    }
    $job = '';
    if ( method_exists( $author, 'get_meta' ) ) {
        $job = $author->get_meta( 'job_title' );
    }
    $job = is_string( $job ) ? trim( $job ) : '';
    if ( $job === '' ) {
        $job = 'Recruiter and Editor, GCheck';
    }
    $link = isset( $author->link ) ? $author->link : '#';
    if ( is_wp_error( $link ) || empty( $link ) ) {
        $link = '#';
    }
    $avatar = '';
    if ( method_exists( $author, 'get_avatar_url' ) ) {
        $avatar = $author->get_avatar_url( 96 );
    }
    if ( is_array( $avatar ) && isset( $avatar['url'] ) ) {
        $avatar = $avatar['url'];
    }
    $avatar = is_string( $avatar ) ? trim( $avatar ) : '';
    $linkedin = '';
    if ( method_exists( $author, 'get_meta' ) ) {
        $linkedin = $author->get_meta( 'linkedin' );
    }
    $linkedin = is_string( $linkedin ) ? trim( $linkedin ) : '';
    return array(
        'name'    => $name,
        'job'     => $job,
        'avatar'  => $avatar,
        'link'    => $link,
        'linkedin' => $linkedin,
        'slug'    => isset( $author->slug ) ? $author->slug : '',
    );
}

/**
 * Reviewer display data for current post.
 * Uses PublishPress Authors "Reviewer" category first; then Article Options "Reviewers" field; else _blog_reviewer_slug (registry).
 * When no reviewer is set, returns null (reviewer section is hidden).
 *
 * @param int|null $post_id Post ID.
 * @return array|null Reviewer data (name, job, avatar, link, slug, linkedin) or null if none set.
 */
function blog_v2_reviewer_display_data( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $registry = blog_v2_reviewers_registry();

    // 1. Reviewer from PublishPress Authors (Author Category "Reviewer").
    if ( function_exists( 'ppma_post_authors_categorized' ) ) {
        $categorized = ppma_post_authors_categorized( $post_id, array( 'reviewer' ) );
        if ( ! empty( $categorized['reviewer'] ) && is_array( $categorized['reviewer'] ) ) {
            $first_reviewer = $categorized['reviewer'][0];
            $data = blog_v2_reviewer_data_from_ppma_author( $first_reviewer );
            if ( $data ) {
                return $data;
            }
        }
    }

    // 2. Reviewer from Article Options (Reviewers field).
    $reviewer_user_id = blog_v2_get_reviewer_user_id( $post_id );
    if ( $reviewer_user_id > 0 ) {
        $data = blog_v2_reviewer_data_from_user_id( $reviewer_user_id, $registry );
        if ( $data ) {
            return $data;
        }
    }

    // 3. _blog_reviewer_slug (only if explicitly set).
    $slug = get_post_meta( $post_id, '_blog_reviewer_slug', true );
    $slug = is_string( $slug ) ? trim( $slug ) : '';
    if ( $slug !== '' && isset( $registry[ $slug ] ) ) {
        $r = $registry[ $slug ];
        return array(
            'name'   => $r['name'],
            'job'    => $r['job'],
            'avatar' => $r['avatar'],
            'link'   => $r['link'],
            'slug'   => $slug,
        );
    }

    return null;
}

/**
 * Build reviewer display array from a user ID. Used by blog_v2_reviewer_display_data.
 *
 * @param int   $user_id User ID.
 * @param array $registry blog_v2_reviewers_registry().
 * @return array|null Reviewer data or null if name empty.
 */
function blog_v2_reviewer_data_from_user_id( $user_id, $registry = null ) {
    if ( ! $user_id ) {
        return null;
    }
    if ( $registry === null ) {
        $registry = blog_v2_reviewers_registry();
    }
    $name = get_the_author_meta( 'display_name', $user_id );
    $name = trim( wp_strip_all_tags( $name ) );
    if ( $name === '' ) {
        return null;
    }
    $job = get_the_author_meta( 'job_title', $user_id );
    $job = is_string( $job ) ? trim( $job ) : '';
    if ( $job === '' ) {
        $job = 'Recruiter and Editor, GCheck';
    }
    $link = get_author_posts_url( $user_id );
    if ( ! $link ) {
        $link = '#';
    }
    $avatar = get_avatar_url( $user_id, array( 'size' => 96 ) );
    foreach ( $registry as $slug => $r ) {
        if ( stripos( $r['name'], $name ) !== false || stripos( $name, $r['name'] ) !== false ) {
            $avatar = $r['avatar'];
            break;
        }
    }
    return array(
        'name'   => $name,
        'job'    => $job,
        'avatar' => $avatar,
        'link'   => $link,
        'slug'   => '',
    );
}

/**
 * Slug from display name (e.g. "Emile Garcia, SHRM-SCP, CHRP" -> "emile-garcia") for expert lookup.
 *
 * @param string $name Display name.
 * @return string Slug for URL/author link matching.
 */
function blog_v2_name_to_slug( $name ) {
    $name = trim( wp_strip_all_tags( $name ) );
    if ( $name === '' ) {
        return '';
    }
    $parts = preg_split( '/[\s,]+/', $name, 3, PREG_SPLIT_NO_EMPTY );
    if ( count( $parts ) >= 2 ) {
        return strtolower( sanitize_title( $parts[0] . '-' . $parts[1] ) );
    }
    return strtolower( sanitize_title( $parts[0] ) );
}

/**
 * Experts data for Expert Insight block JS. Keyed by author slug for lookup from paragraph author link.
 * Merges the current post's reviewer so Expert Insight uses the same profile picture as the Reviewer card.
 *
 * @param int|null $post_id Post ID (default current post).
 * @return array Experts keyed by slug (name, title, avatar, link).
 */
function blog_v2_expert_insight_experts( $post_id = null ) {
    $registry = blog_v2_reviewers_registry();
    $out      = array();
    foreach ( $registry as $slug => $r ) {
        $out[ $slug ] = array(
            'name'   => $r['name'],
            'title'  => $r['job'],
            'avatar' => $r['avatar'],
            'link'   => $r['link'],
        );
    }
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( $post_id && function_exists( 'blog_v2_reviewer_display_data' ) ) {
        $reviewer = blog_v2_reviewer_display_data( $post_id );
        if ( $reviewer && ! empty( $reviewer['avatar'] ) ) {
            $expert = array(
                'name'   => $reviewer['name'],
                'title'  => isset( $reviewer['job'] ) ? $reviewer['job'] : 'Recruiter and Editor, GCheck',
                'avatar' => $reviewer['avatar'],
                'link'   => isset( $reviewer['link'] ) ? $reviewer['link'] : '#',
            );
            if ( ! empty( $reviewer['slug'] ) ) {
                $out[ $reviewer['slug'] ] = $expert;
            }
            $name_slug = blog_v2_name_to_slug( $reviewer['name'] );
            if ( $name_slug !== '' ) {
                $out[ $name_slug ] = $expert;
            }
            // Propagate the real avatar to all slug variants sharing the same name
            foreach ( $out as $s => $e ) {
                if ( strcasecmp( $e['name'], $reviewer['name'] ) === 0 ) {
                    $out[ $s ]['avatar'] = $reviewer['avatar'];
                }
            }
        }
    }
    return $out;
}

/**
 * Get initials from a display name (e.g. "John Doe" -> "JD", "Pat" -> "Pa", "monica" -> "Mo").
 */
function blog_v2_author_initials( $name ) {
    $name = trim( wp_strip_all_tags( $name ) );
    if ( empty( $name ) ) {
        return '';
    }
    $parts = preg_split( '/\s+/', $name, 2, PREG_SPLIT_NO_EMPTY );
    if ( count( $parts ) >= 2 ) {
        return strtoupper( mb_substr( $parts[0], 0, 1 ) . mb_substr( $parts[1], 0, 1 ) );
    }
    return strtoupper( mb_substr( $name, 0, 2 ) );
}

/**
 * Force creator display name + title for specific people.
 *
 * @param string $name Display name.
 * @param string $job  Job title.
 * @return array{name:string,job:string}
 */
function blog_v2_force_creator_identity( $name, $job ) {
    $name = is_string( $name ) ? trim( $name ) : '';
    $job  = is_string( $job ) ? trim( $job ) : '';
    $normalized = strtolower( preg_replace( '/\s+/', ' ', $name ) );

    if ( strpos( $normalized, 'pat' ) !== false && strpos( $normalized, 'hartonian' ) !== false ) {
        return array(
            'name' => 'Pat Hartonian',
            'job'  => 'Chief Compliance Officer',
        );
    }

    if ( strpos( $normalized, 'houman' ) !== false || strpos( $normalized, 'akhavan' ) !== false ) {
        return array(
            'name' => 'Houman Akhavan',
            'job'  => 'Founder and CEO, GCheck',
        );
    }

    return array(
        'name' => $name,
        'job'  => $job,
    );
}

/**
 * Default job title when author has no job_title meta.
 */
function blog_v2_default_author_job() {
    return 'GCheck Editorial Team';
}

/**
 * Default Pat Hartonian bio for About The Creator inline section.
 *
 * @return string HTML-safe bio paragraph.
 */
function blog_v2_default_creator_bio() {
    return 'Pat Hartonian is the Vice President of Operations at GCheck, where he leads strategy and operational excellence across background screening programs. With over 15 years of experience in employment screening and regulatory compliance, he specializes in FCRA compliance, adjudication frameworks, vendor management, and scaling high-volume operations with integrity. <br><br>He holds an Advanced FCRA certification from PBSA and a certification in Generative AI Large Language Models from AWS. Pat is the author of Decoding Humans: How Fear, Happiness, and AI Shape Every Decision We Make, which explores ethics, persuasion, and emerging technologies.';
}

/**
 * Default GCheck Editorial Team bio for About The Creator inline section.
 * Author page: https://gcheck.com/blog/author/marc/
 *
 * @return string HTML-safe bio paragraph.
 */
function blog_v2_default_gcheck_editorial_bio() {
    return 'Meet the GCheck Editorial Team, your trusted source for insightful and up-to-date information in the world of employment background checks. Committed to delivering the latest trends, best practices, and industry insights, our team is dedicated to keeping you informed. <br><br>With a passion for ensuring accuracy, compliance, and efficiency in background screening, we are your go-to experts in the field. Stay tuned for our comprehensive articles, guides, and analysis, designed to empower businesses and individuals with the knowledge they need to make informed decisions. <br><br>At GCheck, we\'re here to guide you through the complexities of background checks, every step of the way.';
}

/**
 * Whether the given user ID is the GCheck Editorial Team (author slug marc).
 *
 * @param int $author_id User ID.
 * @return bool
 */
function blog_v2_is_gcheck_editorial_team( $author_id ) {
    if ( ! $author_id ) {
        return false;
    }
    $nicename = get_the_author_meta( 'user_nicename', $author_id );
    if ( is_string( $nicename ) && strtolower( trim( $nicename ) ) === 'marc' ) {
        return true;
    }
    $name = get_the_author_meta( 'display_name', $author_id );
    return $name && stripos( $name, 'GCheck Editorial Team' ) !== false;
}

/**
 * Bio text for the current post's creator (About The Creator inline).
 * Uses PublishPress creator when available, then creator's WordPress user description;
 * falls back to Pat bio when creator is Pat; otherwise GCheck Editorial Team bio.
 *
 * @param int|null $post_id Post ID.
 * @return string HTML-safe bio (may contain <br> and <p>).
 */
function blog_v2_creator_bio( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( ! $post_id ) {
        return blog_v2_default_gcheck_editorial_bio();
    }
    // PublishPress creator first (same logic as display: exclude reviewers, prefer GCheck Editorial Team).
    $ppma_creator = blog_v2_get_creator_ppma_author( $post_id );
    if ( $ppma_creator && method_exists( $ppma_creator, 'get_meta' ) ) {
        $description = $ppma_creator->get_meta( 'description' );
        $description = is_string( $description ) ? trim( $description ) : '';
        if ( $description !== '' ) {
            $plain = wp_strip_all_tags( $description, false );
            $html  = function_exists( 'gc_author_bio_format_pbsa_fcra_link' )
                ? gc_author_bio_format_pbsa_fcra_link( $plain )
                : esc_html( $plain );
            return wp_kses_post( nl2br( $html ) );
        }
        return blog_v2_default_gcheck_editorial_bio();
    }
    $author_id = blog_v2_get_creator_user_id( $post_id );
    if ( ! $author_id ) {
        $author_id = (int) get_post_field( 'post_author', $post_id );
    }
    if ( ! $author_id ) {
        return blog_v2_default_gcheck_editorial_bio();
    }
    $description = get_the_author_meta( 'description', $author_id );
    $description = is_string( $description ) ? trim( $description ) : '';
    if ( $description !== '' ) {
        $plain = wp_strip_all_tags( $description, false );
        $html  = function_exists( 'gc_author_bio_format_pbsa_fcra_link' )
            ? gc_author_bio_format_pbsa_fcra_link( $plain )
            : esc_html( $plain );
        return wp_kses_post( nl2br( $html ) );
    }
    $name = get_the_author_meta( 'display_name', $author_id );
    $is_pat = $name && stripos( $name, 'Pat Hartonian' ) !== false;
    if ( $is_pat ) {
        return blog_v2_default_creator_bio();
    }
    return blog_v2_default_gcheck_editorial_bio();
}

/**
 * Consistent color for initials circle (hex) derived from author name.
 */
function blog_v2_author_initials_color( $name ) {
    $name = trim( wp_strip_all_tags( $name ) );
    if ( empty( $name ) ) {
        return '#6B7280'; // neutral gray fallback
    }
    $hash = crc32( $name );
    $hue = abs( $hash % 360 );
    // Pastel-ish: high saturation, medium lightness for readable contrast
    return sprintf( 'hsl(%d, 45%%, 42%%)', $hue );
}

/**
 * Whether a PublishPress Author object is GCheck Editorial Team (slug marc or display name).
 *
 * @param object $author PublishPress Author object.
 * @return bool
 */
function blog_v2_ppma_author_is_gcheck_editorial_team( $author ) {
    if ( ! is_object( $author ) ) {
        return false;
    }
    $slug = isset( $author->slug ) ? $author->slug : '';
    if ( is_string( $slug ) && strtolower( trim( $slug ) ) === 'marc' ) {
        return true;
    }
    $name = isset( $author->display_name ) ? $author->display_name : '';
    return $name && stripos( $name, 'GCheck Editorial Team' ) !== false;
}

/**
 * Get the creator (author) from PublishPress for a post: all authors minus reviewers,
 * then prefer GCheck Editorial Team, otherwise first author.
 *
 * @param int $post_id Post ID.
 * @return object|null PublishPress Author object or null.
 */
function blog_v2_get_creator_ppma_author( $post_id ) {
    if ( ! function_exists( 'get_post_authors' ) || ! function_exists( 'ppma_post_authors_categorized' ) ) {
        return null;
    }
    $all_authors = get_post_authors( $post_id, true );
    if ( empty( $all_authors ) || ! is_array( $all_authors ) ) {
        return null;
    }
    $categorized = ppma_post_authors_categorized( $post_id, array( 'reviewer' ) );
    $reviewers = isset( $categorized['reviewer'] ) && is_array( $categorized['reviewer'] ) ? $categorized['reviewer'] : array();
    $reviewer_term_ids = array();
    foreach ( $reviewers as $r ) {
        if ( is_object( $r ) && isset( $r->term_id ) ) {
            $reviewer_term_ids[] = (int) $r->term_id;
        }
    }
    $creator_candidates = array();
    foreach ( $all_authors as $author ) {
        if ( ! is_object( $author ) || ! isset( $author->term_id ) ) {
            continue;
        }
        if ( in_array( (int) $author->term_id, $reviewer_term_ids, true ) ) {
            continue;
        }
        $creator_candidates[] = $author;
    }
    if ( empty( $creator_candidates ) ) {
        return null;
    }
    foreach ( $creator_candidates as $author ) {
        if ( blog_v2_ppma_author_is_gcheck_editorial_team( $author ) ) {
            return $author;
        }
    }
    return $creator_candidates[0];
}

/**
 * Build creator display array from a PublishPress Author object (same shape as blog_v2_author_display_data).
 * Uses the author's profile picture from PublishPress when available.
 *
 * @param object $author PublishPress Author object.
 * @return array|null Creator data (name, job, avatar, url, initials, link, color) or null.
 */
function blog_v2_creator_data_from_ppma_author( $author ) {
    if ( ! is_object( $author ) || empty( $author->display_name ) ) {
        return null;
    }
    $name = trim( wp_strip_all_tags( (string) $author->display_name ) );
    if ( $name === '' ) {
        return null;
    }
    $job = '';
    if ( method_exists( $author, 'get_meta' ) ) {
        $job = $author->get_meta( 'job_title' );
    }
    $job = is_string( $job ) ? trim( $job ) : '';
    $forced = blog_v2_force_creator_identity( $name, $job );
    $name = $forced['name'];
    $job  = $forced['job'];
    $is_editorial_team = blog_v2_ppma_author_is_gcheck_editorial_team( $author );
    if ( $is_editorial_team ) {
        $job = '';
    } elseif ( $job === '' ) {
        $job = blog_v2_default_author_job();
    }
    $link = isset( $author->link ) ? $author->link : '#';
    if ( is_wp_error( $link ) || empty( $link ) ) {
        $link = '#';
    }
    if ( $is_editorial_team ) {
        $link = home_url('/blog/author/marc/');
    }
    $avatar_url = '';
    if ( method_exists( $author, 'get_avatar_url' ) ) {
        $avatar_url = $author->get_avatar_url( 96 );
    }
    if ( is_array( $avatar_url ) && isset( $avatar_url['url'] ) ) {
        $avatar_url = $avatar_url['url'];
    }
    $avatar_url = is_string( $avatar_url ) ? trim( $avatar_url ) : '';
    return array(
        'name'     => $name,
        'job'      => $job,
        'avatar'   => $avatar_url ? 'url' : 'initials',
        'url'      => $avatar_url,
        'initials' => blog_v2_author_initials( $name ),
        'link'     => $link,
        'color'    => blog_v2_author_initials_color( $name ),
    );
}

/**
 * Blog V2: author display data for "Created by" / About The Creator.
 * Uses PublishPress Authors first (all authors minus reviewers, prefer GCheck Editorial Team, else first);
 * then Article Options "Authors" field; else post author; default Pat.
 * Returns: name, job, avatar ('pat' | 'initials'), url, initials, link, color.
 */
function blog_v2_author_display_data( $post_id = null ) {
    $default = blog_v2_default_author();
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( ! $post_id ) {
        return $default;
    }

    // 1. Creator from PublishPress (authors excluding reviewers; prefer GCheck Editorial Team, else first).
    $ppma_creator = blog_v2_get_creator_ppma_author( $post_id );
    if ( $ppma_creator ) {
        $data = blog_v2_creator_data_from_ppma_author( $ppma_creator );
        if ( $data ) {
            return $data;
        }
    }

    // 2. Creator from Article Options (Authors field) or post author.
    $author_id = blog_v2_get_creator_user_id( $post_id );
    if ( ! $author_id ) {
        $author_id = (int) get_post_field( 'post_author', $post_id );
    }
    if ( ! $author_id ) {
        return $default;
    }

    $author_name = get_the_author_meta( 'display_name', $author_id );
    if ( empty( trim( $author_name ) ) ) {
        return $default;
    }
    // Treat "Pat Hartonian" as the default author (use Pat's image).
    $is_pat = ( stripos( $author_name, 'Pat Hartonian' ) !== false );
    if ( $is_pat ) {
        return $default;
    }
    $job = get_the_author_meta( 'job_title', $author_id );
    $job = is_string( $job ) ? trim( $job ) : '';
    $forced = blog_v2_force_creator_identity( $author_name, $job );
    $author_name = $forced['name'];
    $job         = $forced['job'];
    $is_editorial_team = blog_v2_is_gcheck_editorial_team( $author_id ) || ( $job === blog_v2_default_author_job() );
    if ( $is_editorial_team ) {
        $job = '';
    } elseif ( $job === '' ) {
        $job = blog_v2_default_author_job();
    }
    $initials = blog_v2_author_initials( $author_name );
    $link = $is_editorial_team ? home_url('/blog/author/marc/') : get_author_posts_url( $author_id );
    $color = blog_v2_author_initials_color( $author_name );
    $avatar_url = get_avatar_url( $author_id, array( 'size' => 96 ) );
    $avatar_url = is_string( $avatar_url ) ? trim( $avatar_url ) : '';
    return array(
        'name'     => trim( $author_name ),
        'job'      => $job,
        'avatar'   => $avatar_url ? 'url' : 'initials',
        'url'      => $avatar_url,
        'initials' => $initials,
        'link'     => $link ? $link : '',
        'color'    => $color,
    );
}

// --- Content filters, related post, shortcode ---

/**
 * Do not render the core Post Author block on single posts; theme uses "About The Creator" instead.
 * Prevents duplicate author box (block above + about-creator-inline below).
 */
function blog_v2_remove_post_author_block( $block_content, $block ) {
    if ( ! is_singular( 'post' ) ) {
        return $block_content;
    }
    $hide = array( 'core/post-author', 'core/post-author-name', 'core/post-author-biography' );
    if ( isset( $block['blockName'] ) && in_array( $block['blockName'], $hide, true ) ) {
        return '';
    }
    return $block_content;
}
add_filter( 'render_block', 'blog_v2_remove_post_author_block', 10, 2 );

/**
 * Remove PublishPress Authors box from single post content (theme uses "About The Creator" instead).
 * Strips the div with class pp-multiple-authors-boxes-wrapper and all its contents.
 */
function blog_v2_remove_pp_authors_box( $content ) {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }
    $needle = 'pp-multiple-authors-boxes-wrapper';
    $pos = strpos( $content, $needle );
    if ( $pos === false ) {
        return $content;
    }
    // Find the opening <div that contains this class (scan backward for opening tag).
    $start = strrpos( substr( $content, 0, $pos ), '<div' );
    if ( $start === false ) {
        return $content;
    }
    // From the opening div, find the matching closing </div> by counting nesting.
    $depth = 0;
    $i = $start;
    $len = strlen( $content );
    while ( $i < $len ) {
        if ( substr( $content, $i, 4 ) === '<div' ) {
            $depth++;
            $i += 4;
            continue;
        }
        if ( substr( $content, $i, 6 ) === '</div>' ) {
            $depth--;
            if ( $depth === 0 ) {
                $content = substr_replace( $content, '', $start, $i + 6 - $start );
                return $content;
            }
            $i += 6;
            continue;
        }
        $i++;
    }
    return $content;
}
add_filter( 'the_content', 'blog_v2_remove_pp_authors_box', 15 );

/**
 * Remove empty paragraphs and standalone wp-block-separator hr from blog post content (single posts only).
 * Removes <p></p> or <p class="..."></p> with nothing between the tags.
 * Also removes <hr class="wp-block-separator has-alpha-channel-opacity"/> (and variants).
 */
function blog_v2_remove_empty_p_tags( $content ) {
    if ( ! is_single() ) {
        return $content;
    }
    $content = preg_replace( '/<p[^>]*><\/p>/', '', $content );
    // Remove wp-block-separator hr with has-alpha-channel-opacity (class order may vary).
    $content = preg_replace( '/<hr[^>]*class="[^"]*(?:wp-block-separator[^"]*has-alpha-channel-opacity|has-alpha-channel-opacity[^"]*wp-block-separator)[^"]*"[^>]*\/?>/', '', $content );
    return $content;
}
add_filter( 'the_content', 'blog_v2_remove_empty_p_tags', 20 );

/**
 * Generate URL-safe slug from heading text (matches blog-v2-toc.js generateId).
 *
 * @param string $text Heading text.
 * @return string Slug for id attribute.
 */
function blog_v2_toc_heading_slug( $text ) {
    $text = trim( wp_strip_all_tags( $text ) );
    $text = strtolower( $text );
    $text = preg_replace( '/[^\w\s-]/', '', $text );
    $text = preg_replace( '/\s+/', '-', $text );
    $text = preg_replace( '/-+/', '-', $text );
    return trim( $text, '-' );
}

/**
 * Add id attributes to H2 headings in post content (for TOC and anchor links).
 * Excludes H2s inside ._article-keytakeaways. Runs only on single posts.
 *
 * @param string $content Post content HTML.
 * @return string Modified content.
 */
function blog_v2_toc_add_heading_ids( $content ) {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }
    if ( strpos( $content, 'wp-block-heading' ) === false ) {
        return $content;
    }

    $used_ids = array();
    $dom      = new DOMDocument();
    $libxml_prev = libxml_use_internal_errors( true );
    $dom->loadHTML(
        '<?xml encoding="utf-8" ?><div id="blog-v2-toc-root">' . $content . '</div>',
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
    );
    libxml_use_internal_errors( $libxml_prev );
    foreach ( $dom->childNodes as $node ) {
        if ( $node->nodeType === XML_PI_NODE ) {
            $dom->removeChild( $node );
            break;
        }
    }

    $root = $dom->getElementById( 'blog-v2-toc-root' );
    if ( ! $root ) {
        return $content;
    }

    $h2_list = $root->getElementsByTagName( 'h2' );
    foreach ( $h2_list as $h2 ) {
        $class = $h2->getAttribute( 'class' );
        if ( strpos( $class, 'wp-block-heading' ) === false ) {
            continue;
        }
        $ancestor = $h2->parentNode;
        $inside_keytakeaways = false;
        while ( $ancestor && $ancestor !== $root ) {
            $ac = $ancestor->getAttribute( 'class' );
            if ( $ac && strpos( $ac, '_article-keytakeaways' ) !== false ) {
                $inside_keytakeaways = true;
                break;
            }
            $ancestor = $ancestor->parentNode;
        }
        if ( $inside_keytakeaways ) {
            continue;
        }

        $id = $h2->getAttribute( 'id' );
        $id = trim( $id );
        if ( $id === '' ) {
            $text = $h2->textContent;
            $id   = blog_v2_toc_heading_slug( $text );
            if ( $id === '' ) {
                continue;
            }
            $unique_id = $id;
            $counter   = 1;
            while ( in_array( $unique_id, $used_ids, true ) ) {
                $unique_id = $id . '-' . $counter;
                $counter++;
            }
            $used_ids[] = $unique_id;
            $h2->setAttribute( 'id', $unique_id );
        }
    }

    $out = '';
    foreach ( $root->childNodes as $child ) {
        $out .= $dom->saveHTML( $child );
    }
    return $out;
}
add_filter( 'the_content', 'blog_v2_toc_add_heading_ids', 12 );

/**
 * Gutenberg/blog content images: add explicit width/height (avoid CLS) and srcset/sizes (reduce download, 380px display).
 * Matches any <img> that contains wp-image-{id} anywhere in the tag (handles any attribute order).
 *
 * @param string $content Post content HTML.
 * @return string Modified content.
 */
function blog_v2_content_images_add_srcset( $content ) {
    if ( ! is_singular( 'post' ) || strpos( $content, 'wp-image-' ) === false ) {
        return $content;
    }
    // Match any img tag that contains wp-image-{attachment_id} (anywhere in tag for Gutenberg flexibility)
    if ( ! preg_match_all( '/<img\s[^>]*?wp-image-(\d+)[^>]*>/is', $content, $matches, PREG_SET_ORDER ) ) {
        return $content;
    }
    foreach ( $matches as $m ) {
        $full_tag = $m[0];
        $attachment_id = (int) $m[1];
        if ( $attachment_id < 1 ) {
            continue;
        }
        $meta = wp_get_attachment_metadata( $attachment_id );
        $width  = isset( $meta['width'] ) ? (int) $meta['width'] : 0;
        $height = isset( $meta['height'] ) ? (int) $meta['height'] : 0;
        $new_tag = $full_tag;

        // Always add explicit width/height from attachment (fix "Image elements do not have explicit width and height")
        if ( $width > 0 && $height > 0 && ( strpos( $full_tag, 'width=' ) === false || strpos( $full_tag, 'height=' ) === false ) ) {
            $new_tag = preg_replace( '/<img\s/i', '<img width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" ', $new_tag, 1 );
        }

        if ( strpos( $new_tag, 'srcset=' ) !== false ) {
            $content = str_replace( $full_tag, $new_tag, $content );
            continue;
        }
        $srcset = wp_get_attachment_image_srcset( $attachment_id, 'medium_large' );
        if ( ! $srcset ) {
            $content = str_replace( $full_tag, $new_tag, $content );
            continue;
        }
        $sizes = wp_get_attachment_image_sizes( $attachment_id, 'medium_large' );
        if ( ! $sizes ) {
            $sizes = '(max-width: 768px) 100vw, 380px';
        }
        $insert = ' srcset="' . esc_attr( $srcset ) . '" sizes="' . esc_attr( $sizes ) . '"';
        $new_tag = preg_replace( '/\s*src=/i', $insert . ' src=', $new_tag, 1 );
        $content = str_replace( $full_tag, $new_tag, $content );
    }
    return $content;
}
add_filter( 'the_content', 'blog_v2_content_images_add_srcset', 11 );

/**
 * Limit hero image srcset to max 1070w so browser doesn't load 1333px image for 535px display (saves ~66 KiB).
 */
function blog_v2_limit_hero_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
    if ( empty( $size_array[0] ) || $size_array[0] > 768 ) {
        return $sources;
    }
    $max_w = 1070; // 535 * 2 for 2x density
    foreach ( $sources as $w => $data ) {
        if ( (int) $w > $max_w ) {
            unset( $sources[ $w ] );
        }
    }
    return $sources;
}
add_filter( 'wp_calculate_image_srcset', 'blog_v2_limit_hero_srcset', 10, 5 );

/**
 * Get TOC items for the current post (H2s from content, excluding Key Takeaways).
 * Used by sidebar-left to render "In This Article" server-side (avoids CLS from JS-built TOC).
 *
 * @param int|null $post_id Post ID (default current post).
 * @return array List of array( 'id' => string, 'label' => string ). First label is "Introduction".
 */
function blog_v2_get_toc_items( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( ! $post_id ) {
        return array();
    }

    $content = get_post_field( 'post_content', $post_id );
    $content = apply_filters( 'the_content', $content );

    if ( strpos( $content, 'wp-block-heading' ) === false ) {
        return array();
    }

    $dom = new DOMDocument();
    $libxml_prev = libxml_use_internal_errors( true );
    $dom->loadHTML(
        '<?xml encoding="utf-8" ?><div id="blog-v2-toc-root">' . $content . '</div>',
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
    );
    libxml_use_internal_errors( $libxml_prev );
    foreach ( $dom->childNodes as $node ) {
        if ( $node->nodeType === XML_PI_NODE ) {
            $dom->removeChild( $node );
            break;
        }
    }

    $root = $dom->getElementById( 'blog-v2-toc-root' );
    if ( ! $root ) {
        return array();
    }

    $items = array();
    $h2_list = $root->getElementsByTagName( 'h2' );
    foreach ( $h2_list as $h2 ) {
        $class = $h2->getAttribute( 'class' );
        if ( strpos( $class, 'wp-block-heading' ) === false ) {
            continue;
        }
        $ancestor = $h2->parentNode;
        $inside_keytakeaways = false;
        while ( $ancestor && $ancestor !== $root ) {
            $ac = $ancestor->getAttribute( 'class' );
            if ( $ac && strpos( $ac, '_article-keytakeaways' ) !== false ) {
                $inside_keytakeaways = true;
                break;
            }
            $ancestor = $ancestor->parentNode;
        }
        if ( $inside_keytakeaways ) {
            continue;
        }

        $id = trim( $h2->getAttribute( 'id' ) );
        $text = trim( $h2->textContent );
        if ( $text === '' ) {
            continue;
        }
        if ( $id === '' ) {
            $id = blog_v2_toc_heading_slug( $text );
        }
        $label = count( $items ) === 0 ? 'Introduction' : $text;
        $items[] = array( 'id' => $id, 'label' => $label );
    }

    return $items;
}

/**
 * Pick one related post from a list by keyword match (current title words in candidate title).
 * Same logic as whitepaper in sidebar-right: best score wins, else random.
 *
 * @param WP_Post[] $candidates   List of posts.
 * @param string    $current_title Current post title (plain text).
 * @return WP_Post|null
 */
function blog_v2_pick_related_post( array $candidates, $current_title ) {
    if ( empty( $candidates ) ) {
        return null;
    }
    $current_words = array_filter( array_map( 'strtolower', preg_split( '/\s+/', $current_title, -1, PREG_SPLIT_NO_EMPTY ) ) );
    $best_score    = 0;
    $best_index    = 0;

    foreach ( $candidates as $i => $post ) {
        $candidate_title = strtolower( wp_strip_all_tags( get_the_title( $post ) ) );
        $score           = 0;
        foreach ( $current_words as $word ) {
            if ( strlen( $word ) > 2 && strpos( $candidate_title, $word ) !== false ) {
                $score++;
            }
        }
        if ( $score > $best_score ) {
            $best_score = $score;
            $best_index = $i;
        }
    }

    return $best_score > 0 ? $candidates[ $best_index ] : $candidates[ array_rand( $candidates ) ];
}

/**
 * Get the related-article-inline HTML for the current post (one card above references/end of content).
 * Used by the_content filter to inject above References/Resources or at end of content.
 *
 * @return string HTML or empty string.
 */
function blog_v2_get_related_article_inline_html() {
    if ( ! is_singular( 'post' ) || ! in_the_loop() ) {
        return '';
    }
    ob_start();
    get_template_part( 'partials/blog-v2/related-article-inline' );
    return ob_get_clean();
}

/**
 * Inject related article block into post content: above References/Resources section if present,
 * otherwise at the end of content (so it always displays before About The Creator).
 */
function blog_v2_inject_related_article_above_references( $content ) {
    if ( ! is_singular( 'post' ) || ! in_the_loop() ) {
        return $content;
    }

    $related_html = blog_v2_get_related_article_inline_html();
    if ( $related_html === '' ) {
        return $content;
    }

    // Match first heading (h2, h3, h4) that is "References", "Resources", "Sources", or "Additional Resources" (case-insensitive).
    $pattern = '/<(h[2-4])[^>]*>\s*(References|Resources|Sources|Additional Resources?)\s*<\/\1>/i';
    if ( preg_match( $pattern, $content, $m ) ) {
        $insert_before = $m[0];
        $content       = str_replace( $insert_before, $related_html . "\n" . $insert_before, $content );
    } else {
        $content = $content . "\n" . $related_html;
    }

    return $content;
}
add_filter( 'the_content', 'blog_v2_inject_related_article_above_references', 15 );

/**
 * Wrap Expert Insight paragraphs (pale cyan blue) in .blog-v2-expert-insight and output see-more + attribution server-side to avoid CLS.
 * JS only toggles expand/collapse on the button.
 */
function blog_v2_expert_insight_content_filter( $content ) {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }
    if ( strpos( $content, 'has-pale-cyan-blue-background-color' ) === false ) {
        return $content;
    }

    $post_id = get_the_ID();
    $experts = function_exists( 'blog_v2_expert_insight_experts' ) ? blog_v2_expert_insight_experts( $post_id ) : array();
    $charm_link = home_url('/blog/author/charm/');
    $default_name = 'Charm Paz, CHRP';
    $default_title = 'Recruiter and Editor, GCheck';

    $dom = new DOMDocument();
    $libxml_prev = libxml_use_internal_errors( true );
    $dom->loadHTML(
        '<?xml encoding="utf-8" ?><div id="blog-v2-ei-root">' . $content . '</div>',
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
    );
    libxml_use_internal_errors( $libxml_prev );
    foreach ( $dom->childNodes as $node ) {
        if ( $node->nodeType === XML_PI_NODE ) {
            $dom->removeChild( $node );
            break;
        }
    }

    $root = $dom->getElementById( 'blog-v2-ei-root' );
    if ( ! $root ) {
        return $content;
    }

    $paragraphs = $root->getElementsByTagName( 'p' );
    $to_wrap = array();
    foreach ( $paragraphs as $p ) {
        $class = $p->getAttribute( 'class' );
        if ( strpos( $class, 'has-pale-cyan-blue-background-color' ) === false || strpos( $class, 'has-background' ) === false ) {
            continue;
        }
        $ancestor = $p->parentNode;
        $inside = false;
        while ( $ancestor && $ancestor !== $root ) {
            $ac = $ancestor->getAttribute( 'class' );
            if ( $ac && strpos( $ac, 'blog-v2-expert-insight' ) !== false ) {
                $inside = true;
                break;
            }
            $ancestor = $ancestor->parentNode;
        }
        if ( $inside ) {
            continue;
        }
        $to_wrap[] = $p;
    }

    foreach ( $to_wrap as $p ) {
        $expert_slug = '';
        $author_links = $p->getElementsByTagName( 'a' );
        foreach ( $author_links as $a ) {
            $href = $a->getAttribute( 'href' );
            if ( $href && strpos( $href, 'author/' ) !== false && preg_match( '#author/([^/?#]+)#', $href, $m ) ) {
                $expert_slug = strtolower( $m[1] );
                break;
            }
        }

        $expert = null;
        if ( $expert_slug && isset( $experts[ $expert_slug ] ) ) {
            $expert = $experts[ $expert_slug ];
        }
        if ( ! $expert ) {
            $para_text = strtolower( $p->textContent );
            foreach ( $experts as $e ) {
                $first_last = trim( explode( ',', $e['name'], 2 )[0] );
                if ( $first_last !== '' && strpos( $para_text, strtolower( $first_last ) ) !== false ) {
                    $expert = $e;
                    break;
                }
            }
        }
        if ( ! $expert ) {
            $expert = array(
                'name'  => $default_name,
                'title' => $default_title,
                'avatar' => isset( $experts['charm']['avatar'] ) ? $experts['charm']['avatar'] : ( isset( $experts['charm-paz']['avatar'] ) ? $experts['charm-paz']['avatar'] : '' ),
                'link'  => $charm_link,
            );
        }

        $wrapper = $dom->createElement( 'div' );
        $wrapper->setAttribute( 'class', 'blog-v2-expert-insight' );

        $p_clone = $p->cloneNode( true );
        blog_v2_expert_insight_clean_paragraph( $p_clone );
        $wrapper->appendChild( $p_clone );

        $text_only = trim( $p->textContent );
        $needs_truncate = strlen( $text_only ) > 180;
        if ( $needs_truncate ) {
            $btn = $dom->createElement( 'button' );
            $btn->setAttribute( 'type', 'button' );
            $btn->setAttribute( 'class', 'blog-v2-expert-insight__see-more' );
            $btn->setAttribute( 'aria-expanded', 'false' );
            $btn->appendChild( $dom->createTextNode( '… show more' ) );
            $wrapper->appendChild( $btn );
        }

        $name  = isset( $expert['name'] ) ? $expert['name'] : $default_name;
        $title = isset( $expert['title'] ) ? $expert['title'] : $default_title;
        $link  = isset( $expert['link'] ) ? $expert['link'] : $charm_link;
        $avatar = isset( $expert['avatar'] ) ? $expert['avatar'] : '';
        $initials = blog_v2_expert_insight_initials( $name );

        $attr_div = $dom->createElement( 'div' );
        $attr_div->setAttribute( 'class', 'blog-v2-expert-insight__attribution' );
        $attr_link = $dom->createElement( 'a' );
        $attr_link->setAttribute( 'href', $link );
        $attr_link->setAttribute( 'class', 'blog-v2-expert-insight__attribution-link' );
        $attr_span_avatar = $dom->createElement( 'span' );
        $attr_span_avatar->setAttribute( 'class', 'blog-v2-expert-insight__attribution-avatar' . ( $avatar ? '' : ' blog-v2-expert-insight__attribution-avatar--initials' ) );
        if ( $avatar ) {
            $img = $dom->createElement( 'img' );
            $img->setAttribute( 'src', $avatar );
            $img->setAttribute( 'alt', esc_attr( $name ) );
            $img->setAttribute( 'width', '40' );
            $img->setAttribute( 'height', '40' );
            $img->setAttribute( 'loading', 'lazy' );
            $img->setAttribute( 'decoding', 'async' );
            $img->setAttribute( 'class', 'blog-v2-expert-insight__attribution-img' );
            $attr_span_avatar->appendChild( $img );
            $initials_span = $dom->createElement( 'span' );
            $initials_span->setAttribute( 'class', 'blog-v2-expert-insight__attribution-avatar-initials' );
            $initials_span->setAttribute( 'aria-hidden', 'true' );
            $attr_span_avatar->appendChild( $initials_span );
        } else {
            $initials_span = $dom->createElement( 'span' );
            $initials_span->setAttribute( 'class', 'blog-v2-expert-insight__attribution-avatar-initials' );
            $initials_span->setAttribute( 'aria-hidden', 'true' );
            $initials_span->appendChild( $dom->createTextNode( $initials ) );
            $attr_span_avatar->appendChild( $initials_span );
        }
        $attr_link->appendChild( $attr_span_avatar );
        $attr_text = $dom->createElement( 'div' );
        $attr_text->setAttribute( 'class', 'blog-v2-expert-insight__attribution-text' );
        $name_span = $dom->createElement( 'span', $name );
        $name_span->setAttribute( 'class', 'blog-v2-expert-insight__attribution-name' );
        $title_span = $dom->createElement( 'span', $title );
        $title_span->setAttribute( 'class', 'blog-v2-expert-insight__attribution-title' );
        $attr_text->appendChild( $name_span );
        $attr_text->appendChild( $title_span );
        $attr_link->appendChild( $attr_text );
        $attr_div->appendChild( $attr_link );
        $wrapper->appendChild( $attr_div );

        $p->parentNode->replaceChild( $wrapper, $p );
    }

    $out = '';
    foreach ( $root->childNodes as $child ) {
        $out .= $dom->saveHTML( $child );
    }
    return $out;
}

/**
 * Remove "EXPERT INSIGHT:" strong and author links from a paragraph node (in place).
 *
 * @param DOMNode $p Paragraph element.
 */
function blog_v2_expert_insight_clean_paragraph( $p ) {
    $doc = $p->ownerDocument;
    $strongs = $p->getElementsByTagName( 'strong' );
    $to_remove_strong = array();
    $to_unwrap_strong = array();
    foreach ( $strongs as $s ) {
        $t = trim( $s->textContent );
        if ( preg_match( '/^\s*EXPERT INSIGHT\s*:?\s*$/i', $t ) ) {
            $to_remove_strong[] = $s;
        } elseif ( preg_match( '/^[—\-–]\s*Charm Paz/i', $t ) || preg_match( '/^Charm Paz,?\s*CHRP/i', $t ) ) {
            $to_unwrap_strong[] = $s;
        }
    }
    foreach ( $to_unwrap_strong as $s ) {
        if ( $s->parentNode ) {
            $text = $doc->createTextNode( $s->textContent );
            $s->parentNode->replaceChild( $text, $s );
        }
    }
    foreach ( $to_remove_strong as $s ) {
        if ( $s->parentNode ) {
            $s->parentNode->removeChild( $s );
        }
    }
    $links = $p->getElementsByTagName( 'a' );
    $to_remove_links = array();
    foreach ( $links as $a ) {
        if ( strpos( $a->getAttribute( 'href' ), 'author/' ) !== false ) {
            $to_remove_links[] = $a;
        }
    }
    foreach ( $to_remove_links as $a ) {
        $prev = $a->previousSibling;
        if ( $prev && $prev->nodeType === XML_TEXT_NODE ) {
            $prev->nodeValue = preg_replace( '/\s*[–\-—]\s*$/', '', $prev->nodeValue );
        }
        if ( $a->parentNode ) {
            $a->parentNode->removeChild( $a );
        }
    }
}

/**
 * Get initials from expert name (e.g. "Charm Paz" -> "CP").
 *
 * @param string $name Display name.
 * @return string Two-letter initials.
 */
function blog_v2_expert_insight_initials( $name ) {
    $name = trim( wp_strip_all_tags( $name ) );
    if ( $name === '' ) {
        return '';
    }
    $parts = preg_split( '/\s+/', $name, 2, PREG_SPLIT_NO_EMPTY );
    if ( count( $parts ) >= 2 ) {
        return strtoupper( mb_substr( $parts[0], 0, 1 ) . mb_substr( $parts[1], 0, 1 ) );
    }
    return strtoupper( mb_substr( $name, 0, 2 ) );
}

add_filter( 'the_content', 'blog_v2_expert_insight_content_filter', 18 );

/**
 * Shortcode: Blog Article Card
 * Usage: [article_card id="123"] or [article_card id="123" /]
 * Displays a blog post card with featured image, category, title, date, and author
 */
function blog_v2_article_card_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'id' => '',
    ), $atts, 'article_card' );

    if ( empty( $atts['id'] ) || ! is_numeric( $atts['id'] ) ) {
        return '';
    }

    $post_id = intval( $atts['id'] );

    set_query_var( 'article_post_id', $post_id );

    ob_start();
    get_template_part( 'partials/blog-v2/article-card' );
    return ob_get_clean();
}
add_shortcode( 'article_card', 'blog_v2_article_card_shortcode' );
