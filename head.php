<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    
    <?php get_template_part( 'partials/gtm/gtm-script-head-tag' ); ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<?php
    if ( is_singular( 'post' ) ) {
        $post_id = get_queried_object_id();
        if ( $post_id && has_post_thumbnail( $post_id ) ) {
            $lcp_url = get_the_post_thumbnail_url( $post_id, 'large' );
            if ( $lcp_url ) {
                echo '<link rel="preload" as="image" href="' . esc_url( $lcp_url ) . '" fetchpriority="high">' . "\n";
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