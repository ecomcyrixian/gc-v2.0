<?php
/**
 * Callout card: same stacking rhythm as `.aar-report-media-feature__bluebox`, mesh background in CSS.
 *
 * @param array $args {
 *     @type string $title Optional. Heading inside the card.
 *     @type string $text  Optional. Body copy (plain text; wrapped in paragraphs).
 *     @type string $quote Optional. Pullquote line (<strong> allowed).
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_render_callout_card' ) ) {
	function gc_aar_report_render_callout_card( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'title' => '',
				'text'  => '',
				'quote' => '',
			)
		);

		if ( ! $args['title'] && ! $args['text'] && ! $args['quote'] ) {
			return;
		}
		?>
		<div class="aar-report-callout-card">
			<?php if ( $args['title'] ) : ?>
				<h3 class="aar-report-callout-card__title"><?php echo esc_html( $args['title'] ); ?></h3>
			<?php endif; ?>
			<?php if ( $args['text'] ) : ?>
				<div class="aar-report-callout-card__body">
					<?php echo wp_kses_post( wpautop( $args['text'] ) ); ?>
				</div>
			<?php endif; ?>
			<?php
			if ( $args['quote'] ) {
				gc_aar_report_render_quote(
					array(
						'text'          => $args['quote'],
						'wrapper_class' => 'aar-report-callout-card__quote',
						'text_class'    => 'aar-report-callout-card__quote-text',
					)
				);
			}
			?>
		</div>
		<?php
	}
}
