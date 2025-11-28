<?php
    $alignment = get_sub_field('alignment');
    $ImageAlignment = get_sub_field('image_alignment');
    $logos = get_sub_field('logos');
    $h1 = get_sub_field('h1');
    $snippet = get_sub_field('snippet');
    $strong_p = get_sub_field('strong_p');
    $details = get_sub_field('details');
    $image = get_sub_field('image');

?>
<section class="cols cols2 <?= $ImageAlignment ?>">
    
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
    <div>
        <img src="<?= $image ?>" alt="<?= $h1 ?>">
    </div>
</section>