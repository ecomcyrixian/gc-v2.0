<?php
/**
 * Template Part: Blog V2 Page Hero
 * Displays hero with title, category, intro text, and image.
 * All data from post: title, excerpt or SEO meta, first category, featured image.
 * Background from static asset.
 */

$hero_title_plain = wp_strip_all_tags( get_the_title() );

// Hero intro: only manual excerpt or SEO meta — never auto-generated excerpt from post content.
$hero_content = '';
if ( has_excerpt() ) {
    $hero_content = get_the_excerpt();
}
if ( empty( trim( $hero_content ) ) && function_exists( 'get_post_meta' ) ) {
    $post_id   = get_the_ID();
    $meta_desc = get_post_meta( $post_id, '_yoast_wpseo_metadesc', true );
    if ( ! empty( trim( $meta_desc ) ) ) {
        $hero_content = $meta_desc;
    }
    if ( empty( trim( $hero_content ) ) ) {
        $meta_desc = get_post_meta( $post_id, 'rank_math_description', true );
        if ( ! empty( trim( $meta_desc ) ) ) {
            $hero_content = $meta_desc;
        }
    }
}

$hero_bg_image_url = get_template_directory_uri() . '/assets/images/blog-card-bg.png';

$hero_image_url = null;
if ( has_post_thumbnail() ) {
    $hero_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
}
?>

