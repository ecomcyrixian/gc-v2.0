<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $h2 = get_sub_field('h2');
    $tagline = get_sub_field('tagline');

    $columns = get_sub_field('columns');
    
    $colors = get_sub_field('colors');
    $colorLowerCase = strtolower($colors);
    $colorSetting = str_replace(" ", "-", $colorLowerCase);

    $setting = get_sub_field('setting');
    $lowerCase = strtolower($setting);
    $finalSetting = str_replace(" ", "-", $lowerCase);

?>

<?php if ( $display_selection ) : ?>

 <div class="dark-box <?= $colorSetting ?>">
        <div class="container">
            <div class="heading">
                <h2><pre><?= $h2?></pre></h2>
                <?= $tagline ?>
            </div>
            <div class="cards <?= $finalSetting ?>">                   
                    <div class="card-cont cols<?= $columns ?>">
                        <?php if( have_rows('boxes') ): ?>                
                            <?php while( have_rows('boxes') ) : the_row(); ?>
                            <div>
                                <?php
                                    $h4 = get_sub_field('h4');
                                    $details = get_sub_field('details');
                                ?>
                                <h4>
                                    <span>
                                        <?= $h4 ?>
                                    </span>
                                    <span>
                                        <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="56" height="56" rx="4" fill="#F2F3FF"/><path d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z" fill="#4F51FD"/><path d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z" fill="#4F51FD"/></svg>
                                    </span>
                                </h4>
                                <?= $details ?>
                            </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

            </div>            
        </div>    
    </div>
<?php endif; ?> 
