<div class="custom-whitepaper-hero__row custom-whitepaper-hero__row--ungated">
	<div class="custom-whitepaper-hero__content">
		<div class="custom-whitepaper-hero__content-inner">
			<?php if ( $snippet ) : ?>
				<span class="custom-whitepaper-hero__snippet"><?php echo esc_html( $snippet ); ?></span>
			<?php endif; ?>
			<?php if ( $details ) : ?>
				<div class="custom-whitepaper-hero__details"><?php echo wp_kses_post( do_shortcode( $details ) ); ?></div>
			<?php endif; ?>
		</div>
		<?php if ( have_rows( 'cta' ) ) : ?>
			<div class="custom-whitepaper-hero__btns">
				<?php
				while ( have_rows( 'cta' ) ) :
					the_row();
					$button = get_sub_field( 'button' );
					if ( empty( $button['url'] ) ) {
						continue;
					}
					$original_url = $button['url'];
					$registry_key = function_exists( 'gc_secure_pdf_registry_key_for_url' ) ? gc_secure_pdf_registry_key_for_url( $original_url ) : '';
					$viewer_url   = ( $registry_key !== '' && function_exists( 'gc_secure_pdf_view_url' ) )
						? gc_secure_pdf_view_url( $registry_key, get_permalink() )
						: '';
					$link_url     = $viewer_url !== '' ? $viewer_url : $original_url;
					$link_title   = $button['title'] ?: __( 'Download the Report', 'gc-v2' );
					$is_pdf_link  = ( false !== stripos( (string) $original_url, '.pdf' ) );
					$link_target  = ! empty( $button['target'] ) ? $button['target'] : '_self';
					?>
					<a class="button blue custom-whitepaper-hero__cta<?php echo $viewer_url !== '' ? ' custom-whitepaper-hero__download-pdf-blob' : ''; ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"<?php echo ( $is_pdf_link && $viewer_url === '' ) ? ' download' : ''; ?><?php echo ( $registry_key !== '' && function_exists( 'gc_secure_pdf_download_data_attrs' ) ) ? gc_secure_pdf_download_data_attrs( $registry_key ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( $link_title ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<?php
			$trust_view_url = function_exists( 'gc_secure_pdf_view_url' ) && function_exists( 'gc_secure_pdf_primary_trust_report_key' )
				? gc_secure_pdf_view_url( gc_secure_pdf_primary_trust_report_key(), get_permalink() )
				: '';
			?>
			<div class="custom-whitepaper-hero__btns">
				<a
					class="button blue trust-gap-report-hero__cta custom-whitepaper-hero__download-pdf-blob"
					style="margin: 0;"
					href="<?php echo esc_url( $trust_view_url ); ?>"
					aria-label="<?php esc_attr_e( 'Download the Report', 'gc-v2' ); ?>"
					<?php
					if ( $trust_view_url !== '' && function_exists( 'gc_secure_pdf_download_data_attrs' ) && function_exists( 'gc_secure_pdf_primary_trust_report_key' ) ) {
						echo gc_secure_pdf_download_data_attrs( gc_secure_pdf_primary_trust_report_key() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				>
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M9.87695 12.9102C9.89157 12.9288 9.91024 12.9439 9.93156 12.9543C9.95288 12.9647 9.97629 12.9701 10 12.9701C10.0237 12.9701 10.0471 12.9647 10.0684 12.9543C10.0898 12.9439 10.1084 12.9288 10.123 12.9102L12.3105 10.1426C12.3906 10.041 12.3184 9.89062 12.1875 9.89062H10.7402V3.28125C10.7402 3.19531 10.6699 3.125 10.584 3.125H9.41211C9.32617 3.125 9.25586 3.19531 9.25586 3.28125V9.88867H7.8125C7.68164 9.88867 7.60938 10.0391 7.68945 10.1406L9.87695 12.9102ZM17.1484 12.2266H15.9766C15.8906 12.2266 15.8203 12.2969 15.8203 12.3828V15.3906H4.17969V12.3828C4.17969 12.2969 4.10938 12.2266 4.02344 12.2266H2.85156C2.76562 12.2266 2.69531 12.2969 2.69531 12.3828V16.25C2.69531 16.5957 2.97461 16.875 3.32031 16.875H16.6797C17.0254 16.875 17.3047 16.5957 17.3047 16.25V12.3828C17.3047 12.2969 17.2344 12.2266 17.1484 12.2266Z" fill="white"/>
					</svg>
					<?php esc_html_e( 'Download the Report', 'gc-v2' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( $hero_img_url ) : ?>
		<div>
			<img fetchpriority="high" src="<?php echo esc_url( $hero_img_url ); ?>" alt="" <?php echo $cwp_hero_dim_attrs; ?>loading="eager" decoding="async">
		</div>
	<?php endif; ?>
</div>