<header class="blog-v2-hero<?php echo ! $hero_image_url ? ' blog-v2-hero--no-image' : ''; ?>" data-bg-image="<?php echo esc_url( $hero_bg_image_url ); ?>" style="--bg-image: url('<?php echo esc_url( $hero_bg_image_url ); ?>');">
    <div class="blog-v2-hero__content">
        <div class="blog-v2-hero__meta">
            <?php
            $categories = get_the_category();
            $category_name = '';
            if ( ! empty( $categories ) ) {
                $category_name = esc_html( $categories[0]->name );
            }
            ?>
            <?php if ( $category_name ) : ?>
                <span class="blog-v2-hero__category">
                    <?php echo $category_name; ?>
                </span>
            <?php endif; ?>
            <div class="blog-v2-hero__socials">
                <a href="<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Share">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.9999 11.6601V12.0001C25.0007 13.0662 24.576 14.0885 23.8199 14.84L20.9999 17.67C20.4738 18.1911 19.6261 18.1911 19.1 17.67L19 17.56C18.8094 17.3656 18.8094 17.0544 19 16.86L22.4399 13.4201C22.807 13.0394 23.0083 12.5288 22.9999 12.0001V11.6601C23.0003 11.127 22.788 10.6159 22.4099 10.2401L21.7599 9.59011C21.3841 9.21207 20.873 8.99969 20.3399 9.00011H19.9999C19.4669 8.99969 18.9558 9.21207 18.58 9.59011L15.14 13.0001C14.9456 13.1906 14.6344 13.1906 14.44 13.0001L14.33 12.8901C13.8089 12.3639 13.8089 11.5162 14.33 10.9901L17.16 8.15012C17.9165 7.40505 18.9382 6.99133 19.9999 7.00014H20.3399C21.4011 6.9993 22.4191 7.42018 23.1699 8.17012L23.8299 8.83012C24.5798 9.5809 25.0007 10.5989 24.9999 11.6601ZM12.6499 17.94L17.9399 12.6501C18.0338 12.5554 18.1616 12.5022 18.2949 12.5022C18.4282 12.5022 18.556 12.5554 18.6499 12.6501L19.3499 13.3501C19.4445 13.4439 19.4978 13.5717 19.4978 13.7051C19.4978 13.8384 19.4445 13.9662 19.3499 14.0601L14.0599 19.35C13.966 19.4447 13.8382 19.4979 13.7049 19.4979C13.5716 19.4979 13.4438 19.4447 13.3499 19.35L12.6499 18.65C12.5553 18.5561 12.502 18.4283 12.502 18.295C12.502 18.1617 12.5553 18.0339 12.6499 17.94ZM17.5599 19C17.3655 18.8094 17.0543 18.8094 16.8599 19L13.4299 22.41C13.0517 22.7905 12.5365 23.003 12 22.9999H11.66C11.1269 23.0004 10.6158 22.788 10.24 22.41L9.58997 21.76C9.21194 21.3842 8.99956 20.873 8.99998 20.34V20C8.99956 19.4669 9.21194 18.9558 9.58997 18.58L13.0099 15.14C13.2005 14.9456 13.2005 14.6345 13.0099 14.44L12.8999 14.33C12.3738 13.8089 11.5261 13.8089 11 14.33L8.17999 17.16C7.42392 17.9116 6.99916 18.9339 7 20V20.35C7.00182 21.4077 7.42249 22.4216 8.16999 23.1699L8.82998 23.8299C9.58076 24.5799 10.5988 25.0008 11.66 24.9999H12C13.0534 25.0061 14.0667 24.5964 14.8199 23.8599L17.6699 21.01C18.191 20.4838 18.191 19.6361 17.6699 19.11L17.5599 19Z" fill="#1A1C1E"/>
                    </svg>
                </a>
                <a href="https://www.linkedin.com/company/101063425/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7.24268C7.67157 7.24268 7 7.91425 7 8.74268V23.7427C7 24.5711 7.67157 25.2427 8.5 25.2427H23.5C24.3284 25.2427 25 24.5711 25 23.7427V8.74268C25 7.91425 24.3284 7.24268 23.5 7.24268H8.5ZM12.5208 11.2454C12.5264 12.2016 11.8106 12.7909 10.9612 12.7866C10.1611 12.7824 9.46357 12.1454 9.46779 11.2468C9.47201 10.4016 10.14 9.72243 11.0076 9.74212C11.8879 9.76181 12.5264 10.4073 12.5208 11.2454ZM16.2797 14.0044H13.7597H13.7583V22.5643H16.4217V22.3646C16.4217 21.9847 16.4214 21.6047 16.4211 21.2246C16.4203 20.2108 16.4194 19.1959 16.4246 18.1824C16.426 17.9363 16.4372 17.6804 16.5005 17.4455C16.7381 16.568 17.5271 16.0013 18.4074 16.1406C18.9727 16.2291 19.3467 16.5568 19.5042 17.0898C19.6013 17.423 19.6449 17.7816 19.6491 18.129C19.6605 19.1766 19.6589 20.2242 19.6573 21.2719C19.6567 21.6417 19.6561 22.0117 19.6561 22.3815V22.5629H22.328V22.3576C22.328 21.9056 22.3278 21.4537 22.3275 21.0018C22.327 19.8723 22.3264 18.7428 22.3294 17.6129C22.3308 17.1024 22.276 16.599 22.1508 16.1054C21.9638 15.3713 21.5771 14.7638 20.9485 14.3251C20.5027 14.0129 20.0133 13.8118 19.4663 13.7893C19.404 13.7867 19.3412 13.7833 19.2781 13.7799C18.9984 13.7648 18.7141 13.7494 18.4467 13.8033C17.6817 13.9566 17.0096 14.3068 16.5019 14.9241C16.4429 14.9949 16.3852 15.0668 16.2991 15.1741L16.2797 15.1984V14.0044ZM9.68164 22.5671H12.3324V14.01H9.68164V22.5671Z" fill="#1A1C1E"/>
                    </svg>
                </a>
                <a href="https://x.com/gcheckcom" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.1761 8.24268H23.9362L17.9061 15.0201L25 24.2427H19.4456L15.0951 18.6493L10.1172 24.2427H7.35544L13.8052 16.9935L7 8.24268H12.6954L16.6279 13.3553L21.1761 8.24268ZM20.2073 22.6181H21.7368L11.8644 9.78196H10.2232L20.2073 22.6181Z" fill="#1A1C1E"/>
                    </svg>
                </a>
                <a href="https://www.facebook.com/gcheckcom" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M26 16.3038C26 10.7472 21.5229 6.24268 16 6.24268C10.4771 6.24268 6 10.7472 6 16.3038C6 21.3255 9.65684 25.4879 14.4375 26.2427V19.2121H11.8984V16.3038H14.4375V14.0872C14.4375 11.5656 15.9305 10.1728 18.2146 10.1728C19.3088 10.1728 20.4531 10.3693 20.4531 10.3693V12.8453H19.1922C17.95 12.8453 17.5625 13.6209 17.5625 14.4166V16.3038H20.3359L19.8926 19.2121H17.5625V26.2427C22.3432 25.4879 26 21.3257 26 16.3038Z" fill="#1A1C1E"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="blog-v2-hero__title">
            <?php echo esc_html( $hero_title_plain ); ?>
        </div>
        <?php if ( ! empty( trim( $hero_content ) ) ) : ?>
            <div class="blog-v2-hero__intro">
                <?php echo wp_kses_post( wpautop( $hero_content ) ); ?>
            </div>
        <?php endif; ?>

        <div class="blog-hero-authors">
            <div class="written-by">
                <p>Created by</p>
                <div class="blog-hero-authors__author">
                    <?php
                    $creator = function_exists( 'blog_v2_author_display_data' ) ? blog_v2_author_display_data() : blog_v2_default_author();
                    $creator_avatar_url = ! empty( $creator['url'] ) ? $creator['url'] : '';
                    ?>
                    <?php if ( $creator_avatar_url ) : ?>
                        <img src="<?php echo esc_url( $creator_avatar_url ); ?>" alt="<?php echo esc_attr( $creator['name'] ); ?>">
                    <?php else : ?>
                        <div class="blog-hero-authors__initials" style="background-color:<?php echo esc_attr( isset( $creator['color'] ) ? $creator['color'] : '#6B7280' ); ?>"><?php echo esc_html( isset( $creator['initials'] ) ? $creator['initials'] : '' ); ?></div>
                    <?php endif; ?>
                    <div class="blog-hero-authors__author-info">
                        <strong><?php echo esc_html( $creator['name'] ); ?></strong>
                        <span><?php echo esc_html( $creator['job'] ); ?></span>
                    </div>
                </div>
            </div>
            <?php
            $reviewer = function_exists( 'blog_v2_reviewer_display_data' ) ? blog_v2_reviewer_display_data() : null;
            if ( $reviewer ) :
                if ( empty( $reviewer['avatar'] ) ) {
                    $reviewer['avatar'] = get_template_directory_uri() . '/assets/images/charm-paz.png';
                }
            ?>
            <div class="author-divider"></div>
            <div class="reviewed-by">
                <p>Reviewed by</p>
                <div class="blog-hero-authors__author">
                    <img src="<?php echo esc_url( $reviewer['avatar'] ); ?>" alt="<?php echo esc_attr( $reviewer['name'] ); ?>">
                    <div class="blog-hero-authors__author-info">
                        <strong><?php echo esc_html( $reviewer['name'] ); ?></strong>
                        <span><?php echo esc_html( $reviewer['job'] ); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ( $hero_image_url ) : ?>
        <div class="blog-v2-hero__media">
            <img src="<?php echo esc_url( $hero_image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="blog-v2-hero__image" />
        </div>
    <?php endif; ?>
</header>
