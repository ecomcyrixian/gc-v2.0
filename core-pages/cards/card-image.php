<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $with_header = get_sub_field('with_header') == "Yes";
    
    $h2 = get_sub_field('h2');    
    
    $H2details = get_sub_field('details');
    $columns = get_sub_field('columns');

    $snippet = get_sub_field('snippet');
    $snippetLowerCase = strtolower($snippet);
    $snippetSetting = str_replace(" ", "-", $snippetLowerCase);
?>

<?php if ( $display_selection ) : ?>

    <div class="cards image <?= $snippetSetting ?>">
        <div class="container">
        
        <?php if ( $with_header ) : ?>            
            <div class="heading">
                <h2>
                    <span><?= $snippet ?></span>
                    <pre><?= $h2 ?></pre>
                </h2>
                <?= $H2details ?>
            </div>
        <?php endif; ?> 

        <div class="card-cont cols<?= $columns ?>">
            <?php if( have_rows('cards') ): ?>                
                <?php while( have_rows('cards') ) : the_row(); ?>
                <div>
                    <?php
                        $details = get_sub_field('details');
                        $image = get_sub_field('image');
                    ?>
                    
                    <span>
                        <img src="<?= $image ?>"> 
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
