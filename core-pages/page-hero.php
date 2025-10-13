<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $setting = get_sub_field('setting') == "Image";
    $alignment = get_sub_field('alignment');
?>
<?php if ( $display_selection ) : ?>
    
    <div class="page-hero <?= $alignment ?>">        
        <div class="container">
            <?php
                if ( $setting ){
                    get_template_part( 'core-pages/page-hero-image' );
                }else{
                    get_template_part( 'core-pages/page-hero-text' );
                };
            ?>
        </div>
    </div>


<?php endif; ?> 

