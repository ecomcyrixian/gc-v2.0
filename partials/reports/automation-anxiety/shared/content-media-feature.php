<?php
/**
 * Shared report image + copy block.
 *
 * @param array $args {
 *     @type array  $image    Image: src, alt, position (`left`|`right`).
 *     @type array  $blue_box Blue box: `position` = `left`|`right` (which side of the body the blue box sits on; with no image, this is a horizontal split).
 *     @type array|string $body Body settings with optional title and text, or body text only.
 *     @type string $quote    Quote text (strong allowed).
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_render_image' ) ) {
	/**
	 * @param array  $image   src, alt.
	 * @param string $class   CSS class on the img element.
	 * @param string $loading lazy|eager.
	 */
	function gc_aar_report_render_image( $image, $class = 'aar-report-image', $loading = 'lazy' ) {
		if ( empty( $image['src'] ) ) {
			return;
		}
		$fetchpriority = ! empty( $image['fetchpriority'] ) ? $image['fetchpriority'] : '';
		?>
		<img
			class="<?php echo esc_attr( $class ); ?>"
			src="<?php echo esc_url( $image['src'] ); ?>"
			alt="<?php echo esc_attr( $image['alt'] ?? '' ); ?>"
			loading="<?php echo esc_attr( $loading ); ?>"
			<?php echo 'high' === $fetchpriority ? ' fetchpriority="high"' : ''; ?>
			decoding="async"
		/>
		<?php
	}
}

if ( ! function_exists( 'gc_aar_report_render_media_feature' ) ) {
	function gc_aar_report_render_media_feature( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'image'    => array(),
				'blue_box' => array(),
				'body'     => array(),
				'quote'    => '',
			)
		);

		$image = wp_parse_args(
			is_array( $args['image'] ) ? $args['image'] : array(),
			array(
				'src'      => '',
				'alt'      => '',
				'position' => 'left',
			)
		);

		$blue_box = wp_parse_args(
			is_array( $args['blue_box'] ) ? $args['blue_box'] : array(),
			array(
				'position' => 'right',
				'h2'       => '',
				'text'     => '',
			)
		);

		$body = is_string( $args['body'] )
			? array(
				'title' => '',
				'text'  => $args['body'],
			)
			: wp_parse_args(
				is_array( $args['body'] ) ? $args['body'] : array(),
				array(
					'title' => '',
					'text'  => '',
				)
			);

		$image_position   = 'right' === $image['position'] ? 'right' : 'left';
		$content_position = 'left' === $blue_box['position'] ? 'left' : 'right';
		$has_image        = (bool) $image['src'];
		$has_blue_box     = $blue_box['h2'] || $blue_box['text'];
		$has_body         = $body['title'] || $body['text'];
		$has_quote        = (bool) $args['quote'];
		$use_blue_box_stack = $has_blue_box;
		$use_quote_stack    = ! $use_blue_box_stack && $has_quote;

		if ( ! $has_image && ! $has_blue_box && ! $has_body && ! $has_quote ) {
			return;
		}

		$classes = array(
			'aar-report-media-feature',
			'aar-report-media-feature--image-' . $image_position,
			'aar-report-media-feature--content-' . $content_position,
		);

		if ( ! $has_image ) {
			$classes[] = 'aar-report-media-feature--no-image';
		}

		if ( $use_blue_box_stack ) {
			$classes[] = 'aar-report-media-feature--stack-bluebox-body';
		} elseif ( $use_quote_stack ) {
			$classes[] = 'aar-report-media-feature--stack-body-quote';
		}

		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<div class="aar-report-media-feature__row">
				<?php if ( $has_image ) : ?>
					<div class="aar-report-media-feature__media">
						<?php gc_aar_report_render_image( $image, 'aar-report-media-feature__image' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $has_blue_box || $has_body || $has_quote ) : ?>
					<div class="aar-report-media-feature__stack">
						<?php if ( $use_blue_box_stack ) : ?>
							<div class="aar-report-media-feature__bluebox">
								<?php if ( $blue_box['h2'] ) : ?>
									<div class="aar-report-media-feature__bluebox-heading"><?php echo esc_html( $blue_box['h2'] ); ?></div>
								<?php endif; ?>
								<?php if ( $blue_box['text'] ) : ?>
									<div class="aar-report-media-feature__bluebox-text"><?php echo wp_kses_post( trim( $blue_box['text'] ) ); ?></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( $has_body ) : ?>
							<div class="aar-report-media-feature__body">
								<?php if ( $body['title'] ) : ?>
									<div class="aar-report-media-feature__body-heading"><?php echo esc_html( $body['title'] ); ?></div>
								<?php endif; ?>
								<?php if ( $body['text'] ) : ?>
									<div class="aar-report-media-feature__body-text"><?php echo wp_kses_post( trim( $body['text'] ) ); ?></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( $use_quote_stack ) : ?>
							<?php
							gc_aar_report_render_quote(
								array(
									'text'          => $args['quote'],
									'wrapper_class' => 'aar-report-media-feature__quote',
								)
							);
							?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
