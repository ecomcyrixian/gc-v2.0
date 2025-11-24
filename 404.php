<?php get_header(); ?>

<div id="content">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
            
            <h2>404 Page</h2>
            <?php
        endwhile;
    else :
        echo '<p>No posts found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>