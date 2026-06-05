<?php
/**
 * Shared report stat card grid.
 *
 * @param array $args {
 *     @type string $title    Optional grid title.
 *     @type string $intro    Optional intro copy.
 *     @type int    $columns  3, 4, or 5.
 *     @type array  $cards    Card rows with value, text, and optional icon keys.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_get_stat_card_icon_svg' ) ) {
	/**
	 * Default FAQ-style card icon when a card does not pass its own icon.
	 */
	function gc_aar_report_get_stat_card_icon_svg() {
		return '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><rect width="48" height="48" rx="3.42857" fill="#F2F3FF"/><path d="M22.3931 24C22.3931 24.4262 22.5624 24.835 22.8638 25.1364C23.1652 25.4378 23.574 25.6071 24.0002 25.6071C24.4264 25.6071 24.8352 25.4378 25.1366 25.1364C25.438 24.835 25.6073 24.4262 25.6073 24C25.6073 23.5738 25.438 23.165 25.1366 22.8636C24.8352 22.5622 24.4264 22.3929 24.0002 22.3929C23.574 22.3929 23.1652 22.5622 22.8638 22.8636C22.5624 23.165 22.3931 23.5738 22.3931 24ZM29.0895 24C29.0895 24.4262 29.2588 24.835 29.5602 25.1364C29.8616 25.4378 30.2704 25.6071 30.6966 25.6071C31.1229 25.6071 31.5316 25.4378 31.833 25.1364C32.1344 24.835 32.3038 24.4262 32.3038 24C32.3038 23.5738 32.1344 23.165 31.833 22.8636C31.5316 22.5622 31.1229 22.3929 30.6966 22.3929C30.2704 22.3929 29.8616 22.5622 29.5602 22.8636C29.2588 23.165 29.0895 23.5738 29.0895 24ZM15.6966 24C15.6966 24.4262 15.8659 24.835 16.1673 25.1364C16.4687 25.4378 16.8775 25.6071 17.3038 25.6071C17.73 25.6071 18.1388 25.4378 18.4402 25.1364C18.7416 24.835 18.9109 24.4262 18.9109 24C18.9109 23.5738 18.7416 23.165 18.4402 22.8636C18.1388 22.5622 17.73 22.3929 17.3038 22.3929C16.8775 22.3929 16.4687 22.5622 16.1673 22.8636C15.8659 23.165 15.6966 23.5738 15.6966 24ZM37.835 18.1875C37.0783 16.3895 35.9935 14.7757 34.6107 13.3895C33.2375 12.0114 31.6075 10.9159 29.8127 10.1652C27.9712 9.39174 26.0158 9 24.0002 9H23.9332C21.9042 9.01004 19.9388 9.41183 18.0906 10.202C16.3112 10.9605 14.6964 12.0578 13.3361 13.433C11.9667 14.8158 10.8919 16.423 10.1486 18.2143C9.37854 20.0692 8.99015 22.0413 9.00019 24.0703C9.01155 26.3956 9.56166 28.6865 10.6073 30.7634V35.8527C10.6073 36.2612 10.7696 36.6529 11.0584 36.9418C11.3473 37.2306 11.739 37.3929 12.1475 37.3929H17.2401C19.317 38.4385 21.608 38.9886 23.9332 39H24.0035C26.0091 39 27.9544 38.6116 29.7859 37.8516C31.5716 37.1098 33.1956 36.0271 34.5672 34.6641C35.95 33.2946 37.0381 31.6942 37.7982 29.9096C38.5884 28.0614 38.9902 26.096 39.0002 24.067C39.0102 22.0279 38.6152 20.0491 37.835 18.1875ZM32.7759 32.8527C30.4288 35.1763 27.3149 36.4554 24.0002 36.4554H23.9433C21.9243 36.4453 19.9187 35.9431 18.1475 34.9989L17.8663 34.8482H13.152V30.1339L13.0013 29.8527C12.0571 28.0815 11.5549 26.0759 11.5448 24.0569C11.5314 20.7188 12.8071 17.5848 15.1475 15.2243C17.4846 12.8638 20.6085 11.558 23.9466 11.5446H24.0035C25.6776 11.5446 27.3015 11.8694 28.8317 12.5123C30.325 13.1384 31.6643 14.0391 32.816 15.1908C33.9645 16.3393 34.8685 17.6819 35.4946 19.1752C36.1442 20.7221 36.4689 22.3627 36.4622 24.0569C36.4422 27.3917 35.133 30.5156 32.7759 32.8527Z" fill="#4F51FD"/></svg>';
	}
}

if ( ! function_exists( 'gc_aar_report_render_stat_cards' ) ) {
	function gc_aar_report_render_stat_cards( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'title'   => '',
				'intro'   => '',
				'columns' => 3,
				'cards'   => array(),
			)
		);

		$cards = is_array( $args['cards'] ) ? array_values( array_filter( $args['cards'] ) ) : array();
		if ( empty( $cards ) ) {
			return;
		}

		$columns = in_array( (int) $args['columns'], array( 3, 4, 5 ), true ) ? (int) $args['columns'] : 3;
		?>
		<div class="aar-report-stat-cards">
			<?php if ( $args['title'] || $args['intro'] ) : ?>
				<div class="aar-report-stat-cards__header">
					<?php if ( $args['title'] ) : ?>
						<div class="aar-report-stat-cards__title"><?php echo esc_html( $args['title'] ); ?></div>
					<?php endif; ?>
					<?php if ( $args['intro'] ) : ?>
						<div class="aar-report-stat-cards__intro"><?php echo esc_html( $args['intro'] ); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="cards card-same-height">
				<div class="card-cont cols<?php echo esc_attr( $columns ); ?> card-same-height">
					<?php foreach ( $cards as $card ) : ?>
						<?php
						$value = isset( $card['value'] ) ? (string) $card['value'] : '';
						$text  = isset( $card['text'] ) ? (string) $card['text'] : '';
						$icon  = ! empty( $card['icon'] ) ? (string) $card['icon'] : gc_aar_report_get_stat_card_icon_svg();
						if ( '' === $value && '' === $text ) {
							continue;
						}
						?>
						<div class="card-item">
							<h4>
								<?php if ( $value ) : ?>
									<span><?php echo esc_html( $value ); ?></span>
								<?php endif; ?>
								<span class="card-item__icon"><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme-provided SVG markup. ?></span>
							</h4>
							<?php if ( $text ) : ?>
								<p><?php echo esc_html( $text ); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}
}
