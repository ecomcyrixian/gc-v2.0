<?php
    $display_selection = get_sub_field('display_selection') == "Show";
    $details = get_sub_field('details');

    $snippet = get_sub_field('snippet');
    $h2 = get_sub_field('h2');
    $taglines = get_sub_field('taglines');
    $details = get_sub_field('details');

    $form_location = get_sub_field('form_location');
    $formLowerCase = strtolower($form_location);
    $formSetting = str_replace(" ", "-", $formLowerCase);
?>
<?php if ( $display_selection ) : ?>


<div class="container">
    <div class="form-template">
        <section class="<?= $formSetting ?>">
            <div>
                <div class="title">
                    <em><?= $snippet ?></em>
                    <h2><?= $h2 ?></h2>
                    <p><?= $taglines ?></p>
                </div>
                <?php get_template_part('core-pages/forms/forms');	?>
                <!-- <p class="fineprint">Never share sensitive information (credit card numbers, social security numbers, passwords) through this form. This site is protected by reCAPTCHA and th <a href="">Google Privacy Policy</a> and <a href="">Terms of Service</a> apply.</p> -->
            </div>
            <div>
                <?= $details ?>
            </div>
        </section>
    </div>
</div>

<?php endif; ?> 