<?php
/**
 * Shared report graph renderer.
 *
 * @param array $args {
 *     @type string $title        Optional figure title.
 *     @type string $intro         Optional introductory copy above the figure title.
 *     @type string $orientation  horizontal|vertical.
 *     @type string $layout       single|duo for bars; half|whole for pie.
 *     @type bool   $motion       Enable parallax and reveal motion.
 *     @type array  $panels       Chart panel definitions.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_graph_get_allowed_tones' ) ) {
	function gc_aar_report_graph_get_allowed_tones() {
		return array( 'royal', 'cyan', 'navy', 'lavender', 'indigo', 'red', 'gray', 'black' );
	}
}

if ( ! function_exists( 'gc_aar_report_graph_normalize_tone' ) ) {
	function gc_aar_report_graph_normalize_tone( $tone ) {
		$tone = sanitize_key( (string) $tone );
		return in_array( $tone, gc_aar_report_graph_get_allowed_tones(), true ) ? $tone : 'royal';
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_legend' ) ) {
	function gc_aar_report_graph_render_legend( $legend ) {
		$items = is_array( $legend ) ? array_values( array_filter( $legend ) ) : array();

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="aar-report-graph__legend" aria-label="Chart legend">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$item = wp_parse_args(
					is_array( $item ) ? $item : array(),
					array(
						'text'  => '',
						'tone'  => '',
						'color' => '',
					)
				);

				if ( '' === $item['text'] ) {
					continue;
				}

				$color_key  = sanitize_key( (string) $item['color'] );
				$color      = sanitize_hex_color( $item['color'] );
				$tone       = $item['tone'] ? gc_aar_report_graph_normalize_tone( $item['tone'] ) : '';
				$tone       = ! $tone && $color_key && ! $color ? gc_aar_report_graph_normalize_tone( $color_key ) : $tone;
				$swatch_css = $color ? '--aar-legend-color: ' . $color . ';' : '';
				$classes    = array( 'aar-report-graph__legend-swatch' );

				if ( $tone ) {
					$classes[] = 'aar-report-graph__legend-swatch--tone-' . $tone;
				}
				?>
				<div class="aar-report-graph__legend-item">
					<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" style="<?php echo esc_attr( $swatch_css ); ?>" aria-hidden="true"></span>
					<span class="aar-report-graph__legend-label"><?php echo esc_html( $item['text'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
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

if ( ! function_exists( 'gc_aar_report_graph_render_pie' ) ) {
	function gc_aar_report_graph_render_pie( $bars, $max, $center_value = '', $center_label = '', $layout = 'half' ) {
		$max       = max( 1, (float) $max );
		$offset    = 0;
		$segments  = array();
		$layout    = 'whole' === $layout ? 'whole' : 'half';

		foreach ( $bars as $bar ) {
			$value = isset( $bar['value'] ) ? (float) $bar['value'] : 0;
			$label = isset( $bar['label'] ) ? (string) $bar['label'] : '';

			if ( $value <= 0 && '' === $label ) {
				continue;
			}

			$percent = gc_aar_report_graph_get_percent( $value, $max );
			$tone    = gc_aar_report_graph_normalize_tone( isset( $bar['tone'] ) ? $bar['tone'] : 'royal' );

			$segments[] = array(
				'label'   => $label,
				'value'   => $value,
				'percent' => $percent,
				'offset'  => $offset,
				'tone'    => $tone,
			);

			$offset += $percent;
		}

		if ( empty( $segments ) ) {
			return;
		}

		$center_value = '' !== $center_value ? $center_value : (string) round( min( 100, $offset ) ) . '%';
		$primary_tone = gc_aar_report_graph_normalize_tone( $segments[0]['tone'] ?? 'royal' );
		?>
		<div class="aar-report-graph__pie-wrap aar-report-graph__pie-wrap--<?php echo esc_attr( $layout ); ?> aar-report-graph__pie-wrap--tone-<?php echo esc_attr( $primary_tone ); ?>">
			<div class="aar-report-graph__pie" role="img" aria-label="<?php echo esc_attr( wp_strip_all_tags( $center_value . ' ' . $center_label ) ); ?>">
				<svg class="aar-report-graph__pie-svg" viewBox="0 0 42 42" aria-hidden="true" focusable="false">
					<circle class="aar-report-graph__pie-ring" cx="21" cy="21" r="15.9155"></circle>
					<?php foreach ( $segments as $segment ) : ?>
						<circle
							class="aar-report-graph__pie-segment aar-report-graph__pie-segment--tone-<?php echo esc_attr( $segment['tone'] ); ?>"
							cx="21"
							cy="21"
							r="15.9155"
							pathLength="100"
							style="--aar-pie-value: <?php echo esc_attr( number_format( $segment['percent'], 4, '.', '' ) ); ?>; --aar-pie-rest: <?php echo esc_attr( number_format( 100 - $segment['percent'], 4, '.', '' ) ); ?>; --aar-pie-offset: <?php echo esc_attr( number_format( $segment['offset'], 4, '.', '' ) ); ?>;"
						></circle>
					<?php endforeach; ?>
				</svg>
				<?php if ( 'half' === $layout ) : ?>
					<div class="aar-report-graph__pie-center">
						<span class="aar-report-graph__pie-value"><?php echo esc_html( $center_value ); ?></span>
						<?php if ( $center_label ) : ?>
							<span class="aar-report-graph__pie-label"><?php echo esc_html( $center_label ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( 'whole' === $layout ) : ?>
				<div class="aar-report-graph__pie-outside-value">
					<span class="aar-report-graph__pie-value"><?php echo esc_html( $center_value ); ?></span>
					<?php if ( $center_label ) : ?>
						<span class="aar-report-graph__pie-label"><?php echo esc_html( $center_label ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php
			$legend_segments = array_values(
				array_filter(
					$segments,
					static function ( $segment ) {
						return '' !== $segment['label'];
					}
				)
			);
			$primary_segment = $legend_segments[0] ?? $segments[0];
			$split_segments  = array_slice( $legend_segments, 1 );
			$split_row_class = 'aar-report-graph__pie-legend-row aar-report-graph__pie-legend-row--split';
			if ( 1 === count( $split_segments ) ) {
				$split_row_class .= ' aar-report-graph__pie-legend-row--split-single';
			}
			?>
			<?php if ( ! empty( $legend_segments ) ) : ?>
				<div class="aar-report-graph__pie-legend" aria-hidden="true">
					<?php if ( '' !== $primary_segment['label'] ) : ?>
						<div class="aar-report-graph__pie-legend-row aar-report-graph__pie-legend-row--primary">
							<span class="aar-report-graph__pie-legend-item">
								<span class="aar-report-graph__legend-swatch aar-report-graph__legend-swatch--tone-<?php echo esc_attr( $primary_segment['tone'] ); ?>" aria-hidden="true"></span>
								<?php echo esc_html( $primary_segment['label'] . ' (' . (string) $primary_segment['value'] . '%)' ); ?>
							</span>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $split_segments ) ) : ?>
						<div class="<?php echo esc_attr( $split_row_class ); ?>">
							<?php foreach ( $split_segments as $segment ) : ?>
								<span class="aar-report-graph__pie-legend-item">
									<span class="aar-report-graph__legend-swatch aar-report-graph__legend-swatch--tone-<?php echo esc_attr( $segment['tone'] ); ?>" aria-hidden="true"></span>
									<?php echo esc_html( $segment['label'] . ' (' . (string) $segment['value'] . '%)' ); ?>
								</span>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'gc_aar_report_graph_render_panel' ) ) {
	function gc_aar_report_graph_render_panel( $panel, $orientation, $type = 'bar', $layout = 'single' ) {
		$panel = wp_parse_args(
			is_array( $panel ) ? $panel : array(),
			array(
				'type'      => '',
				'title'     => '',
				'y_label'   => '',
				'x_label'   => '',
				'max'       => 100,
				'ticks'     => array(),
				'bars'      => array(),
				'reference' => array(),
				'dividers'  => array(),
				'legend'    => array(),
				'footer'    => '',
				'callout'   => '',
				'center_value' => '',
				'center_label' => '',
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
		$legend      = is_array( $panel['legend'] ) ? $panel['legend'] : array();
		$type        = $panel['type'] ? sanitize_key( (string) $panel['type'] ) : $type;
		$type        = in_array( $type, array( 'bar', 'pie' ), true ) ? $type : 'bar';
		$orientation = in_array( $orientation, array( 'horizontal', 'vertical' ), true ) ? $orientation : 'horizontal';
		$plot_classes = array(
			'aar-report-graph__plot',
			'aar-report-graph__plot--' . ( 'pie' === $type ? 'pie' : $orientation ),
		);

		if ( 'bar' === $type && 'horizontal' === $orientation && ! empty( array_filter( $legend ) ) ) {
			$plot_classes[] = 'aar-report-graph__plot--has-legend';
		}
		?>
		<div class="aar-report-graph__panel">
			<?php if ( $panel['title'] ) : ?>
				<div class="aar-report-graph__panel-title"><?php echo esc_html( $panel['title'] ); ?></div>
			<?php endif; ?>

			<div class="aar-report-graph__chart-frame">
				<div class="<?php echo esc_attr( implode( ' ', $plot_classes ) ); ?>">
					<?php if ( 'pie' === $type ) : ?>
						<div class="aar-report-graph__plot-area">
							<?php gc_aar_report_graph_render_pie( $bars, $max, $panel['center_value'], $panel['center_label'], $layout ); ?>
						</div>
					<?php elseif ( 'vertical' === $orientation ) : ?>
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
							<?php gc_aar_report_graph_render_legend( $legend ); ?>
						</div>

						<?php gc_aar_report_graph_render_horizontal_axis( $ticks, $max, $panel['x_label'], $panel['footer'], $panel['callout'] ); ?>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $panel['callout'] && 'vertical' === $orientation ) : ?>
				<div class="aar-report-graph__callout"><?php echo esc_html( $panel['callout'] ); ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $legend ) && 'vertical' === $orientation ) : ?>
				<?php gc_aar_report_graph_render_legend( $legend ); ?>
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
				'type'        => 'bar',
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
		$type        = in_array( $args['type'], array( 'bar', 'pie' ), true ) ? $args['type'] : 'bar';
		if ( 'pie' === $type ) {
			$layout = in_array( $args['layout'], array( 'half', 'whole' ), true ) ? $args['layout'] : 'half';
		} else {
			$layout = in_array( $args['layout'], array( 'single', 'duo' ), true ) ? $args['layout'] : 'single';
		}
		$motion      = (bool) $args['motion'];

		$classes = array(
			'aar-report-graph',
			'aar-report-graph--' . ( 'pie' === $type ? 'pie' : $orientation ),
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
				<?php $title = preg_replace( '/<br\s*\/?>/i', '<br>', $args['title'] ); ?>
				<figcaption class="aar-report-graph__title"><?php echo wp_kses( $title, array( 'br' => array() ) ); ?></figcaption>
			<?php endif; ?>

			<div class="aar-report-graph__panels">
				<?php foreach ( $panels as $panel ) : ?>
					<?php gc_aar_report_graph_render_panel( $panel, $orientation, $type, $layout ); ?>
				<?php endforeach; ?>
			</div>
		</figure>
		<?php
	}
}
