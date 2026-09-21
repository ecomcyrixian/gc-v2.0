<?php
/**
 * Consequence Gap split figure card graph — two horizontal bar groups side by side
 * under a shared legend.
 *
 * Deliberately separate from gc_aar_report_render_figure_card_graph() so the existing
 * single-column graph used by the other reports is never affected by changes here.
 * Only the CSS class names are shared.
 *
 * @param array $args {
 *     @type string $badge    Badge label, e.g. "Figure 3".
 *     @type string $title    Figure title beside the badge.
 *     @type string $subtitle Supporting line below the header.
 *     @type int    $max      Scale maximum for bar lengths.
 *     @type array  $legend   Legend items: text, tone.
 *     @type array  $columns  Bar groups, each `array( 'heading' => string, 'bars' => array( label, value, tone ) )`.
 *     @type string $footer   Source / base line.
 *     @type bool   $motion   Enable reveal animation.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_cgr_report_render_split_figure_card_graph' ) ) {
	function gc_cgr_report_render_split_figure_card_graph( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'badge'    => '',
				'title'    => '',
				'subtitle' => '',
				'max'      => 100,
				'legend'   => array(),
				'columns'  => array(),
				'footer'   => '',
				'motion'   => true,
			)
		);

		$columns = array();
		foreach ( (array) $args['columns'] as $column ) {
			$bars = isset( $column['bars'] ) ? $column['bars'] : $column;
			$bars = is_array( $bars ) ? array_values( array_filter( $bars ) ) : array();
			if ( $bars ) {
				$columns[] = array(
					'heading' => isset( $column['heading'] ) ? (string) $column['heading'] : '',
					'bars'    => $bars,
				);
			}
		}

		if ( empty( $columns ) ) {
			return;
		}

		$max        = max( 1, (int) $args['max'] );
		$motion     = (bool) $args['motion'];
		$aria_label = wp_strip_all_tags( $args['title'] . ' ' . $args['subtitle'] );
		$bar_count  = max(
			array_map(
				static function ( $column ) {
					return count( $column['bars'] );
				},
				$columns
			)
		);
		$classes    = array(
			'aar-report-figure-card-graph',
			'aar-report-figure-card-graph--horizontal',
			'aar-report-figure-card-graph--split',
		);

		if ( $motion ) {
			$classes[] = 'aar-report-figure-card-graph--motion';
		}

		$legend = array_filter(
			(array) $args['legend'],
			static function ( $item ) {
				return ! empty( $item['text'] );
			}
		);
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

				<?php if ( $legend ) : ?>
					<div class="aar-report-figure-card-graph__legend">
						<?php foreach ( $legend as $item ) : ?>
							<?php
							$legend_tone = function_exists( 'gc_aar_report_graph_normalize_tone' )
								? gc_aar_report_graph_normalize_tone( isset( $item['tone'] ) ? $item['tone'] : 'royal' )
								: 'royal';
							?>
							<span class="aar-report-figure-card-graph__legend-item">
								<span class="aar-report-figure-card-graph__legend-swatch aar-report-figure-card-graph__legend-swatch--tone-<?php echo esc_attr( $legend_tone ); ?>" aria-hidden="true"></span>
								<span class="aar-report-figure-card-graph__legend-label"><?php echo esc_html( $item['text'] ); ?></span>
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="aar-report-figure-card-graph__chart" style="--aar-bar-count: <?php echo esc_attr( (string) $bar_count ); ?>; --aar-y-max: <?php echo esc_attr( (string) $max ); ?>;">
					<div class="aar-report-figure-card-graph__columns">
						<?php foreach ( $columns as $column ) : ?>
							<div class="aar-report-figure-card-graph__column">
								<?php if ( $column['heading'] ) : ?>
									<p class="aar-report-figure-card-graph__column-heading"><?php echo esc_html( $column['heading'] ); ?></p>
								<?php endif; ?>
								<div class="aar-report-figure-card-graph__bars aar-report-figure-card-graph__bars--horizontal" role="img" aria-label="<?php echo esc_attr( trim( $column['heading'] . ' ' . $aria_label ) ); ?>">
								<?php foreach ( $column['bars'] as $bar ) : ?>
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
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if ( $args['footer'] ) : ?>
					<p class="aar-report-figure-card-graph__footer"><?php echo esc_html( $args['footer'] ); ?></p>
				<?php endif; ?>
			</div>
		</figure>
		<?php
	}
}
