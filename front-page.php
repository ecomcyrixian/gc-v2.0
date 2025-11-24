<?php 
    /*
    Template Name: Front Page
    Template post Type: page
*/
?>
<?php get_header('home'); ?>

<?php get_template_part('partials/home/grid-layout/index') ?>
<?php get_template_part('core-pages/banner/option-1') ?>
<?php get_template_part('partials/home/key-features/index') ?>
<?php get_template_part('partials/home/pricing/index') ?>
<?php get_template_part('partials/home/hiring/index') ?>
<?php get_template_part('core-pages/faq/faq-home') ?>
<?php get_template_part('core-pages/banner/option-2') ?>

<?php get_footer(); ?>