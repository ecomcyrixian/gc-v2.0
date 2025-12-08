<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $h2 = get_sub_field('h2');

    $colors = get_sub_field('colors');
    $colorLowerCase = strtolower($colors);
    $colorSetting = str_replace(" ", "-", $colorLowerCase);

    $button = get_sub_field('button');
    $link_url = $button['url'];
    $link_title = $button['title'];
    $link_target = $button['target'] ? $button['target'] : '_self'; 
    
?>

<?php if ( $display_selection ) : ?>

<div class="dark-box relevant-products <?= $colorSetting ?>">
    
        <div class="container">
            <div class="heading">
                <h2><pre><?= $h2?></pre></h2>                
            </div>

            <div class="most-relevant-products">
                <ul>
                    <?php if( have_rows('products') ): ?>                
                            <?php while( have_rows('products') ) : the_row(); ?>
                            <li>
                                <?php
                                    echo get_sub_field('item');                                    
                                ?>                                
                            </li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                </ul>
            </div>
            
            <div class="center">
                    <a class="button blue" href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>" aria-label="<?= esc_attr( $link_title ); ?>">
                        <?= esc_attr( $link_title ); ?>
                    </a>
            </div>
            
        </div>    
    </div>
<?php endif; ?> 
