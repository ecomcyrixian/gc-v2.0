<?php
/*
 * featured image
 */
add_theme_support( 'post-thumbnails' );

/*
 * Specific script and styles per page
 * Automatic cache busting based on file modification time
 */
function theme_styles_script() {
	
    global $post;
    
	if ( is_front_page() ) {
    	$front_page_css = get_template_directory() . '/assets/css/front-page-new.css';
    	$front_page_version = file_exists($front_page_css) ? filemtime($front_page_css) : '1';
    	wp_enqueue_style( 'homepage-style', get_template_directory_uri() . '/assets/css/front-page-new.css', array(), $front_page_version, 'screen' );
        // If you uncomment this, it will automatically have cache busting
        // $front_page_js = get_template_directory() . '/assets/js/front-page.js';
        // $front_page_js_version = file_exists($front_page_js) ? filemtime($front_page_js) : '1';
        // wp_register_script( 'homepage-script', get_template_directory_uri() . '/assets/js/front-page.js', array(), $front_page_js_version, true );
    	// wp_enqueue_script( 'homepage-script' );

    } elseif ( is_page() ) {
        $core_page_css = get_template_directory() . '/assets/css/core-page-new.css';
        $core_page_version = file_exists($core_page_css) ? filemtime($core_page_css) : '1';
        wp_enqueue_style( 'page-style', get_template_directory_uri() . '/assets/css/core-page-new.css', array(), $core_page_version, 'screen' );
    } elseif ( is_single() || is_search() || is_category() || is_author() ) {
        $blog_page_css = get_template_directory() . '/assets/css/blog-page-new.css';
        $blog_page_version = file_exists($blog_page_css) ? filemtime($blog_page_css) : '1';
        wp_enqueue_style( 'page-style', get_template_directory_uri() . '/assets/css/blog-page-new.css', array(), $blog_page_version, 'screen' );
    }
	
}
add_action( 'wp_enqueue_scripts', 'theme_styles_script' );


/*
 * Enqueue jQuery (WordPress's built-in version)
 * Automatic cache busting based on file modification time
 */
    
function gcheck_scripts() {
    // Enqueue jQuery (WordPress's built-in version)
    wp_enqueue_script('jquery');

    // Enqueue your custom script, with jQuery as a dependency
    // Version updates automatically when global-new.js file is modified
    $js_file_path = get_template_directory() . '/assets/js/global-new.js';
    $global_js_version = file_exists($js_file_path) ? filemtime($js_file_path) : '1.0.0';
    
    wp_enqueue_script(
        'my-custom-script', // Unique handle for your script
        get_template_directory_uri() . '/assets/js/global-new.js', // Path to your script
        array('jquery'), // Array of dependencies (jQuery in this case)
        $global_js_version, // Version number - automatically updates when file changes
        false // Load in header (false) to match current head.php placement
    );
}
add_action('wp_enqueue_scripts', 'gcheck_scripts');

/*
 * Enqueue global CSS with automatic cache busting based on file modification time
 * Version updates automatically when global-new.css file is modified
 */
function enqueue_global_styles() {
    $css_file_path = get_template_directory() . '/assets/css/global-new.css';
    $global_css_version = file_exists($css_file_path) ? filemtime($css_file_path) : '1.0.1';
    
    wp_enqueue_style(
        'global-style',
        get_template_directory_uri() . '/assets/css/global-new.css',
        array(), // No dependencies
        $global_css_version, // Version number - automatically updates when file changes
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
                    'Identity' => 'https://gcheck.com/identity',
                    'Background Checks' => 'https://gcheck.com/background-checks',
                    'Verifications' => 'https://gcheck.com/verifications',
                    'Drug & Health' => 'https://gcheck.com/drug-health',
                    'Continuous Monitoring' => 'https://gcheck.com/risk-monitoring',
                    'Compliance' => 'https://gcheck.com/compliance',
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