<?php
/**
 * Shared G2 proof bar.
 *
 * @param array $args {
 *     @type string $label      Accessible name for the section.
 *     @type string $eyebrow    G2 line above the stars.
 *     @type string $stars      Accessible star rating.
 *     @type string $badges_uri Base URL for badge images.
 *     @type array  $badges     Badge file => alt text.
 *     @type array  $chips      Chip labels, or rows with icon HTML and label.
 *     @type string $chip_icon  Icon HTML used when a chip is a plain label.
 *     @type bool   $show_stars  Whether to render the star row (default true).
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_static_render_proof' ) ) {
	function gc_static_render_proof( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'label'      => 'Ratings and compliance',
				'eyebrow'    => 'Rated by real customers on G2',
				'stars'      => '5 out of 5 stars',
				'badges_uri' => get_template_directory_uri() . '/partials/home/grid-layout/images/',
				'badges'     => array(),
				'chips'      => array(),
				'chip_icon'  => '',
				'show_stars' => true,
			)
		);

		$badges = is_array( $args['badges'] ) ? $args['badges'] : array();
		$chips  = is_array( $args['chips'] ) ? $args['chips'] : array();

		if ( empty( $badges ) && empty( $chips ) ) {
			return;
		}
		?>
		<section class="ve-proof" aria-label="<?php echo esc_attr( $args['label'] ); ?>">
			<div class="container ve-proof__inner">
				<div class="ve-proof__g2">
					<span class="ve-eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></span>
					<?php if ( ! empty( $args['show_stars'] ) ) : ?>
						<span class="ve-stars" role="img" aria-label="<?php echo esc_attr( $args['stars'] ); ?>"><i></i><i></i><i></i><i></i><i></i></span>
					<?php endif; ?>
				</div>

				<?php if ( $badges ) : ?>
					<ul class="ve-badges">
						<?php foreach ( $badges as $file => $alt ) : ?>
							<li><img src="<?php echo esc_url( $args['badges_uri'] . $file ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="111" height="127" loading="lazy" decoding="async"></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $chips ) : ?>
					<ul class="ve-chips">
						<?php foreach ( $chips as $chip ) : ?>
							<?php
							$icon  = $args['chip_icon'];
							$label = $chip;

							if ( is_array( $chip ) ) {
								$icon  = isset( $chip['icon'] ) ? $chip['icon'] : '';
								$label = isset( $chip['label'] ) ? $chip['label'] : '';
							}

							if ( '' === $label ) {
								continue;
							}
							?>
							<li><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller-built SVG. ?><?php echo esc_html( $label ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
