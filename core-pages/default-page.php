<?php get_header(); ?>
<div div class="container">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
                <div><?php the_content(); ?></div> 
            <?php
        endwhile;
    else :
        echo '<p>No posts found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>