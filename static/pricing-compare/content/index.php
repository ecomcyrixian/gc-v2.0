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
	$classes = array_merge( array( 'pc-icon' ), $modifiers );

	return '<svg class="' . esc_attr( implode( ' ', $classes ) ) . '" aria-hidden="true"><use href="#pc-icon-' . esc_attr( $name ) . '"></use></svg>';
};

$pc_cell = function ( $cell ) use ( $pc_icon ) {
	$html = '';

	if ( ! empty( $cell['tag'] ) ) {
		$html .= '<span class="pc-tag pc-tag--' . esc_attr( $cell['tag'] ) . '">' . esc_html( $cell['tag_label'] ) . '</span>';
	}

	if ( ! empty( $cell['yes'] ) ) {
		$html .= '<span class="pc-yes">' . $pc_icon( 'check', array() ) . esc_html( $cell['yes'] ) . '</span>';
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
<svg class="pc-sprite" aria-hidden="true" focusable="false">
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
			<h1 class="pc-hero__h1" id="pc-hero-title">Background check pricing <span class="pc-hero__accent">compared (2026)</span><span class="pc-hero__vs">GCheck vs Checkr, GoodHire, HireRight, BackgroundChecks.com, Verified First, First Advantage and Sterling</span></h1>
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
						<?php echo $pc_icon( ! empty( $item['icon'] ) ? $item['icon'] : 'check', array() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php if ( ! empty( $item['strong'] ) ) : ?><b><?php echo esc_html( $item['strong'] ); ?></b><br><?php endif; ?><?php echo esc_html( $item['text'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<p class="pc-ticket__foot">GCheck Standard <b class="num"><?php echo esc_html( gc_static_pricing_compare_money( $pc_config['standard'] ) ); ?></b>: unlimited counties of residence, last 7 years, plus biometric ID verification; other counties <?php echo esc_html( gc_static_pricing_compare_money( $pc_config['extraCounty'] ) ); ?> each, searched automatically if the national search finds possible records.<br>GCheck Advanced <b class="num"><?php echo esc_html( gc_static_pricing_compare_money( $pc_config['advanced'] ) ); ?></b>: adds federal criminal search.<br>Third-party fees passed through with no markup.<sup>1</sup></p>
		</aside>
	</div>
</section>

<?php
$pc_proof_chips = array();
foreach ( $pc['chips'] as $chip ) {
	$pc_proof_chips[] = array(
		'icon'  => $pc_icon( $chip['icon'] ),
		'label' => $chip['label'],
	);
}
gc_static_render_proof(
	array(
		'eyebrow'    => 'G2 badges, 2026',
		'show_stars' => false,
		'badges'     => $pc['badges'],
		'chips'      => $pc_proof_chips,
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

<section class="pc-section" id="pc-quick" aria-labelledby="pc-quick-h">
	<div class="container pc-stack">
		<div class="pc-heading">
			<h2 id="pc-quick-h"><span>Quick answer</span>Eight background check providers, by lowest published price with a county search</h2>
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
				'source_html' => gc_static_pricing_compare_kses( $pc['stats_source'] ),
			)
		);
		?>
	</div>
</section>

<section class="pc-section pc-section--tint" id="pc-compare" aria-labelledby="pc-compare-h">
	<div class="container pc-stack">
		<div class="pc-heading">
			<h2 id="pc-compare-h"><span>Side by side</span>Background check packages and prices</h2>
			<p>Each provider's packages, from lowest to highest price. Packages in the same column don't always include the same searches, so each cell says what the package covers, and the checklist below the table shows every difference. Where a provider doesn't publish a price, we say so instead of estimating.</p>
		</div>
		<p class="pc-callout"><?php echo gc_static_pricing_compare_kses( $pc['callout'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
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
								<?php if ( ! empty( $row['links'] ) ) : ?>
									<?php
									$pc_links = array();
									foreach ( $row['links'] as $link ) {
										$pc_links[] = '<a href="#' . esc_attr( $link['id'] ) . '">' . esc_html( $link['name'] ) . '</a>';
									}
									echo wp_kses(
										implode( ', ', array_slice( $pc_links, 0, -1 ) ) . ' and ' . end( $pc_links ),
										array(
											'a' => array( 'href' => true ),
										)
									);
									?>
								<?php else : ?>
									<a href="#<?php echo esc_attr( $row['id'] ); ?>"><?php echo esc_html( $row['name'] ); ?></a>
								<?php endif; ?>
								<?php if ( ! empty( $row['note'] ) ) : ?>
									<small><?php echo esc_html( $row['note'] ); ?></small>
								<?php endif; ?>
							</th>
							<?php foreach ( $row['cells'] as $index => $cell ) : ?>
								<?php
								$column = isset( $pc['columns'][ $index ] ) ? $pc['columns'][ $index ] : array( 'label' => 'Prices' );
								$span   = ! empty( $cell['colspan'] ) ? ' colspan="' . (int) $cell['colspan'] . '"' : '';
								?>
								<td data-label="<?php echo esc_attr( $column['label'] ); ?>"<?php echo $span; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- cast to int. ?><?php echo ! empty( $column['key'] ) ? ' class="pc-k"' : ''; ?>>
									<?php echo $pc_cell( $cell ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<p class="pc-source"><?php echo gc_static_pricing_compare_kses( $pc['compare_note'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<div class="pc-mx-block" id="pc-features">
      <h3>What each package includes</h3>
      <p>Pick a package level to compare what's in each provider's package, line by line.</p>
      <div class="pc-presets" role="group" aria-label="Package level" id="pc-tier"><button type="button" data-tier="entry" aria-pressed="true">Entry packages</button><button type="button" data-tier="middle" aria-pressed="false">Middle packages</button><button type="button" data-tier="top" aria-pressed="false">Top packages</button></div>
      <ul class="pc-mx-key"><li class="y"><b>&#10003;</b> included in the package price</li><li><b>Add-on</b> available for the published extra fee</li><li class="c"><b>Conditional</b> searched and charged only if the national search finds possible records</li><li class="x"><b>Blank</b> not in this package, and no add-on price is published on the provider's pricing page</li></ul>
      <p class="pc-mx-hint" aria-hidden="true">Swipe the table sideways to see all five providers &rarr;</p>
      <div class="pc-mx-wrap" data-tier="entry">
        <div class="pc-mx-cap" aria-hidden="true">Entry packages</div>
        <div class="pc-mx-scroll" tabindex="0" role="region" aria-label="Entry packages compared">
        <table class="pc-mx"><caption class="pc-sr">Entry packages</caption>
          <colgroup><col class="pc-mx-f"><col><col class="pc-mx-bg"><col><col><col></colgroup>
          <thead><tr><th scope="col">Search or check</th><th scope="col" class="pc-mx-us">GCheck<small>Basic &middot; $18.95</small></th><th scope="col" class="pc-mx-bg">BackgroundChecks.<wbr>com<small>Basic &middot; $29.99</small></th><th scope="col">Verified First<small>Basic &middot; $29.99</small></th><th scope="col">Checkr<small>Basic &middot; $29.99</small></th><th scope="col">GoodHire<small>Basic &middot; $29.99</small></th></tr></thead>
          <tbody>
            <tr><th scope="row">SSN trace</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span><small>Address trace</small></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">National criminal database</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Sex offender registry</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Watchlists and sanctions</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>OIG, OFAC and global watchlists</small></td><td class="y"><span class="pc-sr">Included</span><small>Watchlists</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td></tr>
            <tr><th scope="row">County criminal search</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>Current county of residence included. If the national search finds possible records in other counties, those counties are automatically searched for $9.95 each. Third-party court fees may also apply.</small></td><td class="x"><span class="pc-sr">Not in this package</span></td><td class="x"><span class="pc-sr">Not in this package</span></td><td class="c">Conditional<small>No county search included. If the national search finds possible records, the relevant counties are automatically searched for $15. Third-party court fees may also apply.</small></td><td class="x"><span class="pc-sr">Not in this package</span></td></tr>
            <tr><th scope="row">Statewide criminal search</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $14.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, from $10</td><td class="x"><span class="pc-sr">Not in this package.</span><small>In GoodHire Complete</small></td></tr>
            <tr><th scope="row">Federal criminal search</th><td class="x pc-mx-us"><span class="pc-sr">Not in this package.</span><small>In GCheck Advanced</small></td><td>Add-on, $9.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, $10</td><td class="x"><span class="pc-sr">Not in this package.</span><small>In GoodHire Complete</small></td></tr>
            <tr><th scope="row">Identity verification</th><td class="pc-mx-us">Add-on<small>Biometric; price not published</small></td><td>Add-on, $2.00<small>Shown discounted from $5.00</small></td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, $4.99</td><td class="x"><span class="pc-sr">Not in this package.</span><small>In GoodHire Essential and Complete</small></td></tr>
            <tr><th scope="row">Driving record (MVR)</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $14.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, $9.50</td><td>Available<small>Price not published</small></td></tr>
            <tr><th scope="row">Education or employment verification</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $19.99<small>Education. Employment: price not published</small></td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, from $12.50 each</td><td>Available<small>Price not published</small></td></tr>
          </tbody>
        </table>
        </div>
      </div>
      <div class="pc-mx-wrap" data-tier="middle" hidden>
        <div class="pc-mx-cap" aria-hidden="true">Middle packages</div>
        <div class="pc-mx-scroll" tabindex="0" role="region" aria-label="Middle packages compared">
        <table class="pc-mx"><caption class="pc-sr">Middle packages</caption>
          <colgroup><col class="pc-mx-f"><col><col class="pc-mx-bg"><col><col><col></colgroup>
          <thead><tr><th scope="col">Search or check</th><th scope="col" class="pc-mx-us">GCheck<small>Standard &middot; $39.95</small></th><th scope="col" class="pc-mx-bg">BackgroundChecks.<wbr>com<small>Complete &middot; $44.99</small></th><th scope="col">Verified First<small>Essential &middot; $54.99</small></th><th scope="col">Checkr<small>Essential &middot; $59.99</small></th><th scope="col">GoodHire<small>Essential &middot; $59.99</small></th></tr></thead>
          <tbody>
            <tr><th scope="row">SSN trace</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span><small>Address trace</small></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">National criminal database</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Sex offender registry</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Watchlists and sanctions</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>OIG, OFAC and global watchlists</small></td><td class="y"><span class="pc-sr">Included</span><small>Watchlists</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td></tr>
            <tr><th scope="row">County criminal search</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>Unlimited counties of residence, last 7 years. If the national search finds possible records in other counties, those counties are automatically searched for $9.95 each. Third-party court fees may also apply.</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited, 7-year address history</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td></tr>
            <tr><th scope="row">Statewide criminal search</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $14.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, from $10</td><td class="x"><span class="pc-sr">Not in this package.</span><small>In GoodHire Complete</small></td></tr>
            <tr><th scope="row">Federal criminal search</th><td class="x pc-mx-us"><span class="pc-sr">Not in this package.</span><small>In GCheck Advanced</small></td><td>Add-on, $9.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, $10</td><td class="x"><span class="pc-sr">Not in this package.</span><small>In GoodHire Complete</small></td></tr>
            <tr><th scope="row">Identity verification</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>Biometric</small></td><td>Add-on, $2.00<small>Shown discounted from $5.00</small></td><td class="x"><span class="pc-sr">Not in this package</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Driving record (MVR)</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $14.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, $9.50</td><td>Available<small>Price not published</small></td></tr>
            <tr><th scope="row">Education or employment verification</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $19.99<small>Education. Employment: price not published</small></td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, from $12.50 each</td><td>Available<small>Price not published</small></td></tr>
          </tbody>
        </table>
        </div>
      </div>
      <div class="pc-mx-wrap" data-tier="top" hidden>
        <div class="pc-mx-cap" aria-hidden="true">Top packages</div>
        <div class="pc-mx-scroll" tabindex="0" role="region" aria-label="Top packages compared">
        <table class="pc-mx"><caption class="pc-sr">Top packages</caption>
          <colgroup><col class="pc-mx-f"><col><col class="pc-mx-bg"><col><col><col></colgroup>
          <thead><tr><th scope="col">Search or check</th><th scope="col" class="pc-mx-us">GCheck<small>Advanced &middot; $49.95</small></th><th scope="col" class="pc-mx-bg">BackgroundChecks.<wbr>com<small>Professional &middot; $76.99</small></th><th scope="col">Verified First<small>Premium &middot; $79.99</small></th><th scope="col">Checkr<small>Complete &middot; $94.99</small></th><th scope="col">GoodHire<small>Complete &middot; $94.99</small></th></tr></thead>
          <tbody>
            <tr><th scope="row">SSN trace</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span><small>Address trace</small></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">National criminal database</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Sex offender registry</th><td class="y pc-mx-us"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Watchlists and sanctions</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>OIG, OFAC and global watchlists</small></td><td class="y"><span class="pc-sr">Included</span><small>Watchlists</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td><td class="y"><span class="pc-sr">Included</span><small>Global watchlist</small></td></tr>
            <tr><th scope="row">County criminal search</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>Unlimited counties of residence, last 7 years. If the national search finds possible records in other counties, those counties are automatically searched for $9.95 each. Third-party court fees may also apply.</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited, 7-year address history</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td></tr>
            <tr><th scope="row">Statewide criminal search</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $14.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td><td class="y"><span class="pc-sr">Included</span><small>Unlimited</small></td></tr>
            <tr><th scope="row">Federal criminal search</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>Federal districts of residence</small></td><td class="y"><span class="pc-sr">Included</span></td><td class="x"><span class="pc-sr">Not in this package</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Identity verification</th><td class="y pc-mx-us"><span class="pc-sr">Included</span><small>Biometric</small></td><td>Add-on, $2.00<small>Shown discounted from $5.00</small></td><td class="x"><span class="pc-sr">Not in this package</span></td><td class="y"><span class="pc-sr">Included</span></td><td class="y"><span class="pc-sr">Included</span></td></tr>
            <tr><th scope="row">Driving record (MVR)</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td>Add-on, $14.99</td><td class="x"><span class="pc-sr">Not in this package</span></td><td>Add-on, $9.50</td><td>Available<small>Price not published</small></td></tr>
            <tr><th scope="row">Education or employment verification</th><td class="pc-mx-us">Add-on<small>Price not published</small></td><td class="y"><span class="pc-sr">Included</span><small>Education and employment</small></td><td class="y"><span class="pc-sr">Included</span><small>Employment and education</small></td><td>Add-on, from $12.50 each</td><td>Available<small>Price not published</small></td></tr>
          </tbody>
        </table>
        </div>
      </div>
      <p class="pc-source">What each package includes, as shown on each provider's pricing page: checked November 2026. GoodHire's driving record, education and employment checks are listed on its screening pages, with no prices. Court and other third-party fees are excluded for every provider. First Advantage, HireRight and Sterling don't publish package contents or prices.</p>
	</div>
</section>

<section class="pc-section" id="pc-calc" aria-labelledby="pc-calc-h">
	<div class="container pc-calc">
		<div class="pc-calc__copy">
			<span class="pc-pilltag">Savings calculator</span>
			<h2 class="pc-calc__h" id="pc-calc-h">See how much you'd save with GCheck each year</h2>
			<p>Pick your coverage and checks per year to compare annual spend at each provider's lowest published price. Providers that don't publish prices are left out instead of estimated. Most providers offer volume pricing at higher volumes, so treat this as list price.</p>
		</div>
		<div class="pc-flow">
			<div class="pc-save">
				<span>Your estimated savings</span>
				<strong class="num" id="pc-save-v"><?php echo esc_html( gc_static_pricing_compare_money( $pc_annual['save'], 0 ) ); ?></strong>
				<span id="pc-save-t">less per year than the next lowest published price, at <?php echo esc_html( number_format( $pc_annual['checks'] ) ); ?> checks <?php echo esc_html( $pc_annual['text'] ); ?>.</span>
				<span class="pc-save__note"><?php echo esc_html( $pc['save_note'] ); ?></span>
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
					$pc_scale = ( null !== $pc_total && $pc_annual['max'] > 0 ) ? ( $pc_total / $pc_annual['max'] ) : 0;
					$pc_label = null === $pc_total ? 'Not published' : gc_static_pricing_compare_money( $pc_total, 0 );
					$pc_pkg   = isset( $pc_config['bar_labels'][ $pc_annual['coverage'] ][ $bar['index'] ] ) ? $pc_config['bar_labels'][ $pc_annual['coverage'] ][ $bar['index'] ] : '';
					?>
					<div class="pc-bar<?php echo ! empty( $bar['us'] ) ? ' pc-bar--us' : ''; ?>">
						<span class="pc-bar__who"><?php echo esc_html( $bar['name'] ); ?><small class="pc-bar__pkg" id="pc-l<?php echo esc_attr( $bar['index'] ); ?>"><?php echo esc_html( $pc_pkg ); ?></small></span>
						<div class="pc-bar__track"><div class="pc-bar__fill" id="pc-b<?php echo esc_attr( $bar['index'] ); ?>" style="transform: scaleX(<?php echo esc_attr( round( $pc_scale, 4 ) ); ?>)"></div></div>
						<span class="pc-bar__amt num" id="pc-a<?php echo esc_attr( $bar['index'] ); ?>"><?php echo esc_html( $pc_label ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section class="pc-section" id="pc-county" aria-labelledby="pc-county-h">
	<div class="container pc-stack">
		<div class="pc-heading">
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

<section class="pc-section pc-section--tint" id="pc-provs" aria-labelledby="pc-provs-h">
	<div class="container pc-stack">
		<div class="pc-heading">
			<h2 id="pc-provs-h"><span>Provider by provider</span>What each provider charges and includes</h2>
			<p>GCheck publishes this page and is one of the providers compared. Each card sticks to what the provider publishes.</p>
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

<section class="pc-section" id="pc-method" aria-labelledby="pc-method-h">
	<div class="container pc-stack">
		<div class="pc-heading">
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
		'section_class' => 'pc-section pc-section--tint faq--collapsible ve-faq',
		'heading_id'    => 'pc-faq-h',
		'title'         => 'Background check pricing, answered',
		'items'         => $pc['faqs'],
		'panel_prefix'  => 'pc-faq-panel',
	)
);
?>

<section class="pc-section" aria-labelledby="pc-cfg-h">
	<div class="container pc-stack">
		<div class="pc-heading pc-heading--xl">
			<h2 id="pc-cfg-h"><span>Compliance for Good&reg;</span>Low price, same standards</h2>
			<p><?php echo gc_static_pricing_compare_kses( $pc['compliance'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		</div>
		<ul class="pc-moments">
			<?php foreach ( $pc['moments'] as $moment ) : ?>
				<li>
					<span class="pc-moment__icon"><?php echo $pc_icon( $moment['icon'], array() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
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
		<p class="pc-source"><?php echo gc_static_pricing_compare_kses( $pc['source_note'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	</div>
</section>
