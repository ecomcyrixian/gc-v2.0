<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $setting = get_sub_field('setting') == "Image";
    $alignment = get_sub_field('alignment');

    $colors = get_sub_field('colors');
    $colorLowerCase = strtolower($colors);
    $colorSetting = str_replace(" ", "-", $colorLowerCase);

?>
<?php
    $overlap = $setting && (
        get_sub_field( 'hero_layout_style' ) === 'overlap' ||
        (bool) get_sub_field( 'hero_overlap_card' )
    );
?>
<?php if ( $display_selection ) : ?>
    
    <div class="page-hero <?= $alignment ?> <?= $colorSetting ?> <?= $overlap ? 'page-hero--overlap' : '' ?>">        
        
        <div class="container">
            <?php
                if ( $overlap ) {
                    get_template_part( 'core-pages/page-hero/page-hero-overlap' );
                } elseif ( $setting ) {
                    get_template_part( 'core-pages/page-hero/page-hero-image' );
                } else {
                    get_template_part( 'core-pages/page-hero/page-hero-text' );
                }
            ?>
        </div>

    </div>


<?php endif; ?> 

