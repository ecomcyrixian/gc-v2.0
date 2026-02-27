<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    
    <?php get_template_part( 'partials/gtm/gtm-script-head-tag' ); ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
    if ( is_singular( 'post' ) ) {
        $post_id = get_queried_object_id();
        $hero_bg_slug   = 'blog-card-bg';
        $hero_bg_webp   = get_template_directory() . '/assets/images/' . $hero_bg_slug . '.webp';
        $hero_bg_url    = file_exists( $hero_bg_webp )
            ? get_template_directory_uri() . '/assets/images/' . $hero_bg_slug . '.webp'
            : get_template_directory_uri() . '/assets/images/' . $hero_bg_slug . '.png';
        if ( $hero_bg_url ) {
            echo '<link rel="preload" as="image" href="' . esc_url( $hero_bg_url ) . '" fetchpriority="high">' . "\n";
        }
        if ( $post_id && has_post_thumbnail( $post_id ) ) {
            $tid = get_post_thumbnail_id( $post_id );
            $img = $tid ? wp_get_attachment_image_src( $tid, 'blog_hero' ) : null;
            if ( ! $img || ( isset( $img[1] ) && (int) $img[1] > 800 ) ) {
                $img = $tid ? wp_get_attachment_image_src( $tid, 'medium_large' ) : null;
            }
            if ( $img && ! empty( $img[0] ) ) {
                echo '<link rel="preload" as="image" href="' . esc_url( $img[0] ) . '" fetchpriority="high">' . "\n";
            }
        }
    }
?>
    <?php wp_head(); ?>

    <?php $font_dir = get_template_directory_uri() . '/assets/fonts'; ?>
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

    <!-- global.css and global.js are now loaded via wp_enqueue_style/wp_enqueue_script in functions.php with cache busting -->

    

</head>
<body <?php body_class(); ?>>

<?php get_template_part( 'partials/gtm/gtm-script-body-tag' ); ?>