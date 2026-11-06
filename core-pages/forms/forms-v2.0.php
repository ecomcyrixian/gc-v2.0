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

    $has_talk_to_sales = strpos( (string) $details, 'talk-to-sales' ) !== false;
    $is_service_form_hero = strpos( (string) $details, 'service-form-hero__content' ) !== false;
    $has_service_hero_img = false;

    if ( $is_service_form_hero && preg_match_all( '/class=(["\'])([^"\']*)\1/', (string) $details, $service_hero_classes ) ) {
        foreach ( $service_hero_classes[2] as $service_hero_class_attr ) {
            $service_hero_class_list = preg_split( '/\s+/', trim( $service_hero_class_attr ) );
            if ( in_array( 'service-form-hero__content', $service_hero_class_list, true ) && in_array( 'img', $service_hero_class_list, true ) ) {
                $has_service_hero_img = true;
                break;
            }
        }
    }

    $service_hero_bg = $has_service_hero_img ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';

    $form_classes = trim(
        $formSetting . ( $is_service_form_hero ? ' service-form-hero' : '' )
    );
?>
<?php if ( $display_selection ) : ?>

<div id="gcheck-form-state" class="gcheck-form-state<?php echo $is_service_form_hero ? ' gcheck-form-state--service-hero' : ''; ?>">
    <?php if ( $service_hero_bg ) : ?>
    <div class="service-form-hero__bg" aria-hidden="true" style="background-image:url('<?php echo esc_url( $service_hero_bg ); ?>')"></div>
    <?php endif; ?>
    <div class="container">
        <div class="form-template">
            <section class="<?= esc_attr( $form_classes ) ?>">
                <div<?php echo $is_service_form_hero ? ' id="quote"' : ''; ?>>
                    <?php if ( $is_service_form_hero ) : ?>
                    <div class="title">
                        <h2>Get your free quote</h2>
                        <p>Tell us about your hiring. A screening specialist will follow up with pricing for your team.
                        </p>
                    </div>
                    <?php else : ?>
                    <div class="title">
                        <?php if ( $has_talk_to_sales ) : ?>
                        <div class="title-copy">
                        <?php endif; ?>
                            <em><?= $snippet ?></em>
                            <h2><?= $h2 ?></h2>
                            <p><?= $taglines ?></p>
                        <?php if ( $has_talk_to_sales ) : ?>
                        </div>
                        <span class="title-dots" aria-hidden="true">
                            <svg width="88" height="88" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.2">
                                    <circle cx="4" cy="4" r="4" fill="white"/>
                                    <circle cx="20" cy="4" r="4" fill="white"/>
                                    <circle cx="36" cy="4" r="4" fill="white"/>
                                    <circle cx="52" cy="4" r="4" fill="white"/>
                                    <circle cx="68" cy="4" r="4" fill="white"/>
                                    <circle cx="84" cy="4" r="4" fill="white"/>
                                    <circle cx="4" cy="20" r="4" fill="white"/>
                                    <circle cx="20" cy="20" r="4" fill="white"/>
                                    <circle cx="36" cy="20" r="4" fill="white"/>
                                    <circle cx="52" cy="20" r="4" fill="white"/>
                                    <circle cx="68" cy="20" r="4" fill="white"/>
                                    <circle cx="84" cy="20" r="4" fill="white"/>
                                    <circle cx="4" cy="36" r="4" fill="white"/>
                                    <circle cx="20" cy="36" r="4" fill="white"/>
                                    <circle cx="36" cy="36" r="4" fill="white"/>
                                    <circle cx="52" cy="36" r="4" fill="white"/>
                                    <circle cx="68" cy="36" r="4" fill="white"/>
                                    <circle cx="84" cy="36" r="4" fill="white"/>
                                    <circle cx="4" cy="52" r="4" fill="white"/>
                                    <circle cx="20" cy="52" r="4" fill="white"/>
                                    <circle cx="36" cy="52" r="4" fill="white"/>
                                    <circle cx="52" cy="52" r="4" fill="white"/>
                                    <circle cx="68" cy="52" r="4" fill="white"/>
                                    <circle cx="84" cy="52" r="4" fill="white"/>
                                    <circle cx="4" cy="68" r="4" fill="white"/>
                                    <circle cx="20" cy="68" r="4" fill="white"/>
                                    <circle cx="36" cy="68" r="4" fill="white"/>
                                    <circle cx="52" cy="68" r="4" fill="white"/>
                                    <circle cx="68" cy="68" r="4" fill="white"/>
                                    <circle cx="84" cy="68" r="4" fill="white"/>
                                    <circle cx="4" cy="84" r="4" fill="white"/>
                                    <circle cx="20" cy="84" r="4" fill="white"/>
                                    <circle cx="36" cy="84" r="4" fill="white"/>
                                    <circle cx="52" cy="84" r="4" fill="white"/>
                                    <circle cx="68" cy="84" r="4" fill="white"/>
                                    <circle cx="84" cy="84" r="4" fill="white"/>
                                </g>
                            </svg>
                        </span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php get_template_part('core-pages/forms/forms');	?>
                    <!-- <p class="fineprint">Never share sensitive information (credit card numbers, social security numbers, passwords) through this form. This site is protected by reCAPTCHA and th <a href="">Google Privacy Policy</a> and <a href="">Terms of Service</a> apply.</p> -->
                </div>
                <div class="<?php echo $is_service_form_hero ? 'service-form-hero__details' : ''; ?>">
                    <?php if ( $is_service_form_hero && ( $snippet || $h2 || $taglines ) ) : ?>
                    <div class="service-form-hero__content">
                        <?php if ( $snippet ) : ?><em><?= $snippet ?></em><?php endif; ?>
                        <?php if ( $h2 ) : ?><h1><?= $h2 ?></h1><?php endif; ?>
                        <?php if ( $taglines ) : ?><p class="service-form-hero__intro"><?= $taglines ?></p><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?= $details ?>
                    <?php if ( $is_service_form_hero ) : ?>
                        <?php
                        $service_hero_badges = array(
                            'hp.png'    => 'G2 High Performer',
                            'roi.png'   => 'G2 Best Estimated ROI',
                            'umltr.png' => 'G2 Users Most Likely To Recommend',
                            'ulu.png'   => 'G2 Users Love Us',
                        );
                        $service_hero_badge_dir = get_template_directory_uri() . '/partials/home/grid-layout/images/';
                        ?>
                        <div class="service-form-hero__g2" aria-label="G2 awards">
                            <div class="service-form-hero__badges">
                                <?php foreach ( $service_hero_badges as $file => $alt ) : ?>
                                    <img src="<?php echo esc_url( $service_hero_badge_dir . $file ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="111" height="127" loading="eager">
                                <?php endforeach; ?>
                            </div>
                            <span>Rated by HR teams<br>on G2</span>
                        </div>
                    <?php endif; ?>
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
