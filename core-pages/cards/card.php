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

	$click_raw = get_sub_field( 'make_cards_clikable' );
	if ( null === $click_raw || '' === $click_raw ) {
		$click_raw = get_sub_field( 'make_cards_clickable' );
	}
	$cards_clickable = strtolower( (string) $click_raw ) === 'yes';

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
				'link'     => $cards_clickable ? get_sub_field( 'card_link' ) : null,
			);
		}
	}

	$columns_int = (int) $columns;
	$use_row_two_col_stagger = $is_row_layout && 2 === $columns_int && ! empty( $cards_data );

	$same_height_cards = strtolower( (string) get_sub_field( 'same_height_cards' ) ) === 'yes';
?>

<?php if ( $display_selection ) : ?>

<div class="cards <?php echo esc_attr( $finalSetting ); ?> <?php echo esc_attr( $snippetSetting ); ?><?php echo $is_row_layout ? ' cards--layout-row' : ''; ?><?php echo $use_whitepaper_background ? ' cards--whitepaper-bg' : ''; ?><?php echo $same_height_cards ? ' card-same-height' : ''; ?>"<?php
if ( $use_whitepaper_background ) {
	echo ' style="background-image: url(' . esc_url( $whitepaper_bg_url ) . ');"';
}
?>>
	<div class="container">

		<?php if ( $with_header ) : ?>
			<div class="heading">
				<h2>
					<span><?php echo esc_html( $snippet ); ?></span>
					<pre><?php echo esc_html( $h2 ); ?></pre>
				</h2>
				<?php echo $H2details; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards_data ) ) : ?>
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
							$url     = is_array( $link ) ? ( $link['url'] ?? '' ) : '';
							$target  = is_array( $link ) ? ( $link['target'] ?? '_self' ) : '_self';
							?>
							<?php if ( $cards_clickable && $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="card-link">
							<?php endif; ?>
								<div class="card-item">
									<h4>
										<span><?php echo $h4; ?></span>
										<span><?php echo $icon; ?></span>
									</h4>
									<div class="card-item__divider" aria-hidden="true"></div>
									<?php echo $details; ?>
								</div>
							<?php if ( $cards_clickable && $url ) : ?>
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
							$url     = is_array( $link ) ? ( $link['url'] ?? '' ) : '';
							$target  = is_array( $link ) ? ( $link['target'] ?? '_self' ) : '_self';
							?>
							<?php if ( $cards_clickable && $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="card-link">
							<?php endif; ?>
								<div class="card-item">
									<h4>
										<span><?php echo $h4; ?></span>
										<span><?php echo $icon; ?></span>
									</h4>
									<div class="card-item__divider" aria-hidden="true"></div>
									<?php echo $details; ?>
								</div>
							<?php if ( $cards_clickable && $url ) : ?>
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
						$url     = is_array( $link ) ? ( $link['url'] ?? '' ) : '';
						$target  = is_array( $link ) ? ( $link['target'] ?? '_self' ) : '_self';
						?>
						<?php if ( $cards_clickable && $url ) : ?>
							<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="card-link">
						<?php endif; ?>
							<div class="card-item">
								<h4>
									<span><?php echo $h4; ?></span>
									<span><?php echo $icon; ?></span>
								</h4>
								<div class="card-item__divider" aria-hidden="true"></div>
								<?php echo $details; ?>
							</div>
						<?php if ( $cards_clickable && $url ) : ?>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	</div>
</div>

<?php endif; ?>
