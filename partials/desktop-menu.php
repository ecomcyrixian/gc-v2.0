<nav>
    <span id="mobile-menu" class="icon-menu" >
        <input type="checkbox" id="menu-toggle" class="hidden-checkbox">
        <label for="menu-toggle" class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </span>
    <div id="desktop-nav">
        <?php
            wp_nav_menu( array(
                'menu'             => 'GCv2.0 : Services',
                'walker'           => new Desktop_Nav_Walker(),
                'menu_class'       => 'main-menu',
                'container'        => 'div',
                'container_class'  => 'menu-block nav-services',
                'panel_type'       => 'group',
                'group_arrow'      => '<svg class="nav-group-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M20.3672 11.4328L11.5125 3.74766C11.4445 3.68906 11.3578 3.65625 11.2664 3.65625H9.19219C9.01875 3.65625 8.93906 3.87187 9.07031 3.98438L17.2781 11.1094H3.5625C3.45937 11.1094 3.375 11.1937 3.375 11.2969V12.7031C3.375 12.8062 3.45937 12.8906 3.5625 12.8906H17.2758L9.06797 20.0156C8.93672 20.1305 9.01641 20.3438 9.18984 20.3438H11.3344C11.3789 20.3438 11.4234 20.3273 11.4562 20.2969L20.3672 12.5672C20.4483 12.4966 20.5134 12.4095 20.558 12.3116C20.6025 12.2138 20.6256 12.1075 20.6256 12C20.6256 11.8925 20.6025 11.7862 20.558 11.6884C20.5134 11.5905 20.4483 11.5034 20.3672 11.4328Z" fill="#4F51FD"/></svg>',
            ) );
            wp_nav_menu( array(
                'menu'             => 'GCv2.0 : Industries',
                'walker'           => new Desktop_Nav_Walker(),
                'menu_class'       => 'main-menu',
                'container'        => 'div',
                'container_class'  => 'menu-block nav-industries',
                'panel_type'       => 'grid',
                'panel_eyebrow'    => 'Industries we serve',
                'panel_link_label' => 'View all industries',
                'panel_link_url'   => home_url( '/industries/' ),
            ) );
            wp_nav_menu( array(
                'menu'             => 'GCv2.0 : Integrations',
                'walker'           => new Desktop_Nav_Walker(),
                'menu_class'       => 'main-menu',
                'container'        => 'div',
                'container_class'  => 'menu-block nav-integrations',
            ) );
            wp_nav_menu( array(
                'menu'             => 'GCv2.0 : Pricing',
                'walker'           => new Desktop_Nav_Walker(),
                'menu_class'       => 'main-menu',
                'container'        => 'div',
                'container_class'  => 'menu-block nav-pricing',
            ) );
            wp_nav_menu( array(
                'menu'             => 'GCv2.0 : Company',
                'walker'           => new Desktop_Nav_Walker(),
                'menu_class'       => 'main-menu',
                'container'        => 'div',
                'container_class'  => 'menu-block nav-company',
                'panel_type'       => 'list',
            ) );
            wp_nav_menu( array(
                'menu'             => 'GCv2.0 : Contact Us',
                'walker'           => new Desktop_Nav_Walker(),
                'menu_class'       => 'main-menu',
                'container'        => 'div',
                'container_class'  => 'menu-block nav-contact',
            ) );
        ?>
    </div>
    <div class="desktop-menu-buttons">
        <a href="https://app.gcheck.com/sdocs/secure_home.html" target="_parent" class="login-button">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.6667 7.3335H3.33333C2.59695 7.3335 2 7.93045 2 8.66683V13.3335C2 14.0699 2.59695 14.6668 3.33333 14.6668H12.6667C13.403 14.6668 14 14.0699 14 13.3335V8.66683C14 7.93045 13.403 7.3335 12.6667 7.3335Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4.66663 7.3335V4.66683C4.66663 3.78277 5.01782 2.93493 5.64294 2.30981C6.26806 1.68469 7.1159 1.3335 7.99996 1.3335C8.88401 1.3335 9.73186 1.68469 10.357 2.30981C10.9821 2.93493 11.3333 3.78277 11.3333 4.66683V7.3335" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Login</span>
        </a>

        <a href="<?php echo esc_url( home_url('/book-a-demo/') ); ?>" target="_parent" class="button white">
        Book a Demo
        </a>
    </div>
</nav>






