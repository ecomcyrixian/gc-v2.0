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

$option5_bg = $banner_img( 'option-5-bg.webp' );
$quote5_bg  = $banner_img( 'quote-5-bg.webp' );
?>
<div class="banner option5">
    <div class="container">
        <img class="option5__bg" src="<?php echo esc_url( $option5_bg['uri'] ); ?>" alt=""<?php echo $option5_bg['attrs']; ?> loading="lazy" decoding="async" fetchpriority="low" aria-hidden="true">
        <div class="banner-info">
            <div class="quote-card">
                <img class="quote-card__bg" src="<?php echo esc_url( $quote5_bg['uri'] ); ?>" alt=""<?php echo $quote5_bg['attrs']; ?> loading="lazy" decoding="async" fetchpriority="low" aria-hidden="true">
                <span class="quote-mark" aria-hidden="true"><svg width="51" height="40" viewBox="0 0 51 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M50.6105 40H28.0421V21.9789L38.9053 0H48.8421L40.7579 20.2105H50.6105V40ZM22.6526 40H0V21.9789L10.9474 0H20.8842L12.8 20.2105H22.6526V40Z" fill="#30319A"/>
</svg>
</span>
<div>
                <p>
                It’s also a direct consequence of increasingly tight and competitive labor markets—and applicants’ doubts that recruiters have the time, means, or diligence to check their experience and skills claims.</p>

<p>That’s resulting in a spreading practice of what GCheck founder and CEO Houman Akhavan calls “’careerfishing,’ where candidates misrepresent their professional identity to secure employment” with a high degree of confidence they won’t be caught.</p>
</div>
                <span class="quote-source"><svg width="70" height="24" viewBox="0 0 70 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_200_473)">
<path d="M0 5.52632H3.06316V18.4421H0V23.5579H16.3895V18.4421H13.2947V5.52632H16.3895V0H0V5.52632Z" fill="white"/>
<path d="M41.6211 18.4421V11.6526C41.6211 7.32628 38.4632 5.74734 34.5475 5.74734C31.7685 5.74734 29.6527 6.50523 27.8211 8.62102C27.6948 8.77891 27.5369 8.96839 27.3475 9.12628V5.55786H17.2422V10.7052H19.5475V18.4421H17.2422V23.5894H30.0632V18.4421H27.6317V13.9894C27.6317 12.0947 29.0527 10.7052 30.9475 10.7052C32.4317 10.7052 33.6001 11.4315 33.6001 13.0421V18.4105H31.2317V23.5579H43.7685V18.5052C43.7685 18.4736 43.7369 18.4421 43.7369 18.4105H41.6211V18.4421Z" fill="white"/>
<path d="M64.1683 16.9264H57.5052H57.2841C57.2841 18.8211 55.8946 19.7053 54.3473 19.7053C51.3788 19.7053 51.1262 17.2106 51.1262 14.8421V14.779C51.1262 12.4106 51.3473 9.91583 54.3473 9.91583C56.6841 9.91583 57.0946 11.9369 57.1578 13.8632L64.0736 13.1053C63.3473 6.0632 56.3999 5.62109 54.6631 5.62109C54.4104 5.62109 54.2841 5.62109 54.2841 5.62109C48.5683 5.62109 42.9473 8.43162 42.9473 14.8106C42.9473 16.1685 43.1999 17.3685 43.6736 18.4106H43.7052V18.5053C45.4104 22.2948 49.8315 24 54.2841 24C57.9157 24 62.9999 23.1158 64.1367 17.5264L64.1683 16.9264Z" fill="white"/>
<path d="M66.5361 23.6526C68.1407 23.6526 69.4414 22.3518 69.4414 20.7473C69.4414 19.1428 68.1407 17.842 66.5361 17.842C64.9316 17.842 63.6309 19.1428 63.6309 20.7473C63.6309 22.3518 64.9316 23.6526 66.5361 23.6526Z" fill="white"/>
</g>
<defs>
<clipPath id="clip0_200_473">
<rect width="69.4737" height="24" fill="white"/>
</clipPath>
</defs>
</svg>
</span>
            </div>
        </div>
    </div>
</div>
