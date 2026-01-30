<?php
/**
 * Template Part: Blog V2 Right Sidebar
 * Right sidebar for author and reviewer cards
 * Hardcoded to match Figma design
 */
?>

<aside class="blog-v2-sidebar blog-v2-sidebar--right">
    <div class="blog-v2-sidebar__author">
        <div class="blog-v2-sidebar__card">
            <h3 class="blog-v2-sidebar__title">About The Creator</h3>
            <?php
            $author_name = 'Pat Hartonian';
            $author_job = 'VP of Operations, GCheck';
            $author_avatar = get_template_directory_uri() . '/assets/images/pat-hat.png';
            ?>
            <div class="blog-v2-sidebar__author-container">
                <img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="blog-v2-sidebar__avatar">
                <div class="blog-v2-sidebar__author-info">
                    <div class="blog-v2-sidebar__author-name-wrapper">
                        <span><?php echo esc_html( $author_name ); ?></span>
                        <a href="#" class="blog-v2-sidebar__linkedin" aria-label="LinkedIn">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/linkedin.png' ); ?>" alt="LinkedIn">
                        </a>
                    </div>
                    <span><?php echo esc_html( $author_job ); ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="blog-v2-sidebar__reviewer">
        <div class="blog-v2-sidebar__card">
            <div class="blog-v2-sidebar__title">About The Reviewer</div>
            <?php
            $reviewer_name = 'Charm Paz, CHRP';
            $reviewer_job = 'Recruiter and Editor, GCheck';
            $reviewer_avatar = get_template_directory_uri() . '/assets/images/charm-paz.png';
            ?>
            <div class="blog-v2-sidebar__author-container">
                <img src="<?php echo esc_url( $reviewer_avatar ); ?>" alt="<?php echo esc_attr( $reviewer_name ); ?>" class="blog-v2-sidebar__avatar">
                <div class="blog-v2-sidebar__author-info">
                    <div class="blog-v2-sidebar__author-name-wrapper">
                        <span><?php echo esc_html( $reviewer_name ); ?></span>
                        <a href="#" class="blog-v2-sidebar__linkedin" aria-label="LinkedIn">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/linkedin.png' ); ?>" alt="LinkedIn">
                        </a>
                    </div>
                    <span><?php echo esc_html( $reviewer_job ); ?></span>
                </div>
            </div>
        </div>
    </div>

    <?php 
    // Loop through flexible content to find cards with position="right"
    if ( function_exists( 'have_rows' ) && have_rows( 'blog_v2_layout' ) ) :
        while ( have_rows( 'blog_v2_layout' ) ) : the_row();
            if ( get_row_layout() == 'card' ) :
                set_query_var( 'sidebar_position', 'right' );
                get_template_part( 'partials/blog-v2/card' );
            endif;
        endwhile;
    endif;
    ?>
</aside>
