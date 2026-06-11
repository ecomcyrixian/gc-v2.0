<?php
$pricing_context  = isset( $args['pricing_context'] ) ? $args['pricing_context'] : 'page';
$pricing_modifier = ( 'home' === $pricing_context ) ? 'pricing-section--home' : 'pricing-page';
$heading_tag      = ( 'home' === $pricing_context ) ? 'h2' : 'h1';

$contact_url    = esc_url( home_url( '/contact-us/' ) );
$check_icon     = '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10 1.25C5.16797 1.25 1.25 5.16797 1.25 10C1.25 14.832 5.16797 18.75 10 18.75C14.832 18.75 18.75 14.832 18.75 10C18.75 5.16797 14.832 1.25 10 1.25ZM13.7793 7.14258L9.66602 12.8457C9.60853 12.9259 9.53274 12.9913 9.44493 13.0364C9.35713 13.0815 9.25984 13.1051 9.16113 13.1051C9.06242 13.1051 8.96513 13.0815 8.87733 13.0364C8.78953 12.9913 8.71374 12.9259 8.65625 12.8457L6.2207 9.4707C6.14648 9.36719 6.2207 9.22266 6.34766 9.22266H7.26367C7.46289 9.22266 7.65234 9.31836 7.76953 9.48242L9.16016 11.4121L12.2305 7.1543C12.3477 6.99219 12.5352 6.89453 12.7363 6.89453H13.6523C13.7793 6.89453 13.8535 7.03906 13.7793 7.14258Z" fill="#5DC567"/>
</svg>
';
$pill_icon      = '<svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12.0004 21.6004C14.5465 21.6004 16.9883 20.589 18.7886 18.7886C20.589 16.9883 21.6004 14.5465 21.6004 12.0004C21.6004 9.45431 20.589 7.01252 18.7886 5.21217C16.9883 3.41182 14.5465 2.40039 12.0004 2.40039C9.45431 2.40039 7.01252 3.41182 5.21217 5.21217C3.41182 7.01252 2.40039 9.45431 2.40039 12.0004C2.40039 14.5465 3.41182 16.9883 5.21217 18.7886C7.01252 20.589 9.45431 21.6004 12.0004 21.6004ZM16.4488 10.4488C16.6674 10.2225 16.7883 9.91935 16.7856 9.60471C16.7829 9.29007 16.6567 8.9891 16.4342 8.76661C16.2117 8.54412 15.9107 8.41792 15.5961 8.41518C15.2814 8.41245 14.9783 8.5334 14.752 8.75199L10.8004 12.7036L9.24879 11.152C9.02247 10.9334 8.71935 10.8124 8.40471 10.8152C8.09007 10.8179 7.7891 10.9441 7.56661 11.1666C7.34412 11.3891 7.21792 11.6901 7.21518 12.0047C7.21245 12.3193 7.3334 12.6225 7.55199 12.8488L9.95199 15.2488C10.177 15.4738 10.4822 15.6001 10.8004 15.6001C11.1186 15.6001 11.4238 15.4738 11.6488 15.2488L16.4488 10.4488Z" fill="white"/>
</svg>
';
$tooltip_icon   = '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10.0003 18.3332C14.6027 18.3332 18.3337 14.6022 18.3337 9.99984C18.3337 5.39746 14.6027 1.6665 10.0003 1.6665C5.39795 1.6665 1.66699 5.39746 1.66699 9.99984C1.66699 14.6022 5.39795 18.3332 10.0003 18.3332Z" stroke="#777E8C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 13.3333V10" stroke="#777E8C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10.1045 6.87484H10.0003M10.2087 6.87484C10.2087 6.75978 10.1154 6.6665 10.0003 6.6665C9.88524 6.6665 9.79199 6.75978 9.79199 6.87484C9.79199 6.9899 9.88524 7.08317 10.0003 7.08317C10.1154 7.08317 10.2087 6.9899 10.2087 6.87484Z" stroke="#777E8C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

$feature_tooltips = array(
    'Biometric Identity Verification'      => 'Uses biometric matching technology, such as facial recognition and document authentication, to confirm that a candidate\'s identity matches their submitted identification credentials.',
    'SSN Trace and Address History'        => 'Generates historical address records and associated aliases tied to a Social Security Number to support jurisdictional criminal searches and identity verification.',
    'National Criminal Database Search'    => 'Searches a multi-source national criminal database for potential criminal records, offenses, and arrest information across participating jurisdictions.',
    'Nationwide Sex Offender Registry Search' => 'Searches national and state sex offender registries to identify registered sex offender records associated with a candidate.',
    'OIG Excluded Parties List'            => 'Searches the Office of Inspector General exclusion database to identify individuals prohibited from participating in federally funded healthcare programs.',
    'Global Watchlists'                    => 'Searches global sanctions lists, terrorism watchlists, and international enforcement databases covering financial crimes, corruption, and restricted parties.',
    'OFAC Sanctions Lists'                 => 'Searches the U.S. Treasury Office of Foreign Assets Control sanctions lists for individuals and entities associated with terrorism, narcotics trafficking, and restricted activities.',
    'County Criminal Search'               => 'Searches county-level court records for felony and misdemeanor criminal history within a specific jurisdiction where a candidate has lived or worked.',
    'Federal Criminal Search'              => 'Searches U.S. federal district courts for fraud, embezzlement, interstate crimes, and white-collar offenses in all identified federal districts the candidate has resided in the last 7 years.',
);

