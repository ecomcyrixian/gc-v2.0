<?php
    get_header();
    
    
    // contact page
    if ( is_page( 'contact-us' ) ) {
		// get_template_part('core-pages/contact-us');	
	}
    
    /*
    elseif( is_page('thanks-for-reaching-out') ){
        get_template_part('core-pages/default-page');	
    }
    */


    // ACF Configuration Widgets
    get_template_part( 'core-pages/config' );


    get_footer();
?>