<nav>
    <div id="mobile-nav">
        
        <div>
            
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
            
             <!-- GCv2.0 : Industry -->
            <div>
                <input type="checkbox" id="Industry" class="toggle"/>
                <label for="Industry">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg>
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Industry',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Industry',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>
            
             <!-- GCv2.0 : Integrations -->
            <div>
                <input type="checkbox" id="Integrations" class="toggle"/>
                <label for="Integrations">
                    <span>
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg> -->
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Integrations',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Integrations',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>

            <!-- GCv2.0 : Company -->
            <div>
                <input type="checkbox" id="Company" class="toggle"/>
                <label for="Company">
                    <span>
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg> -->
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Company',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Company',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>

             <!-- GCv2.0 : Contact -->
            <div>
                <input type="checkbox" id="Contact" class="toggle"/>
                <label for="Contact">
                    <span>
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg> -->
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Contact',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Contact',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>
            
             <!-- GCv2.0 : Pricing -->
            <div>
                <input type="checkbox" id="Pricing" class="toggle"/>
                <label for="Pricing">
                    <span>
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024"><path fill="#000000" d="M104.704 338.752a64 64 0 0 1 90.496 0l316.8 316.8 316.8-316.8a64 64 0 0 1 90.496 90.496L557.248 791.296a64 64 0 0 1-90.496 0L104.704 429.248a64 64 0 0 1 0-90.496z"/></svg> -->
                    </span>
                    <?php
                         wp_nav_menu( array(
                           'menu' => 'GCv2.0 : Pricing',
                            'walker' => new Parent_Menu_Walker(),
                        ) );  
                    ?>

                </label>
                <div class="content-to-show-hide">
                    <?php 
                        wp_nav_menu( array(
                            'menu' => 'GCv2.0 : Pricing',
                            'menu_class'     => 'main-menu',
                            'walker'         => new Walker_Nav_Menu_With_Description(),
                            
                        ) );
                    ?>
                </div>
            </div>
          
        </div>
        
        <div id="buttons">
            <a href="" target="_parent" class="button blue">
                Get Started Today
            </a>
            <a href="" target="_parent" class="button white">
                Get Volume Pricing
            </a>
        </div>
    
    </div>
</nav>






