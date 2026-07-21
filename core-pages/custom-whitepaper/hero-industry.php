<?php
/**
 * Custom Whitepaper Hero — Industry (standard + industry-row list layout).
 *
 * Expects from hero.php: $snippet, $details, $hero_img_url, $cwp_hero_dim_attrs, $is_industry_row.
 */

$cwp_render_industry_cards = static function ( $cards_class = '' ) {
	if ( ! have_rows( 'cards' ) ) {
		return;
	}
	?>
	<div class="custom-whitepaper-hero__cards<?php echo esc_attr( $cards_class ); ?>">
		<?php
		while ( have_rows( 'cards' ) ) :
			the_row();
			$h4           = get_sub_field( 'h4' );
			$details_card = get_sub_field( 'details' );
			$card_icon    = get_sub_field( 'icon' );
			$card_icon    = is_string( $card_icon ) ? trim( $card_icon ) : '';
			?>
			<div class="custom-whitepaper-hero__card">
				<?php if ( $card_icon !== '' ) : ?>
					<span class="custom-whitepaper-hero__card-icon"><?php echo $card_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG from trusted ACF editor field. ?></span>
				<?php endif; ?>
				<?php if ( $h4 || $details_card ) : ?>
					<div class="custom-whitepaper-hero__card-body">
						<?php if ( $h4 ) : ?>
							<div class="custom-whitepaper-hero__card-label"><?php echo esc_html( $h4 ); ?></div>
						<?php endif; ?>
						<?php if ( $details_card ) : ?>
							<div class="custom-whitepaper-hero__card-details"><?php echo wp_kses_post( $details_card ); ?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
	</div>
	<?php
};

if ( $is_industry_row ) :
	?>
	<div class="custom-whitepaper-hero__row custom-whitepaper-hero__row--industry-list">
		<div class="custom-whitepaper-hero__industry-intro">
			<?php if ( $hero_img_url ) : ?>
				<div class="custom-whitepaper-hero__image">
					<img fetchpriority="high" src="<?php echo esc_url( $hero_img_url ); ?>" alt="" <?php echo $cwp_hero_dim_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>loading="eager" decoding="async" />
				</div>
			<?php endif; ?>
			<?php if ( $details ) : ?>
				<div class="custom-whitepaper-hero__details"><?php echo wp_kses_post( do_shortcode( $details ) ); ?></div>
			<?php endif; ?>
		</div>
		<?php $cwp_render_industry_cards( ' custom-whitepaper-hero__cards--list' ); ?>
	</div>
	<?php
	return;
endif;
?>
<div class="custom-whitepaper-hero__row custom-whitepaper-hero__row--industry">
	<div class="custom-whitepaper-hero__content">
		<div class="custom-whitepaper-hero__content-inner">
			<?php if ( $snippet ) : ?>
				<span class="custom-whitepaper-hero__snippet"><?php echo esc_html( $snippet ); ?></span>
			<?php endif; ?>
			<?php if ( $details ) : ?>
				<div class="custom-whitepaper-hero__details"><?php echo wp_kses_post( do_shortcode( $details ) ); ?></div>
			<?php endif; ?>
		</div>
		<?php
		$cwp_cta_links = array();
		$cta           = get_sub_field( 'cta' );

		if ( is_array( $cta ) && ! empty( $cta['url'] ) ) {
			$cwp_cta_links[] = $cta;
		} elseif ( have_rows( 'cta' ) ) {
			while ( have_rows( 'cta' ) ) {
				the_row();
				$button = get_sub_field( 'button' );
				if ( ! empty( $button['url'] ) ) {
					$cwp_cta_links[] = $button;
				}
			}
		}

		if ( ! empty( $cwp_cta_links ) ) :
			?>
			<div class="custom-whitepaper-hero__btns">
				<?php foreach ( $cwp_cta_links as $button ) : ?>
					<?php
					$link_url    = $button['url'];
					$link_title  = $button['title'] ?: __( 'Talk to Our Team', 'gc-v2' );
					$link_target = ! empty( $button['target'] ) ? $button['target'] : '_self';
					?>
					<a class="button blue custom-whitepaper-hero__cta" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" aria-label="<?php echo esc_attr( $link_title ); ?>"><?php echo esc_html( $link_title ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( $hero_img_url ) : ?>
		<div class="custom-whitepaper-hero__image">
			<img fetchpriority="high" src="<?php echo esc_url( $hero_img_url ); ?>" alt="" <?php echo $cwp_hero_dim_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>loading="eager" decoding="async" />
		</div>
	<?php endif; ?>
</div>
<?php $cwp_render_industry_cards( '' ); ?>