$pricing_plans = array(
    array(
        'name'        => 'Basic',
        'badge'       => '',
        'description' => 'The non-negotiables, covered. Built for speed, compliance, and everyday hiring.',
        'price'       => '$24.95',
        'cta_class'   => 'white',
        'features'    => array(
            array( 'label' => 'Biometric Identity Verification' ),
            array( 'label' => 'SSN Trace and Address History' ),
            array( 'label' => 'National Criminal Database Search' ),
            array( 'label' => 'Nationwide Sex Offender Registry Search' ),
            array( 'label' => 'OIG Excluded Parties List' ),
            array( 'label' => 'OFAC Sanctions Lists' ),
            array( 'label' => 'Global Watchlists' ),
            array(
                'label'   => 'County Criminal Search',
                'subtext' => 'Current county of residence',
            ),
        ),
    ),
    array(
        'name'        => 'Standard',
        'badge'       => 'Most Popular',
        'badge_style' => 'popular',
        'description' => 'Everything in Basic, plus county-level criminal searches across a candidate\'s full address history.',
        'price'       => '$49.95',
        'cta_class'   => 'blue',
        'features'    => array(
            array( 'label' => 'Biometric Identity Verification' ),
            array( 'label' => 'SSN Trace and Address History' ),
            array( 'label' => 'National Criminal Database Search' ),
            array( 'label' => 'Nationwide Sex Offender Registry Search' ),
            array( 'label' => 'OIG Excluded Parties List' ),
            array( 'label' => 'OFAC Sanctions Lists' ),
            array( 'label' => 'Global Watchlists' ),
            array(
                'label'     => 'County Criminal Search',
                'subtext'   => 'Unlimited counties of residence',
                'highlight' => true,
                'tooltip'   => 'Retrieves felony and misdemeanor records from county courts in all identified counties the candidate has resided in the last 7 years.',
            ),
        ),
    ),
    array(
        'name'        => 'Advanced',
        'badge'       => 'Recommended',
        'badge_style' => 'recommended',
        'description' => 'Adds federal court searches on top of full county coverage. Built for regulated industries and high-trust roles.',
        'price'       => '$64.95',
        'cta_class'   => 'white',
        'features'    => array(
            array( 'label' => 'Biometric Identity Verification' ),
            array( 'label' => 'SSN Trace and Address History' ),
            array( 'label' => 'National Criminal Database Search' ),
            array( 'label' => 'Nationwide Sex Offender Registry Search' ),
            array( 'label' => 'OIG Excluded Parties List' ),
            array( 'label' => 'OFAC Sanctions Lists' ),
            array( 'label' => 'Global Watchlists' ),
            array(
                'label'     => 'County Criminal Search',
                'subtext'   => 'Unlimited counties of residence',
                'highlight' => true,
                'tooltip'   => 'Retrieves felony and misdemeanor records from county courts in all identified counties the candidate has resided in the last 7 years.',
            ),
            array(
                'label'     => 'Federal Criminal Search',
                'subtext'   => 'Unlimited federal districts of residence',
                'highlight' => true,
                'tooltip'   => 'Searches U.S. federal district courts for fraud, embezzlement, interstate crimes, and white-collar offenses in all identified federal districts the candidate has resided in the last 7 years.',
            ),
        ),
    ),
);

$hero_pills = array(
    'Pay per screen',
    'No setup fees',
    'No minimums',
    'No long-term contracts',
);

$quote_features = array(
    'Hire candidates faster',
    'Integrated FCRA Compliance',
    'ATS and HRIS integrations',
    'Customized workflows',
);
?>

