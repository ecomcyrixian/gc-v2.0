<?php
/*
 * Template Name: Core Website Pages
 * Description: Custom Single Page Template for all core website pages
 * Version: 1.0
 */
?>

<?php

	// Background Checks
	if ( is_page( 'background-checks' ) ) {
		get_template_part('core-pages/background-checks');	
	}

	// Industries
	elseif ( is_page( 'industries' ) ) {
		//get_template_part('core-pages/industries');	
	}

?>
