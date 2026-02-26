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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet"> -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" onload="this.onload=null;this.rel='stylesheet';this.removeAttribute('as')" as="style" fetchpriority="high">

    <!-- global.css and global.js are now loaded via wp_enqueue_style/wp_enqueue_script in functions.php with cache busting -->

    

</head>
<body <?php body_class(); ?>>

<?php get_template_part( 'partials/gtm/gtm-script-body-tag' ); ?>