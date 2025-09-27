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
                'menu' => 'GCv2.0 : Background Checks',
                'walker'         => new Walker_Nav_Menu_With_Description(),
                'menu_class'     => 'main-menu',
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Industry',
                'walker'         => new Walker_Nav_Menu_With_Description(),
                'menu_class'     => 'main-menu',
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Integrations',
                'walker'         => new Walker_Nav_Menu_With_Description(),
                'menu_class'     => 'main-menu',
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Company',
                'walker'         => new Walker_Nav_Menu_With_Description(),
                'menu_class'     => 'main-menu',
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Contact',
                'walker'         => new Walker_Nav_Menu_With_Description(),
                'menu_class'     => 'main-menu',
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Pricing',
                'walker'         => new Walker_Nav_Menu_With_Description(),
                'menu_class'     => 'main-menu',
            ) );
        ?>
    </div>
    <a href="" target="_parent" class="button blue">
        Get Started Today
    </a>
    <a href="" target="_parent" class="button white">
        Get Volume Pricing
    </a>
    <span class="icon-user">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.1812 3.00023C8.86999 2.90148 2.90124 8.87023 2.99999 16.1815C3.09749 23.1934 8.80686 28.9027 15.8187 29.0002C23.1312 29.1002 29.0987 23.1315 28.9987 15.8202C28.9025 8.80711 23.1931 3.09773 16.1812 3.00023ZM24.0825 23.4534C24.0576 23.4803 24.0271 23.5014 23.9931 23.5152C23.9591 23.529 23.9225 23.5352 23.8859 23.5333C23.8493 23.5314 23.8136 23.5214 23.7812 23.5042C23.7489 23.4869 23.7207 23.4627 23.6987 23.4334C23.1397 22.7019 22.4551 22.0757 21.6769 21.584C20.0856 20.5627 18.0694 20.0002 16 20.0002C13.9306 20.0002 11.9144 20.5627 10.3231 21.584C9.54491 22.0755 8.8603 22.7015 8.30124 23.4327C8.27927 23.4621 8.25112 23.4863 8.21877 23.5035C8.18642 23.5208 8.15067 23.5308 8.11405 23.5327C8.07743 23.5346 8.04084 23.5284 8.00687 23.5146C7.9729 23.5008 7.94238 23.4797 7.91749 23.4527C6.08353 21.473 5.04467 18.886 4.99999 16.1877C4.89811 10.1059 9.88874 5.01523 15.9731 5.00023C22.0575 4.98523 27 9.92586 27 16.0002C27.0021 18.7636 25.96 21.4257 24.0825 23.4534Z" fill="#CDD6E0"/><path d="M16 9C14.7675 9 13.6532 9.46188 12.8613 10.3013C12.0694 11.1406 11.6738 12.3012 11.7632 13.5469C11.9444 16 13.845 18 16 18C18.155 18 20.0519 16 20.2369 13.5475C20.3294 12.3137 19.9369 11.1638 19.1319 10.3088C18.3369 9.465 17.2244 9 16 9Z" fill="#CDD6E0"/></svg>
    </span>
</nav>






