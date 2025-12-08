<?php get_header(); ?>

    <div class="articles-posts">
        <div class="container">
            <h4>
                <?php printf( esc_html__( 'Search Results for: %s', 'textdomain' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h4>
            <div class="cards">
                <div class="card-cont cols3">

                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
                            
                    <?php
                        endwhile; else :
                        echo '<p>No posts found.</p>';
                        endif;
                    ?>
                        

                </div>
            </div>
        </div>
        
    </div>

<?php get_footer(); ?>