<?php
/*
 * featured image
 */
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );

require_once get_template_directory() . '/partials/publishpress-author-sync.php';

/*
 * Blog hero image size: ~540px width so srcset can serve smaller file when displayed at 535px (mobile LCP).
 * Regenerate thumbnails for existing uploads to get this size.
 */
add_image_size( 'blog_hero', 540, 0, false );

/**
 * Build width/height attributes for <img> to reserve space (CLS). Does not affect download speed.
 *
 * @param mixed $image ACF image field (array or ID), attachment ID, or other value passed to gc_get_acf_image_src.
 * @return string Attributes with trailing space, e.g. width="800" height="600" , or empty.
 */
function gc_theme_img_dimension_attrs( $image ) {
	if ( $image === null || $image === '' || $image === array() ) {
		return '';
	}
	$w = 0;
	$h = 0;
	if ( function_exists( 'gc_get_acf_image_src' ) ) {
		$src = gc_get_acf_image_src( $image );
		if ( is_array( $src ) && ! empty( $src['width'] ) && ! empty( $src['height'] ) ) {
			$w = (int) $src['width'];
			$h = (int) $src['height'];
		}
	}
	if ( ( $w < 1 || $h < 1 ) && is_array( $image ) ) {
		if ( ! empty( $image['width'] ) && ! empty( $image['height'] ) ) {
			$w = (int) $image['width'];
			$h = (int) $image['height'];
		} else {
			$aid = isset( $image['ID'] ) ? (int) $image['ID'] : ( isset( $image['id'] ) ? (int) $image['id'] : 0 );
			if ( $aid && function_exists( 'wp_get_attachment_image_src' ) ) {
				$meta = wp_get_attachment_image_src( $aid, 'full' );
				if ( $meta && isset( $meta[1], $meta[2] ) ) {
					$w = (int) $meta[1];
					$h = (int) $meta[2];
				}
			}
		}
	} elseif ( ( $w < 1 || $h < 1 ) && is_numeric( $image ) && function_exists( 'wp_get_attachment_image_src' ) ) {
		$meta = wp_get_attachment_image_src( (int) $image, 'full' );
		if ( $meta && isset( $meta[1], $meta[2] ) ) {
			$w = (int) $meta[1];
			$h = (int) $meta[2];
		}
	}
	if ( $w > 0 && $h > 0 ) {
		return 'width="' . esc_attr( (string) $w ) . '" height="' . esc_attr( (string) $h ) . '" ';
	}
	return '';
}

/*
 * Specific script and styles per page
 * Automatic cache busting based on source SCSS and compiled CSS file modification time
 * Uses whichever is newer (industry-standard hybrid approach)
 */
