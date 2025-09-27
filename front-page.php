<?php 
    /*
    Template Name: Front Page
    Template post Type: page
*/
?>
<?php get_header('home'); ?>

<div class="container">
    <?php get_template_part('partials/home/grid-layout/grid-layout') ?>
</div>

<?php get_footer(); ?>