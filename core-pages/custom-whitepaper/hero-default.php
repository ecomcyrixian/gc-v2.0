<?php
$default_no_image = ! $hero_img_url;
$cwp_has_cta      = true;
$cwp_has_image    = (bool) $hero_img_url;
$cwp_access       = $cwp_has_image ? 'gated' : 'ungated';
$cwp_align        = $cwp_has_image ? 'left' : 'center';
$cwp_image_class  = $cwp_has_image ? 'has-image' : 'no-image';
$cwp_pdf_ungated  = ( 'ungated' === $cwp_access );
$cwp_btn_href     = $cwp_pdf_ungated ? '#' : '#gcheck-pdf-request-form';
$cwp_page_url     = get_permalink();
$cwp_page_title   = wp_strip_all_tags( get_the_title() );
$cwp_share_url    = rawurlencode( $cwp_page_url );
$cwp_share_title  = rawurlencode( $cwp_page_title );
$cwp_mailto_href  = 'mailto:?subject=' . rawurlencode( $cwp_page_title ) . '&body=' . rawurlencode( $cwp_page_url );

if ( empty( $cwp_pdf_registry_key ) ) {
	$cwp_pdf_registry_key = function_exists( 'gc_secure_pdf_primary_trust_report_key' )
		? gc_secure_pdf_primary_trust_report_key()
		: 'trust_in_hiring_report_2026';
}

$cwp_pdf_view_url = isset( $cwp_pdf_view_url ) ? (string) $cwp_pdf_view_url : '';
if ( $cwp_pdf_view_url === '' && function_exists( 'gc_secure_pdf_view_url' ) ) {
	$cwp_pdf_view_url = gc_secure_pdf_view_url( $cwp_pdf_registry_key, get_permalink() );
}
$cwp_pdf_use_viewer = $cwp_pdf_ungated && $cwp_pdf_view_url !== '';
if ( $cwp_pdf_use_viewer ) {
	$cwp_btn_href = $cwp_pdf_view_url;
}

