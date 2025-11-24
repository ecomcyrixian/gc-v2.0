<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $banner_setting = get_sub_field('banner_setting') == "Full";
    

    if ( $display_selection ) :

        if (get_sub_field('banner_setting') == "Full"){
            get_template_part( 'core-pages/banner/full' );
        
        }elseif (get_sub_field('banner_setting') == "Option 1"){
            get_template_part( 'core-pages/banner/option-1' );
        
        }elseif (get_sub_field('banner_setting') == "Option 2"){
            get_template_part( 'core-pages/banner/option-2' );
        
        }elseif (get_sub_field('banner_setting') == "Option 3"){
            get_template_part( 'core-pages/banner/option-3' );

        }elseif (get_sub_field('banner_setting') == "Option 4"){
            get_template_part( 'core-pages/banner/option-4' );

        };

        


    endif;
?> 

