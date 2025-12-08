<?php get_header(); ?>

<div class="container">
     <h2>404 Page</h2>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
            
           
            <?php
        endwhile;
    else :
        echo '<p>No posts found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>