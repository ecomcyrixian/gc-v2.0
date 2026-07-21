<?php
	$display_selection = get_sub_field( 'display_selection' ) === 'Show';
	$with_header       = get_sub_field( 'with_header' ) === 'Yes';

	$h2        = get_sub_field( 'h2' );
	$H2details = get_sub_field( 'details' );
	$columns   = get_sub_field( 'columns' );

	$snippet = get_sub_field( 'snippet' );
	$snippetSetting = str_replace( ' ', '-', strtolower( $snippet ) );

	$setting = get_sub_field( 'setting' );
	$finalSetting = str_replace( ' ', '-', strtolower( $setting ) );

	$is_compliance_heading = ( 'compliance' === $finalSetting );

	$cards_clickable = get_sub_field( 'make_cards_clickable' ) === 'Yes';

	$layout_raw    = get_sub_field( 'layout' );
	$is_row_layout = strtolower( (string) $layout_raw ) === 'row';

	$use_whitepaper_background = strtolower( (string) get_sub_field( 'use_whitepaper_background' ) ) === 'yes';
	$whitepaper_bg_url         = get_template_directory_uri() . '/assets/images/custom-whitepaper-bg.webp';

	$cards_data = array();
	if ( $display_selection && have_rows( 'cards' ) ) {
		while ( have_rows( 'cards' ) ) {
			the_row();
			$cards_data[] = array(
				'h4'       => get_sub_field( 'h4' ),
				'details'  => get_sub_field( 'details' ),
				'svg_icon' => get_sub_field( 'svg_icon' ),
				'link'     => get_sub_field( 'card_link' ),
			);
		}
	}

	$columns_int = (int) $columns;
	$use_row_two_col_stagger = $is_row_layout && 2 === $columns_int && ! empty( $cards_data );

	$same_height_cards = strtolower( (string) get_sub_field( 'same_height_cards' ) ) === 'yes';
	$is_thankyou_contact_card = is_string( $H2details ) && strpos( $H2details, 'thankyou-contact-card' ) !== false;
	$use_thankyou_card_buttons = $is_thankyou_contact_card && $cards_clickable;
	$is_sub_industry = is_string( $H2details ) && false !== strpos( $H2details, 'sub-industry' );
	$is_sub_industry_auto = $is_sub_industry && false !== strpos( $H2details, 'sub-industry auto' );

	if ( ! function_exists( 'gc_card_link_url_target' ) ) {
		function gc_card_link_url_target( $link ) {
			$url    = '';
			$target = '_self';
			if ( is_array( $link ) ) {
				$url    = isset( $link['url'] ) ? (string) $link['url'] : '';
				$target = ! empty( $link['target'] ) ? (string) $link['target'] : '_self';
			} elseif ( is_string( $link ) && $link !== '' ) {
				$url = $link;
			}
			return array( $url, $target );
		}
	}

	if ( ! function_exists( 'gc_card_icon_full_image' ) ) {
		/**
		 * Replace ACF svg_icon medium/thumbnail <img> with the full-size attachment.
		 * Sub-industry only — other card layouts are unchanged.
		 *
		 * @param string $icon Raw ACF SVG/HTML icon field.
		 * @return string
		 */
		function gc_card_icon_full_image( $icon ) {
			if ( ! is_string( $icon ) || '' === $icon ) {
				return $icon;
			}
			if ( ! preg_match( '/wp-image-(\d+)/', $icon, $matches ) ) {
				return $icon;
			}
			$attachment_id = (int) $matches[1];
			if ( $attachment_id < 1 ) {
				return $icon;
			}
			$full_html = wp_get_attachment_image(
				$attachment_id,
				'full',
				false,
				array(
					'alt'      => '',
					'loading'  => 'lazy',
					'decoding' => 'async',
				)
			);
			return $full_html ? $full_html : $icon;
		}
	}
?>

<?php if ( $display_selection ) : ?>

