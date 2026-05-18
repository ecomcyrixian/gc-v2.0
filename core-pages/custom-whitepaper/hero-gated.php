<div class="custom-whitepaper-hero__row custom-whitepaper-hero__row--gated">
	<div class="custom-whitepaper-hero__content">
		<div class="custom-whitepaper-hero__content-inner">
			<?php if ( $snippet ) : ?>
				<span class="custom-whitepaper-hero__snippet"><?php echo esc_html( $snippet ); ?></span>
			<?php endif; ?>
			<?php if ( $details ) : ?>
				<div class="custom-whitepaper-hero__details"><?php echo wp_kses_post( do_shortcode( $details ) ); ?></div>
			<?php endif; ?>
		</div>
		<?php if ( $hero_img_url ) : ?>
			<div class="custom-whitepaper-hero__image-below">
				<img fetchpriority="high" src="<?php echo esc_url( $hero_img_url ); ?>" alt="" <?php echo $cwp_hero_dim_attrs; ?>loading="eager" decoding="async">
			</div>
		<?php endif; ?>
	</div>
	<div class="custom-whitepaper-hero__form" id="gcheck-pdf-request-form" tabindex="-1">
		<?php
		if ( function_exists( 'gc_render_post_pdf_request_form_in_hero' ) ) {
			gc_render_post_pdf_request_form_in_hero();
		}
		?>
	</div>
</div>
