<?php
/**
 * Pricing compare page content.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/static/pricing-compare/content.php';
require_once get_template_directory() . '/static/shared/content.php';

$pc        = gc_static_pricing_compare_content();
$pc_config = gc_static_pricing_compare_config();
$pc_annual = gc_static_pricing_compare_annual( $pc_config['checks'], 'current' );

$pc_icon = function ( $name, $modifiers = array() ) {
	$classes = array_merge( array( 've-icon' ), $modifiers );

	return '<svg class="' . esc_attr( implode( ' ', $classes ) ) . '" aria-hidden="true"><use href="#pc-icon-' . esc_attr( $name ) . '"></use></svg>';
};

$pc_cell = function ( $cell ) use ( $pc_icon ) {
	$html = '';

	if ( ! empty( $cell['tag'] ) ) {
		$html .= '<span class="pc-tag pc-tag--' . esc_attr( $cell['tag'] ) . '">' . esc_html( $cell['tag_label'] ) . '</span>';
	}

	if ( ! empty( $cell['yes'] ) ) {
		$html .= '<span class="pc-yes">' . $pc_icon( 'check', array( 've-icon--line', 've-icon--ok' ) ) . esc_html( $cell['yes'] ) . '</span>';
	}

	if ( isset( $cell['strong'] ) ) {
		$html .= '<b class="num">' . esc_html( $cell['strong'] );
		if ( ! empty( $cell['sup'] ) ) {
			$html .= '<sup>' . esc_html( $cell['sup'] ) . '</sup>';
		}
		$html .= '</b>';
	} elseif ( ! empty( $cell['sup'] ) ) {
		$html .= '<sup>' . esc_html( $cell['sup'] ) . '</sup>';
	}

	if ( isset( $cell['text'] ) ) {
		$html .= '<span' . ( ! empty( $cell['dim'] ) ? ' class="pc-dim"' : '' ) . '>' . esc_html( $cell['text'] ) . '</span>';
	} elseif ( ! empty( $cell['dim'] ) && is_string( $cell['dim'] ) ) {
		$html .= '<span class="pc-dim">' . esc_html( $cell['dim'] ) . '</span>';
	}

	if ( ! empty( $cell['after'] ) ) {
		$html .= '<br><span class="pc-dim">' . esc_html( $cell['after'] ) . '</span>';
	}

	return $html;
};

?>
<svg class="ve-sprite" aria-hidden="true" focusable="false">
	<symbol id="pc-icon-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="m7.5 12.5 3 3 6-6.5"></path></symbol>
	<symbol id="pc-icon-shield" viewBox="0 0 24 24"><path d="M12 3 4.5 6v5.5c0 4.5 3.2 8.4 7.5 9.5 4.3-1.1 7.5-5 7.5-9.5V6L12 3Z"></path><path d="m9 12 2 2 4-4"></path></symbol>
	<symbol id="pc-icon-receipt" viewBox="0 0 24 24"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3Z"></path><path d="M9 8h6M9 12h6M9 16h3"></path></symbol>
	<symbol id="pc-icon-eye" viewBox="0 0 24 24"><path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"></path><circle cx="12" cy="12" r="2.8"></circle></symbol>
	<symbol id="pc-icon-scale" viewBox="0 0 24 24"><path d="M12 4v16M7 20h10M5 7h14"></path><path d="m5 7-2.5 6a2.8 2.8 0 0 0 5 0L5 7ZM19 7l-2.5 6a2.8 2.8 0 0 0 5 0L19 7Z"></path></symbol>
	<symbol id="pc-icon-lock" viewBox="0 0 24 24"><rect x="5" y="10.5" width="14" height="10" rx="2"></rect><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"></path></symbol>
</svg>

<section class="pc-hero" aria-labelledby="pc-hero-title">
	<div class="container pc-hero__grid">
		<div class="pc-hero__copy">
			<p class="pc-kicker">Background check pricing, compared</p>
			<h1 class="pc-hero__h1" id="pc-hero-title">Background check pricing <span class="pc-hero__accent">compared (2026)</span><span class="pc-hero__vs">GCheck vs Checkr, GoodHire, HireRight, BackgroundChecks.com, First Advantage and Sterling</span></h1>
			<p class="pc-hero__lede"><?php echo gc_static_pricing_compare_kses( $pc['lede'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<dl class="pc-hero__next">
				<?php foreach ( $pc['next'] as $group ) : ?>
					<div>
						<dt><?php echo esc_html( $group['label'] ); ?></dt>
						<dd>
							<?php foreach ( $group['items'] as $item ) : ?>
								<span><?php if ( ! empty( $item['price'] ) ) : ?><b class="num"><?php echo esc_html( $item['price'] ); ?></b> <?php endif; ?><?php echo esc_html( $item['name'] ); ?></span>
							<?php endforeach; ?>
						</dd>
					</div>
				<?php endforeach; ?>
			</dl>
			<p class="pc-meta">
				<span>Updated <b><time datetime="<?php echo esc_attr( $pc_config['updated_iso'] ); ?>"><?php echo esc_html( $pc_config['updated'] ); ?></time></b></span>
				<span>Prices from each provider's own website</span>
				<span>GCheck publishes this page and is one of the providers compared.</span>
			</p>
			<div class="pc-hero__ctas">
				<a class="button white" href="<?php echo esc_url( $pc['demo'] ); ?>">Book a demo</a>
				<a class="button ghost" href="#pc-compare">See the comparison</a>
			</div>
		</div>
		<aside class="pc-ticket" aria-label="GCheck Basic package">
			<p class="pc-ticket__label">GCheck Basic</p>
			<div class="pc-ticket__price">
				<span class="pc-ticket__cur">$</span>
				<span class="pc-ticket__amt num"><?php echo esc_html( number_format( $pc_config['base'], 2 ) ); ?></span>
				<span class="pc-ticket__per">per check</span>
			</div>
			<ul class="pc-ticket__list">
				<?php foreach ( $pc['ticket'] as $item ) : ?>
					<li>
						<?php echo $pc_icon( 'check', array( 've-icon--line', 've-icon--ok' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php if ( ! empty( $item['strong'] ) ) : ?><b><?php echo esc_html( $item['strong'] ); ?></b><br><?php endif; ?><?php echo esc_html( $item['text'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<p class="pc-ticket__foot">GCheck Standard <b class="num"><?php echo esc_html( gc_static_pricing_compare_money( $pc_config['standard'] ) ); ?></b>: unlimited counties of residence.<br>GCheck Advanced <b class="num"><?php echo esc_html( gc_static_pricing_compare_money( $pc_config['advanced'] ) ); ?></b>: adds federal criminal search.<br>Third-party fees passed through with no markup.<sup>1</sup></p>
		</aside>
	</div>
</section>

<?php
gc_static_render_proof(
	array(
		'eyebrow' => 'G2 badges, 2026',
		'badges'  => $pc['badges'],
		'chips'   => array_map(
			function ( $chip ) use ( $pc_icon ) {
				return array(
					'icon'  => $pc_icon( $chip['icon'], array( 've-icon--line' ) ),
					'label' => $chip['label'],
				);
			},
			$pc['chips']
		),
	)
);
?>

<nav class="pc-toc" aria-label="On this page">
	<div class="container pc-toc__inner">
		<span class="pc-toc__label">On this page</span>
		<ul>
			<?php foreach ( $pc['toc'] as $item ) : ?>
				<li><a href="<?php echo esc_url( $item['href'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>

<section class="ve-section" id="pc-quick" aria-labelledby="pc-quick-h">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="pc-quick-h"><span>Quick answer</span>Seven background check providers, by lowest published price with a county search</h2>
		</div>
		<ol class="pc-quick">
			<?php foreach ( $pc['quick'] as $item ) : ?>
				<li>
					<span class="pc-quick__n num"><?php echo esc_html( $item['n'] ); ?></span>
					<a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['name'] ); ?></a>
					<span><?php echo gc_static_pricing_compare_kses( $item['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</li>
			<?php endforeach; ?>
		</ol>
		<?php
		gc_static_render_stats(
			array(
				'items'       => $pc['stats'],
				'value_class' => 'num',
			)
		);
		?>
		<p class="ve-source"><?php echo gc_static_pricing_compare_kses( $pc['stats_source'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	</div>
</section>

<section class="ve-section ve-section--tint" id="pc-compare" aria-labelledby="pc-compare-h">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="pc-compare-h"><span>Side by side</span>Background check prices by coverage level</h2>
			<p>Each provider's lowest published per-check price for the same coverage. Where a provider doesn't publish a price, we say so instead of estimating.</p>
		</div>
		<div class="pc-table-wrap" tabindex="0" role="region" aria-label="Pricing comparison table">
			<table class="pc-table">
				<colgroup>
					<col class="pc-c-row">
					<?php foreach ( $pc['columns'] as $column ) : ?>
						<col<?php echo ! empty( $column['key'] ) ? ' class="pc-c-key"' : ''; ?>>
					<?php endforeach; ?>
				</colgroup>
				<thead>
					<tr>
						<th scope="col">Provider</th>
						<?php foreach ( $pc['columns'] as $column ) : ?>
							<th scope="col"<?php echo ! empty( $column['key'] ) ? ' class="pc-k"' : ''; ?>>
								<?php echo esc_html( $column['label'] ); ?>
								<?php if ( ! empty( $column['note'] ) ) : ?>
									<small><?php echo esc_html( $column['note'] ); ?></small>
								<?php endif; ?>
							</th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $pc['rows'] as $row ) : ?>
						<tr<?php echo ! empty( $row['us'] ) ? ' class="pc-us"' : ''; ?>>
							<th scope="row">
								<a href="#<?php echo esc_attr( $row['id'] ); ?>"><?php echo esc_html( $row['name'] ); ?></a>
								<?php if ( ! empty( $row['note'] ) ) : ?>
									<small><?php echo esc_html( $row['note'] ); ?></small>
								<?php endif; ?>
							</th>
							<?php foreach ( $row['cells'] as $index => $cell ) : ?>
								<?php $column = $pc['columns'][ $index ]; ?>
								<td data-label="<?php echo esc_attr( $column['label'] ); ?>"<?php echo ! empty( $column['key'] ) ? ' class="pc-k"' : ''; ?>>
									<?php echo $pc_cell( $cell ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<p class="ve-source"><?php echo gc_static_pricing_compare_kses( $pc['compare_note'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	</div>
</section>

<section class="ve-section" id="pc-calc" aria-labelledby="pc-calc-h">
	<div class="container pc-calc">
		<div class="pc-calc__copy">
			<span class="pc-pilltag">Savings calculator</span>
			<h2 class="pc-calc__h" id="pc-calc-h">See how much you'd save with GCheck each year</h2>
			<p>Pick your coverage and checks per year to compare annual spend at each provider's lowest published price. Quote-based providers are left out instead of estimated. Most providers offer volume pricing at higher volumes, so treat this as list price.</p>
		</div>
		<div class="pc-flow">
			<div class="pc-save">
				<span>Your estimated savings</span>
				<strong class="num" id="pc-save-v"><?php echo esc_html( gc_static_pricing_compare_money( $pc_annual['save'], 0 ) ); ?></strong>
				<span id="pc-save-t">less per year than the next lowest published price, at <?php echo esc_html( number_format( $pc_annual['checks'] ) ); ?> checks <?php echo esc_html( $pc_annual['text'] ); ?>.</span>
				<span class="pc-save__note">Based on published list prices. Most providers offer volume pricing, so your quote may differ.</span>
			</div>
			<div>
				<span class="pc-flow-label" id="pc-cov-label">Coverage</span>
				<div class="pc-presets" role="group" aria-labelledby="pc-cov-label" id="pc-cov">
					<?php foreach ( $pc['coverages'] as $coverage ) : ?>
						<button type="button" data-cov="<?php echo esc_attr( $coverage['id'] ); ?>" aria-pressed="<?php echo $coverage['id'] === $pc_annual['coverage'] ? 'true' : 'false'; ?>"><?php echo esc_html( $coverage['label'] ); ?></button>
					<?php endforeach; ?>
				</div>
			</div>
			<div>
				<label for="pc-hires">Checks per year</label>
				<div class="pc-range">
					<input type="range" id="pc-hires" min="10" max="2000" step="10" value="<?php echo esc_attr( $pc_annual['checks'] ); ?>" aria-label="Checks per year slider">
					<input type="number" id="pc-hires-num" min="1" max="100000" value="<?php echo esc_attr( $pc_annual['checks'] ); ?>" aria-label="Checks per year">
				</div>
			</div>
			<div class="pc-bars" aria-live="polite">
				<?php foreach ( $pc_config['bars'] as $bar ) : ?>
					<?php
					$pc_total = $pc_annual['totals'][ $bar['index'] ];
					$pc_width = ( null !== $pc_total && $pc_annual['max'] > 0 ) ? ( $pc_total / $pc_annual['max'] * 100 ) : 0;
					$pc_label = null === $pc_total ? 'Not published' : gc_static_pricing_compare_money( $pc_total, 0 );
					$pc_pkg   = isset( $pc_config['bar_labels'][ $pc_annual['coverage'] ][ $bar['index'] ] ) ? $pc_config['bar_labels'][ $pc_annual['coverage'] ][ $bar['index'] ] : '';
					?>
					<div class="pc-bar<?php echo ! empty( $bar['us'] ) ? ' pc-bar--us' : ''; ?>">
						<span class="pc-bar__who"><?php echo esc_html( $bar['name'] ); ?><small class="pc-bar__pkg" id="pc-l<?php echo esc_attr( $bar['index'] ); ?>"><?php echo esc_html( $pc_pkg ); ?></small></span>
						<div class="pc-bar__track"><div class="pc-bar__fill" id="pc-b<?php echo esc_attr( $bar['index'] ); ?>" style="width: <?php echo esc_attr( round( $pc_width, 2 ) ); ?>%"></div></div>
						<span class="pc-bar__amt num" id="pc-a<?php echo esc_attr( $bar['index'] ); ?>"><?php echo esc_html( $pc_label ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="ve-section" id="pc-county" aria-labelledby="pc-county-h">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="pc-county-h"><span>Why the county column matters</span>National database vs. county criminal search</h2>
			<p>Many entry packages run a national criminal database search only. That's a good way to find leads, but it isn't a complete search. Running at least one county search, starting with the candidate's current county, fills the gap.</p>
		</div>
		<div class="pc-method">
			<?php foreach ( $pc['county'] as $card ) : ?>
				<div>
					<strong><?php echo esc_html( $card['title'] ); ?></strong>
					<p><?php echo gc_static_pricing_compare_kses( $card['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="pc-why" id="pc-why-county">
			<h3><span><?php echo esc_html( $pc['why']['eyebrow'] ); ?></span><?php echo esc_html( $pc['why']['title'] ); ?></h3>
			<div class="pc-why__body">
				<?php foreach ( $pc['why']['body'] as $paragraph ) : ?>
					<p><?php echo gc_static_pricing_compare_kses( $paragraph ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endforeach; ?>
				<p class="pc-why__note"><?php echo esc_html( $pc['why']['note'] ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="ve-section ve-section--tint" id="pc-provs" aria-labelledby="pc-provs-h">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="pc-provs-h"><span>Provider by provider</span>What each provider charges, and who it fits</h2>
			<p>GCheck publishes this page and is one of the providers compared. We've noted where a competitor is the better fit.</p>
		</div>
		<div class="pc-provs">
			<?php foreach ( $pc['providers'] as $provider ) : ?>
				<article class="pc-prov<?php echo ! empty( $provider['us'] ) ? ' pc-prov--us' : ''; ?>" id="<?php echo esc_attr( $provider['id'] ); ?>">
					<div class="pc-prov__head">
						<h3><span class="num"><?php echo esc_html( $provider['n'] ); ?></span><?php echo esc_html( $provider['name'] ); ?></h3>
						<p class="pc-prov__lead"><?php echo esc_html( $provider['lead'] ); ?></p>
					</div>
					<dl>
						<?php foreach ( $provider['facts'] as $fact ) : ?>
							<dt><?php echo esc_html( $fact[0] ); ?></dt>
							<dd><?php echo esc_html( $fact[1] ); ?></dd>
						<?php endforeach; ?>
					</dl>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ve-section" id="pc-method" aria-labelledby="pc-method-h">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="pc-method-h"><span>Methodology</span>How we compared prices</h2>
		</div>
		<div class="pc-method">
			<?php foreach ( $pc['method'] as $card ) : ?>
				<div>
					<strong><?php echo esc_html( $card['title'] ); ?></strong>
					<p><?php echo gc_static_pricing_compare_kses( $card['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
gc_static_render_faq(
	array(
		'section_class' => 've-section ve-section--tint faq--collapsible ve-faq',
		'heading_id'    => 'pc-faq-h',
		'eyebrow'       => 'Common questions',
		'title'         => 'Background check pricing, answered',
		'items'         => $pc['faqs'],
		'panel_prefix'  => 'pc-faq-panel',
	)
);
?>

<section class="ve-section" aria-labelledby="pc-cfg-h">
	<div class="container ve-stack">
		<div class="heading ve-heading--xl">
			<h2 id="pc-cfg-h"><span>Compliance for Good<span class="ve-tm">®</span></span>Low price, same standards</h2>
			<p><?php echo gc_static_pricing_compare_kses( $pc['compliance'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		</div>
		<ul class="ve-moments ve-moments--grid">
			<?php foreach ( $pc['moments'] as $moment ) : ?>
				<li>
					<span class="ve-moment__icon"><?php echo $pc_icon( $moment['icon'], array( 've-icon--line', 've-icon--ok' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<strong><?php echo esc_html( $moment['title'] ); ?></strong>
						<span><?php echo esc_html( $moment['text'] ); ?></span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
gc_static_render_banner(
	array(
		'heading_id' => 'pc-cta-h',
		'title_html' => 'National database and county search included, from <span class="num">' . esc_html( gc_static_pricing_compare_money( $pc_config['base'] ) ) . '</span>',
		'text'       => 'No setup fees, no minimums, no long-term contracts. Behind Better Teams.',
		'buttons'    => array(
			array(
				'class' => 'white',
				'href'  => $pc['demo'],
				'label' => 'Book a demo',
			),
			array(
				'class' => 'ghost',
				'href'  => $pc['contact'],
				'label' => 'Talk to sales',
			),
		),
	)
);
?>

<section class="pc-notes" id="pc-sources" aria-labelledby="pc-notes-h">
	<div class="container">
		<h3 id="pc-notes-h">Pricing sources and notes</h3>
		<ol>
			<?php foreach ( $pc['sources'] as $source ) : ?>
				<li><span><?php echo gc_static_pricing_compare_kses( $source ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></li>
			<?php endforeach; ?>
		</ol>
		<p class="pc-source"><?php echo esc_html( $pc['source_change'] ); ?></p>
		<p class="ve-source"><?php echo gc_static_pricing_compare_kses( $pc['source_note'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	</div>
</section>