<div class="cards <?php echo esc_attr( $finalSetting ); ?> <?php echo esc_attr( $snippetSetting ); ?><?php echo $is_row_layout ? ' cards--layout-row' : ''; ?><?php echo $use_whitepaper_background ? ' cards--whitepaper-bg' : ''; ?><?php echo $same_height_cards ? ' card-same-height' : ''; ?><?php echo $is_sub_industry ? ' cards--sub-industry' : ''; ?><?php echo $is_sub_industry_auto ? ' cards--sub-industry-auto' : ''; ?>"<?php
if ( $use_whitepaper_background ) {
	echo ' style="background-image: url(' . esc_url( $whitepaper_bg_url ) . ');"';
}
?>>
	<div class="container">

		<?php if ( $with_header ) : ?>
			<div class="heading">
				<?php if ( $is_compliance_heading ) : ?>
					<div class="card-same-height compliance">
						<?php if ( $snippet ) : ?>
							<p class="cards-heading__eyebrow"><?php echo esc_html( $snippet ); ?></p>
						<?php endif; ?>
						<?php if ( $h2 ) : ?>
							<h2><?php echo wp_kses_post( $h2 ); ?></h2>
						<?php endif; ?>
						<?php echo $H2details; ?>
					</div>
				<?php else : ?>
					<h2>
						<span><?php echo esc_html( $snippet ); ?></span>
						<pre><?php echo esc_html( $h2 ); ?></pre>
					</h2>
					<?php echo $H2details; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards_data ) && $is_sub_industry ) : ?>
			<div class="card-cont cols<?php echo esc_attr( $columns ); ?>">
				<?php foreach ( $cards_data as $card ) : ?>
					<?php
					$h4      = $card['h4'] ?? '';
					$details = $card['details'] ?? '';
					$icon    = gc_card_icon_full_image( $card['svg_icon'] ?? '' );
					$link    = $cards_clickable ? ( $card['link'] ?? null ) : null;
					list( $url, $target ) = gc_card_link_url_target( $link );
					?>
					<div>
						<span class="featured-image">
							<?php if ( $icon ) : ?>
								<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF SVG/HTML field. ?>
							<?php endif; ?>
						</span>
						<span class="desc">
							<?php if ( $h4 ) : ?>
								<h4><?php echo $h4; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF HTML field. ?></h4>
							<?php endif; ?>
							<?php echo $details; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF HTML field. ?>
							<?php if ( $cards_clickable && $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>">
									<?php esc_html_e( 'Read more', 'gc-v2' ); ?>
								</a>
							<?php endif; ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php elseif ( ! empty( $cards_data ) ) : ?>
			<?php if ( $use_row_two_col_stagger ) : ?>
				<?php
				$half        = (int) ceil( count( $cards_data ) / 2 );
				$left_cards  = array_slice( $cards_data, 0, $half );
				$right_cards = array_slice( $cards_data, $half );
				?>
				<div class="card-cont cols2 card-cont--row-stagger">
					<div class="card-cont__col card-cont__col--left">
						<?php foreach ( $left_cards as $card ) : ?>
							<?php
							$h4      = $card['h4'] ?? '';
							$details = $card['details'] ?? '';
							$icon    = $card['svg_icon'] ?? '';
							$link    = $cards_clickable ? ( $card['link'] ?? null ) : null;
							list( $url, $target ) = gc_card_link_url_target( $link );
							$link_title = '';
							if ( is_array( $link ) ) {
								$link_title = isset( $link['title'] ) ? (string) $link['title'] : '';
							}
							if ( '' === $link_title ) {
								$link_title = 'Read More';
							}
							?>
							<?php if ( ! $use_thankyou_card_buttons && $cards_clickable && $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="card-link">
							<?php endif; ?>
								<div class="card-item">
									<?php if ( $use_thankyou_card_buttons ) : ?>
										<div class="card-item__header">
											<div class="card-item__copy">
												<h4><span><?php echo $h4; ?></span></h4>
												<?php echo $details; ?>
											</div>
											<?php if ( $icon ) : ?>
												<div class="card-item__icon"><?php echo $icon; ?></div>
											<?php endif; ?>
										</div>
										<?php if ( $url ) : ?>
											<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="button outline card-item__button" aria-label="<?php echo esc_attr( $link_title ); ?>">
												<?php echo esc_html( $link_title ); ?>
											</a>
										<?php endif; ?>
									<?php else : ?>
										<h4>
											<span><?php echo $h4; ?></span>
											<span><?php echo $icon; ?></span>
										</h4>
										<div class="card-item__divider" aria-hidden="true"></div>
										<?php echo $details; ?>
									<?php endif; ?>
								</div>
							<?php if ( ! $use_thankyou_card_buttons && $cards_clickable && $url ) : ?>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="card-cont__col card-cont__col--right">
						<?php foreach ( $right_cards as $card ) : ?>
							<?php
							$h4      = $card['h4'] ?? '';
							$details = $card['details'] ?? '';
							$icon    = $card['svg_icon'] ?? '';
							$link    = $cards_clickable ? ( $card['link'] ?? null ) : null;
							list( $url, $target ) = gc_card_link_url_target( $link );
							$link_title = '';
							if ( is_array( $link ) ) {
								$link_title = isset( $link['title'] ) ? (string) $link['title'] : '';
							}
							if ( '' === $link_title ) {
								$link_title = 'Read More';
							}
							?>
							<?php if ( ! $use_thankyou_card_buttons && $cards_clickable && $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="card-link">
							<?php endif; ?>
								<div class="card-item">
									<?php if ( $use_thankyou_card_buttons ) : ?>
										<div class="card-item__header">
											<div class="card-item__copy">	
												<h4><span><?php echo $h4; ?></span></h4>
												<?php echo $details; ?>
											</div>
											<?php if ( $icon ) : ?>
												<div class="card-item__icon"><?php echo $icon; ?></div>
											<?php endif; ?>
										</div>
										<?php if ( $url ) : ?>
											<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="button outline card-item__button" aria-label="<?php echo esc_attr( $link_title ); ?>">
												<?php echo esc_html( $link_title ); ?>
											</a>
										<?php endif; ?>
									<?php else : ?>
										<h4>
											<span><?php echo $h4; ?></span>
											<span><?php echo $icon; ?></span>
										</h4>
										<div class="card-item__divider" aria-hidden="true"></div>
										<?php echo $details; ?>
									<?php endif; ?>
								</div>
							<?php if ( ! $use_thankyou_card_buttons && $cards_clickable && $url ) : ?>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="card-cont cols<?php echo esc_attr( $columns ); ?><?php echo $same_height_cards ? ' card-same-height' : ''; ?>">
					<?php foreach ( $cards_data as $card ) : ?>
						<?php
						$h4      = $card['h4'] ?? '';
						$details = $card['details'] ?? '';
						$icon    = $card['svg_icon'] ?? '';
						$link    = $cards_clickable ? ( $card['link'] ?? null ) : null;
						list( $url, $target ) = gc_card_link_url_target( $link );
						$link_title = '';
						if ( is_array( $link ) ) {
							$link_title = isset( $link['title'] ) ? (string) $link['title'] : '';
						}
						if ( '' === $link_title ) {
							$link_title = 'Read More';
						}
						?>
						<?php if ( ! $use_thankyou_card_buttons && $cards_clickable && $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="card-link">
						<?php endif; ?>
							<div class="card-item">
								<?php if ( $use_thankyou_card_buttons ) : ?>
									<div class="card-item__header">
										<div class="card-item__copy">
											<h4><span><?php echo $h4; ?></span></h4>
											<?php echo $details; ?>
										</div>
										<?php if ( $icon ) : ?>
											<div class="card-item__icon"><?php echo $icon; ?></div>
										<?php endif; ?>
									</div>
									<?php if ( $url ) : ?>
										<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="button outline card-item__button" aria-label="<?php echo esc_attr( $link_title ); ?>">
											<?php echo esc_html( $link_title ); ?>
										</a>
									<?php endif; ?>
								<?php else : ?>
									<h4>
										<span><?php echo $h4; ?></span>
										<span><?php echo $icon; ?></span>
									</h4>
									<div class="card-item__divider" aria-hidden="true"></div>
									<?php echo $details; ?>
								<?php endif; ?>
							</div>
						<?php if ( ! $use_thankyou_card_buttons && $cards_clickable && $url ) : ?>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	</div>
</div>

<?php endif; ?>
