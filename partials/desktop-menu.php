<?php
    function get_mega_feature_content( $menu_name, $feature_type = 'article' ) {
        if ( $feature_type === 'whitepaper' ) {
            $post = get_mega_menu_featured_article( $menu_name );
            if ( $post ) {
                return generate_mega_featured_article( $post );
            }
        } else {
            $post = get_mega_menu_featured_article( $menu_name );
            if ( $post ) {
                return generate_mega_featured_article( $post );
            }
        }
        
        return <<<HTML
<div class="mega-feature blog">
    <div class="feature-card">
        <p class="eyebrow category-colored">Featured story</p>
        <h4 class="feature-title">Placeholder article title</h4>
        <p class="feature-meta">Jan 1, 2025 • 5 min read</p>
        <a class="button outline" href="#">Read More</a>
    </div>
</div>
HTML;
    }
?>
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
                'menu' => 'GCv2.0 : Identity',
                'walker'         => new Desktop_Mega_Walker(),
                'menu_class'     => 'main-menu',
                'container'      => 'div',
                'container_class'=> 'menu-block nav-identity',
                'mega_feature'   => get_mega_feature_content( 'GCv2.0 : Identity', 'article' ),
                'mega_panel_title'=> "Identity",
                'mega_cta_label' => "Talk To Sales",
                'mega_cta_url'   => esc_url( home_url('/contact-us/') )
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Background Checks',
                'walker'         => new Desktop_Mega_Walker(),
                'menu_class'     => 'main-menu',
                'container'      => 'div',
                'container_class'=> 'menu-block nav-background',
                'mega_feature'   => get_mega_feature_content( 'GCv2.0 : Background Checks', 'article' ),
                'mega_panel_title'=> "Background Checks",
                'mega_cta_label' => "Talk To Sales",
                'mega_cta_url'   => esc_url( home_url('/contact-us/') )
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Verifications',
                'walker'         => new Desktop_Mega_Walker(),
                'menu_class'     => 'main-menu',
                'container'      => 'div',
                'container_class'=> 'menu-block nav-verifications',
                'mega_feature'   => get_mega_feature_content( 'GCv2.0 : Verifications', 'article' ),
                'mega_panel_title'=> "Verifications",
                'mega_cta_label' => "Talk To Sales",
                'mega_cta_url'   => esc_url( home_url('/contact-us/') )
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Drug & Health',
                'walker'         => new Desktop_Mega_Walker(),
                'menu_class'     => 'main-menu',
                'container'      => 'div',
                'container_class'=> 'menu-block nav-drug-health',
                'mega_feature'   => get_mega_feature_content( 'GCv2.0 : Drug & Health', 'article' ),
                'mega_panel_title'=> "Drug & Health",
                'mega_cta_label' => "Talk To Sales",
                'mega_cta_url'   => esc_url( home_url('/contact-us/') )
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Risk Monitoring',
                'walker'         => new Desktop_Mega_Walker(),
                'menu_class'     => 'main-menu',
                'container'      => 'div',
                'container_class'=> 'menu-block nav-risk',
                'mega_feature'   => get_mega_feature_content( 'GCv2.0 : Risk Monitoring', 'article' ),
                'mega_panel_title'=> "Continuous Monitoring",
                'mega_cta_label' => "Talk To Sales",
                'mega_cta_url'   => esc_url( home_url('/contact-us/') )
            ) );
            wp_nav_menu( array(
                'menu' => 'GCv2.0 : Compliance',
                'walker'         => new Desktop_Mega_Walker(),
                'menu_class'     => 'main-menu',
                'container'      => 'div',
                'container_class'=> 'menu-block nav-compliance',
                'mega_feature'   => get_mega_feature_content( 'GCv2.0 : Compliance', 'article' ),
                'mega_panel_title'=> "Compliance",
                'mega_cta_label' => "Talk To Sales",
                'mega_cta_url'   => esc_url( home_url('/contact-us/') )

            ) );
        ?>
    </div>
    <div class="desktop-menu-buttons">
    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" target="_parent" class="button blue">
        Get Started Today
    </a>
    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" target="_parent" class="button white">
     Book a Demo
    </a>
    <div class="hamburger-desktop">
        <a href="#" class="hamburger-icon desktop-trigger" aria-label="Open quick links">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M28.25 5H3.75C3.6125 5 3.5 5.1125 3.5 5.25V7.25C3.5 7.3875 3.6125 7.5 3.75 7.5H28.25C28.3875 7.5 28.5 7.3875 28.5 7.25V5.25C28.5 5.1125 28.3875 5 28.25 5ZM28.25 24.5H3.75C3.6125 24.5 3.5 24.6125 3.5 24.75V26.75C3.5 26.8875 3.6125 27 3.75 27H28.25C28.3875 27 28.5 26.8875 28.5 26.75V24.75C28.5 24.6125 28.3875 24.5 28.25 24.5ZM28.25 14.75H3.75C3.6125 14.75 3.5 14.8625 3.5 15V17C3.5 17.1375 3.6125 17.25 3.75 17.25H28.25C28.3875 17.25 28.5 17.1375 28.5 17V15C28.5 14.8625 28.3875 14.75 28.25 14.75Z" fill="currentColor"/>
            </svg>
        </a>
        
        <div class="hamburger-flyout">
            <div class="hamburger-flyout__nav">
                <h3 class="hamburger-section-label">Quick links</h3>
                <ul class="hamburger-links">
                    <li>
                        <a href="<?php echo esc_url( home_url('/industry/') ); ?>" target="_parent">
                            <svg class="quick-link-chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M10 16L14 12L10 8" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Industries</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( home_url('/integrations/') ); ?>" target="_parent">
                            <svg class="quick-link-chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M10 16L14 12L10 8" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Integrations</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( home_url('/pricing-packages/') ); ?>" target="_parent">
                            <svg class="quick-link-chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M10 16L14 12L10 8" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Pricing</span>
                        </a>
                    </li>
                </ul>
                <h3 class="hamburger-section-label">Company</h3>
                <ul class="hamburger-links">
                    <li>
                        <a href="<?php echo esc_url( home_url('/company/') ); ?>" target="_parent">
                            <svg class="quick-link-chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M10 16L14 12L10 8" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( home_url('/leadership-team/') ); ?>" target="_parent">
                            <svg class="quick-link-chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M10 16L14 12L10 8" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Leadership</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( home_url('/compliance-for-good/') ); ?>" target="_parent">
                            <svg class="quick-link-chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M10 16L14 12L10 8" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Compliance for Good&trade;</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="hamburger-actions">
                <a href="<?php echo esc_url( home_url('/pricing-packages/') ); ?>" target="_parent" class="button blue">
                    Get Volume Pricing
                </a>
                <a href="https://app.gcheck.com/sdocs/secure_home.html" target="_parent" class="button outline login-button">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.3496 14.793H16.2988C16.2168 14.793 16.1484 14.8613 16.1484 14.9434V16.1504H3.84961V3.84961H16.1504V5.05664C16.1504 5.13867 16.2187 5.20703 16.3008 5.20703H17.3516C17.4336 5.20703 17.502 5.14062 17.502 5.05664V3.09961C17.502 2.76758 17.2344 2.5 16.9023 2.5H3.09961C2.76758 2.5 2.5 2.76758 2.5 3.09961V16.9004C2.5 17.2324 2.76758 17.5 3.09961 17.5H16.9004C17.2324 17.5 17.5 17.2324 17.5 16.9004V14.9434C17.5 14.8594 17.4316 14.793 17.3496 14.793ZM17.6172 9.29688H11.4844V7.8125C11.4844 7.68164 11.332 7.60742 11.2305 7.68945L8.45898 9.87695C8.44031 9.89157 8.42521 9.91024 8.41482 9.93156C8.40443 9.95288 8.39903 9.97629 8.39903 10C8.39903 10.0237 8.40443 10.0471 8.41482 10.0684C8.42521 10.0898 8.44031 10.1084 8.45898 10.123L11.2305 12.3105C11.334 12.3926 11.4844 12.3184 11.4844 12.1875V10.7031H17.6172C17.7031 10.7031 17.7734 10.6328 17.7734 10.5469V9.45312C17.7734 9.36719 17.7031 9.29688 17.6172 9.29688Z" fill="#4F51FD"/>
                    </svg>
                    Account Login
                </a>
            </div>
        </div>
    </div>
    </div>
</nav>