$cwp_trust_parts = array(
	'custom-whitepaper-hero__trust-gap',
	$cwp_image_class,
	$cwp_align,
	$cwp_access,
);
if ( $cwp_has_cta ) {
	$cwp_trust_parts[] = 'has-cta';
}
$cwp_trust_gap_classes = implode( ' ', $cwp_trust_parts );
?>
<div class="custom-whitepaper-hero__row custom-whitepaper-hero__row--default<?php echo $default_no_image ? ' custom-whitepaper-hero__row--no-image' : ''; ?>">
	<div class="custom-whitepaper-hero__content">
		<div class="custom-whitepaper-hero__content-inner">
			<?php if ( $snippet ) : ?>
				<span class="custom-whitepaper-hero__snippet"><?php echo esc_html( $snippet ); ?></span>
			<?php endif; ?>
			<?php if ( $details ) : ?>
				<div class="custom-whitepaper-hero__details"><?php echo wp_kses_post( do_shortcode( $details ) ); ?></div>
			<?php endif; ?>

			<div class="<?php echo esc_attr( $cwp_trust_gap_classes ); ?>">
				<?php if ( $cwp_has_cta ) : ?>
					<div class="custom-whitepaper-hero__trust-gap-cta">
						<a href="<?php echo esc_url( $cwp_btn_href ); ?>" class="button blue trust-gap-report-hero__cta<?php echo $cwp_pdf_use_viewer ? ' custom-whitepaper-hero__trust-gap-download--ungated custom-whitepaper-hero__download-pdf-blob' : ( $cwp_pdf_ungated ? ' custom-whitepaper-hero__trust-gap-download--ungated' : ' custom-whitepaper-hero__trust-gap-download--gated' ); ?>" aria-label="<?php esc_attr_e( 'Download the Report', 'gc-v2' ); ?>"<?php echo ( $cwp_pdf_use_viewer && function_exists( 'gc_secure_pdf_download_data_attrs' ) ) ? gc_secure_pdf_download_data_attrs( $cwp_pdf_registry_key ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M9.87695 12.9102C9.89157 12.9288 9.91024 12.9439 9.93156 12.9543C9.95288 12.9647 9.97629 12.9701 10 12.9701C10.0237 12.9701 10.0471 12.9647 10.0684 12.9543C10.0898 12.9439 10.1084 12.9288 10.123 12.9102L12.3105 10.1426C12.3906 10.041 12.3184 9.89062 12.1875 9.89062H10.7402V3.28125C10.7402 3.19531 10.6699 3.125 10.584 3.125H9.41211C9.32617 3.125 9.25586 3.19531 9.25586 3.28125V9.88867H7.8125C7.68164 9.88867 7.60938 10.0391 7.68945 10.1406L9.87695 12.9102ZM17.1484 12.2266H15.9766C15.8906 12.2266 15.8203 12.2969 15.8203 12.3828V15.3906H4.17969V12.3828C4.17969 12.2969 4.10938 12.2266 4.02344 12.2266H2.85156C2.76562 12.2266 2.69531 12.2969 2.69531 12.3828V16.25C2.69531 16.5957 2.97461 16.875 3.32031 16.875H16.6797C17.0254 16.875 17.3047 16.5957 17.3047 16.25V12.3828C17.3047 12.2969 17.2344 12.2266 17.1484 12.2266Z" fill="white"/>
							</svg>
							<?php esc_html_e( 'Download the Report', 'gc-v2' ); ?>
						</a>
						<div class="trust-gap-cta__row">
							<p class="trust-gap-cta__intro"><strong><?php esc_html_e( 'Found this useful?', 'gc-v2' ); ?></strong> <?php esc_html_e( 'Share it with your team', 'gc-v2' ); ?></p>
							<div class="trust-gap-cta__socials">
								<a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $cwp_share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'gc-v2' ); ?>" title="<?php esc_attr_e( 'Share on LinkedIn', 'gc-v2' ); ?>">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7.24268C7.67157 7.24268 7 7.91425 7 8.74268V23.7427C7 24.5711 7.67157 25.2427 8.5 25.2427H23.5C24.3284 25.2427 25 24.5711 25 23.7427V8.74268C25 7.91425 24.3284 7.24268 23.5 7.24268H8.5ZM12.5208 11.2454C12.5264 12.2016 11.8106 12.7909 10.9612 12.7866C10.1611 12.7824 9.46357 12.1454 9.46779 11.2468C9.47201 10.4016 10.14 9.72243 11.0076 9.74212C11.8879 9.76181 12.5264 10.4073 12.5208 11.2454ZM16.2797 14.0044H13.7597H13.7583V22.5643H16.4217V22.3646C16.4217 21.9847 16.4214 21.6047 16.4211 21.2246C16.4203 20.2108 16.4194 19.1959 16.4246 18.1824C16.426 17.9363 16.4372 17.6804 16.5005 17.4455C16.7381 16.568 17.5271 16.0013 18.4074 16.1406C18.9727 16.2291 19.3467 16.5568 19.5042 17.0898C19.6013 17.423 19.6449 17.7816 19.6491 18.129C19.6605 19.1766 19.6589 20.2242 19.6573 21.2719C19.6567 21.6417 19.6561 22.0117 19.6561 22.3815V22.5629H22.328V22.3576C22.328 21.9056 22.3278 21.4537 22.3275 21.0018C22.327 19.8723 22.3264 18.7428 22.3294 17.6129C22.3308 17.1024 22.276 16.599 22.1508 16.1054C21.9638 15.3713 21.5771 14.7638 20.9485 14.3251C20.5027 14.0129 20.0133 13.8118 19.4663 13.7893C19.404 13.7867 19.3412 13.7833 19.2781 13.7799C18.9984 13.7648 18.7141 13.7494 18.4467 13.8033C17.6817 13.9566 17.0096 14.3068 16.5019 14.9241C16.4429 14.9949 16.3852 15.0668 16.2991 15.1741L16.2797 15.1984V14.0044ZM9.68164 22.5671H12.3324V14.01H9.68164V22.5671Z" fill="#1A1C1E"/>
									</svg>
								</a>
								<a href="<?php echo esc_url( 'https://x.com/intent/post?url=' . $cwp_share_url . '&text=' . $cwp_share_title ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on X', 'gc-v2' ); ?>" title="<?php esc_attr_e( 'Share on X', 'gc-v2' ); ?>">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M21.1761 8.24268H23.9362L17.9061 15.0201L25 24.2427H19.4456L15.0951 18.6493L10.1172 24.2427H7.35544L13.8052 16.9935L7 8.24268H12.6954L16.6279 13.3553L21.1761 8.24268ZM20.2073 22.6181H21.7368L11.8644 9.78196H10.2232L20.2073 22.6181Z" fill="#1A1C1E"/>
									</svg>
								</a>
								<a href="#" class="blog-v2-hero__copy-link" data-url="<?php echo esc_url( $cwp_page_url ); ?>" data-title="<?php echo esc_attr( $cwp_page_title ); ?>" aria-label="<?php esc_attr_e( 'Copy link', 'gc-v2' ); ?>" title="<?php esc_attr_e( 'Copy link', 'gc-v2' ); ?>">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M24.9999 11.6601V12.0001C25.0007 13.0662 24.576 14.0885 23.8199 14.84L20.9999 17.67C20.4738 18.1911 19.6261 18.1911 19.1 17.67L19 17.56C18.8094 17.3656 18.8094 17.0544 19 16.86L22.4399 13.4201C22.807 13.0394 23.0083 12.5288 22.9999 12.0001V11.6601C23.0003 11.127 22.788 10.6159 22.4099 10.2401L21.7599 9.59011C21.3841 9.21207 20.873 8.99969 20.3399 9.00011H19.9999C19.4669 8.99969 18.9558 9.21207 18.58 9.59011L15.14 13.0001C14.9456 13.1906 14.6344 13.1906 14.44 13.0001L14.33 12.8901C13.8089 12.3639 13.8089 11.5162 14.33 10.9901L17.16 8.15012C17.9165 7.40505 18.9382 6.99133 19.9999 7.00014H20.3399C21.4011 6.9993 22.4191 7.42018 23.1699 8.17012L23.8299 8.83012C24.5798 9.5809 25.0007 10.5989 24.9999 11.6601ZM12.6499 17.94L17.9399 12.6501C18.0338 12.5554 18.1616 12.5022 18.2949 12.5022C18.4282 12.5022 18.556 12.5554 18.6499 12.6501L19.3499 13.3501C19.4445 13.4439 19.4978 13.5717 19.4978 13.7051C19.4978 13.8384 19.4445 13.9662 19.3499 14.0601L14.0599 19.35C13.966 19.4447 13.8382 19.4979 13.7049 19.4979C13.5716 19.4979 13.4438 19.4447 13.3499 19.35L12.6499 18.65C12.5553 18.5561 12.502 18.4283 12.502 18.295C12.502 18.1617 12.5553 18.0339 12.6499 17.94ZM17.5599 19C17.3655 18.8094 17.0543 18.8094 16.8599 19L13.4299 22.41C13.0517 22.7905 12.5365 23.003 12 22.9999H11.66C11.1269 23.0004 10.6158 22.788 10.24 22.41L9.58997 21.76C9.21194 21.3842 8.99956 20.873 8.99998 20.34V20C8.99956 19.4669 9.21194 18.9558 9.58997 18.58L13.0099 15.14C13.2005 14.9456 13.2005 14.6345 13.0099 14.44L12.8999 14.33C12.3738 13.8089 11.5261 13.8089 11 14.33L8.17999 17.16C7.42392 17.9116 6.99916 18.9339 7 20V20.35C7.00182 21.4077 7.42249 22.4216 8.16999 23.1699L8.82998 23.8299C9.58076 24.5799 10.5988 25.0008 11.66 24.9999H12C13.0534 25.0061 14.0667 24.5964 14.8199 23.8599L17.6699 21.01C18.191 20.4838 18.191 19.6361 17.6699 19.11L17.5599 19Z" fill="#1A1C1E"/>
									</svg>
								</a>
								<a href="<?php echo esc_url( $cwp_mailto_href ); ?>" aria-label="<?php esc_attr_e( 'Share by email', 'gc-v2' ); ?>" title="<?php esc_attr_e( 'Share by email', 'gc-v2' ); ?>">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M25.75 7.75H6.25C5.83516 7.75 5.5 8.08516 5.5 8.5V23.5C5.5 23.9148 5.83516 24.25 6.25 24.25H25.75C26.1648 24.25 26.5 23.9148 26.5 23.5V8.5C26.5 8.08516 26.1648 7.75 25.75 7.75ZM23.8563 10.3023L16.4617 16.0563C16.2789 16.1992 16.0234 16.1992 15.8406 16.0563L8.44375 10.3023C8.41587 10.2808 8.39541 10.2511 8.38526 10.2174C8.37511 10.1837 8.37576 10.1476 8.38713 10.1143C8.3985 10.0809 8.42002 10.052 8.44867 10.0315C8.47731 10.011 8.51165 9.99999 8.54688 10H23.7531C23.7883 9.99999 23.8227 10.011 23.8513 10.0315C23.88 10.052 23.9015 10.0809 23.9129 10.1143C23.9242 10.1476 23.9249 10.1837 23.9147 10.2174C23.9046 10.2511 23.8841 10.2808 23.8563 10.3023Z" fill="#1A1C1E"/>
									</svg>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if ( $hero_img_url ) : ?>
		<div class="custom-whitepaper-hero__image">
			<img fetchpriority="high" src="<?php echo esc_url( $hero_img_url ); ?>" alt="" <?php echo $cwp_hero_dim_attrs; ?>loading="eager" decoding="async" />
		</div>
	<?php endif; ?>
</div>
