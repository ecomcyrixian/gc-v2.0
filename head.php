<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/css/global.css' ?>">   
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/js/global.js' ?>">    
</head>
<body <?php body_class(); ?>>