function theme_styles_script() {
	
    global $post;
    
	if ( is_front_page() ) {
    	$front_page_scss = get_template_directory() . '/assets/css/front-page-new.scss';
    	$front_page_css = get_template_directory() . '/assets/css/front-page-new.css';
    	
    	$scss_time = file_exists($front_page_scss) ? filemtime($front_page_scss) : 0;
    	$css_time = file_exists($front_page_css) ? filemtime($front_page_css) : 0;
    	$front_page_version = max($scss_time, $css_time) ?: '1';
    	
    	wp_enqueue_style( 'homepage-style', get_template_directory_uri() . '/assets/css/front-page-new.css', array(), $front_page_version, 'screen' );
        // If you uncomment this, it will automatically have cache busting
        // $front_page_js = get_template_directory() . '/assets/js/front-page.js';
        // $front_page_js_version = file_exists($front_page_js) ? filemtime($front_page_js) : '1';
        // wp_register_script( 'homepage-script', get_template_directory_uri() . '/assets/js/front-page.js', array(), $front_page_js_version, true );
    	// wp_enqueue_script( 'homepage-script' );

    } elseif ( is_page() ) {
        $core_page_scss = get_template_directory() . '/assets/css/core-page.scss';
        $page_hero_scss = get_template_directory() . '/core-pages/page-hero/css/_page-hero.scss';
        $custom_whitepaper_scss = get_template_directory() . '/core-pages/custom-whitepaper/css/_custom-whitepaper-hero.scss';
        $core_page_css = get_template_directory() . '/assets/css/core-page-new.css';
        
        $scss_times = array();
        if (file_exists($core_page_scss)) {
            $scss_times[] = filemtime($core_page_scss);
        }
        if (file_exists($page_hero_scss)) {
            $scss_times[] = filemtime($page_hero_scss);
        }
        if (file_exists($custom_whitepaper_scss)) {
            $scss_times[] = filemtime($custom_whitepaper_scss);
        }
        
        $css_time = file_exists($core_page_css) ? filemtime($core_page_css) : 0;
        $max_scss_time = !empty($scss_times) ? max($scss_times) : 0;
        $version = max($max_scss_time, $css_time) ?: '1';
        
        wp_enqueue_style( 'page-style', get_template_directory_uri() . '/assets/css/core-page-new.css', array(), $version, 'screen' );
    } elseif ( is_single() || is_search() || is_category() || is_author() || is_tax( 'author' ) ) {
        $blog_page_scss = get_template_directory() . '/assets/css/blog-page-new.scss';
        $search_scss = get_template_directory() . '/core-pages/blog/css/_search.scss';
        $blog_page_css = get_template_directory() . '/assets/css/blog-page-new.css';
        
        $scss_times = array();
        if (file_exists($blog_page_scss)) {
            $scss_times[] = filemtime($blog_page_scss);
        }
        if (file_exists($search_scss)) {
            $scss_times[] = filemtime($search_scss);
        }
        
        $css_time = file_exists($blog_page_css) ? filemtime($blog_page_css) : 0;
        $max_scss_time = !empty($scss_times) ? max($scss_times) : 0;
        $version = max($max_scss_time, $css_time) ?: '1';
        
        wp_enqueue_style( 'page-style', get_template_directory_uri() . '/assets/css/blog-page-new.css', array(), $version, 'screen' );
    }
	
}
add_action( 'wp_enqueue_scripts', 'theme_styles_script' );

require_once get_template_directory() . '/core-pages/custom-whitepaper/gcheck-pdf-form.php';

/*
 * Enqueue jQuery and theme scripts
 * Automatic cache busting based on file modification time
 */
function gcheck_scripts() {
    wp_enqueue_script('jquery');

    $js_file_path = get_template_directory() . '/assets/js/global-new.js';
    $global_js_version = file_exists($js_file_path) ? filemtime($js_file_path) : '1.0.0';
    
    wp_enqueue_script(
        'my-custom-script',
        get_template_directory_uri() . '/assets/js/global-new.js',
        array('jquery'),
        $global_js_version,
        true
    );

    if ( is_single() ) {
        $blog_v2_js_path = get_template_directory() . '/assets/js/blog-v2.js';
        $blog_v2_js_version = file_exists($blog_v2_js_path) ? filemtime($blog_v2_js_path) : '1.0.0';

        wp_enqueue_script(
            'blog-v2',
            get_template_directory_uri() . '/assets/js/blog-v2.js',
            array(),
            $blog_v2_js_version,
            true
        );

        $expert_insight_data = array(
            'charmAvatarUrl' => '',
            'charmLink'      => home_url('/blog/author/charm/'),
        );
        if ( function_exists( 'blog_v2_expert_insight_experts' ) ) {
            $expert_insight_data['experts'] = blog_v2_expert_insight_experts( get_the_ID() );
        } else {
            $expert_insight_data['experts'] = array();
        }
        wp_localize_script(
            'blog-v2',
            'blogV2ExpertInsight',
            $expert_insight_data
        );
    }
}
add_action('wp_enqueue_scripts', 'gcheck_scripts');

/**
 * Bing UET: consent bar styles/scripts (front-end only). Tag + default consent load from head.php partial.
 */
