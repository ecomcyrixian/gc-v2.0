<?php
/**
 * Shared FAQ accordion. The section id stays "faq" so the global accordion script can find it.
 *
 * @param array $args {
 *     @type string $section_class Section classes.
 *     @type string $heading_id    Heading id used by aria-labelledby.
 *     @type string $eyebrow       Small line above the title.
 *     @type string $title         Plain title.
 *     @type string $title_html    Title HTML when the plain title is not enough.
 *     @type array  $items         Rows with q and a.
 *     @type string $panel_prefix  Id prefix for each answer panel.
 *     @type string $format        Optional callback that returns safe HTML for a question or answer.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_static_render_faq' ) ) {
	function gc_static_render_faq( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'section_class' => 've-section faq--collapsible ve-faq',
				'heading_id'    => '',
				'eyebrow'       => 'Common questions',
				'title'         => '',
				'title_html'    => '',
				'items'         => array(),
				'panel_prefix'  => 'faq-panel',
				'format'        => '',
			)
		);

		$items = is_array( $args['items'] ) ? array_values( $args['items'] ) : array();
		if ( empty( $items ) || ( '' === $args['title'] && '' === $args['title_html'] ) ) {
			return;
		}

		$format = is_callable( $args['format'] ) ? $args['format'] : '';
		?>
		<section id="faq" class="<?php echo esc_attr( $args['section_class'] ); ?>"<?php echo $args['heading_id'] ? ' aria-labelledby="' . esc_attr( $args['heading_id'] ) . '"' : ''; ?>>
			<div class="container ve-container--narrow ve-stack">
				<div class="heading center">
					<h2<?php echo $args['heading_id'] ? ' id="' . esc_attr( $args['heading_id'] ) . '"' : ''; ?>><span><?php echo esc_html( $args['eyebrow'] ); ?></span><?php echo $args['title_html'] ? $args['title_html'] : esc_html( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller-built title HTML. ?></h2>
				</div>

				<div class="card-cont">
					<?php foreach ( $items as $index => $faq ) : ?>
						<?php
						$open     = 0 === $index;
						$panel_id = $args['panel_prefix'] . '-' . ( $index + 1 );
						$question = isset( $faq['q'] ) ? $faq['q'] : '';
						$answer   = isset( $faq['a'] ) ? $faq['a'] : '';
						?>
						<div class="faq-card<?php echo $open ? ' is-open' : ''; ?>">
							<button class="faq-card__toggle" type="button" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $panel_id ); ?>">
								<span><?php echo $format ? call_user_func( $format, $question ) : esc_html( $question ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- formatter returns escaped HTML. ?></span>
								<span class="faq-card__icon" aria-hidden="true"></span>
							</button>
							<div id="<?php echo esc_attr( $panel_id ); ?>" class="faq-card__panel"<?php echo $open ? '' : ' hidden'; ?>>
								<p><?php echo $format ? call_user_func( $format, $answer ) : esc_html( $answer ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- formatter returns escaped HTML. ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
