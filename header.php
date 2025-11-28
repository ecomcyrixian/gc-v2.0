<?php get_template_part('head') ?>
<header id="typical">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
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
</header>