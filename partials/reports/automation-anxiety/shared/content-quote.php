<?php
/**
 * Shared report quote block.
 *
 * @param array $args {
 *     @type string $text           Quote text (strong allowed).
 *     @type string $wrapper_class  Optional wrapper BEM class.
 *     @type string $text_class     Optional paragraph class.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_render_quote' ) ) {
	function gc_aar_report_render_quote( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'text'          => '',
				'wrapper_class' => '',
				'text_class'    => '',
			)
		);

		if ( ! $args['text'] ) {
			return;
		}

		$wrapper_classes = array( 'aar-report-quote' );
		if ( $args['wrapper_class'] ) {
			array_unshift( $wrapper_classes, $args['wrapper_class'] );
		}

		$text_classes = array();
		if ( $args['text_class'] ) {
			$text_classes[] = $args['text_class'];
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
			<p<?php echo $text_classes ? ' class="' . esc_attr( implode( ' ', $text_classes ) ) . '"' : ''; ?>>
				<?php echo wp_kses_post( $args['text'] ); ?>
			</p>
		</div>
		<?php
	}
}