function gc_bing_uet_consent_assets() {
	if ( is_admin() ) {
		return;
	}
	$css_path = get_template_directory() . '/assets/css/bing-consent.css';
	$js_path  = get_template_directory() . '/assets/js/bing-consent.js';
	$v_css    = file_exists( $css_path ) ? filemtime( $css_path ) : '1';
	$v_js     = file_exists( $js_path ) ? filemtime( $js_path ) : '1';
	wp_enqueue_style(
		'gc-bing-consent',
		get_template_directory_uri() . '/assets/css/bing-consent.css',
		array(),
		$v_css
	);
	wp_enqueue_script(
		'gc-bing-consent',
		get_template_directory_uri() . '/assets/js/bing-consent.js',
		array(),
		$v_js,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'gc_bing_uet_consent_assets' );

/**
 * Bing UET: cookie consent bar markup (Accept / Reject → localStorage + uetq consent update).
 */
function gc_bing_uet_consent_banner() {
	if ( is_admin() ) {
		return;
	}
	get_template_part( 'partials/bing/bing-consent-banner' );
}
add_action( 'wp_footer', 'gc_bing_uet_consent_banner', 5 );

/**
 * Reduce unused CSS: dequeue dashicons on front-end when admin bar is not shown.
 * Saves ~35 KiB. Dashicons is required for admin bar and block editor; safe to remove on front when not used.
 */
function theme_dequeue_dashicons_on_front() {
    if ( is_admin() || is_customize_preview() ) {
        return;
    }
    if ( ! is_admin_bar_showing() ) {
        wp_dequeue_style( 'dashicons' );
        wp_deregister_style( 'dashicons' );
    }
}
add_action( 'wp_enqueue_scripts', 'theme_dequeue_dashicons_on_front', 999 );

/**
 * Dequeue Font Awesome from plugins (cdnjs all.min.css) when not needed.
 * Saves ~22 KiB on single posts only. Other pages keep FA if a plugin enqueues it.
 */
function theme_dequeue_font_awesome_css() {
    if ( is_admin() || ! is_singular( 'post' ) ) {
        return;
    }
    $wp_styles = wp_styles();
    if ( ! $wp_styles || empty( $wp_styles->registered ) ) {
        return;
    }
    foreach ( $wp_styles->registered as $handle => $obj ) {
        if ( empty( $obj->src ) ) {
            continue;
        }
        $src = is_string( $obj->src ) ? $obj->src : '';
        if ( strpos( $src, 'all.min.css' ) !== false && ( strpos( $src, 'cdnjs' ) !== false || strpos( $src, 'cloudflare' ) !== false ) ) {
            wp_dequeue_style( $handle );
            wp_deregister_style( $handle );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'theme_dequeue_font_awesome_css', 999 );
add_action( 'wp_print_styles', 'theme_dequeue_font_awesome_css', 999 );

/**
 * Strip Font Awesome link from output on single posts only (plugin may print outside queue).
 * Other pages keep FA. Runs when each style tag is output.
 */
function theme_strip_font_awesome_style_tag( $tag, $handle, $href, $media ) {
    if ( ! is_singular( 'post' ) ) {
        return $tag;
    }
    if ( empty( $href ) || ! is_string( $href ) ) {
        return $tag;
    }
    if ( strpos( $href, 'all.min.css' ) !== false && ( strpos( $href, 'cdnjs' ) !== false || strpos( $href, 'cloudflare' ) !== false ) ) {
        return '';
    }
    return $tag;
}
add_filter( 'style_loader_tag', 'theme_strip_font_awesome_style_tag', 10, 4 );

/**
 * Dequeue wp-block-library CSS on non-Gutenberg pages (archives, category, search, etc.).
 * Keep it on any singular content (posts and pages) where Gutenberg blocks render.
 * Defer it on those pages so it's non-render-blocking.
 */
function theme_dequeue_block_library() {
    if ( is_admin() ) {
        return;
    }
    if ( ! is_singular() ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }
}
add_action( 'wp_enqueue_scripts', 'theme_dequeue_block_library', 999 );


/**
 * Last-chance dequeue dashicons right before styles are printed (in case re-enqueued by plugin).
 */
function theme_dequeue_dashicons_before_print() {
    if ( ! is_admin() && ! is_admin_bar_showing() && ! is_customize_preview() ) {
        wp_dequeue_style( 'dashicons' );
    }
}
add_action( 'wp_print_styles', 'theme_dequeue_dashicons_before_print', 999 );

/**
 * Dequeue Contact Form 7 JS + CSS on single blog posts (no forms present).
 * Saves ~136 ms main-thread blocking + 2 network requests.
 */
function theme_dequeue_cf7_on_blog_posts() {
    if ( ! is_singular( 'post' ) ) {
        return;
    }
    wp_dequeue_script( 'contact-form-7' );
    wp_dequeue_script( 'swv' );
    wp_dequeue_style( 'contact-form-7' );
}
add_action( 'wp_enqueue_scripts', 'theme_dequeue_cf7_on_blog_posts', 999 );

/**
 * Load Blog V2 functions only on single post views (author helpers, content filters, related post, shortcode).
 * Expand condition later if [article_card] or other blog-v2 logic is needed on pages/archives.
 */
function maybe_load_blog_v2_functions() {
    if ( is_singular( 'post' ) ) {
        require_once get_template_directory() . '/partials/blog-v2/blog-v2-functions.php';
    }
}
add_action( 'wp', 'maybe_load_blog_v2_functions' );

/*
 * Enqueue global CSS with automatic cache busting based on source SCSS and compiled CSS file modification time
 * Uses whichever is newer (industry-standard hybrid approach)
 */
function enqueue_global_styles() {
    $scss_file_path = get_template_directory() . '/assets/css/global-new.scss';
    $page_hero_scss = get_template_directory() . '/core-pages/page-hero/css/_page-hero.scss';
    $cards_scss = get_template_directory() . '/core-pages/cards/css/_cards.scss';
    $search_scss = get_template_directory() . '/core-pages/blog/css/_search.scss';
    $css_file_path = get_template_directory() . '/assets/css/global-new.css';
    
    $scss_times = array();
    
    if (file_exists($scss_file_path)) {
        $scss_times[] = filemtime($scss_file_path);
    }
    if (file_exists($page_hero_scss)) {
        $scss_times[] = filemtime($page_hero_scss);
    }
    if (file_exists($cards_scss)) {
        $scss_times[] = filemtime($cards_scss);
    }
    if (file_exists($search_scss)) {
        $scss_times[] = filemtime($search_scss);
    }
    
    $css_time = file_exists($css_file_path) ? filemtime($css_file_path) : 0;
    $max_scss_time = !empty($scss_times) ? max($scss_times) : 0;
    
    // Use content hash of the CSS file for reliable cache busting
    // This ensures the version changes whenever the CSS file content actually changes
    // Even if server-side caching affects file modification times
    $css_hash = file_exists($css_file_path) ? md5_file($css_file_path) : '';
    $hash_suffix = $css_hash ? substr($css_hash, 0, 8) : '';
    
    // Combine modification time with content hash for maximum reliability
    $version = max($max_scss_time, $css_time) . ($hash_suffix ? '-' . $hash_suffix : '');
    
    wp_enqueue_style(
        'global-style',
        get_template_directory_uri() . '/assets/css/global-new.css',
        array(), // No dependencies
        $version, // Version number - automatically updates when source SCSS or compiled CSS changes
        'all'
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_global_styles' );


/*
 * Menu description
 */
function custom_wp_nav_menu_item_args( $args, $item, $depth ) {
    if ( ! empty( $item->description ) ) {
        $args->link_after = '<span class="menu-item-description">' . $item->description . '</span>';
    }
    return $args;
}
add_filter( 'nav_menu_item_args', 'custom_wp_nav_menu_item_args', 10, 3 );

/*
 * Register menu
 */
function register_my_menu() {
    register_nav_menu( 'primary', __( 'Main Menu', 'theme-slug' ) );
    register_nav_menu( 'footer', __( 'Footer Menu', 'theme-slug' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );


/*
 * Register menu support
 */ 
//add_theme_support( 'menus' );
/*
 * Custom walker class
 */ 
class Walker_Nav_Menu_With_Description extends Walker_Nav_Menu {
	
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Same spacing logic as core
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent  = str_repeat( $t, $depth );
        $classes = array( 'sub-menu' );

        $class_names = implode( ' ', $classes );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= "{$n}{$indent}<ul{$class_names}>{$n}";
    }

    // Start element output
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Get ACF description
        $description = get_field( 'menu_item_description', $item->ID );

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output  = $args->before;
		 $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . $title . $args->link_after;
            if ( $description ) {
                $item_output .= '<span class="menu-item-description">' . $description . '</span>';
            }
            $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Desktop-specific walker that wraps the first sub-menu level
 * in a mega-panel container so we can pair menu links with
 * feature callouts (blog/whitepaper) per Figma design.
 */
class Desktop_Mega_Walker extends Walker_Nav_Menu_With_Description {

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        
        if ( $depth === 0 ) {
            $atts['class'] = 'mega-menu-trigger';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $description = get_field( 'menu_item_description', $item->ID );

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output  = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        if ( $description ) {
            $item_output .= '<span class="menu-item-description">' . $description . '</span>';
        }
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent  = str_repeat( $t, $depth );
        $classes = array( 'sub-menu' );

        $class_names = implode( ' ', $classes );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        if ( $depth === 0 ) {
            $output .= "{$n}{$indent}<div class=\"mega-panel\"><div class=\"mega-links\">{$n}";
            if ( ! empty( $args->mega_panel_title ) ) {
                // Map panel titles to their URLs
                $title_url_map = array(
                    'Identity' => home_url('/identity'),
                    'Background Checks' => home_url('/background-checks'),
                    'Verifications' => home_url('/verifications'),
                    'Drug & Health' => home_url('/drug-health'),
                    'Continuous Monitoring' => home_url('/risk-monitoring'),
                    'Compliance' => home_url('/compliance-automation'),
                );
                $title_url = isset( $title_url_map[ $args->mega_panel_title ] ) ? $title_url_map[ $args->mega_panel_title ] : '#';
                $output .= "{$indent}<a href=\"" . esc_url( $title_url ) . "\" class=\"mega-title\">" . esc_html( $args->mega_panel_title ) . "</a>{$n}";
            }
            $output .= "{$indent}<ul{$class_names}>{$n}";
        } else {
            $output .= "{$n}{$indent}<ul{$class_names}>{$n}";
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent = str_repeat( $t, $depth );

        if ( $depth === 0 ) {
            $output .= "{$indent}</ul>";
            if ( ! empty( $args->mega_cta_url ) && ! empty( $args->mega_cta_label ) ) {
                $output .= "{$indent}<a class=\" mega-cta button white\" href=\"" . esc_url( $args->mega_cta_url ) . "\">" . esc_html( $args->mega_cta_label ) . "</a>{$n}";
            }
            $output .= "</div>";
            if ( ! empty( $args->mega_feature ) ) {
                $output .= $args->mega_feature;
            }
            $output .= "</div>{$n}";
        } else {
            $output .= "{$indent}</ul>{$n}";
        }
    }
}

class Parent_Menu_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( $depth == 0 ) { // Only process top-level items (parent menu items)
            parent::start_el( $output, $item, $depth, $args, $id );
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( $depth == 0 ) { // Only process top-level items
            parent::end_el( $output, $item, $depth, $args );
        }
    }

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Do nothing for sub-levels
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        // Do nothing for sub-levels
    }
}

/*
 * categories and tags to page
 */

function register_category_and_tag_with_pages() {
    // Add categories to pages
    register_taxonomy_for_object_type('category', 'page');
    // Add tags to pages
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'register_category_and_tag_with_pages');

function allow_category_and_tag_archives_for_pages($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    // Allow pages to be included in category archives
    if ($query->is_category() && $query->is_main_query()) {
        $query->set('post_type', array('post', 'page'));
    }

    // Allow pages to be included in tag archives
    if ($query->is_tag() && $query->is_main_query()) {
        $query->set('post_type', array('post', 'page'));
    }
}
add_action('pre_get_posts', 'allow_category_and_tag_archives_for_pages');


//  Add excerpt for pages
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}

/*
 * Get featured article for navigation menu
 * This function will look for a post based on menu name or category
 */
function get_mega_menu_featured_article( $menu_name, $menu_item_title = '' ) {
    // Map menu names to specific post IDs (prioritized)
    $menu_post_map = array(
        'GCv2.0 : Identity' => 2965,
        'GCv2.0 : Background Checks' => 2721,
        'GCv2.0 : Drug & Health' => 10978,
        'GCv2.0 : Verifications' => 16952,
        'GCv2.0 : Risk Monitoring' => 2344,
        'GCv2.0 : Compliance' => 18359,
    );
    
    // First, try to get the prioritized post ID
    if ( isset( $menu_post_map[ $menu_name ] ) ) {
        $post_id = $menu_post_map[ $menu_name ];
        $post = get_post( $post_id );
        
        // Check if post exists and is published
        if ( $post && $post->post_status === 'publish' ) {
            return $post;
        }
    }
    
    // Map menu names to actual WordPress category slugs (fallback)
    $menu_category_map = array(
        'GCv2.0 : Drug & Health' => 'industry-guides',     
        'GCv2.0 : Identity' => 'technology',                
        'GCv2.0 : Background Checks' => 'fundamentals',     
        'GCv2.0 : Verifications' => 'fundamentals',         
        'GCv2.0 : Risk Monitoring' => 'technology',        
        'GCv2.0 : Compliance' => 'legal-compliance',        
    );
    
    $category_slug = isset( $menu_category_map[ $menu_name ] ) ? $menu_category_map[ $menu_name ] : null;
    
    $args = array(
        'post_type' => array( 'post', 'page' ),
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
    );
    
    if ( $category_slug ) {
        $args['category_name'] = $category_slug;
        $query = new WP_Query( $args );
        
        if ( $query->have_posts() ) {
            if ( ! empty( $menu_item_title ) ) {
                $search_term = strtolower( $menu_item_title );
                
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $post = get_post();
                    $title = strtolower( get_the_title( $post ) );
                    $content = strtolower( wp_strip_all_tags( get_the_content( $post ) ) );
                    $excerpt = strtolower( get_the_excerpt( $post ) );
                    
                    $search_text = $title . ' ' . $content . ' ' . $excerpt;
                    
                    if ( strpos( $search_text, $search_term ) !== false ) {
                        wp_reset_postdata();
                        return $post;
                    }
                }
                wp_reset_postdata();
            }
            
            $args['posts_per_page'] = 1;
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                $query->the_post();
                $post = get_post();
                wp_reset_postdata();
                return $post;
            }
        }
    }
    
    unset( $args['category_name'] );
    $args['posts_per_page'] = 1;
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        $query->the_post();
        $post = get_post();
        wp_reset_postdata();
        return $post;
    }
    
    return null;
}

/*
 * Get whitepaper for navigation menu
 */
function get_mega_menu_whitepaper( $menu_name ) {
    $whitepaper_map = array(
        'GCv2.0 : Background Checks' => array( 'background', 'screening', 'criminal', 'check', 'hr', 'prompt' ),
        'GCv2.0 : Drug & Health' => array( 'drug', 'health', 'pharmacy', 'medical', 'occupational', 'screening', 'hr' ),
    );
    
    $search_terms = isset( $whitepaper_map[ $menu_name ] ) ? $whitepaper_map[ $menu_name ] : array();
    
    $args = array(
        'category_name' => 'whitepapers',
        'post_type' => array( 'post', 'page' ),
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() && ! empty( $search_terms ) ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post = get_post();
            $title = strtolower( get_the_title( $post ) );
            $content = strtolower( wp_strip_all_tags( get_the_content( $post ) ) );
            $excerpt = strtolower( get_the_excerpt( $post ) );
            
            $search_text = $title . ' ' . $content . ' ' . $excerpt;
            
            foreach ( $search_terms as $term ) {
                if ( strpos( $search_text, strtolower( $term ) ) !== false ) {
                    wp_reset_postdata();
                    return $post;
                }
            }
        }
        wp_reset_postdata();
    }
    
    $args['posts_per_page'] = 1;
    $args['category_name'] = 'whitepapers';
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        $query->the_post();
        $post = get_post();
        wp_reset_postdata();
        return $post;
    }
    
    return null;
}

