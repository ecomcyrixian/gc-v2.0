<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $with_header = get_sub_field('with_header') == "Yes";
    
    $h2 = get_sub_field('h2');    
    
    $details = get_sub_field('details');
    $columns = get_sub_field('columns');

    $snippet = get_sub_field('snippet');
    $lowerCaseString = strtolower($snippet);
    
    $setting = get_sub_field('setting');
    $lowerCase = strtolower($setting);
    $finalSetting = str_replace(" ", "-", $lowerCase);
?>

<?php if ( $display_selection ) : ?>


    <div class="cards <?= $finalSetting ?>">
        <div class="container">
        
        <?php if ( $with_header ) : ?>            
            <div class="heading">
                <h2>
                    <span><?= $snippet ?></span>
                    <pre><?= $h2 ?></pre>
                </h2>
            </div>
        <?php endif; ?> 

        <div class="card-cont cols<?= $columns ?>">
            <?php if( have_rows('cards') ): ?>                
                <?php while( have_rows('cards') ) : the_row(); ?>
                <div>
                    <?php
                        $h4 = get_sub_field('h4');
                        $details = get_sub_field('details');
                        $icon = get_sub_field('svg_icon');
                    ?>
                    <h4>
                        <span>
                            <?= $h4 ?>
                        </span>
                        <span>
                            <?= $icon ?>
                        </span>
                    </h4>
                    <?= $details ?>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        
        </div>
    </div>

<?php endif; ?> 
