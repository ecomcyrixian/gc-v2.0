<?php
    $alignment = get_sub_field('alignment');
    $logos = get_sub_field('logos');
    $h1 = get_sub_field('h1');
    $snippet = get_sub_field('snippet');
    $strong_p = get_sub_field('strong_p');
    $details = get_sub_field('details');
    $is_management_hero = is_string($details) && strpos($details, 'management-hero-frame') !== false;
    $management_bg_asset = get_template_directory_uri() . '/assets/images/page-hero-bg-management-page.webp';
    $section_classes = 'text-only' . ($is_management_hero ? ' text-only--management-team' : '');
    $section_style = $is_management_hero ? 'background-image: url(' . esc_url($management_bg_asset) . ');' : '';
?>

<section class="<?= esc_attr($section_classes); ?>"<?= $section_style ? ' style="' . esc_attr($section_style) . '"' : ''; ?>>
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