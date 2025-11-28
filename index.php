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
                    'order'      => 'ASC',
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

</main>

<?php get_footer(); ?>
