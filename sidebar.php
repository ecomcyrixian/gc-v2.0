<div id="sidebar">
    <div>
        <div id="search">
            <h2 class="widget-title">Search</h2>
            <?php get_search_form(); ?>
        </div>

        <div id="categories-list" class="widget widget_categories">
            <h2 class="widget-title">Categories</h2>
            <ul>
                <?php
                // List all categories
                wp_list_categories( array(
                    'orderby'    => 'name',
                    'show_count' => true, // Optional: show post count
                    'title_li'   => '', // Removes the default list heading
                    'depth'      => 1, // Optional: only show top-level categories
                ) );
                ?>
            </ul>
        </div>

        <div id="recent-posted">
                    <h2 class="widget-title">Recent Posts</h2>
            <ul>
                <?php
                // WP_Query to fetch recent posts
                $recent_posts_args = array(
                    'post_type'      => 'post',      // Only get standard posts
                    'post_status'    => 'publish',   // Only published posts
                    'posts_per_page' => 5,           // Number of posts to show
                    'orderby'        => 'date',      // Order by date
                    'order'          => 'DESC',      // Newest first
                    'ignore_sticky_posts' => true,   // Exclude sticky posts
                );
                
                $recent_posts_query = new WP_Query( $recent_posts_args );
                
                if ( $recent_posts_query->have_posts() ) :
                    while ( $recent_posts_query->have_posts() ) : $recent_posts_query->the_post();
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </li>
                        <?php
                    endwhile;
                    
                    // Restore original Post Data
                    wp_reset_postdata(); 
                    
                else :
                    // Fallback for no posts
                    echo '<li>No recent posts found.</li>';
                endif;
                ?>
            </ul>
        </div>
        
    </div>
</div>
