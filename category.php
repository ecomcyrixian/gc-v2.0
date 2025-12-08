<?php
    get_header(); 
    global $wp_query;
?>
<main>

    <div class="page-hero Center">
        <div class="container">
            <section class="text-only">
                <div>
                    <pre>ARTICLE CATEGORY</pre>
                    <h1><?php single_cat_title(); ?></h1>
                </div>
            </section>
        </div>
    </div>

    <div class="container">
        
        <div class="latest-category-artile">


            <?php
                
                if (is_category()) {
                    $category_object = $wp_query->get_queried_object();
                    $category_id = $category_object->term_id;
                    // echo "Current Category ID: " . $category_id;
                }
              
                // Define the custom query to get the 3 most recent posts
                $args = array(
                    'posts_per_page' => 4,  // Limit the number of post
                    'post_type'      => 'post',  // Only fetch posts (not pages or custom post types)
                    'orderby'        => 'publish_date',  // Order by date
                    'order'          => 'DESC',  // Latest posts first
                    'cat'            => $category_id,
                );

                // Execute the query
                $recent_posts = new WP_Query($args);
            ?>

            <?php if ($recent_posts->have_posts()) : ?>
            <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>

                <?php
                    $post_date = get_the_date( ' j M, Y' );
                    $word_count = str_word_count( strip_tags( get_the_content() ) );
                    $reading_time = ceil( $word_count / 200 );
                ?>
                <div>
                    <span class="featured-image">
                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                    </span>
                    
                    <div class="articles-info">
                        
                        <span class="category">                                       
                            <?php
                                // Get the current post's categories
                                $categories = get_the_category();

                                if ( ! empty( $categories ) ) {
                                    // Take the first category in the array (often the primary one)
                                    $category = $categories[0];

                                    // Get the category name (title)
                                    $category_title = $category->name;

                                    // Get the category URL (link)
                                    $category_link = get_category_link( $category->term_id );

                                    // Output the HTML
                                    echo '<a href="' . esc_url( $category_link ) . '" rel="category tag">';
                                    echo esc_html( $category_title );
                                    echo '</a>';
                                }

                            ?>
                            
                        </span>

                        <h4>
                            <a class="title" href="<?php echo get_permalink(); ?>" aria-label="<?php the_title(); ?> ">
                                    <?php the_title(); ?>
                            </a>
                        </h4>

                        <span class="read-time">
                                <span class="post-date"><?php echo $post_date ?></span>
                                <strong>•</strong>
                                <span class="reading-time"><?php echo $reading_time; ?> min read</span>
                        </span>

                        <div class="description">
                            <?php
                                $excerpt = wp_trim_words(get_the_excerpt(), 50, '...');
                                echo $excerpt;
                            ?>                                        
                        </div>

                        <span class="btn">
                            <a class="button readmore" href="<?php echo get_permalink(); ?>"> Read More</a>
                        </span>

                    </div>
                </div>
            
            <!-- wp else condition -->
            <?php endwhile; else: ?>
            <?php wp_reset_postdata(); ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?> 
        </div>
    </div>

    <div class="articles-posts">
        <div class="container">
            <div class="cards">
                <div class="card-cont cols3">
                    <!-- wp default loop  -->
                     <?php
                
                        if (is_category()) {
                            $category_object = $wp_query->get_queried_object();
                            $category_id = $category_object->term_id;
                            // echo "Current Category ID: " . $category_id;
                        }
                    
                        // Define the custom query to get the 3 most recent posts
                        $args = array(
                            // 'posts_per_page' => 4,  // Limit the number of post
                            'post_type'      => 'post',  // Only fetch posts (not pages or custom post types)
                            'orderby'        => 'publish_date',  // Order by date
                            'order'          => 'ASC',  // Latest posts first
                            'cat'            => $category_id,
                        );

                        // Execute the query
                        $recent_posts = new WP_Query($args);
                    ?>

                    <?php if ($recent_posts->have_posts()) : ?>
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>

                        <?php
                            $post_date = get_the_date( ' j M, Y' );
                            $word_count = str_word_count( strip_tags( get_the_content() ) );
                            $reading_time = ceil( $word_count / 200 );
                        ?>
                        
                        <div>
                                <span class="featured-image">
                                <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                            </span>
                            <div class="articles-info">
                                <span class="category">                                       
                                    <?php
                                        // Get the current post's categories
                                        $categories = get_the_category();

                                        if ( ! empty( $categories ) ) {
                                            // Take the first category in the array (often the primary one)
                                            $category = $categories[0];

                                            // Get the category name (title)
                                            $category_title = $category->name;

                                            // Get the category URL (link)
                                            $category_link = get_category_link( $category->term_id );

                                            // Output the HTML
                                            echo '<a href="' . esc_url( $category_link ) . '" rel="category tag">';
                                            echo esc_html( $category_title );
                                            echo '</a>';
                                        }

                                    ?>
                                    
                                </span>
                                <h4>
                                    <a class="title" href="<?php echo get_permalink(); ?>" aria-label="<?php the_title(); ?> ">
                                            <?php the_title(); ?>
                                    </a>
                                </h4>
                                <span class="read-time">
                                        <span class="post-date"><?php echo $post_date ?></span>
                                        <strong>•</strong>
                                        <span class="reading-time"><?php echo $reading_time; ?> min read</span>
                                </span>
                                <div class="description">
                                    <?php
                                        $excerpt = wp_trim_words(get_the_excerpt(), 50, '...');
                                        echo $excerpt;
                                    ?>                                        
                                </div>
                                <span class="btn">
                                    <a class="button readmore" href="<?php echo get_permalink(); ?>"> Read More</a>
                                </span>
                            </div>

                        </div>

                        <!-- wp else condition -->
                    <?php endwhile; else: ?>
                    <?php wp_reset_postdata(); ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
                                    
                </div>
            </div>
        </div>
    </div>


</main>
<?php get_footer(); ?>