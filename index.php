<?php get_header(); ?>

<main>

    <div class="page-hero">
        <div class="container">
            <div class="heading">
                <pre>Blog</pre>
                <h2>Empower Your Growth Strategy with <br> GCheck's Content Hub</h2>
                <p>Your Go-To Resource for Employment Background Check Questions, Insights, and Expertise</p>
            </div>
            <span class="search-form">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.7656 16.6895L12.6934 11.6172C13.4805 10.5996 13.9062 9.35547 13.9062 8.04688C13.9062 6.48047 13.2949 5.01172 12.1895 3.9043C11.084 2.79687 9.61133 2.1875 8.04688 2.1875C6.48242 2.1875 5.00977 2.79883 3.9043 3.9043C2.79687 5.00977 2.1875 6.48047 2.1875 8.04688C2.1875 9.61133 2.79883 11.084 3.9043 12.1895C5.00977 13.2969 6.48047 13.9062 8.04688 13.9062C9.35547 13.9062 10.5977 13.4805 11.6152 12.6953L16.6875 17.7656C16.7024 17.7805 16.72 17.7923 16.7395 17.8004C16.7589 17.8084 16.7797 17.8126 16.8008 17.8126C16.8218 17.8126 16.8427 17.8084 16.8621 17.8004C16.8815 17.7923 16.8992 17.7805 16.9141 17.7656L17.7656 16.916C17.7805 16.9011 17.7923 16.8835 17.8004 16.864C17.8084 16.8446 17.8126 16.8238 17.8126 16.8027C17.8126 16.7817 17.8084 16.7609 17.8004 16.7414C17.7923 16.722 17.7805 16.7043 17.7656 16.6895V16.6895ZM11.1406 11.1406C10.3125 11.9668 9.21484 12.4219 8.04688 12.4219C6.87891 12.4219 5.78125 11.9668 4.95313 11.1406C4.12695 10.3125 3.67188 9.21484 3.67188 8.04688C3.67188 6.87891 4.12695 5.7793 4.95313 4.95313C5.78125 4.12695 6.87891 3.67188 8.04688 3.67188C9.21484 3.67188 10.3145 4.125 11.1406 4.95313C11.9668 5.78125 12.4219 6.87891 12.4219 8.04688C12.4219 9.21484 11.9668 10.3145 11.1406 11.1406Z" fill="#1A1C1E"/></svg>
                <?php //get_search_form(); ?>
                <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label>
                        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span>
                        <input type="search" class="search-field" 
                            placeholder="<?php echo esc_attr_x( 'Enter search article', 'placeholder' ) ?>" 
                            value="<?php echo get_search_query() ?>" name="s" />
                    </label>
                    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
                </form>
            </span>
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
                    'exclude' => array( 29, 43 ), // exclude glossary category
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
