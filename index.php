<?php //get_header(); ?>
<?php get_header('home'); ?>

<div id="content">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div><?php the_content(); ?></div> 
            <?php
        endwhile;
    else :
        echo '<p>No posts found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>