<div id="pricing" class="<?php echo esc_attr( $pricing_modifier ); ?>">

    <div class="container">

        <div class="pricing-header">
            <div class="pricing-header__content">
                <p class="pricing-header__eyebrow">Background Check Pricing</p>
                <<?php echo esc_html( $heading_tag ); ?> class="pricing-header__title">Pay Per Screen. No Surprises.</<?php echo esc_html( $heading_tag ); ?>>
                <p class="pricing-header__subtitle">Biometric identity verification included in all packages.</p> 
            </div>
            <div class="pricing-header__pills">
                <?php foreach ( $hero_pills as $pill ) : ?>
                    <span class="pricing-header__pill">
                        <?php echo $pill_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo esc_html( $pill ); ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="pricing-cards">
            <?php foreach ( $pricing_plans as $plan ) : ?>
                <article class="pricing-card">
                    <div class="pricing-card__header">
                        <div class="pricing-card__heading-row">
                            <h2 class="pricing-card__title"><?php echo esc_html( $plan['name'] ); ?></h2>
                            <?php if ( ! empty( $plan['badge'] ) ) : ?>
                                <span class="pricing-card__badge pricing-card__badge--<?php echo esc_attr( $plan['badge_style'] ?? 'default' ); ?>"><?php echo esc_html( $plan['badge'] ); ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="pricing-card__description"><?php echo esc_html( $plan['description'] ); ?></p>
                    </div>

                    <div class="pricing-card__price">
                        <strong><?php echo esc_html( $plan['price'] ); ?></strong>
                        <span>per background check*</span>
                    </div>

                    <a
                        class="button <?php echo esc_attr( $plan['cta_class'] ); ?> pricing-card__cta"
                        href="<?php echo esc_url( $contact_url ); ?>"
                        aria-label="<?php echo esc_attr( 'Get Started with ' . $plan['name'] ); ?>"
                    >
                        <?php echo esc_html( 'Get Started with ' . $plan['name'] ); ?>
                    </a>

                    <div class="pricing-card__features">
                        <ul>
                            <?php foreach ( $plan['features'] as $feature ) : ?>
                                <?php
                                $feature_label = html_entity_decode( wp_strip_all_tags( $feature['label'] ), ENT_QUOTES, get_bloginfo( 'charset' ) );
                                $tooltip_text  = $feature['tooltip'] ?? ( $feature_tooltips[ $feature_label ] ?? 'Tooltip description placeholder' );
                                ?>
                                <li>
                                    <span class="pricing-card__feature-icon">
                                        <?php echo $check_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </span>
                                    <span class="pricing-card__feature-copy">
                                        <span class="pricing-card__feature-title"><?php echo wp_kses_post( $feature['label'] ); ?></span>
                                        <?php if ( ! empty( $feature['subtext'] ) ) : ?>
                                            <?php if ( ! empty( $feature['highlight'] ) && strpos( $feature['subtext'], 'Unlimited' ) === 0 ) : ?>
                                                <small>
                                                    <span class="highlight">Unlimited</span><?php echo esc_html( substr( $feature['subtext'], strlen( 'Unlimited' ) ) ); ?>
                                                </small>
                                            <?php else : ?>
                                                <small><?php echo esc_html( $feature['subtext'] ); ?></small>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </span>
                                    <span class="pricing-card__tooltip" data-tooltip="<?php echo esc_attr( $tooltip_text ); ?>" aria-label="<?php echo esc_attr( $tooltip_text ); ?>" tabindex="0">
                                        <?php echo $tooltip_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="pricing-disclaimer">*Additional third party fees may apply to some products and will be passed through with no markup.</p>

        <div class="pricing-quote">
            <div class="pricing-quote__banner">
                <div class="pricing-quote__content">
                    <h2>Running more than 50 background checks a year?</h2>
                    <ul>
                        <?php foreach ( $quote_features as $feature ) : ?>
                            <li>
                                <?php echo $check_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                <?php echo esc_html( $feature ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a class="button blue" href="<?php echo esc_url( $contact_url ); ?>">
                    Get a Custom Quote
                </a>
            </div>
        </div>

        <div class="pricing-trust">
            <p>Volume pricing and merit-based nonprofit discounts available.</p>
            <div class="pricing-trust__cta"><a href="<?php echo esc_url( $contact_url ); ?>">Contact us</a> to build a package that meets your needs.</div>

            <div class="copyright-badges">
                <span class="pbsa-badge">
                    <a href="https://credential.thepbsa.org/114492a9-638f-4bc4-bda1-bd465b3a5c2b#acc.Pw2lZ9sL" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/PBSA logo.png' ); ?>" alt="PBSA" width="100" height="100" loading="lazy" decoding="async">
                    </a>
                </span>
                <span class="bbb-badge">
                    <a href="https://www.bbb.org/us/ca/los-angeles/profile/employment-background-check/gcheck-1216-1000042700" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bbb-logo copy.png' ); ?>" alt="BBB Accredited Business" width="100" height="100" loading="lazy" decoding="async">
                    </a>
                </span>
                <span class="shrm-badge">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/core-pages/pricing/css/shrm.webp' ); ?>" alt="SHRM, ASA Accreditations" width="100" height="100" loading="lazy" decoding="async">
                </span>
            </div>
        </div>

    </div>

</div>
