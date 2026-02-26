<?php
/**
 * Template Part: Blog V2 Left Sidebar
 * In This Article (TOC) and hardcoded CTA card. No ACF; no card.php.
 */
?>

<?php
$toc_items = function_exists( 'blog_v2_get_toc_items' ) ? blog_v2_get_toc_items( get_the_ID() ) : array();
?>
<aside class="blog-v2-sidebar blog-v2-sidebar__container">
    <div class="blog-v2-sidebar--left">
        <div class="blog-v2-sidebar--left__container">
            <div class="blog-v2-sidebar--left__header">
                <h2 class="blog-v2-sidebar--left__heading">
                    <span>In This Article</span>
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.375 4.40234H19.1188C17.7762 4.40234 16.4637 4.78789 15.3344 5.51524L14 6.37109L12.6656 5.51524C11.5375 4.78803 10.2235 4.40163 8.88125 4.40234H2.625C2.14102 4.40234 1.75 4.79336 1.75 5.27734V20.8086C1.75 21.2926 2.14102 21.6836 2.625 21.6836H8.88125C10.2238 21.6836 11.5363 22.0691 12.6656 22.7965L13.8797 23.5785C13.9152 23.6004 13.9563 23.6141 13.9973 23.6141C14.0383 23.6141 14.0793 23.6031 14.1148 23.5785L15.3289 22.7965C16.4609 22.0691 17.7762 21.6836 19.1188 21.6836H25.375C25.859 21.6836 26.25 21.2926 26.25 20.8086V5.27734C26.25 4.79336 25.859 4.40234 25.375 4.40234ZM8.88125 19.7148H3.71875V6.37109H8.88125C9.84922 6.37109 10.7898 6.64727 11.602 7.16953L12.9363 8.02539L13.125 8.14844V20.7813C11.8234 20.0813 10.3688 19.7148 8.88125 19.7148ZM24.2813 19.7148H19.1188C17.6313 19.7148 16.1766 20.0813 14.875 20.7813V8.14844L15.0637 8.02539L16.398 7.16953C17.2102 6.64727 18.1508 6.37109 19.1188 6.37109H24.2813V19.7148ZM10.8527 9.8711H5.77227C5.66563 9.8711 5.57813 9.96406 5.57813 10.0762V11.3066C5.57813 11.4188 5.66563 11.5117 5.77227 11.5117H10.85C10.9566 11.5117 11.0441 11.4188 11.0441 11.3066V10.0762C11.0469 9.96406 10.9594 9.8711 10.8527 9.8711ZM16.9531 10.0762V11.3066C16.9531 11.4188 17.0406 11.5117 17.1473 11.5117H22.225C22.3316 11.5117 22.4191 11.4188 22.4191 11.3066V10.0762C22.4191 9.96406 22.3316 9.8711 22.225 9.8711H17.1473C17.0406 9.8711 16.9531 9.96406 16.9531 10.0762ZM10.8527 13.6992H5.77227C5.66563 13.6992 5.57813 13.7922 5.57813 13.9043V15.1348C5.57813 15.2469 5.66563 15.3398 5.77227 15.3398H10.85C10.9566 15.3398 11.0441 15.2469 11.0441 15.1348V13.9043C11.0469 13.7922 10.9594 13.6992 10.8527 13.6992ZM22.2277 13.6992H17.1473C17.0406 13.6992 16.9531 13.7922 16.9531 13.9043V15.1348C16.9531 15.2469 17.0406 15.3398 17.1473 15.3398H22.225C22.3316 15.3398 22.4191 15.2469 22.4191 15.1348V13.9043C22.4219 13.7922 22.3344 13.6992 22.2277 13.6992Z" fill="#777E8C"/>
                    </svg>
                </h2>
                <div class="blog-v2-sidebar--left__divider"></div>
            </div>
            <div class="blog-v2-sidebar--left__toc-scroll">
                <nav class="blog-v2-toc<?php echo empty( $toc_items ) ? ' blog-v2-toc--empty' : ''; ?>" aria-label="Table of Contents">
                    <ul class="blog-v2-toc__list" id="blog-v2-toc-list">
                        <?php
                        foreach ( $toc_items as $item ) :
                            $id    = isset( $item['id'] ) ? $item['id'] : '';
                            $label = isset( $item['label'] ) ? $item['label'] : '';
                            if ( $id === '' ) {
                                continue;
                            }
                            ?>
                            <li class="blog-v2-toc__item blog-v2-toc__item--level-2">
                                <a href="#<?php echo esc_attr( $id ); ?>" class="blog-v2-toc__link blog-v2-toc__link--level-2"><?php echo esc_html( $label ); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="blog-v2-cards-container">
        <div class="blog-v2-card">
            <?php
            $blog_card_bg_png = get_template_directory_uri() . '/assets/images/blog-card-bg.png';
            $blog_card_bg_webp = get_template_directory() . '/assets/images/blog-card-bg.webp';
            $blog_card_bg_webp_url = file_exists( $blog_card_bg_webp ) ? get_template_directory_uri() . '/assets/images/blog-card-bg.webp' : '';
            ?>
            <?php if ( $blog_card_bg_webp_url ) : ?>
            <picture>
                <source type="image/webp" srcset="<?php echo esc_url( $blog_card_bg_webp_url ); ?>">
                <img src="<?php echo esc_url( $blog_card_bg_png ); ?>" alt="" class="blog-v2-card__bg-image" width="288" height="200" loading="lazy" decoding="async">
            </picture>
            <?php else : ?>
            <img src="<?php echo esc_url( $blog_card_bg_png ); ?>" alt="" class="blog-v2-card__bg-image" width="288" height="200" loading="lazy" decoding="async">
            <?php endif; ?>
            <div class="blog-v2-card__content">
                <div class="blog-v2-card__heading-prefix">Hire with Confidence</div>
                <h3 class="blog-v2-card__heading">Stay Compliant.</h3>
                <div class="blog-v2-card__details">The only FCRA compliance platform that gives you instant, job-specific guidance for every hire across all 50 states.</div>
                <a href="https://compliance.gcheck.com/?_gl=1*1pp1g4c*_gcl_au*MjAyMzgwMzQ1NC4xNzY1ODgxNTAx*_ga*ODA0NjI3MjYuMTc2NTg4MTUwMQ..*_ga_JHFG7MMVGL*czE3Njk3NTYxNzMkbzczJGcwJHQxNzY5NzU2MTczJGo2MCRsMCRoMA.." class="blog-v2-card__btn">Check Compliance Now</a>
            </div>
        </div>
    </div>
</aside>
