<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $with_header = get_sub_field('with_header') == "Yes";
    
    $h2 = get_sub_field('h2');    
    
    $H2details = get_sub_field('details');
    $columns = get_sub_field('columns');
    $is_executive_cards = is_string($H2details) && strpos($H2details, 'executive-header') !== false;

    $snippet = get_sub_field('snippet');
    $snippetLowerCase = strtolower($snippet);
    $snippetSetting = str_replace(" ", "-", $snippetLowerCase);
?>

<?php if ( $display_selection ) : ?>

    <div class="cards image <?= $snippetSetting ?><?= $is_executive_cards ? ' cards--executive-team' : '' ?>">
        <div class="container">
        
        <?php if ( $with_header ) : ?>            
            <div class="heading">
                <?php if ( $is_executive_cards ) : ?>
                    <?= $H2details ?>
                <?php else : ?>
                    <h2>
                        <span><?= $snippet ?></span>
                        <pre><?= $h2 ?></pre>
                    </h2>
                    <?= $H2details ?>
                <?php endif; ?>
            </div>
        <?php endif; ?> 

        <div class="card-cont cols<?= $columns ?>">
            <?php if( have_rows('cards') ): ?>                
                <?php while( have_rows('cards') ) : the_row(); ?>
                <div>
                    <?php
                        $details = get_sub_field('details');
                        $image = get_sub_field('image');

                        $card_img_url = is_array( $image ) ? $image['url'] : $image;
                        $card_img_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $image ) : '';
                    ?>
                    
                    <span>
                        <img src="<?= esc_url( $card_img_url ) ?>" alt="" <?php echo $card_img_dim_attrs; ?>>
                    </span>
                    <span class="desc">
                        <?= $details ?>
                    </span>

                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        
        </div>
    </div>

<?php endif; ?> 
