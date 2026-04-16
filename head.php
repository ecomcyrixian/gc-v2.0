<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
<?php get_template_part( 'partials/bing/bing-uet-head' ); ?>
<?php if ( is_singular( 'post' ) ) : ?>
    <!-- GTM delayed on blog posts for Lighthouse performance -->
    <script>
    window.dataLayer=window.dataLayer||[];
    (function(){var l=false;function g(){if(l)return;l=true;(function(w,d,s,i){var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i;f.parentNode.insertBefore(j,f);})(window,document,'script','GTM-TCP9FBDQ');}
    ['scroll','click','touchstart','mouseover','keydown'].forEach(function(e){window.addEventListener(e,g,{once:true,passive:true});});
    setTimeout(g,3500);
    })();
    </script>
<?php else : ?>
    <?php get_template_part( 'partials/gtm/gtm-script-head-tag' ); ?>
<?php endif; ?>
<?php
    $font_dir = get_template_directory_uri() . '/assets/fonts';
    if ( is_singular( 'post' ) ) {
        $hero_bg_slug = 'blog-card-bg';
        $hero_bg_webp = get_template_directory() . '/assets/images/' . $hero_bg_slug . '.webp';
        $hero_bg_url  = file_exists( $hero_bg_webp )
            ? get_template_directory_uri() . '/assets/images/' . $hero_bg_slug . '.webp'
            : get_template_directory_uri() . '/assets/images/' . $hero_bg_slug . '.png';
        $hero_bg_type = file_exists( $hero_bg_webp ) ? ' type="image/webp"' : '';
        echo '<link rel="preload" as="image" href="' . esc_url( $hero_bg_url ) . '"' . $hero_bg_type . ' fetchpriority="high">' . "\n";

        $post_id = get_queried_object_id();
        if ( $post_id && has_post_thumbnail( $post_id ) ) {
            $tid = get_post_thumbnail_id( $post_id );
            $hero_size = 'blog_hero';
            $img = $tid ? wp_get_attachment_image_src( $tid, 'blog_hero' ) : null;
            if ( ! $img || ( isset( $img[1] ) && (int) $img[1] > 800 ) ) {
                $img = $tid ? wp_get_attachment_image_src( $tid, 'medium_large' ) : null;
                $hero_size = 'medium_large';
            }
            if ( $img && ! empty( $img[0] ) ) {
                $srcset = wp_get_attachment_image_srcset( $tid, $hero_size );
                $sizes  = '(max-width: 768px) 100vw, 535px';
                $preload = '<link rel="preload" as="image" href="' . esc_url( $img[0] ) . '"';
                if ( $srcset ) {
                    $preload .= ' imagesrcset="' . esc_attr( $srcset ) . '" imagesizes="' . esc_attr( $sizes ) . '"';
                }
                $preload .= ' fetchpriority="high">';
                echo $preload . "\n";
            }
        }
    }
?>
    <link rel="preload" href="<?php echo esc_url( $font_dir . '/inter-latin.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
    <style>
    @font-face {
        font-family: 'Inter';
        font-style: normal;
        font-weight: 100 900;
        font-display: swap;
        src: url('<?php echo esc_url( $font_dir . '/inter-latin.woff2' ); ?>') format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    @font-face {
        font-family: 'Inter';
        font-style: normal;
        font-weight: 100 900;
        font-display: swap;
        src: url('<?php echo esc_url( $font_dir . '/inter-latin-ext.woff2' ); ?>') format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    @font-face {
        font-family: 'Inter';
        font-style: italic;
        font-weight: 100 900;
        font-display: swap;
        src: url('<?php echo esc_url( $font_dir . '/inter-italic-latin.woff2' ); ?>') format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    @font-face {
        font-family: 'Inter';
        font-style: italic;
        font-weight: 100 900;
        font-display: swap;
        src: url('<?php echo esc_url( $font_dir . '/inter-italic-latin-ext.woff2' ); ?>') format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    @font-face {
        font-family: 'Inter Fallback';
        font-display: swap;
        src: local('Arial');
        size-adjust: 107.64%;
        ascent-override: 90.49%;
        descent-override: 22.56%;
        line-gap-override: 0%;
    }
    body, .blog-v2-content, .blog-v2-hero, .button, input, button, select, textarea {
        font-family: "Inter", "Inter Fallback", sans-serif;
    }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php get_template_part( 'partials/gtm/gtm-script-body-tag' ); ?>
