<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    
    $h2 = get_sub_field('h2');    
    
    $details = get_sub_field('details');
    $columns = get_sub_field('columns');

    $snippet = get_sub_field('snippet');
    $lowerCaseString = strtolower($snippet);
        
?>

<?php if ( $display_selection ) : ?>


<div id="<?= $lowerCaseString ?>" class="cards">
        <div class="container">
        
            <div class="heading">
                <h2>
                    <span><?= $snippet ?></span>
                    <pre><?= $h2 ?></pre>
                </h2>
            </div>

            <div class="card-cont cols3">
                <?php if( have_rows('cards') ): ?>                
                    <?php while( have_rows('cards') ) : the_row(); ?>
                    <div>
                        <?php
                            $brand_logo = get_sub_field('brand_logo');
                            $name = get_sub_field('name');
                            $details = get_sub_field('details');                            
                        ?>                        
                        <span>
                            <?= $brand_logo ?>
                        </span>
                        <p>
                            <?= $details ?>
                        </p>
                        <p class="fineprint">
                            <?= $name ?>
                        </p>
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

        
        </div>
    </div>

<?php endif; ?> 
