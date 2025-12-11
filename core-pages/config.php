 <?php
  

  if( have_rows('page_content') ):
    while ( have_rows('page_content') ) : the_row();
      
        // Case: Page Hero Widget
        if( get_row_layout() == 'page_hero' ):
            get_template_part( 'core-pages/page-hero' );    

        // Case: FAQ Widget
        elseif( get_row_layout() == 'faq' ):
            get_template_part( 'core-pages/faq/faq' );
    
        // Case: Dark Box Widget
        elseif( get_row_layout() == 'dark_box' ):
            get_template_part( 'core-pages/cards/dark-box' );
        
        // Case: Card Widget
        elseif( get_row_layout() == 'card' ):
            get_template_part( 'core-pages/cards/card' );
        
        // Case: Card Image Widget
        elseif( get_row_layout() == 'card_image' ):
            get_template_part( 'core-pages/cards/card-image' );
        
        // Case: Most Relevant Products Widget
        elseif( get_row_layout() == 'most_relevant_products' ):
            get_template_part( 'core-pages/most-relevant-products' );
        
        // Case: Testimonilas Widget
        elseif( get_row_layout() == 'testimonials' ):
            get_template_part( 'core-pages/testimonials' );
        
        // Case: Side By Side Feature Comparison Widget
        elseif( get_row_layout() == 'side_by_side_feature_comparison' ):
            get_template_part( 'core-pages/side-by-side-feature-comparison' );
        
        // Case: How We Can Help Widget
        elseif( get_row_layout() == 'how_we_can_help' ):
            get_template_part( 'core-pages/how-we-can-help' );

        // Case: Banners Widget
        elseif( get_row_layout() == 'banners' ):
            get_template_part( 'core-pages/banner/banners' );
       
        // Case: Join Us Widget
        elseif( get_row_layout() == 'join_us' ):
            get_template_part( 'core-pages/join-us' );

        // Case: Percentage Value Props Widget
        elseif( get_row_layout() == 'percentage_value_props' ):
            get_template_part( 'core-pages/percentage-value-props' );            

        // Case: Price Widget
        elseif( get_row_layout() == 'prcing' ):
            get_template_part( 'core-pages/pricing' );

        // Case: Price Widget
        elseif( get_row_layout() == 'side_by_side_feature_comparison' ):
            get_template_part( 'core-pages/side-by-side-feature-comparison' );

        // Case: Forms Widget
        elseif( get_row_layout() == 'forms' ):
            get_template_part( 'core-pages/forms/forms-v2.0' );

        // Case: Latest Articles Widget
        elseif( get_row_layout() == 'latest_articles' ):
            get_template_part( 'core-pages/latest-articles' );
        
        // Case: Latest Integration
        elseif( get_row_layout() == 'integration' ):
             get_template_part( 'core-pages/brand-page' );
            

        endif;

    endwhile;
  else :
      // Do something...
  endif;


  ?>