<?php
/**
 * Shared closing banner.
 *
 * @param array $args {
 *     @type string $heading_id Heading id used by aria-labelledby.
 *     @type string $title      Plain title.
 *     @type string $title_html Title HTML when the plain title is not enough.
 *     @type string $text       Line under the title.
 *     @type array  $buttons    Rows with class, href, and label.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_static_render_banner' ) ) {
	function gc_static_render_banner( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'heading_id' => '',
				'title'      => '',
				'title_html' => '',
				'text'       => '',
				'buttons'    => array(),
			)
		);

		if ( '' === $args['title'] && '' === $args['title_html'] ) {
			return;
		}

		$buttons = is_array( $args['buttons'] ) ? array_values( $args['buttons'] ) : array();
		?>
		<section class="ve-section ve-section--cta"<?php echo $args['heading_id'] ? ' aria-labelledby="' . esc_attr( $args['heading_id'] ) . '"' : ''; ?>>
			<div class="container">
				<div class="ve-cta">
					<div class="ve-cta__copy">
						<h2<?php echo $args['heading_id'] ? ' id="' . esc_attr( $args['heading_id'] ) . '"' : ''; ?> class="ve-cta__title"><?php echo $args['title_html'] ? $args['title_html'] : esc_html( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller-built title HTML. ?></h2>
						<?php if ( '' !== $args['text'] ) : ?>
							<p><?php echo esc_html( $args['text'] ); ?></p>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $buttons ) ) : ?>
						<div class="ve-cta__btns">
							<?php foreach ( $buttons as $button ) : ?>
								<a class="button <?php echo esc_attr( isset( $button['class'] ) ? $button['class'] : '' ); ?>" href="<?php echo esc_url( isset( $button['href'] ) ? $button['href'] : '' ); ?>"><?php echo esc_html( isset( $button['label'] ) ? $button['label'] : '' ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
