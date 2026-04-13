<?php get_template_part('head') ?>
<header id="home">
    <div id="header-cont">
        <div class="container">
            <span class="gCheck-logo">
                <a href="<?php echo site_url(); ?>" aria-label="GCheck">
                    <?php get_template_part('partials/gcheck-logo') ?>
                </a>
            </span>
            <?php get_template_part('partials/desktop-menu') ?>
        </div>
    </div>
    
    <?php get_template_part('partials/mobile-menu') ?>

    <div class="container">
        <div>
            <h1>
                Modern Background Checks
                Built on Compliance for Good™
            </h1>
            <div class="header-subtitle-container">
                <h5><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1.5C6.20156 1.5 1.5 6.20156 1.5 12C1.5 17.7984 6.20156 22.5 12 22.5C17.7984 22.5 22.5 17.7984 22.5 12C22.5 6.20156 17.7984 1.5 12 1.5ZM16.5352 8.57109L11.5992 15.4148C11.5302 15.5111 11.4393 15.5896 11.3339 15.6437C11.2286 15.6978 11.1118 15.7261 10.9934 15.7261C10.8749 15.7261 10.7582 15.6978 10.6528 15.6437C10.5474 15.5896 10.4565 15.5111 10.3875 15.4148L7.46484 11.3648C7.37578 11.2406 7.46484 11.0672 7.61719 11.0672H8.71641C8.95547 11.0672 9.18281 11.182 9.32344 11.3789L10.9922 13.6945L14.6766 8.58516C14.8172 8.39062 15.0422 8.27344 15.2836 8.27344H16.3828C16.5352 8.27344 16.6242 8.44688 16.5352 8.57109Z" fill="#5DC567"/>
                    </svg>
                    <span>Fast</span>
                </h5>
                <h5><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1.5C6.20156 1.5 1.5 6.20156 1.5 12C1.5 17.7984 6.20156 22.5 12 22.5C17.7984 22.5 22.5 17.7984 22.5 12C22.5 6.20156 17.7984 1.5 12 1.5ZM16.5352 8.57109L11.5992 15.4148C11.5302 15.5111 11.4393 15.5896 11.3339 15.6437C11.2286 15.6978 11.1118 15.7261 10.9934 15.7261C10.8749 15.7261 10.7582 15.6978 10.6528 15.6437C10.5474 15.5896 10.4565 15.5111 10.3875 15.4148L7.46484 11.3648C7.37578 11.2406 7.46484 11.0672 7.61719 11.0672H8.71641C8.95547 11.0672 9.18281 11.182 9.32344 11.3789L10.9922 13.6945L14.6766 8.58516C14.8172 8.39062 15.0422 8.27344 15.2836 8.27344H16.3828C16.5352 8.27344 16.6242 8.44688 16.5352 8.57109Z" fill="#5DC567"/>
                    </svg>
                    <span>Accurate</span>           
                    </h5>
                    <h5><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1.5C6.20156 1.5 1.5 6.20156 1.5 12C1.5 17.7984 6.20156 22.5 12 22.5C17.7984 22.5 22.5 17.7984 22.5 12C22.5 6.20156 17.7984 1.5 12 1.5ZM16.5352 8.57109L11.5992 15.4148C11.5302 15.5111 11.4393 15.5896 11.3339 15.6437C11.2286 15.6978 11.1118 15.7261 10.9934 15.7261C10.8749 15.7261 10.7582 15.6978 10.6528 15.6437C10.5474 15.5896 10.4565 15.5111 10.3875 15.4148L7.46484 11.3648C7.37578 11.2406 7.46484 11.0672 7.61719 11.0672H8.71641C8.95547 11.0672 9.18281 11.182 9.32344 11.3789L10.9922 13.6945L14.6766 8.58516C14.8172 8.39062 15.0422 8.27344 15.2836 8.27344H16.3828C16.5352 8.27344 16.6242 8.44688 16.5352 8.57109Z" fill="#5DC567"/>
                    </svg>
                    <span>Safe</span>
                    </h5>

            </div>
            <span class="buttons">
                <a href="<?php echo esc_url( home_url('/contact-us/') ); ?>" target="_parent" class="button blue">
                    Get Started Today
                </a>
                <a href="<?php echo esc_url( home_url('/pricing-packages/') ); ?>" target="_parent" class="button white">
                    Get Volume Pricing
                </a>
            </span>
        </div>
    </div>

    <!-- <div class="container screenshot">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/header-img2.png' ); ?>" alt="gceck" width="1080" height="638" loading="lazy" decoding="async">
    </div> -->
    
</header>


