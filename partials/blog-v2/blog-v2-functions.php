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
 * Blog V2: author display data for "Created by" (post author, default Pat).
 * Returns: name, job, avatar ('pat' | 'initials'), url, initials, link, color.
 * Non-Pat authors use colored initials circle (no Gravatar); empty job uses default.
 */
function blog_v2_author_display_data( $post_id = null ) {
    $default = blog_v2_default_author();
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( ! $post_id ) {
        return $default;
    }
    $author_id = (int) get_post_field( 'post_author', $post_id );
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
    $link = get_author_posts_url( $author_id );
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
 * Remove only strictly empty paragraph tags from blog post content (single posts only).
 * Removes <p></p> or <p class="..."></p> with nothing between the tags.
 */
function blog_v2_remove_empty_p_tags( $content ) {
    if ( ! is_single() ) {
        return $content;
    }
    $content = preg_replace( '/<p[^>]*><\/p>/', '', $content );
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
