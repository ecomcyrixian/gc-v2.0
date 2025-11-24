<?php get_header(); ?>

<article>
    <section class="posts-title">
             <?php while ( have_posts() ) : the_post(); ?>

             <div class="article-banner">
                    <div class="box">
                        <h1><?php the_title( ); ?></h1>
                        <div class="reviewer-user">
                            <?php echo do_shortcode(' [publishpress_authors_box layout="ppma_boxes_4965" author_categories="reviewer" ] ') ?>
                        </div>
                        <div class="author-user">
                            <div class="written-by">
                                <span>Written by &nbsp;<?php echo do_shortcode(' [publishpress_authors_box layout="ppma_boxes_4964" author_categories="author,coauthor" ] ') ?></span>
                                <span>Published on <?php echo get_the_date('j M Y') ?></span>
                            </div>
                        </div>
                    </div>                    
                    <?php the_post_thumbnail();?>
             </div>
             
                    
            <?php endwhile; ?>
        
    </section>    
</article>

<div id="primary" class="container">
    <main id="main" class="site-main">
        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                     
                    
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                    <div class="entry-meta">
                        
                        <span class="posted-on">
                            <time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>

                        <span class="sep"> | </span>

                        <span class="byline">
                            By <span class="author vcard">
                                <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                    <?php echo esc_html( get_the_author() ); ?>
                                </a>
                            </span>
                            
                            <?php
                            // Get the author's job title from a custom user meta field
                            $author_job = get_the_author_meta( 'job_title' ); // Change 'job_title' if your field has a different key
                            if ( ! empty( $author_job ) ) {
                                echo '<span class="author-job">, ' . esc_html( $author_job ) . '</span>';
                            }
                            ?>
                        </span>
                    </div></header><?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail( 'large' ); // Use 'large', 'medium', or a custom size ?>
                    </div>
                <?php endif; ?>

                
               <?php the_content() ?>
                
              

            </article>
            
        <?php endwhile; // End of the loop. ?>
    </main>
    
    <?php get_sidebar(); ?>
</div>




<?php get_footer(); ?>