<?php
$banner_img = static function ( string $file ): array {
    $path = get_template_directory() . '/core-pages/banner/images/' . $file;
    $uri  = get_template_directory_uri() . '/core-pages/banner/images/' . $file;
    $attrs = '';

    if ( function_exists( 'getimagesize' ) && file_exists( $path ) ) {
        $size = getimagesize( $path );
        if ( ! empty( $size[0] ) && ! empty( $size[1] ) ) {
            $attrs = ' width="' . esc_attr( (string) $size[0] ) . '" height="' . esc_attr( (string) $size[1] ) . '"';
        }
    }

    return array(
        'uri'   => $uri,
        'attrs' => $attrs,
    );
};

$option6_primary_bg = $banner_img( 'option-6-bg.webp' );
$option6_media      = $banner_img( 'option-6-card-2.webp' );
$option6_connect    = $banner_img( 'option-6-card-3.webp' );
?>
<div class="banner option6">
    <div class="container">
        <div class="option6-layout">
            <article class="option6-card option6-card--primary">
                <img class="option6-card__bg" src="<?php echo esc_url( $option6_primary_bg['uri'] ); ?>" alt=""<?php echo $option6_primary_bg['attrs']; ?> loading="lazy" decoding="async" fetchpriority="low" aria-hidden="true">
                <div class="option6-card__content">
                    <h3>Grow With Our Team</h3>
                    <p>GCheck&rsquo;s leadership is supported by an exceptional team of compliance experts, technologists, customer success professionals, and operations specialists, all committed to delivering Compliance for Good&trade;.</p>
                    <a class="button white" href="<?php echo esc_url( home_url('/contact-us/') ); ?>">Join Our Team Pool</a>
                </div>
            </article>

            <div class="option6-right-col">
                <article class="option6-card option6-card--media">
                    <div class="option6-card__body">
                        <div>
                            <h4>Media Inquiries</h4>
                            <p>For press inquiries, interviews with leadership, or expert commentary on background screening and compliance, please contact:</p>
                            <a href="mailto:press@gcheck.com"><div><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M22 2L11 13" stroke="#CDD6E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="#CDD6E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></div>
<div>press@gcheck.com</div></a>
                        </div>
                        <div class="option6-card__icon-slot" aria-hidden="true">
                            <img class="photo" src="<?php echo esc_url( $option6_media['uri'] ); ?>" alt=""<?php echo $option6_media['attrs']; ?> loading="lazy" decoding="async" fetchpriority="low">
                        </div>
                    </div>
                </article>

                <article class="option6-card option6-card--connect">
                    <div class="option6-card__body option6-card__body--connect">
                        <div class="option6-card__icon-slot" aria-hidden="true">
                            <img class="photo" src="<?php echo esc_url( $option6_connect['uri'] ); ?>" alt=""<?php echo $option6_connect['attrs']; ?> loading="lazy" decoding="async" fetchpriority="low">
                        </div>
                        <div>
                            <h4>Connect With GCheck</h4>
                            <p>Ready to learn how our team can help your organization achieve <strong>Compliance for Good™?</strong></p>
                            <a class="button white" href="<?php echo esc_url( home_url('/contact-us/') ); ?>">Connect With Us</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
