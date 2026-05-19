<?php
/**
 * Shared report content section heading.
 *
 * @param array $args {
 *     @type string $title       Section title.
 *     @type string $subtitle    Optional supporting line.
 *     @type string $id          Optional heading id.
 *     @type string $index       Optional large background index.
 *     @type string $title_tag   Heading tag. Default h2.
 * }
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_aar_report_render_section_heading' ) ) {
	function gc_aar_report_render_section_heading( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'title'     => '',
				'subtitle'  => '',
				'id'        => '',
				'index'     => '',
				'title_tag' => 'h2',
			)
		);

		if ( '' === $args['title'] ) {
			return;
		}

		?>
		<div class="aar-report-section-heading">
			<div class="aar-report-section-heading__inner">
				<h2 class="aar-report-section-heading__title"<?php echo $args['id'] ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>><?php echo esc_html( $args['title'] ); ?></h2>
				<?php if ( $args['subtitle'] ) : ?>
					<div class="aar-report-section-heading__subtitle"><?php echo esc_html( $args['subtitle'] ); ?></div>
				<?php endif; ?>
			</div>
			<?php if ( $args['index'] ) : ?>
				<div class="aar-report-section-heading__index"><?php echo esc_html( (string) $args['index'] ); ?></div>
			<?php endif; ?>
		</div>
		<?php
	}
}
