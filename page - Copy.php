<?php get_header(); ?>

 <?php
  

  if( have_rows('page_content') ):
    while ( have_rows('page_content') ) : the_row();
      
        // Case: Page Hero
        if( get_row_layout() == 'page_hero' ):
            get_template_part( 'core-pages/page-hero' );    

        // Case: FAQ
        elseif( get_row_layout() == 'faq' ):
            get_template_part( 'core-pages/faq/faq' );
    
        // Case: Dark Box
        elseif( get_row_layout() == 'dark_box' ):
            get_template_part( 'core-pages/cards/dark-box' );
        
        // Case: Card
        elseif( get_row_layout() == 'card' ):
            get_template_part( 'core-pages/cards/card' );
        
        // Case: Most Relevant Products
        elseif( get_row_layout() == 'most_relevant_products' ):
            get_template_part( 'core-pages/most-relevant-products' );
        
        // Case: Testimonilas
        elseif( get_row_layout() == 'testimonials' ):
            get_template_part( 'core-pages/testimonials' );
        
        // Case: Side By Side Feature Comparison
        elseif( get_row_layout() == 'side_by_side_feature_comparison' ):
            get_template_part( 'core-pages/side-by-side-feature-comparison' );
        
        // Case: How We Can Help
        elseif( get_row_layout() == 'how_we_can_help' ):
            get_template_part( 'core-pages/how-we-can-help' );

        // Case: Banners
        elseif( get_row_layout() == 'banners' ):
            get_template_part( 'core-pages/banner/banners' );
       
        // Case: Join Us
        elseif( get_row_layout() == 'join_us' ):
            get_template_part( 'core-pages/join-us' );

        // Case: Percentage Value Props
        elseif( get_row_layout() == 'percentage_value_props' ):
            get_template_part( 'core-pages/percentage-value-props' );            

        // Case: Price Widget
        elseif( get_row_layout() == 'latest_articles' ):
            //get_template_part( 'core-pages/latest-articles' );

        // Case: latest Articles
        elseif( get_row_layout() == 'prcing' ):
            get_template_part( 'core-pages/pricing' );

        endif;

    endwhile;
  else :
      // Do something...
  endif;


  ?>

<!-- Join Us Banner -->
<?php
    /*
    if( have_rows('join_us', 'option') ):
        while( have_rows('join_us', 'option') ) : the_row();
            get_template_part( 'core-pages/join-us' );
        endwhile;
    endif;
    */
?>


<?php get_footer(); ?>