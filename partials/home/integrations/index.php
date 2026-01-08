<div id="integrations">
    <div class="container">
    
        <div class="heading">
            <h2>
                <span>INTEGRATIONS</span>
                Scalable Integrations for ATS & HRIS Systems
            </h2>
        </div>

        <div class="integrations-logos">
            <?php
            // Array of logo filenames in the order they should appear (5-4-5-4 pattern)
            // Row 1: 5 logos
            $row1 = [
                'bamboohr.png',
                'bullhorn.png',
                'dayforce.png',
                'greenhouse.png',
                'oracle-recruiting-cloud.png'
            ];
            // Row 2: 4 logos
            $row2 = [
                'workday-recruiting.png',
                'icims.png',
                'neogov.png',
                'jazzhr.png'
            ];
            // Row 3: 5 logos
            $row3 = [
                'rippling.png',
                'sap-successfactors.png',
                'taleo-business-edition.png',
                'ukg-pro.png',
                'workable.png'
            ];
            // Row 4: 4 logos
            $row4 = [
                'avionte.png',
                'lever.png',
                'smartrecruiters.png',
                'jobvite.png'
            ];
            
            $all_logos = [$row1, $row2, $row3, $row4];
            
            foreach ($all_logos as $index => $row) {
                $row_class = count($row) === 4 ? 'integration-row integration-row-4' : 'integration-row integration-row-5';
                ?>
                <div class="<?php echo esc_attr($row_class); ?>">
                    <?php
                    foreach ($row as $logo_file) {
                        // Extract integration name by removing ".png"
                        $integration_name = str_replace('.png', '', $logo_file);
                        $integration_url = 'https://gcheck.com/integrations/' . $integration_name . '/';
                        $logo_path = get_template_directory_uri() . '/assets/images/ats-logo/' . $logo_file;
                        $logo_alt = ucwords(str_replace('-', ' ', $integration_name)) . ' Integration';
                        
                        // Define image sizes and object-fit for each logo
                        $logo_sizes = [
                            'workday-recruiting' => ['width' => '116', 'height' => '60.9', 'fit' => 'contain'],
                            'icims' => ['width' => '124', 'height' => '37.78', 'fit' => 'contain'],
                            'neogov' => ['width' => '160', 'height' => '24.17', 'fit' => 'contain'],
                            'sap-successfactors' => ['width' => '160', 'height' => '18.67', 'fit' => 'contain'],
                            'taleo-business-edition' => ['width' => '134', 'height' => '50.25', 'fit' => 'contain'],
                            'ukg-pro' => ['width' => '114', 'height' => '42.75', 'fit' => 'contain'],
                            'workable' => ['width' => '160', 'height' => '26.47', 'fit' => 'contain'],
                            'jobvite' => ['width' => '124', 'height' => '46.5', 'fit' => 'contain'],
                            'bullhorn' => ['width' => '160', 'height' => '60', 'fit' => 'contain'],
                            'oracle-recruiting-cloud' => ['width' => '160', 'height' => '60', 'fit' => 'cover'],
                            'avionte' => ['width' => '160', 'height' => '60', 'fit' => 'cover'],
                        ];
                        
                        // Default size: 160x60 with contain
                        $img_width = '160';
                        $img_height = '60';
                        $img_fit = 'contain';
                        
                        if (isset($logo_sizes[$integration_name])) {
                            $img_width = $logo_sizes[$integration_name]['width'];
                            $img_height = $logo_sizes[$integration_name]['height'];
                            $img_fit = $logo_sizes[$integration_name]['fit'];
                        }
                        ?>
                        <a href="<?php echo esc_url($integration_url); ?>" class="integration-logo-link" target="_self" aria-label="<?php echo esc_attr($logo_alt); ?>">
                            <img src="<?php echo esc_url($logo_path); ?>" alt="<?php echo esc_attr($logo_alt); ?>" loading="lazy" style="width: <?php echo esc_attr($img_width); ?>px; height: <?php echo esc_attr($img_height); ?>px; object-fit: <?php echo esc_attr($img_fit); ?>;">
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="integrations-description">
            <p>Integrate your ATS and HRIS to automate data flow and keep teams focused on what matters most—hiring great talent.</p>
        </div>

        <div class="integrations-cta">
            <a href="https://gcheck.com/integrations/" target="_parent" class="button blue">
                Explore All Integrations
            </a>
        </div>
    
    </div>
</div>

