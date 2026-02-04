<?php
/**
 * Blog V2: theme functions and hooks.
 * Loaded once from functions.php. All blog-v2 logic in one place: author display, content filters, related post, shortcode.
 */

// --- Author display (Created by / About The Creator) ---

/**
 * Default blog author when post has no author or for fallback (Pat).
 */
function blog_v2_default_author() {
    return array(
        'name'     => 'Pat Hartonian',
        'job'      => 'VP of Operations, GCheck',
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
            'link'   => 'https://gcheck.com/blog/author/charm/',
        ),
        'charm' => array(
            'name'   => 'Charm Paz, CHRP',
            'job'    => 'Recruiter and Editor, GCheck',
            'avatar' => $base . 'charm-paz.png',
            'link'   => 'https://gcheck.com/blog/author/charm/',
        ),
        'emile' => array(
            'name'   => 'Emile Garcia, SHRM-SCP, CHRP, CHRBP',
            'job'    => 'Recruiter and Editor, GCheck',
            'avatar' => $base . 'emile-garcia.png',
            'link'   => 'https://gcheck.com/blog/author/emile/',
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
 * Whether the current post has a reviewer (PublishPress Reviewer category, Article Options, or _blog_reviewer_slug).
 *
 * @param int|null $post_id Post ID.
 * @return bool
 */
function blog_v2_has_reviewer( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( ! $post_id ) {
        return false;
    }
    // PublishPress Authors: Reviewer category.
    if ( function_exists( 'ppma_post_authors_categorized' ) ) {
        $categorized = ppma_post_authors_categorized( $post_id, array( 'reviewer' ) );
        if ( ! empty( $categorized['reviewer'] ) && is_array( $categorized['reviewer'] ) ) {
            return true;
        }
    }
    if ( blog_v2_get_reviewer_user_id( $post_id ) > 0 ) {
        return true;
    }
    $slug = get_post_meta( $post_id, '_blog_reviewer_slug', true );
    $slug = is_string( $slug ) ? trim( $slug ) : '';
    if ( $slug !== '' && isset( blog_v2_reviewers_registry()[ $slug ] ) ) {
        return true;
    }
    return false;
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
    $no_asset_slugs = array( 'charm', 'charm-paz', 'emile' );
    foreach ( $registry as $slug => $r ) {
        $avatar = in_array( $slug, $no_asset_slugs, true ) ? '' : $r['avatar'];
        $out[ $slug ] = array(
            'name'   => $r['name'],
            'title'  => $r['job'],
            'avatar' => $avatar,
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
            return wp_kses_post( nl2br( $description ) );
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
        return wp_kses_post( nl2br( $description ) );
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
        $link = 'https://gcheck.com/blog/author/marc/';
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
    $is_editorial_team = blog_v2_is_gcheck_editorial_team( $author_id ) || ( $job === blog_v2_default_author_job() );
    if ( $is_editorial_team ) {
        $job = '';
    } elseif ( $job === '' ) {
        $job = blog_v2_default_author_job();
    }
    $initials = blog_v2_author_initials( $author_name );
    $link = $is_editorial_team ? 'https://gcheck.com/blog/author/marc/' : get_author_posts_url( $author_id );
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