/*
 * Generate featured article HTML for mega menu
 */
function generate_mega_featured_article( $post ) {
    if ( ! $post ) {
        return '';
    }
    
    $title = get_the_title( $post );
    $permalink = get_permalink( $post );
    $thumbnail = get_the_post_thumbnail( $post->ID, 'medium' );
    $date = get_the_date( 'M j, Y', $post );
    $read_time = get_field( 'read_time', $post->ID );
    
    $categories = get_the_category( $post->ID );
    $category_name = ! empty( $categories ) ? strtoupper( $categories[0]->name ) : 'FEATURED STORY';
    
    $html = '<div class="mega-feature blog">';
    $html .= '<div class="feature-card">';
    
    if ( $thumbnail ) {
        $html .= '<div class="feature-image"><a href="' . esc_url( $permalink ) . '">' . $thumbnail . '</a></div>';
    }
    
    $html .= '<p class="eyebrow category-colored"><a href="' . esc_url( $permalink ) . '">' . esc_html( $category_name ) . '</a></p>';
    $html .= '<h4 class="feature-title"><a href="' . esc_url( $permalink ) . '">' . esc_html( $title ) . '</a></h4>';
    
    // Date removed from header - only show read time if available
    if ( $read_time ) {
        $html .= '<p class="feature-meta">';
        $html .= esc_html( $read_time ) . ' min read';
        $html .= '</p>';
    }
    
    $html .= '<a class="button outline" href="' . esc_url( $permalink ) . '">Read More</a>';
    $html .= '</div>';
    $html .= '</div>';
    
    return $html;
}

