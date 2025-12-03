<?php get_header(); ?>

<main>

    <div class="page-hero Left yes">        
        
        <div class="container">
            <section class="cols cols2 Right">
            <div>
                <span class="logos Left ">
                    </span>
                        <h2>Empower Your Growth Strategy with <br>GCheck's Content Hub</h2>
                        <p>Your Go-To Resource for Employment Background Check Questions, Insights, and Expertise</p>
                    <span>
                    
                </span>
            </div>
            <div>
                <img src="https://gcheck.com/wp-content/uploads/2023/12/blog-heroshot-img.svg" alt="">
            </div>
            </section>        

        </div>
    </div>

    <div class="latest-articles">
        <div class="cards">
            <?php
                /*
                $articles_data = array(
                    'category' => 'industry-guides',
                    'article' => 3,
                );
                get_template_part('core-pages/get-articles',null, $articles_data);

                */

                $categories = get_categories( array(
                    'orderby'    => 'name',
                    'order'      => 'DESC',
                    'exclude' => array( 29 ), // exclude glossary category
                    'hide_empty' => true, // Set to true to exclude categories with no posts

                ) );

                $slugs = array();
            
                foreach ( $categories as $category ) {
                    // $slugs[] = $category->slug;
                    $names[] = $category->name;
                }

                // foreach ( $slugs as $slug ) {
                foreach ( $names as $name ) {

                    $category_id = get_cat_ID( $name );
                    $category_link = get_category_link( $category_id );

                    // echo '<div class="heading"> <h2>' . esc_html( $name ) . '</h2> <a href="'. esc_html( $category_link ) .'" target="_parent" aria-label="'. esc_html( $name ) .'"> View all articles </a> </div>';

                    $articles_data = array(
                        // 'category' => $slug,
                        'category_link' => $category_link,
                        'category_name' => $name,
                        'article' => 6,
                        
                        
                    );

                    get_template_part('core-pages/get-articles',null, $articles_data);
                }
            ?>
        </div>
    </div>
    
    <div class="recent-articles">
        <div class="cards">
            <div class="container">
                <div class="heading">
                    <h2>
                        Recent Articles
                    </h2>
                </div>
                <div class="cards">
                    <div class="card-cont cols3">

                        <!-- wp default loop  -->
                        <?php
                            // Define the custom query to get the 3 most recent posts
                            $args = array(
                                'posts_per_page' => esc_html(15),  // Limit the number of post
                                'post_type'      => 'post',  // Only fetch posts (not pages or custom post types)
                                'orderby'        => 'publish_date',  // Order by date
                                'order'          => 'ASCs',  // Latest posts first
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
    </div>



</main>

<?php get_footer(); ?>
