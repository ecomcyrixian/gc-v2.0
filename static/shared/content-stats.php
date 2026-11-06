<?php
/**
 * Shared stat tiles.
 *
 * @param array $args {
 *     @type array  $items       Rows with value, text, and tone.
 *     @type string $source      Source line under the tiles.
 *     @type string $value_class Extra class on the value, such as num.
 *     @type bool   $text_html   Allow a superscript in the tile text.
 *     @type string $source_html Source line HTML (caller-sanitized); used instead of source when set.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_static_render_stats' ) ) {
	function gc_static_render_stats( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'items'       => array(),
				'source'      => '',
				'value_class' => '',
				'text_html'   => false,
				'source_html' => '',
			)
		);

		$items = is_array( $args['items'] ) ? $args['items'] : array();
		if ( empty( $items ) ) {
			return;
		}

		$value_class = $args['value_class'] ? ' class="' . esc_attr( $args['value_class'] ) . '"' : '';
		?>
		<ul class="ve-stats">
			<?php foreach ( $items as $stat ) : ?>
				<li class="ve-stat ve-stat--<?php echo esc_attr( isset( $stat['tone'] ) ? $stat['tone'] : '' ); ?>">
					<strong<?php echo $value_class; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>><?php echo esc_html( isset( $stat['value'] ) ? $stat['value'] : '' ); ?></strong>
					<span><?php echo $args['text_html'] ? wp_kses( isset( $stat['text'] ) ? $stat['text'] : '', array( 'sup' => array() ) ) : esc_html( isset( $stat['text'] ) ? $stat['text'] : '' ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if ( $args['source_html'] ) : ?>
			<p class="ve-source"><?php echo $args['source_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller-sanitized HTML. ?></p>
		<?php elseif ( $args['source'] ) : ?>
			<p class="ve-source"><?php echo esc_html( $args['source'] ); ?></p>
		<?php endif; ?>
		<?php
	}
}
