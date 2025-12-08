<?php
get_header();
global $wp_query;
?>

<article>
    <section class="posts-title">
        <?php while ( have_posts() ) : the_post(); ?>

        <div class="article-banner">
            <div>
                <div class="box">
                    <h1><?php the_title( ); ?></h1>
                    <div class="reviewer-user">
                        <?php echo do_shortcode(' [publishpress_authors_box layout="ppma_boxes_4965" author_categories="reviewer" ] ') ?>
                    </div>
                    <div class="author-user">
                    <div class="written-by">
                        <span>Written by &nbsp;<?php echo do_shortcode(' [publishpress_authors_box layout="ppma_boxes_4964" author_categories="author,coauthor" ] ') ?></span>
                        <!-- <span>Published on <?php //echo get_the_date('j M Y') ?></span> -->
                    </div>
                </div>
                </div>
            </div>
            <span>
                <?php the_post_thumbnail();?>
            </span>

        </div>
        <?php endwhile; ?>
    </section>


    <div id="primary" class="container">
        <main id="main" class="site-main">

            <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php the_content() ?>

            </article>
            <?php endwhile; // End of the loop. ?>

            <!-- Webforms added 01.14.25 -->
            <div class="webforms">

                <div class="container">
                    <section>
                        <h2>Still have questions?</h2>
                        <p>Get in touch with our team today for a personalized demo and discover how our tailored volume
                            pricing and packages can drive results for your business!</p>
                    </section>
                    <section>
                        <?php
                        if (class_exists('ReviewSchemaPlugin')) {
                            $plugin = new ReviewSchemaPlugin();
                            echo $plugin->render_review_form(array());
                        }
                        ?>
                        <!-- <div class="pipedriveWebForms" data-pd-webforms="https://webforms.pipedrive.com/f/bYWCbtZeuHogh6JK4UbrdTgrb0aaX9hLt89hsetfoTsSDxB5Y0TcC64MFGDOyM4TF9"><script src="https://webforms.pipedrive.com/f/loader"></script></div>-->
                    </section>
                </div>
            </div>

            <!-- Credits Author added 11.21.24 -->
            <div id="author-credits" class="container">
                <section>
                    <h2>Credits</h2>
                    <?php echo do_shortcode(' [publishpress_authors_box layout="ppma_boxes_4969 author_categories="reviewer" ] ') ?>
                    <?php echo do_shortcode(' [publishpress_authors_box layout="ppma_boxes_4969 author_categories="author,coauthor" ] ') ?>
                </section>
            </div>

            <div class="latest-articles">
                <div class="container">
                    <div class="heading">
                        <h2>
                            <span>From the blog</span>
                            Explore the GCheck Content Hub
                        </h2>
                    </div>

                   

                    <div class="cards">
                        <div class="card-cont cols3">

                            <?php
                                $categories = get_the_category();

                                if ( ! empty( $categories ) ) {
                                    $first_category_id = $categories[0]->cat_ID;
                                } else {
                                    echo "No categories found for this post.";
                                }
                           
                                // Define the custom query to get the 3 most recent posts
                                $args = array(
                                    'posts_per_page' => 3,  // Limit the number of post
                                    'post_type'      => 'post',  // Only fetch posts (not pages or custom post types)
                                    'orderby'        => 'publish_date',  // Order by date
                                    'order'          => 'DESC',  // Latest posts first
                                    'cat'            => $first_category_id,
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
                                        <a class="title" href="<?php echo get_permalink(); ?>"
                                            aria-label="<?php the_title(); ?> ">
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

            <div class="legal-disclaimer">
                <strong>LEGAL DISCLAIMER: </strong>
                <p>The information provided in this article is for general informational and educational purposes only
                    and should not be construed as legal advice or a substitute for consultation with qualified legal
                    counsel. While we strive to ensure accuracy, employment screening laws and regulations—including but
                    not limited to the Fair Credit Reporting Act (FCRA), Equal Employment Opportunity Commission (EEOC)
                    guidelines, state and local ban-the-box laws, industry-specific requirements, and other applicable
                    federal, state, and local statutes—are subject to frequent changes, varying interpretations, and
                    jurisdiction-specific applications that may affect their implementation in your organization.
                    Employers and screening decision-makers are solely responsible for ensuring their background check
                    policies, procedures, and practices comply with all applicable laws and regulations relevant to
                    their specific industry, location, and circumstances. We strongly recommend consulting with
                    qualified employment law attorneys and compliance professionals before making hiring, tenant
                    screening, or other decisions based on background check information.</p>
            </div>

        </main>
    </div>

</article>




<?php get_footer(); ?>