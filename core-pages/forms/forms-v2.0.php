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

    // Same routing as forms.php — success UI only for the default contact form
    $is_contact_form = ! is_page( 'human-trafficking-dispute-form' )
        && ! ( is_page( 'dispute' ) || is_page( 14684 ) )
        && ! is_page( 'contact-support' );
?>
<?php if ( $display_selection ) : ?>

<div id="gcheck-form-state" class="gcheck-form-state">
    <div class="container">
        <div class="form-template">
            <section class="<?= esc_attr( $formSetting ) ?>">
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
</div>

<?php if ( $is_contact_form ) : ?>
<div id="gcheck-success-state" class="gcheck-success-state" hidden>
    <?php get_template_part( 'core-pages/forms/contact-form-success' ); ?>
</div>
<div id="gcheck-error-state" class="gcheck-error-state" hidden>
    <div class="container">
        <div class="gcheck-form-error-panel" role="alert">
            <h3 class="gcheck-form-error-panel__title">Something went wrong</h3>
            <p class="gcheck-form-error-panel__message" id="gcheck-error-message">We couldn't submit your form. Please try again.</p>
            <button type="button" class="button blue" id="gcheck-error-retry">Try again</button>
        </div>
    </div>
</div>
<?php endif; ?>

<?php endif; ?>
