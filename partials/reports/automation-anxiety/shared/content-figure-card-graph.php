<?php
/**
 * Figure card graph — white card with badge, title, and axis-free bars.
 *
 * @param array $args {
 *     @type string $badge       Badge label, e.g. "Figure 1".
 *     @type string $title       Figure title beside the badge.
 *     @type string $subtitle    Supporting line below the header.
 *     @type int    $max         Scale maximum for bar lengths.
 *     @type array  $bars        Bar rows: label, value, tone.
 *     @type string $footer      Source / base line.
 *     @type string $orientation vertical|horizontal.
 *     @type bool   $motion      Enable reveal animation.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_render_figure_card_graph' ) ) {
	function gc_aar_report_render_figure_card_graph( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'badge'       => '',
				'title'       => '',
				'subtitle'    => '',
				'max'         => 100,
				'bars'        => array(),
				'footer'      => '',
				'orientation' => 'vertical',
				'motion'      => true,
			)
		);

		$bars = is_array( $args['bars'] ) ? array_values( array_filter( $args['bars'] ) ) : array();
		if ( empty( $bars ) ) {
			return;
		}

		$max         = max( 1, (int) $args['max'] );
		$motion      = (bool) $args['motion'];
		$orientation = 'horizontal' === $args['orientation'] ? 'horizontal' : 'vertical';
		$classes     = array(
			'aar-report-figure-card-graph',
			'aar-report-figure-card-graph--' . $orientation,
		);

		if ( $motion ) {
			$classes[] = 'aar-report-figure-card-graph--motion';
		}

		$bar_count = count( $bars );
		$bar_style = '--aar-bar-count: ' . max( 1, $bar_count ) . '; --aar-y-max: ' . $max . ';';
		?>
		<figure
			class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
			<?php echo $motion ? ' data-aar-figure-card-graph-motion="true"' : ''; ?>
		>
			<div class="aar-report-figure-card-graph__card">
				<?php if ( $args['badge'] || $args['title'] || $args['subtitle'] ) : ?>
					<div class="aar-report-figure-card-graph__header">
						<?php if ( $args['badge'] || $args['title'] ) : ?>
							<div class="aar-report-figure-card-graph__title-row">
								<?php if ( $args['badge'] ) : ?>
									<span class="aar-report-figure-card-graph__badge"><?php echo esc_html( $args['badge'] ); ?></span>
								<?php endif; ?>
								<?php if ( $args['title'] ) : ?>
									<figcaption class="aar-report-figure-card-graph__title"><?php echo esc_html( $args['title'] ); ?></figcaption>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if ( $args['subtitle'] ) : ?>
							<p class="aar-report-figure-card-graph__subtitle"><?php echo esc_html( $args['subtitle'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="aar-report-figure-card-graph__chart" style="<?php echo esc_attr( $bar_style ); ?>">
					<?php if ( 'horizontal' === $orientation ) : ?>
						<div class="aar-report-figure-card-graph__bars aar-report-figure-card-graph__bars--horizontal" role="img" aria-label="<?php echo esc_attr( wp_strip_all_tags( $args['title'] . ' ' . $args['subtitle'] ) ); ?>">
							<?php foreach ( $bars as $bar ) : ?>
								<?php
								$value   = isset( $bar['value'] ) ? (float) $bar['value'] : 0;
								$label   = isset( $bar['label'] ) ? (string) $bar['label'] : '';
								$tone    = function_exists( 'gc_aar_report_graph_normalize_tone' )
									? gc_aar_report_graph_normalize_tone( isset( $bar['tone'] ) ? $bar['tone'] : 'royal' )
									: 'royal';
								$percent = function_exists( 'gc_aar_report_graph_get_percent' )
									? gc_aar_report_graph_get_percent( $value, $max )
									: min( 100, max( 0, ( $value / $max ) * 100 ) );

								if ( 0.0 === $value && '' === $label ) {
									continue;
								}
								?>
								<div
									class="aar-report-figure-card-graph__row"
									style="--aar-value: <?php echo esc_attr( number_format( $percent, 4, '.', '' ) ); ?>%;"
									tabindex="0"
								>
									<div class="aar-report-figure-card-graph__row-meta">
										<?php if ( $label ) : ?>
											<span class="aar-report-figure-card-graph__label"><?php echo esc_html( $label ); ?></span>
										<?php endif; ?>
										<span class="aar-report-figure-card-graph__value"><?php echo esc_html( (string) $value ); ?>%</span>
									</div>
									<div class="aar-report-figure-card-graph__row-track">
										<div class="aar-report-figure-card-graph__bar aar-report-figure-card-graph__bar--tone-<?php echo esc_attr( $tone ); ?>"></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<div class="aar-report-figure-card-graph__bars" role="img" aria-label="<?php echo esc_attr( wp_strip_all_tags( $args['title'] . ' ' . $args['subtitle'] ) ); ?>">
							<?php foreach ( $bars as $bar ) : ?>
								<?php
								$value   = isset( $bar['value'] ) ? (float) $bar['value'] : 0;
								$label   = isset( $bar['label'] ) ? (string) $bar['label'] : '';
								$tone    = function_exists( 'gc_aar_report_graph_normalize_tone' )
									? gc_aar_report_graph_normalize_tone( isset( $bar['tone'] ) ? $bar['tone'] : 'royal' )
									: 'royal';
								$percent = function_exists( 'gc_aar_report_graph_get_percent' )
									? gc_aar_report_graph_get_percent( $value, $max )
									: min( 100, max( 0, ( $value / $max ) * 100 ) );

								if ( 0.0 === $value && '' === $label ) {
									continue;
								}
								?>
								<div
									class="aar-report-figure-card-graph__bar-item"
									style="--aar-value: <?php echo esc_attr( number_format( $percent, 4, '.', '' ) ); ?>;"
									tabindex="0"
								>
									<div class="aar-report-figure-card-graph__bar-column">
										<span class="aar-report-figure-card-graph__value"><?php echo esc_html( (string) $value ); ?>%</span>
										<div class="aar-report-figure-card-graph__bar-track">
											<div class="aar-report-figure-card-graph__bar aar-report-figure-card-graph__bar--tone-<?php echo esc_attr( $tone ); ?>"></div>
										</div>
									</div>
									<?php if ( $label ) : ?>
										<span class="aar-report-figure-card-graph__label"><?php echo esc_html( $label ); ?></span>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $args['footer'] ) : ?>
					<p class="aar-report-figure-card-graph__footer"><?php echo esc_html( $args['footer'] ); ?></p>
				<?php endif; ?>
			</div>
		</figure>
		<?php
	}
}
