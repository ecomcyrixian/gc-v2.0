<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

    <!-- Preload Fonts -->
    <link rel="preload" href="<?php echo esc_url( $font_dir . '/inter-latin.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
    <style>
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url('<?php echo esc_url( $font_dir . '/inter-latin.woff2' ); ?>') format('woff2');
        }
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 100 900;
            font-display: swap;
            src: url('<?php echo esc_url( $font_dir . '/inter-latin-ext.woff2' ); ?>') format('woff2');
        }
        @font-face {
            font-family: 'Inter';
            font-style: italic;
            font-weight: 100 900;
            font-display: swap;
            src: url('<?php echo esc_url( $font_dir . '/inter-italic-latin.woff2' ); ?>') format('woff2');
        }
        @font-face {
            font-family: 'Inter';
            font-style: italic;
            font-weight: 100 900;
            font-display: swap;
            src: url('<?php echo esc_url( $font_dir . '/inter-italic-latin-ext.woff2' ); ?>') format('woff2');
        }
        @font-face {
            font-family: 'Inter Fallback';
            font-display: swap;
            src: local('Arial');
        }
        body, .blog-v2-content, .blog-v2-hero, .button, input, button, select, textarea {
            font-family: "Inter", "Inter Fallback", sans-serif;
        }
    </style>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
