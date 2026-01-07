<?php
    $display_selection = get_sub_field('display_selection') === 'Show';
    $with_header       = get_sub_field('with_header') === 'Yes';

    $h2        = get_sub_field('h2');
    $H2details = get_sub_field('details');
    $columns   = get_sub_field('columns');

    $snippet = get_sub_field('snippet');
    $snippetSetting = str_replace(' ', '-', strtolower($snippet));

    $setting = get_sub_field('setting');
    $finalSetting = str_replace(' ', '-', strtolower($setting));

    $cards_clickable = strtolower(get_sub_field('make_cards_clickable')) === 'yes';
?>

<?php if ( $display_selection ) : ?>

<div class="cards <?= esc_attr($finalSetting); ?> <?= esc_attr($snippetSetting); ?>">
    <div class="container">

        <?php if ( $with_header ) : ?>
            <div class="heading">
                <h2>
                    <span><?= esc_html($snippet); ?></span>
                    <pre><?= esc_html($h2); ?></pre>
                </h2>
                <?= $H2details; ?>
            </div>
        <?php endif; ?>

        <div class="card-cont cols<?= esc_attr($columns); ?>">

            <?php if ( have_rows('cards') ) : ?>
                <?php while ( have_rows('cards') ) : the_row(); ?>

                    <?php
                        $h4      = get_sub_field('h4');
                        $details = get_sub_field('details');
                        $icon    = get_sub_field('svg_icon');

                        $link   = $cards_clickable ? get_sub_field('card_link') : null;
                        $url    = $link['url'] ?? '';
                        $target = $link['target'] ?? '_self';
                    ?>

                    <?php if ( $cards_clickable && $url ) : ?>
                        <a href="<?= esc_url($url); ?>" target="<?= esc_attr($target); ?>" class="card-link">
                    <?php endif; ?>

                        <div class="card-item">
                            <h4>
                                <span><?= $h4; ?></span>
                                <span><?= $icon; ?></span>
                            </h4>
                            <?= $details; ?>
                        </div>

                    <?php if ( $cards_clickable && $url ) : ?>
                        </a>
                    <?php endif; ?>

                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php endif; ?>