/**
 * Force Background Check CPT pages to return Page Not Found
 * This removes them from Google search on recrawl
 */

add_action('init', function () {
    add_rewrite_rule(
        '^blog/background_check/.*',
        'index.php?post_type=background_check',
        'top'
    );
});

add_action('template_redirect', function () {

    if (is_singular('background_check')) {
        global $wp_query;
        $wp_query->set_404();
        status_header(410); // change to 410 if you want faster removal
        nocache_headers();
        exit;
    }

});


/*
 * Generate whitepaper HTML for mega menu
 * Uses static image from assets, no post query
 * COMMENTED OUT FOR FUTURE USE - Background Checks and Drug & Health now use articles
 */
/*
function generate_mega_featured_whitepaper( $menu_name = '' ) {
    $image_path = get_template_directory_uri() . '/assets/images/whitepaper-mega-menu.png';
    
    $html = '<div class="mega-feature whitepaper">';
    $html .= '<div class="feature-card">';
    
    $html .= '<div class="feature-image">';
    $html .= '<img src="' . esc_url( $image_path ) . '" alt="Whitepaper" />';
    $html .= '</div>';
    
    $html .= '<a class="button outline" href="' . esc_url( home_url( '/whitepapers' ) ) . '" aria-label="Download PDF">Download PDF</a>';
    $html .= '</div>';
    $html .= '</div>';
    
    return $html;
}
*/
