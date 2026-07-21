<?php
/**
 * Card widget — Layout: Grid.
 *
 * Bordered clickable tile grid (icon, title, description, arrow).
 * Footer HTML goes in the widget Details field (class link-grid-footer).
 * Screening services header + card overrides: class link-grid-services in Details.
 */
$display_selection = get_sub_field( 'display_selection' ) === 'Show';
$with_header       = get_sub_field( 'with_header' ) === 'Yes';
$h2                = get_sub_field( 'h2' );
$H2details         = get_sub_field( 'details' );
$columns           = get_sub_field( 'columns' );
$cards_clickable   = get_sub_field( 'make_cards_clickable' ) === 'Yes';

$snippet        = get_sub_field( 'snippet' );
$snippetSetting = str_replace( ' ', '-', strtolower( $snippet ) );

$setting      = get_sub_field( 'setting' );
$finalSetting = str_replace( ' ', '-', strtolower( $setting ) );

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

$is_link_grid_footer = is_string( $H2details ) && (
	false !== strpos( $H2details, 'link-grid-footer' )
	|| false !== strpos( $H2details, 'industries-page-footer' )
);

$is_link_grid_services = is_string( $H2details ) && false !== strpos( $H2details, 'link-grid-services' );

$is_link_grid_special_details = $is_link_grid_footer || $is_link_grid_services;

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

if ( ! function_exists( 'gc_card_link_grid_arrow_svg' ) ) {
	function gc_card_link_grid_arrow_svg() {
		return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M20.3672 11.4328L11.5125 3.74766C11.4445 3.68906 11.3578 3.65625 11.2664 3.65625H9.19219C9.01875 3.65625 8.93906 3.87187 9.07031 3.98438L17.2781 11.1094H3.5625C3.45937 11.1094 3.375 11.1937 3.375 11.2969V12.7031C3.375 12.8062 3.45937 12.8906 3.5625 12.8906H17.2758L9.06797 20.0156C8.93672 20.1305 9.01641 20.3438 9.18984 20.3438H11.3344C11.3789 20.3438 11.4234 20.3273 11.4562 20.2969L20.3672 12.5672C20.4483 12.4966 20.5134 12.4095 20.558 12.3116C20.6025 12.2138 20.6256 12.1075 20.6256 12C20.6256 11.8925 20.6025 11.7862 20.558 11.6884C20.5134 11.5905 20.4483 11.5034 20.3672 11.4328Z" fill="#4F51FD"/></svg>';
	}
}
?>

<?php if ( $display_selection ) : ?>
<div class="cards <?php echo esc_attr( $finalSetting ); ?> <?php echo esc_attr( $snippetSetting ); ?> cards--link-grid<?php echo $is_link_grid_services ? ' cards--link-grid-services' : ''; ?>">
	<div class="container">

		<?php if ( $with_header && ! $is_link_grid_special_details && ( $h2 || $H2details ) ) : ?>
			<div class="heading">
				<?php if ( $h2 ) : ?>
					<h2><?php echo wp_kses_post( $h2 ); ?></h2>
				<?php endif; ?>
				<?php echo $H2details; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF HTML field. ?>
			</div>
		<?php endif; ?>

		<?php if ( $is_link_grid_services && $with_header && $H2details ) : ?>
			<?php echo $H2details; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF HTML field. ?>
		<?php endif; ?>

		<?php if ( ! empty( $cards_data ) ) : ?>
			<div class="card-cont cols<?php echo esc_attr( $columns ); ?>">
				<?php foreach ( $cards_data as $card ) : ?>
					<?php
					$h4      = isset( $card['h4'] ) ? trim( (string) $card['h4'] ) : '';
					$details = isset( $card['details'] ) ? trim( (string) $card['details'] ) : '';
					$icon    = isset( $card['svg_icon'] ) ? trim( (string) $card['svg_icon'] ) : '';
					if ( $h4 === '' && $details === '' && $icon === '' ) {
						continue;
					}
					$link    = $cards_clickable ? ( $card['link'] ?? null ) : null;
					list( $url, $target ) = gc_card_link_url_target( $link );
					$link_title = '';
					if ( is_array( $link ) ) {
						$link_title = isset( $link['title'] ) ? (string) $link['title'] : '';
					}
					if ( '' === $link_title && $h4 !== '' ) {
						$link_title = wp_strip_all_tags( $h4 );
					}
					?>
					<?php if ( $cards_clickable && $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>" class="card-link" aria-label="<?php echo esc_attr( $link_title ); ?>">
					<?php endif; ?>
						<div class="card-item card-item--link-grid">
							<?php if ( $h4 !== '' || $icon !== '' ) : ?>
								<h4>
									<span><?php echo $h4; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF HTML field. ?></span>
									<?php if ( $icon !== '' ) : ?>
										<span><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF SVG field. ?></span>
									<?php endif; ?>
								</h4>
							<?php endif; ?>
							<?php if ( $details !== '' ) : ?>
								<div class="link-grid-card__details"><?php echo $details; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF HTML field. ?></div>
							<?php endif; ?>
							<span class="link-grid-card__arrow"><?php echo gc_card_link_grid_arrow_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hardcoded SVG. ?></span>
						</div>
					<?php if ( $cards_clickable && $url ) : ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $is_link_grid_footer && $with_header ) : ?>
			<?php echo $H2details; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ACF HTML field. ?>
		<?php endif; ?>

	</div>
</div>
<?php endif; ?>
