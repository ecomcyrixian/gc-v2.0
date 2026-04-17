<nav>
    <div id="mobile-nav">
        
        <div>
            
            <!-- GCv2.0 : Identity -->
            <div>
                <input type="checkbox" id="Identity" class="toggle" />
                <label for="Identity">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg>
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Identity',
                            'walker'  => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Identity',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>

            <!-- GCv2.0 : Background Checks -->
            <div>
                <input type="checkbox" id="Background-Checks" class="toggle" />
                <label for="Background-Checks">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg>
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Background Checks',
                            'walker'  => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Background Checks',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>

            <!-- GCv2.0 : Verifications -->
            <div>
                <input type="checkbox" id="Verifications" class="toggle"/>
                <label for="Verifications">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg>
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Verifications',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Verifications',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>

            <!-- GCv2.0 : Drug & Health -->
            <div>
                <input type="checkbox" id="Drug-Health" class="toggle"/>
                <label for="Drug-Health">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg>
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Drug & Health',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Drug & Health',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>

            <!-- GCv2.0 : Risk Monitoring -->
            <div>
                <input type="checkbox" id="Risk-Monitoring" class="toggle"/>
                <label for="Risk-Monitoring">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg>
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Risk Monitoring',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Risk Monitoring',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>

            <!-- GCv2.0 : Compliance -->
            <div>
                <input type="checkbox" id="Compliance" class="toggle"/>
                <label for="Compliance">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg>
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Compliance',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Compliance',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>
            
            <div class="mobile-quick-links">
                <h3 class="mobile-quick-links__label">Quick links</h3>
                <ul class="quick-links-list">
                    <!-- <li>
                        <a href="<?php echo esc_url( home_url('/industry/') ); ?>" target="_parent">
                            <svg class="quick-link-chevron" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M10 16L14 12L10 8" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Industries</span>
                        </a>
                    </li> -->
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
                <h3 class="mobile-quick-links__label">Company</h3>
                <ul class="quick-links-list">
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
          
        </div>
        
        <div id="buttons">
            <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" target="_parent" class="button blue full">
                Get Started Today
            </a>
            <a href="https://app.gcheck.com/sdocs/secure_home.html" target="_parent" class="button outline login-button full">
                Account Login
            </a>
        </div>
    
    </div>
</nav>






