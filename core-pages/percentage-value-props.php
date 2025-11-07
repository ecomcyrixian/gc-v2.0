<?php
    $display_selection = get_sub_field('display_selection') == "Show";
?>


<?php if ( $display_selection ) : ?>
     
<div class="percentage-value-props cards">
        <div class="container">
        
            <div class="card-cont cols3">
                <?php if( have_rows('percentage') ): ?>                
                    <?php while( have_rows('percentage') ) : the_row(); ?>
                    <div>
                        <?php
                            $percent = get_sub_field('percent');
                            $snippet = get_sub_field('snippet');
                        ?>
                        <h3>
                            <i><?= $percent ?></i>
                        </h3>
                        <span>
                            <?= $snippet ?>
                        </span>                    
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <div class="card-cont cols5">
                <?php if( have_rows('brand_logo') ): ?>                
                    <?php while( have_rows('brand_logo') ) : the_row(); ?>
                    <div>
                        <?php
                            $logo = get_sub_field('logo');                            
                        ?>
                        <span>
                            <?= $logo ?>
                        </span>                    
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

        
        </div>
    </div>

<?php endif; ?> 
