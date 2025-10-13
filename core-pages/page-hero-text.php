<?php
    $alignment = get_sub_field('alignment');
    $logos = get_sub_field('logos');
    $h1 = get_sub_field('h1');
    $snippet = get_sub_field('snippet');
    $strong_p = get_sub_field('strong_p');
    $details = get_sub_field('details');    
?>

<section class="text-only">
    <div>
        <span class="logos <?= $alignment ?> ">
                <?= $logos ?>
        </span>
        <div class="heading">
            <h2>
                <span><?= $snippet ?></span>
                <pre><?= $h1 ?></pre></h2>
            </h2>
        </div>
        <p><strong><?= $strong_p ?></strong></p>
        <p> <?= $details ?></p>
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
        <?php if( have_rows('value_props') ): ?>                
            <ul class="value-props">
            <?php while( have_rows('value_props') ) : the_row(); ?>
                <?php
                    $value_prop = get_sub_field('value_prop');                    
                ?>               
                <li>
                    <span class="icon">
                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 1.25C5.66797 1.25 1.75 5.16797 1.75 10C1.75 14.832 5.66797 18.75 10.5 18.75C15.332 18.75 19.25 14.832 19.25 10C19.25 5.16797 15.332 1.25 10.5 1.25ZM14.2793 7.14258L10.166 12.8457C10.1085 12.9259 10.0327 12.9913 9.94493 13.0364C9.85713 13.0815 9.75984 13.1051 9.66113 13.1051C9.56242 13.1051 9.46513 13.0815 9.37733 13.0364C9.28953 12.9913 9.21374 12.9259 9.15625 12.8457L6.7207 9.4707C6.64648 9.36719 6.7207 9.22266 6.84766 9.22266H7.76367C7.96289 9.22266 8.15234 9.31836 8.26953 9.48242L9.66016 11.4121L12.7305 7.1543C12.8477 6.99219 13.0352 6.89453 13.2363 6.89453H14.1523C14.2793 6.89453 14.3535 7.03906 14.2793 7.14258V7.14258Z" fill="#5DC567"/></svg>
                    </span>
                    <?= $value_prop ?>
                </li>
                
            <?php endwhile; ?>
            </ul>
        <?php endif; ?>

        </span>
    </div>    
</section>