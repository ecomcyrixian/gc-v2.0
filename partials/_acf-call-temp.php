    
    <!-- import code -->
   <?php if( have_rows('top_menu_group', 'option') ): ?>
		<?php while( have_rows('top_menu_group', 'option') ) : the_row(); ?>
            <?php get_template_part('partials/menu') ?> <!-- directory template path -->
		<?php endwhile; ?>
	<?php endif; ?>
    
    
    <!-- Announcement Bar -->
    <?php
        $display_selection = get_sub_field('display_selection') == "Show";
    ?>   
    <?php if ( $display_selection ) : ?>
        
        <div class="items">
                <?php if( have_rows('add_menu') ): ?>
                
                    <?php while( have_rows('add_menu') ) : the_row(); ?>
                    <?php
                        $menu_name = get_sub_field('menu_item');
                        
                        $url = get_sub_field('menu_link');
                        $link_url = $url['url'];
                        $link_title = $url['title'];
                        $link_target = $url['target'] ? $url['target'] : '_self';


                    ?>
                    <a href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>" aria-label="<?= esc_attr( $link_title ); ?>">
                        <h4><?= $menu_name ?></h4>
                    </a>

                    <?php endwhile; ?>

                <?php endif; ?>
            </div>

    <?php endif; ?> 


    <!-- Menu -->
     <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'walker'         => new Walker_Nav_Menu_With_Description(),
            'menu_class'     => 'main-menu',
        ) );

     ?>