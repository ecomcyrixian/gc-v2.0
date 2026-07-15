<?php
/**
 * Reusable report data table markup.
 *
 * @param array $args {
 *     @type string $caption        Optional table caption (screen-reader only).
 *     @type array  $columns        Column headings (string or array with label + colspan keys).
 *     @type array  $rows           Rows of cell values, or rows with cells + optional class keys.
 *     @type string $wrap_class     Optional extra class on the wrapper div.
 *     @type string $table_class    Optional extra class on the table.
 *     @type array  $column_widths  Optional body column widths as % (may exceed header count when using colspan).
 *     @type string $footnote       Optional note below the table (limited HTML via wp_kses_post).
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_render_data_table' ) ) {
	function gc_aar_report_render_data_table( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'caption'       => '',
				'columns'       => array(),
				'rows'          => array(),
				'wrap_class'    => '',
				'table_class'   => '',
				'column_widths' => array(),
				'footnote'      => '',
			)
		);

		$columns = is_array( $args['columns'] ) ? $args['columns'] : array();
		$rows    = is_array( $args['rows'] ) ? $args['rows'] : array();

		if ( empty( $columns ) || empty( $rows ) ) {
			return;
		}

		$body_column_count = count( $columns );
		if ( ! empty( $args['column_widths'] ) ) {
			$body_column_count = count( $args['column_widths'] );
		} else {
			$first_row = reset( $rows );
			if ( is_array( $first_row ) ) {
				if ( isset( $first_row['cells'] ) && is_array( $first_row['cells'] ) ) {
					$body_column_count = count( $first_row['cells'] );
				} else {
					$body_column_count = count( $first_row );
				}
			}
		}

		$col_equal = $body_column_count > 0 ? round( 100 / $body_column_count, 6 ) : 100;

		$widths = array();
		if ( ! empty( $args['column_widths'] ) && count( $args['column_widths'] ) === $body_column_count ) {
			$widths = array_map( 'floatval', $args['column_widths'] );
		} else {
			for ( $i = 0; $i < $body_column_count; $i++ ) {
				$widths[] = $col_equal;
			}
		}

		$wrap_classes  = array( 'aar-report-data-table-wrap' );
		$table_classes = array( 'aar-report-data-table' );

		if ( $args['wrap_class'] ) {
			$wrap_classes[] = $args['wrap_class'];
		}
		if ( $args['table_class'] ) {
			$table_classes[] = $args['table_class'];
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrap_classes ) ); ?>">
			<table class="<?php echo esc_attr( implode( ' ', $table_classes ) ); ?>">
				<?php if ( $args['caption'] ) : ?>
					<caption class="screen-reader-text"><?php echo esc_html( $args['caption'] ); ?></caption>
				<?php endif; ?>
				<colgroup>
					<?php foreach ( $widths as $w ) : ?>
						<col style="width: <?php echo esc_attr( (string) $w ); ?>%" />
					<?php endforeach; ?>
				</colgroup>
				<thead>
					<tr>
						<?php foreach ( $columns as $column ) : ?>
							<?php
							if ( is_array( $column ) ) {
								$label   = isset( $column['label'] ) ? (string) $column['label'] : '';
								$colspan = isset( $column['colspan'] ) ? max( 1, (int) $column['colspan'] ) : 1;
							} else {
								$label   = (string) $column;
								$colspan = 1;
							}
							?>
							<th scope="col"<?php echo $colspan > 1 ? ' colspan="' . esc_attr( (string) $colspan ) . '"' : ''; ?>><?php echo esc_html( $label ); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rows as $row ) : ?>
						<?php
						$row_class = '';
						$cells     = array();

						if ( isset( $row['cells'] ) && is_array( $row['cells'] ) ) {
							$cells     = $row['cells'];
							$row_class = isset( $row['class'] ) ? (string) $row['class'] : '';
						} elseif ( is_array( $row ) ) {
							$cells = $row;
						}

						if ( empty( $cells ) ) {
							continue;
						}
						?>
						<tr<?php echo $row_class ? ' class="' . esc_attr( $row_class ) . '"' : ''; ?>>
							<?php foreach ( $cells as $cell ) : ?>
								<td><?php echo esc_html( $cell ); ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
		if ( $args['footnote'] ) {
			echo '<p class="aar-report-data-table-footnote">' . wp_kses_post( $args['footnote'] ) . '</p>';
		}
	}
}
