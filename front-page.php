<?php 
    /*
    Template Name: Front Page
    Template post Type: page
*/
?>
<?php get_header('home'); ?>

<?php get_template_part('partials/home/grid-layout/index') ?>
<?php get_template_part('partials/home/banner/index') ?>
<?php get_template_part('partials/home/key-features/index') ?>

<?php get_footer(); ?>