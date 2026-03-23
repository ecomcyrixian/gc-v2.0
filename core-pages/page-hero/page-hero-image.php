<?php
    $alignment = get_sub_field('alignment');
    $ImageAlignment = get_sub_field('image_alignment');
    $logos = get_sub_field('logos');
    $h1 = get_sub_field('h1');
    $snippet = get_sub_field('snippet');
    $strong_p = get_sub_field('strong_p');
    $details = get_sub_field('details');
    $image = get_sub_field('image');

    $hero_img_url = is_array( $image ) ? ( $image['url'] ?? '' ) : $image;

    $hero_img_dim_attrs = function_exists( 'gc_theme_img_dimension_attrs' ) ? gc_theme_img_dimension_attrs( $image ) : '';

    $image_on_top = strtolower( (string) $ImageAlignment ) === 'top';
    $section_class = 'cols cols2 ' . esc_attr( $ImageAlignment );
?>
<section class="<?= $section_class ?>">
    <?php if ( $image_on_top ) : ?>
    <div class="page-hero__image-wrap">
        <img src="<?= esc_url( $hero_img_url ) ?>" alt="<?= esc_attr( $h1 ) ?>" <?php echo $hero_img_dim_attrs; ?>decoding="async" fetchpriority="high">
    </div>
    <?php endif; ?>
    <div>
            <span class="logos <?= $alignment ?> ">
            <?= $logos ?>
            </span>
            <?= $details ?>
            <span>
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

        </span>
    </div>
    <?php if ( ! $image_on_top ) : ?>
    <div>
        <div class="page-hero__image-wrap">
            <img src="<?= esc_url( $hero_img_url ) ?>" alt="<?= esc_attr( $h1 ) ?>" <?php echo $hero_img_dim_attrs; ?>decoding="async" fetchpriority="high">
        </div>
    </div>
    <?php endif; ?>
</section>