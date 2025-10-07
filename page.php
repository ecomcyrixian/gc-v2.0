<?php get_header(); ?>

 <?php
  

  if( have_rows('page_content') ):
    while ( have_rows('page_content') ) : the_row();
      
        // Case: Top Banner
        if( get_row_layout() == 'top_banner' ):
            get_template_part( 'core-pages/top-banner' );
    
        // Case: FAQ
        elseif( get_row_layout() == 'faq' ):
            get_template_part( 'core-pages/faq' );
    
        // Case: Dark Box
        elseif( get_row_layout() == 'dark_box' ):
            get_template_part( 'core-pages/dark-box' );
        
        // Case: Card
        elseif( get_row_layout() == 'card' ):
            get_template_part( 'core-pages/card' );
            
    
        endif;
    endwhile;
  else :
      // Do something...
  endif;


  ?>


<?php get_footer(); ?>