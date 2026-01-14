<?php
/**
 * Single Post V2 Template
 * New blog post design template with 3-column layout
 * All classes prefixed with blog-v2- for future CSS styling
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        
        // Render flexible content layouts
        if ( function_exists( 'have_rows' ) && have_rows( 'blog_v2_layout' ) ) :
            while ( have_rows( 'blog_v2_layout' ) ) : the_row();
                
                // Page Hero layout
                if ( get_row_layout() == 'page_hero' ) :
                    get_template_part( 'partials/blog-v2/page-hero' );
                
                // Progress Bar layout
                elseif ( get_row_layout() == 'progress_bar' ) :
                    get_template_part( 'partials/blog-v2/progress-bar' );
                
                endif;
                
            endwhile;
        endif;
        
        // Render main content layout with sidebars
        get_template_part( 'partials/blog-v2/layout' );
        
    endwhile;
endif;

get_footer();
?>
