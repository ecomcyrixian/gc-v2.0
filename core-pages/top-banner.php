<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $h1 = get_sub_field('h1');
    $strong_p = get_sub_field('strong_p');
    $details = get_sub_field('details');
    $image = get_sub_field('image');
?>

<?php if ( $display_selection ) : ?>
    
      <div class="top-banner">
        <div class="container">
            <div>
                <h1>
                    <span><?= $h1 ?></span>
                    Safeguarding Your Workplace
                </h1>
                <p><strong><?= $strong_p ?></strong></p>
                <p><?= $details ?></p>

            </div>
            <div>
                <img src="<?= $image ?>" alt="<?= $h1 ?>">
            </div>
        </div>
    </div>


<?php endif; ?> 

