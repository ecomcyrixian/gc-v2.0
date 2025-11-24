<?php
/*
 * featured image
 */
add_theme_support( 'post-thumbnails' );

/*
 * Specific script and styles per page
 */
function theme_styles_script() {
	
    global $post;
    
	if ( is_front_page() ) {
    	wp_enqueue_style( 'homepage-style', get_template_directory_uri() . '/assets/css/front-page.css', array(), '1', 'screen' );
        //wp_register_script( 'homepage-script', get_template_directory_uri() . '/assets/js/front-page.js', '', '', true );
    	//wp_enqueue_script( 'homepage-script' );

    } elseif ( is_page() ) {
        wp_enqueue_style( 'page-style', get_template_directory_uri() . '/assets/css/core-page.css', array(), '1', 'screen' );
    } elseif ( is_single() || is_search() || is_category() || is_author() ) {
        wp_enqueue_style( 'page-style', get_template_directory_uri() . '/assets/css/blog-page.css', array(), '1', 'screen' );
    }
	
}
add_action( 'wp_enqueue_scripts', 'theme_styles_script' );


/*
 * Enqueue jQuery (WordPress's built-in version)
 */
    
function gcheck_scripts() {
    // Enqueue jQuery (WordPress's built-in version)
    wp_enqueue_script('jquery');

    // Enqueue your custom script, with jQuery as a dependency
    wp_enqueue_script(
        'my-custom-script', // Unique handle for your script
        get_template_directory_uri() . '/assets/js/global.js', // Path to your script
        array('jquery'), // Array of dependencies (jQuery in this case)
        '1.0.0', // Version number (optional)
        true // Load in the footer (true) or header (false)
    );
}
add_action('wp_enqueue_scripts', 'gcheck_scripts');


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
            // $item_output .= '<span class="menu-item-description">' . esc_html( $description ) . '</span>';
            $item_output .= '<span class="menu-item-description">' . $description . '</span>';
        }
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
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