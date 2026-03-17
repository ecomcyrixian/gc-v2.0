<?php
    // Helper function to get mega feature content
    function get_mega_feature_content( $menu_name, $feature_type = 'article' ) {
        if ( $feature_type === 'whitepaper' ) {
            // Whitepaper function commented out for future use - Background Checks and Drug & Health now use articles
            // return generate_mega_featured_whitepaper( $menu_name );
            // Fallback to article if whitepaper is requested but function is commented out
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
        
        // Fallback placeholder for articles only
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
    <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" target="_parent" class="button blue">
        Get Started Today
    </a>
    <div class="hamburger-desktop">
        <a href="#" class="hamburger-icon desktop-trigger" aria-label="Open quick links">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M28.25 5H3.75C3.6125 5 3.5 5.1125 3.5 5.25V7.25C3.5 7.3875 3.6125 7.5 3.75 7.5H28.25C28.3875 7.5 28.5 7.3875 28.5 7.25V5.25C28.5 5.1125 28.3875 5 28.25 5ZM28.25 24.5H3.75C3.6125 24.5 3.5 24.6125 3.5 24.75V26.75C3.5 26.8875 3.6125 27 3.75 27H28.25C28.3875 27 28.5 26.8875 28.5 26.75V24.75C28.5 24.6125 28.3875 24.5 28.25 24.5ZM28.25 14.75H3.75C3.6125 14.75 3.5 14.8625 3.5 15V17C3.5 17.1375 3.6125 17.25 3.75 17.25H28.25C28.3875 17.25 28.5 17.1375 28.5 17V15C28.5 14.8625 28.3875 14.75 28.25 14.75Z" fill="currentColor"/>
            </svg>
        </a>
        
        <div class="hamburger-flyout">
            <ul class="hamburger-links">
                <?php /* Industries link commented out - page not ready yet
                <li>
                    <a href="<?php echo esc_url( home_url('/industry/') ); ?>" target="_parent">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" rx="4" fill="#F2F3FF"/>
                            <path d="M15.3516 18.9062H24.7031C24.7141 18.9062 24.7277 18.9062 24.7387 18.9035C24.859 18.8844 24.9383 18.7723 24.9191 18.652L23.8199 11.8707C23.8035 11.7641 23.7105 11.6875 23.6039 11.6875H16.4508C16.3441 11.6875 16.2512 11.7641 16.2348 11.8707L15.1355 18.652C15.1328 18.6629 15.1328 18.6766 15.1328 18.6875C15.1328 18.8078 15.2312 18.9062 15.3516 18.9062ZM17.8453 13.5469H22.2066L22.7727 17.0469H17.2766L17.8453 13.5469ZM17.9137 21.277C17.8973 21.1703 17.8043 21.0938 17.6977 21.0938H10.5445C10.4379 21.0938 10.3449 21.1703 10.3285 21.277L9.2293 28.0582C9.22656 28.0691 9.22656 28.0828 9.22656 28.0938C9.22656 28.2141 9.325 28.3125 9.44531 28.3125H18.7969C18.8078 28.3125 18.8215 28.3125 18.8324 28.3098C18.9527 28.2906 19.032 28.1785 19.0129 28.0582L17.9137 21.277ZM11.373 26.4531L11.9391 22.9531H16.3004L16.8664 26.4531H11.373ZM30.7707 28.0582L29.6715 21.277C29.6551 21.1703 29.5621 21.0938 29.4555 21.0938H22.3023C22.1957 21.0938 22.1027 21.1703 22.0863 21.277L20.9871 28.0582C20.9844 28.0691 20.9844 28.0828 20.9844 28.0938C20.9844 28.2141 21.0828 28.3125 21.2031 28.3125H30.5547C30.5656 28.3125 30.5793 28.3125 30.5902 28.3098C30.7078 28.2906 30.7898 28.1785 30.7707 28.0582ZM23.1309 26.4531L23.6969 22.9531H28.0582L28.6242 26.4531H23.1309Z" fill="#4F51FD"/>
                        </svg>
                        <span>Industries</span> 
                    </a>
                </li>
                */ ?>
                <li>
                    <a href="<?php echo esc_url( home_url('/integrations/') ); ?>" target="_parent">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="4" fill="#F2F3FF"/>
                        <path d="M31.0932 10.0692L29.9339 8.90981C29.8901 8.86606 29.8354 8.84692 29.778 8.84692C29.7206 8.84692 29.6659 8.8688 29.6221 8.90981L27.5413 10.9907C26.6367 10.3778 25.5687 10.051 24.476 10.0528C23.076 10.0528 21.676 10.586 20.6069 11.6551L17.8206 14.4415C17.7799 14.4826 17.757 14.5381 17.757 14.5959C17.757 14.6538 17.7799 14.7093 17.8206 14.7504L25.2499 22.1797C25.2936 22.2235 25.3483 22.2426 25.4057 22.2426C25.4604 22.2426 25.5178 22.2208 25.5616 22.1797L28.3479 19.3934C30.2319 17.5067 30.4534 14.5891 29.0124 12.4618L31.0932 10.3809C31.178 10.2934 31.178 10.154 31.0932 10.0692V10.0692ZM27.03 18.0782L25.4057 19.7024L20.2979 14.5946L21.9221 12.9704C22.603 12.2895 23.5108 11.9122 24.476 11.9122C25.4413 11.9122 26.3464 12.2868 27.03 12.9704C27.7108 13.6512 28.0882 14.559 28.0882 15.5243C28.0882 16.4895 27.7108 17.3946 27.03 18.0782V18.0782ZM21.8292 20.9493C21.7881 20.9086 21.7325 20.8857 21.6747 20.8857C21.6168 20.8857 21.5613 20.9086 21.5202 20.9493L19.6991 22.7704L17.23 20.3012L19.0538 18.4774C19.1385 18.3926 19.1385 18.2532 19.0538 18.1684L18.0585 17.1731C18.0174 17.1324 17.9618 17.1095 17.904 17.1095C17.8461 17.1095 17.7906 17.1324 17.7495 17.1731L15.9257 18.9969L14.7499 17.8211C14.7295 17.8007 14.7051 17.7846 14.6784 17.7738C14.6516 17.763 14.6229 17.7577 14.594 17.7583C14.5393 17.7583 14.4819 17.7801 14.4382 17.8211L11.6546 20.6075C9.77058 22.4942 9.54909 25.4118 10.9901 27.5391L8.90925 29.62C8.86854 29.6611 8.8457 29.7166 8.8457 29.7745C8.8457 29.8323 8.86854 29.8878 8.90925 29.929L10.0686 31.0883C10.1124 31.1321 10.1671 31.1512 10.2245 31.1512C10.2819 31.1512 10.3366 31.1293 10.3803 31.0883L12.4612 29.0075C13.3827 29.6336 14.4546 29.9454 15.5264 29.9454C16.9264 29.9454 18.3264 29.4122 19.3956 28.343L22.1819 25.5567C22.2667 25.4719 22.2667 25.3325 22.1819 25.2477L21.0061 24.0719L22.83 22.2481C22.9147 22.1633 22.9147 22.0239 22.83 21.9391L21.8292 20.9493V20.9493ZM18.0776 27.0305C17.7429 27.3669 17.3449 27.6336 16.9066 27.8152C16.4682 27.9969 15.9982 28.0898 15.5237 28.0887C14.5585 28.0887 13.6534 27.7141 12.9698 27.0305C12.6334 26.6959 12.3667 26.2978 12.1851 25.8595C12.0034 25.4211 11.9105 24.9511 11.9116 24.4766C11.9116 23.5114 12.2862 22.6063 12.9698 21.9227L14.594 20.2985L19.7018 25.4063L18.0776 27.0305V27.0305Z" fill="#4F51FD"/>
                        </svg>
                        <span>Integrations</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url( home_url('/company/') ); ?>" target="_parent">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="4" fill="#F2F3FF"/>
                        <path d="M30.4458 18.6319C31.2907 18.6319 31.6435 17.5464 30.9571 17.046L20.5146 9.4499C20.3654 9.34064 20.1854 9.28174 20.0005 9.28174C19.8156 9.28174 19.6356 9.34064 19.4864 9.4499L9.04385 17.046C8.35753 17.5437 8.71026 18.6319 9.55792 18.6319H11.2505V28.8585H9.28174C9.16143 28.8585 9.06299 28.9569 9.06299 29.0772V30.4991C9.06299 30.6194 9.16143 30.7179 9.28174 30.7179H30.7192C30.8396 30.7179 30.938 30.6194 30.938 30.4991V29.0772C30.938 28.9569 30.8396 28.8585 30.7192 28.8585H28.7505V18.6319H30.4458ZM20.0005 11.3776L27.4134 16.7698H12.5876L20.0005 11.3776ZM13.2192 18.6319H16.4185V28.8585H13.2192V18.6319ZM18.3872 18.6319H21.5864V28.8585H18.3872V18.6319ZM26.7817 28.8585H23.5552V18.6319H26.7817V28.8585Z" fill="#4F51FD"/>
                        </svg>
                        <span>Company</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url( home_url('/pricing-packages/') ); ?>" target="_parent">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="4" fill="#F2F3FF"/>
                    <path d="M20 7.75C13.2352 7.75 7.75 13.2352 7.75 20C7.75 26.7648 13.2352 32.25 20 32.25C26.7648 32.25 32.25 26.7648 32.25 20C32.25 13.2352 26.7648 7.75 20 7.75ZM20 30.1719C14.3836 30.1719 9.82812 25.6164 9.82812 20C9.82812 14.3836 14.3836 9.82812 20 9.82812C25.6164 9.82812 30.1719 14.3836 30.1719 20C30.1719 25.6164 25.6164 30.1719 20 30.1719ZM21.3043 19.3656L20.6098 19.2043V15.532C21.6488 15.6742 22.2914 16.325 22.4008 17.1234C22.4145 17.2328 22.5074 17.3121 22.6168 17.3121H23.8445C23.973 17.3121 24.0742 17.2 24.0633 17.0715C23.8965 15.368 22.4938 14.2742 20.6207 14.0855V13.1914C20.6207 13.0711 20.5223 12.9727 20.402 12.9727H19.6336C19.5133 12.9727 19.4148 13.0711 19.4148 13.1914V14.0938C17.4789 14.2824 15.9641 15.3516 15.9641 17.3477C15.9641 19.1961 17.3258 20.0875 18.7559 20.4293L19.4313 20.6016V24.5035C18.2227 24.3422 17.5445 23.6969 17.4051 22.8273C17.3887 22.7234 17.2957 22.6469 17.1891 22.6469H15.9258C15.7973 22.6469 15.6961 22.7563 15.707 22.8848C15.8301 24.3887 16.9703 25.7723 19.4039 25.95V26.8086C19.4039 26.9289 19.5023 27.0273 19.6227 27.0273H20.3992C20.5195 27.0273 20.618 26.9289 20.618 26.8059L20.6125 25.9391C22.7535 25.7504 24.2848 24.6047 24.2848 22.5484C24.282 20.6508 23.0762 19.8031 21.3043 19.3656V19.3656ZM19.4285 18.9227C19.2754 18.8789 19.1469 18.8379 19.0184 18.7859C18.0941 18.4523 17.6648 17.9137 17.6648 17.2191C17.6648 16.2266 18.4168 15.6605 19.4285 15.532V18.9227ZM20.6098 24.5117V20.8559C20.6945 20.8805 20.7711 20.8996 20.8504 20.916C22.1437 21.3098 22.5785 21.8566 22.5785 22.6961C22.5785 23.7652 21.7746 24.4078 20.6098 24.5117Z" fill="#4F51FD"/>
                    </svg>
                    <span>Pricing</span>
                    </a>
                </li>
            </ul>
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
</nav>






