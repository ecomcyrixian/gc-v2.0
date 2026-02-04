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
 * Get first creator (author) user ID from post's Article Options "Authors" field.
 * Tries ACF field "authors", then post meta "authors". Returns 0 if none.
 *
 * @param int $post_id Post ID.
 * @return int User ID or 0.
 */
function blog_v2_get_creator_user_id( $post_id ) {
    $author_id = 0;
    if ( function_exists( 'get_field' ) ) {
        $authors = get_field( 'authors', $post_id );
        if ( is_array( $authors ) && ! empty( $authors ) ) {
            $first = $authors[0];
            $author_id = is_object( $first ) && isset( $first->ID ) ? (int) $first->ID : ( is_array( $first ) && isset( $first['ID'] ) ? (int) $first['ID'] : (int) $first );
        } elseif ( is_numeric( $authors ) && $authors > 0 ) {
            $author_id = (int) $authors;
        }
    }
    if ( ! $author_id ) {
        $raw = get_post_meta( $post_id, 'authors', true );
        if ( is_array( $raw ) && ! empty( $raw ) ) {
            $author_id = (int) $raw[0];
        } elseif ( is_numeric( $raw ) && $raw > 0 ) {
            $author_id = (int) $raw;
        }
    }
    return $author_id;
}

/**
 * Get first reviewer user ID from post's Article Options "Reviewers" field.
 * Tries ACF field "reviewers", then post meta "reviewers". Returns 0 if none.
 *
 * @param int $post_id Post ID.
 * @return int User ID or 0.
 */
function blog_v2_get_reviewer_user_id( $post_id ) {
    $reviewer_id = 0;
    if ( function_exists( 'get_field' ) ) {
        $reviewers = get_field( 'reviewers', $post_id );
        if ( is_array( $reviewers ) && ! empty( $reviewers ) ) {
            $first = $reviewers[0];
            $reviewer_id = is_object( $first ) && isset( $first->ID ) ? (int) $first->ID : ( is_array( $first ) && isset( $first['ID'] ) ? (int) $first['ID'] : (int) $first );
        } elseif ( is_numeric( $reviewers ) && $reviewers > 0 ) {
            $reviewer_id = (int) $reviewers;
        }
    }
    if ( ! $reviewer_id ) {
        $raw = get_post_meta( $post_id, 'reviewers', true );
        if ( is_array( $raw ) && ! empty( $raw ) ) {
            $reviewer_id = (int) $raw[0];
        } elseif ( is_numeric( $raw ) && $raw > 0 ) {
            $reviewer_id = (int) $raw;
        }
    }
    return $reviewer_id;
}

/**
 * Whether the current post has a reviewer explicitly set (Article Options Reviewers or _blog_reviewer_slug).
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
 * Reviewer display data for current post.
 * Uses Article Options "Reviewers" field first (user); else post meta _blog_reviewer_slug (registry).
 * Returns null when no reviewer is set (no default to Charm).
 *
 * @param int|null $post_id Post ID.
 * @return array|null Reviewer data (name, job, avatar, link, slug) or null if none set.
 */
function blog_v2_reviewer_display_data( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $registry = blog_v2_reviewers_registry();

    // Prefer reviewer from Article Options (Reviewers field).
    $reviewer_user_id = blog_v2_get_reviewer_user_id( $post_id );
    if ( $reviewer_user_id > 0 ) {
        $name = get_the_author_meta( 'display_name', $reviewer_user_id );
        $name = trim( wp_strip_all_tags( $name ) );
        if ( $name !== '' ) {
            $job = get_the_author_meta( 'job_title', $reviewer_user_id );
            $job = is_string( $job ) ? trim( $job ) : '';
            if ( $job === '' ) {
                $job = 'Recruiter and Editor, GCheck';
            }
            $link = get_author_posts_url( $reviewer_user_id );
            if ( ! $link ) {
                $link = '#';
            }
            $avatar = get_avatar_url( $reviewer_user_id, array( 'size' => 96 ) );
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
    }

    // Else: _blog_reviewer_slug (only if explicitly set).
    $slug = get_post_meta( $post_id, '_blog_reviewer_slug', true );
    $slug = is_string( $slug ) ? trim( $slug ) : '';
    if ( $slug === '' || ! isset( $registry[ $slug ] ) ) {
        return null;
    }
    $r = $registry[ $slug ];
    return array(
        'name'   => $r['name'],
        'job'    => $r['job'],
        'avatar' => $r['avatar'],
        'link'   => $r['link'],
        'slug'   => $slug,
    );
}

/**
 * Experts data for Expert Insight block JS. Keyed by author slug for lookup from paragraph author link.
 */
function blog_v2_expert_insight_experts() {
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
 * Uses the creator's WordPress user description; falls back to Pat bio when creator is Pat; otherwise GCheck Editorial Team bio (e.g. Monica, marc, anyone without a custom bio).
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
 * Blog V2: author display data for "Created by" / About The Creator.
 * Uses Article Options "Authors" field first (creator); else post author; default Pat.
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

    // Prefer creator from Article Options (Authors field).
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
    if ( $job === '' ) {
        $job = blog_v2_default_author_job();
    }
    $initials = blog_v2_author_initials( $author_name );
    $is_editorial_team = blog_v2_is_gcheck_editorial_team( $author_id ) || ( $job === blog_v2_default_author_job() );
    $link = $is_editorial_team ? 'https://gcheck.com/blog/author/marc/' : get_author_posts_url( $author_id );
    $color = blog_v2_author_initials_color( $author_name );
    $name_display = trim( $author_name );
    if ( $name_display !== '' && function_exists( 'mb_convert_case' ) ) {
        $name_display = mb_convert_case( $name_display, MB_CASE_TITLE, 'UTF-8' );
    } elseif ( $name_display !== '' ) {
        $name_display = ucwords( strtolower( $name_display ) );
    }
    return array(
        'name'     => $name_display,
        'job'      => $job,
        'avatar'   => 'initials',
        'url'      => '',
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
