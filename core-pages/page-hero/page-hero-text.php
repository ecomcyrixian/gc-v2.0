<?php
    $alignment = get_sub_field('alignment');
    $logos = get_sub_field('logos');
    $h1 = get_sub_field('h1');
    $snippet = get_sub_field('snippet');
    $strong_p = get_sub_field('strong_p');
    $details = get_sub_field('details');
    $is_management_hero = is_string($details) && strpos($details, 'management-hero-frame') !== false;
    $management_bg_asset = get_template_directory_uri() . '/assets/images/page-hero-bg-management-page.webp';
    $management_bg_path = get_template_directory() . '/assets/images/page-hero-bg-management-page.webp';
    $management_bg_dim_attrs = '';
    if ($is_management_hero && function_exists('getimagesize') && file_exists($management_bg_path)) {
        $management_bg_size = getimagesize($management_bg_path);
        if (!empty($management_bg_size[0]) && !empty($management_bg_size[1])) {
            $management_bg_dim_attrs = ' width="' . esc_attr((string) $management_bg_size[0]) . '" height="' . esc_attr((string) $management_bg_size[1]) . '"';
        }
    }
    $section_classes = 'text-only' . ($is_management_hero ? ' text-only--management-team' : '');
?>

<section class="<?= esc_attr($section_classes); ?>">
    <?php if ($is_management_hero) : ?>
        <img class="text-only--management-team__bg" src="<?= esc_url($management_bg_asset); ?>" alt=""<?= $management_bg_dim_attrs; ?> loading="eager" decoding="async" fetchpriority="high" aria-hidden="true">
    <?php endif; ?>
    <div>
        <span class="logos <?= $alignment ?> ">
                <?= $logos ?>
        </span>
        <div class="heading">
            
        </div>
        <?= $details ?>
        
        <div class="btns">
        <?php if( have_rows('cta') ): ?>                
            <?php while( have_rows('cta') ) : the_row(); ?>
                <?php
                    $button = get_sub_field('button');
                    $link_url = $button['url'];
                    $link_title = $button['title'];
                    $link_target = $button['target'] ? $button['target'] : '_self';
                ?>
                <a class="button blue" href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $link_target ); ?>" aria-label="<?= esc_attr( $link_title ); ?>">
                    <?= esc_attr( $link_title ); ?>
                </a>                
            <?php endwhile; ?>
        <?php endif; ?>        
        </div>

    </div>    
</section>