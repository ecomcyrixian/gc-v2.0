<?php
/**
 * Shared report graph renderer.
 *
 * @param array $args {
 *     @type string $title        Optional figure title.
 *     @type string $intro         Optional introductory copy above the figure title.
 *     @type string $orientation  horizontal|vertical.
 *     @type string $layout       single|duo.
 *     @type bool   $motion       Enable parallax and reveal motion.
 *     @type array  $panels       Chart panel definitions.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_graph_get_allowed_tones' ) ) {
	function gc_aar_report_graph_get_allowed_tones() {
		return array( 'royal', 'cyan', 'navy', 'lavender', 'indigo', 'red' );
	}
}

if ( ! function_exists( 'gc_aar_report_graph_normalize_tone' ) ) {
	function gc_aar_report_graph_normalize_tone( $tone ) {
		$tone = sanitize_key( (string) $tone );
		return in_array( $tone, gc_aar_report_graph_get_allowed_tones(), true ) ? $tone : 'royal';
	}
}

if ( ! function_exists( 'gc_aar_report_graph_build_ticks' ) ) {
	function gc_aar_report_graph_build_ticks( $max ) {
		$max = max( 1, (int) $max );

		if ( $max <= 50 ) {
			$step = 10;
		} elseif ( $max <= 80 ) {
			$step = 20;
		} else {
			$step = 10;
		}

		$ticks = array();
		for ( $value = 0; $value <= $max; $value += $step ) {
			$ticks[] = $value;
		}

		if ( end( $ticks ) !== $max ) {
			$ticks[] = $max;
		}

		return array_values( array_unique( $ticks ) );
	}
}

if ( ! function_exists( 'gc_aar_report_graph_get_percent' ) ) {
	function gc_aar_report_graph_get_percent( $value, $max ) {
		$value = (float) $value;
		$max   = max( 1, (float) $max );

		return min( 100, max( 0, ( $value / $max ) * 100 ) );
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_ticks' ) ) {
	function gc_aar_report_graph_render_ticks( $ticks, $max, $orientation ) {
		$max = max( 1, (int) $max );

		foreach ( $ticks as $tick ) {
			$position = gc_aar_report_graph_get_percent( $tick, $max );
			?>
			<span
				class="aar-report-graph__tick"
				style="--aar-tick-position: <?php echo esc_attr( number_format( $position, 4, '.', '' ) ); ?>;"
			>
				<span class="aar-report-graph__tick-label"><?php echo esc_html( (string) $tick ); ?></span>
			</span>
			<?php
		}
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_gridlines' ) ) {
	function gc_aar_report_graph_render_gridlines( $ticks, $max ) {
		$max = max( 1, (int) $max );

		foreach ( $ticks as $tick ) {
			$position = gc_aar_report_graph_get_percent( $tick, $max );
			?>
			<span
				class="aar-report-graph__gridline"
				style="--aar-tick-position: <?php echo esc_attr( number_format( $position, 4, '.', '' ) ); ?>%;"
				aria-hidden="true"
			></span>
			<?php
		}
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_reference' ) ) {
	function gc_aar_report_graph_render_reference( $reference, $max, $orientation ) {
		if ( ! is_array( $reference ) ) {
			return;
		}

		$has_value = array_key_exists( 'value', $reference ) && '' !== $reference['value'];
		$has_label = ! empty( $reference['label'] );

		if ( ! $has_value && ! $has_label ) {
			return;
		}

		$value    = isset( $reference['value'] ) ? (float) $reference['value'] : 0;
		$label    = isset( $reference['label'] ) ? (string) $reference['label'] : '';
		$position = gc_aar_report_graph_get_percent( $value, $max );
		?>
		<div
			class="aar-report-graph__reference"
			style="--aar-reference-position: <?php echo esc_attr( number_format( $position, 4, '.', '' ) ); ?>;"
		>
			<span class="aar-report-graph__reference-line" aria-hidden="true"></span>
			<?php if ( $label ) : ?>
				<span class="aar-report-graph__reference-label"><?php echo esc_html( $label ); ?></span>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_divider' ) ) {
	function gc_aar_report_graph_render_divider( $divider, $layout = 'default' ) {
		$label = isset( $divider['label'] ) ? (string) $divider['label'] : '';

		if ( 'horizontal' === $layout ) {
			?>
			<div class="aar-report-graph__divider aar-report-graph__divider--horizontal" role="presentation">
				<div class="aar-report-graph__divider-track">
					<span class="aar-report-graph__divider-line" aria-hidden="true"></span>
					<?php if ( $label ) : ?>
						<span class="aar-report-graph__divider-label"><?php echo esc_html( $label ); ?></span>
					<?php endif; ?>
				</div>
			</div>
			<?php
			return;
		}
		?>
		<div class="aar-report-graph__divider" role="presentation">
			<span class="aar-report-graph__divider-line" aria-hidden="true"></span>
			<?php if ( $label ) : ?>
				<span class="aar-report-graph__divider-label"><?php echo esc_html( $label ); ?></span>
			<?php endif; ?>
			<span class="aar-report-graph__divider-line" aria-hidden="true"></span>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_horizontal_tick_marks' ) ) {
	function gc_aar_report_graph_render_horizontal_tick_marks( $ticks, $max ) {
		$max = max( 1, (int) $max );

		foreach ( $ticks as $tick ) {
			$position = gc_aar_report_graph_get_percent( $tick, $max );
			?>
			<span
				class="aar-report-graph__x-axis-mark"
				style="--aar-tick-position: <?php echo esc_attr( number_format( $position, 4, '.', '' ) ); ?>;"
			></span>
			<?php
		}
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_horizontal_axis' ) ) {
	function gc_aar_report_graph_render_horizontal_axis( $ticks, $max, $x_label = '', $footer = '', $callout = '' ) {
		$max = max( 1, (int) $max );
		?>
		<div class="aar-report-graph__x-axis">
			<div class="aar-report-graph__x-axis-grid">
				<div class="aar-report-graph__x-axis-gutter" aria-hidden="true"></div>
				<div class="aar-report-graph__x-axis-scale">
					<div class="aar-report-graph__x-axis-line-band">
						<span class="aar-report-graph__x-axis-line" aria-hidden="true"></span>
						<div class="aar-report-graph__x-axis-marks" aria-hidden="true">
							<?php gc_aar_report_graph_render_horizontal_tick_marks( $ticks, $max ); ?>
						</div>
					</div>
					<div class="aar-report-graph__ticks aar-report-graph__ticks--x" aria-hidden="true">
						<?php gc_aar_report_graph_render_ticks( $ticks, $max, 'horizontal' ); ?>
					</div>
					<?php if ( $x_label || $footer || $callout ) : ?>
						<div class="aar-report-graph__x-axis-meta">
							<?php if ( $x_label ) : ?>
								<p class="aar-report-graph__axis-label aar-report-graph__axis-label--x"><?php echo esc_html( $x_label ); ?></p>
							<?php endif; ?>
							<?php if ( $callout ) : ?>
								<div class="aar-report-graph__callout aar-report-graph__callout--axis"><?php echo esc_html( $callout ); ?></div>
							<?php endif; ?>
							<?php if ( $footer ) : ?>
								<p class="aar-report-graph__footer"><?php echo esc_html( $footer ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="aar-report-graph__x-axis-gutter aar-report-graph__x-axis-gutter--values" aria-hidden="true"></div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_vertical_dataset' ) ) {
	function gc_aar_report_graph_render_vertical_dataset( $bars, $max, $section = 'all' ) {
		$max       = max( 1, (int) $max );
		$bar_count     = count( $bars );
		$bar_max_width = 2 === $bar_count ? '268px' : '154px';
		$bar_style     = '--aar-bar-count: ' . max( 1, $bar_count ) . '; --aar-bar-max-width: ' . $bar_max_width . '; --aar-y-max: ' . $max . ';';
		$sections  = array( 'bars', 'categories' );

		if ( in_array( $section, $sections, true ) ) {
			$sections = array( $section );
		}

		if ( in_array( 'bars', $sections, true ) ) :
			?>
		<div class="aar-report-graph__bars" style="<?php echo esc_attr( $bar_style ); ?>">
			<?php foreach ( $bars as $bar ) : ?>
				<?php
				$value    = isset( $bar['value'] ) ? (float) $bar['value'] : 0;
				$label    = isset( $bar['label'] ) ? (string) $bar['label'] : '';
				$sublabel = isset( $bar['sublabel'] ) ? (string) $bar['sublabel'] : '';
				$tone     = gc_aar_report_graph_normalize_tone( isset( $bar['tone'] ) ? $bar['tone'] : 'royal' );
				$percent  = gc_aar_report_graph_get_percent( $value, $max );

				if ( 0.0 === $value && '' === $label && '' === $sublabel ) {
					continue;
				}
				?>
				<div
					class="aar-report-graph__bar-item"
					style="--aar-value: <?php echo esc_attr( number_format( $percent, 4, '.', '' ) ); ?>;"
					tabindex="0"
				>
					<div class="aar-report-graph__bar-data">
						<span class="aar-report-graph__value"><?php echo esc_html( (string) $value ); ?>%</span>
						<div class="aar-report-graph__bar-track">
							<div class="aar-report-graph__bar aar-report-graph__bar--tone-<?php echo esc_attr( $tone ); ?>"></div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
			<?php
		endif;

		if ( in_array( 'categories', $sections, true ) ) :
			?>
		<div class="aar-report-graph__category-row" style="<?php echo esc_attr( $bar_style ); ?>">
			<?php foreach ( $bars as $bar ) : ?>
				<?php
				$label    = isset( $bar['label'] ) ? (string) $bar['label'] : '';
				$sublabel = isset( $bar['sublabel'] ) ? (string) $bar['sublabel'] : '';

				if ( '' === $label && '' === $sublabel ) {
					continue;
				}
				?>
				<div class="aar-report-graph__category">
					<?php if ( $label ) : ?>
						<span class="aar-report-graph__label"><?php echo esc_html( $label ); ?></span>
					<?php endif; ?>
					<?php if ( $sublabel ) : ?>
						<span class="aar-report-graph__sublabel">(<?php echo esc_html( $sublabel ); ?>)</span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_horizontal_bars' ) ) {
	function gc_aar_report_graph_render_horizontal_bars( $bars, $max, $dividers = array() ) {
		$max = max( 1, (int) $max );
		$divider_map = array();

		foreach ( $dividers as $divider ) {
			if ( ! is_array( $divider ) || ! isset( $divider['after'] ) ) {
				continue;
			}

			$divider_map[ (int) $divider['after'] ] = $divider;
		}
		?>
		<div class="aar-report-graph__rows">
			<?php foreach ( $bars as $index => $bar ) : ?>
				<?php
				$label    = isset( $bar['label'] ) ? (string) $bar['label'] : '';
				$sublabel = isset( $bar['sublabel'] ) ? (string) $bar['sublabel'] : '';
				$value    = isset( $bar['value'] ) ? (float) $bar['value'] : 0;
				$tone     = gc_aar_report_graph_normalize_tone( isset( $bar['tone'] ) ? $bar['tone'] : 'royal' );
				$percent  = gc_aar_report_graph_get_percent( $value, $max );

				if ( '' === $label && 0.0 === $value ) {
					continue;
				}
				$row_classes = array( 'aar-report-graph__row' );
				$has_divider = isset( $divider_map[ $index + 1 ] );

				if ( $has_divider ) {
					$row_classes[] = 'aar-report-graph__row--with-divider';
				}
				?>
				<div
					class="<?php echo esc_attr( implode( ' ', $row_classes ) ); ?>"
					style="--aar-value: <?php echo esc_attr( number_format( $percent, 4, '.', '' ) ); ?>%;"
					tabindex="0"
				>
					<div class="aar-report-graph__row-label">
						<?php if ( $label ) : ?>
							<span class="aar-report-graph__label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
						<?php if ( $sublabel ) : ?>
							<span class="aar-report-graph__sublabel"><?php echo esc_html( $sublabel ); ?></span>
						<?php endif; ?>
					</div>
					<div class="aar-report-graph__row-track">
						<div class="aar-report-graph__row-fill aar-report-graph__bar--tone-<?php echo esc_attr( $tone ); ?>" aria-hidden="true"></div>
						<span class="aar-report-graph__row-value"><?php echo esc_html( (string) $value ); ?>%</span>
					</div>
					<?php if ( $has_divider ) : ?>
						<?php gc_aar_report_graph_render_divider( $divider_map[ $index + 1 ], 'horizontal' ); ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_panel' ) ) {
	function gc_aar_report_graph_render_panel( $panel, $orientation ) {
		$panel = wp_parse_args(
			is_array( $panel ) ? $panel : array(),
			array(
				'title'     => '',
				'y_label'   => '',
				'x_label'   => '',
				'max'       => 100,
				'ticks'     => array(),
				'bars'      => array(),
				'reference' => array(),
				'dividers'  => array(),
				'footer'    => '',
				'callout'   => '',
			)
		);

		$bars = is_array( $panel['bars'] ) ? array_values( array_filter( $panel['bars'] ) ) : array();
		if ( empty( $bars ) ) {
			return;
		}

		$max         = max( 1, (int) $panel['max'] );
		$ticks       = is_array( $panel['ticks'] ) && ! empty( $panel['ticks'] ) ? $panel['ticks'] : gc_aar_report_graph_build_ticks( $max );
		$dividers    = is_array( $panel['dividers'] ) ? $panel['dividers'] : array();
		$reference   = is_array( $panel['reference'] ) ? $panel['reference'] : array();
		$orientation = in_array( $orientation, array( 'horizontal', 'vertical' ), true ) ? $orientation : 'horizontal';
		?>
		<div class="aar-report-graph__panel">
			<?php if ( $panel['title'] ) : ?>
				<div class="aar-report-graph__panel-title"><?php echo esc_html( $panel['title'] ); ?></div>
			<?php endif; ?>

			<div class="aar-report-graph__chart-frame">
				<div class="aar-report-graph__plot aar-report-graph__plot--<?php echo esc_attr( $orientation ); ?>">
					<?php if ( 'vertical' === $orientation ) : ?>
						<?php
						$chart_body_classes = array( 'aar-report-graph__chart-body' );

						if ( $panel['y_label'] ) {
							$chart_body_classes[] = 'aar-report-graph__chart-body--with-y-label';
						}
						?>
						<div class="<?php echo esc_attr( implode( ' ', $chart_body_classes ) ); ?>" style="--aar-chart-plot-height: 400px; --aar-y-max: <?php echo esc_attr( (string) $max ); ?>;">
							<?php if ( $panel['y_label'] ) : ?>
								<p class="aar-report-graph__axis-label aar-report-graph__axis-label--y"><?php echo esc_html( $panel['y_label'] ); ?></p>
							<?php endif; ?>

							<div class="aar-report-graph__scale" aria-hidden="true">
								<?php gc_aar_report_graph_render_ticks( $ticks, $max, $orientation ); ?>
							</div>

							<div class="aar-report-graph__plot-stack">
								<div class="aar-report-graph__plot-area">
									<?php if ( ! empty( $reference ) ) : ?>
										<?php gc_aar_report_graph_render_reference( $reference, $max, $orientation ); ?>
									<?php endif; ?>

									<?php gc_aar_report_graph_render_vertical_dataset( $bars, $max, 'bars' ); ?>
								</div>
								<?php gc_aar_report_graph_render_vertical_dataset( $bars, $max, 'categories' ); ?>
							</div>
						</div>
					<?php else : ?>
						<div class="aar-report-graph__plot-area">
							<?php gc_aar_report_graph_render_horizontal_bars( $bars, $max, $dividers ); ?>
						</div>

						<?php gc_aar_report_graph_render_horizontal_axis( $ticks, $max, $panel['x_label'], $panel['footer'], $panel['callout'] ); ?>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $panel['callout'] && 'vertical' === $orientation ) : ?>
				<div class="aar-report-graph__callout"><?php echo esc_html( $panel['callout'] ); ?></div>
			<?php endif; ?>

			<?php if ( $panel['footer'] && 'vertical' === $orientation ) : ?>
				<p class="aar-report-graph__footer"><?php echo esc_html( $panel['footer'] ); ?></p>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gc_aar_report_render_graph' ) ) {
	function gc_aar_report_render_graph( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'title'       => '',
				'intro'       => '',
				'orientation' => 'horizontal',
				'layout'      => 'single',
				'motion'      => true,
				'panels'      => array(),
			)
		);

		$panels = is_array( $args['panels'] ) ? array_values( array_filter( $args['panels'] ) ) : array();
		if ( empty( $panels ) ) {
			return;
		}

		$orientation = in_array( $args['orientation'], array( 'horizontal', 'vertical' ), true ) ? $args['orientation'] : 'horizontal';
		$layout      = in_array( $args['layout'], array( 'single', 'duo' ), true ) ? $args['layout'] : 'single';
		$motion      = (bool) $args['motion'];

		$classes = array(
			'aar-report-graph',
			'aar-report-graph--' . $orientation,
			'aar-report-graph--' . $layout,
		);

		if ( $motion ) {
			$classes[] = 'aar-report-graph--motion';
		}
		?>
		<figure class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo $motion ? ' data-aar-graph-motion="true"' : ''; ?>>
			<?php if ( $args['intro'] ) : ?>
				<div class="aar-report-graph__intro">
					<p><?php echo esc_html( $args['intro'] ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( $args['title'] ) : ?>
				<figcaption class="aar-report-graph__title"><?php echo esc_html( $args['title'] ); ?></figcaption>
			<?php endif; ?>

			<div class="aar-report-graph__panels">
				<?php foreach ( $panels as $panel ) : ?>
					<?php gc_aar_report_graph_render_panel( $panel, $orientation ); ?>
				<?php endforeach; ?>
			</div>
		</figure>
		<?php
	}
}
