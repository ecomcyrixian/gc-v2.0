<?php get_template_part('head') ?>
<header id="typical">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <div id="header-cont">
        <div class="container">
            <span class="gCheck-logo">
                <a href="<?php echo site_url(); ?>" aria-label="GCheck">
                    <img class="gCheck-logo__img gCheck-logo__img--dark" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/gcheck-black-logo-new.svg' ); ?>" alt="GCheck Logo" width="216" height="37">
                    <img class="gCheck-logo__img gCheck-logo__img--light" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/gcheck-white-logo-new.svg' ); ?>" alt="" width="216" height="37">
                </a>
            </span>
            <?php get_template_part('partials/desktop-menu') ?>
        </div>
    </div>    
    <?php get_template_part('partials/mobile-menu') ?>
</header>