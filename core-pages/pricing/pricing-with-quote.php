<?php
$gc_quote_check = '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 1.25C5.16797 1.25 1.25 5.16797 1.25 10C1.25 14.832 5.16797 18.75 10 18.75C14.832 18.75 18.75 14.832 18.75 10C18.75 5.16797 14.832 1.25 10 1.25ZM13.7793 7.14258L9.66602 12.8457C9.60853 12.9259 9.53274 12.9913 9.44493 13.0364C9.35713 13.0815 9.25984 13.1051 9.16113 13.1051C9.06242 13.1051 8.96513 13.0815 8.87733 13.0364C8.78953 12.9913 8.71374 12.9259 8.65625 12.8457L6.2207 9.4707C6.14648 9.36719 6.2207 9.22266 6.34766 9.22266H7.26367C7.46289 9.22266 7.65234 9.31836 7.76953 9.48242L9.16016 11.4121L12.2305 7.1543C12.3477 6.99219 12.5352 6.89453 12.7363 6.89453H13.6523C13.7793 6.89453 13.8535 7.03906 13.7793 7.14258Z" fill="#5DC567"/></svg>';
$gc_quote_tip   = '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.0003 18.3332C14.6027 18.3332 18.3337 14.6022 18.3337 9.99984C18.3337 5.39746 14.6027 1.6665 10.0003 1.6665C5.39795 1.6665 1.66699 5.39746 1.66699 9.99984C1.66699 14.6022 5.39795 18.3332 10.0003 18.3332Z" stroke="#777E8C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 13.3333V10" stroke="#777E8C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.1045 6.87484H10.0003M10.2087 6.87484C10.2087 6.75978 10.1154 6.6665 10.0003 6.6665C9.88524 6.6665 9.79199 6.75978 9.79199 6.87484C9.79199 6.9899 9.88524 7.08317 10.0003 7.08317C10.1154 7.08317 10.2087 6.9899 10.2087 6.87484Z" stroke="#777E8C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$gc_quote_features = array(
	'bio'  => array(
		'label' => 'Biometric Identity Verification',
		'tip'   => 'Confirms the candidate is who they say they are by matching a live selfie to a government-issued photo ID.',
	),
	'ssn'  => array(
		'label' => 'SSN Trace & Address History',
		'tip'   => 'Validates the Social Security number and surfaces the names and addresses linked to it, which determines where records are searched.',
	),
	'ncd'  => array(
		'label' => 'National Criminal Database Search',
		'tip'   => 'A broad multi-state database search that flags potential records for verification at the county source.',
	),
	'sor'  => array(
		'label' => 'National Sex Offender Registry Search',
		'tip'   => 'Searches public sex offender registries across all 50 states.',
	),
	'oig'  => array(
		'label' => 'OIG Excluded Sanctions List',
		'tip'   => 'Checks the HHS Office of Inspector General list of individuals excluded from federal healthcare programs.',
	),
	'ofac' => array(
		'label' => 'OFAC Sanctions List',
		'tip'   => 'Screens against the U.S. Treasury Office of Foreign Assets Control sanctions list.',
	),
	'glob' => array(
		'label' => 'Global Watchlists',
		'tip'   => 'Screens international sanctions and enforcement watchlists, including UN and EU lists.',
	),
	'cty'  => array(
		'label' => 'County Criminal Search',
		'tip'   => 'A direct search of county court records, the primary source for felony and misdemeanor cases.',
	),
	'fed'  => array(
		'label' => 'Federal Criminal Search',
		'tip'   => 'Searches U.S. federal district courts for federal offenses such as fraud and embezzlement.',
	),
);

$gc_quote_plans = array(
	array(
		'name'     => 'Basic',
		'price'    => '18.95',
		'desc'     => 'The non-negotiables, covered. Built for speed, compliance, and everyday hiring.',
		'popular'  => false,
		'cta'      => 'white',
		'features' => array(
			array( 'key' => 'ssn' ),
			array( 'key' => 'ncd' ),
			array( 'key' => 'sor' ),
			array( 'key' => 'oig' ),
			array( 'key' => 'ofac' ),
			array( 'key' => 'glob' ),
			array(
				'key' => 'cty',
				'sub' => 'Current county of residence',
			),
		),
	),
	array(
		'name'      => 'Standard',
		'price'     => '39.95',
		'desc'      => 'Everything in Basic, plus county-level criminal searches across a candidate’s full address history.',
		'popular'   => true,
		'tag'       => 'Most Popular',
		'tag_style' => 'popular',
		'cta'       => 'blue',
		'features'  => array(
			array( 'key' => 'bio' ),
			array( 'key' => 'ssn' ),
			array( 'key' => 'ncd' ),
			array( 'key' => 'sor' ),
			array( 'key' => 'oig' ),
			array( 'key' => 'ofac' ),
			array( 'key' => 'glob' ),
			array(
				'key'  => 'cty',
				'sub'  => 'Unlimited counties of residence',
				'mark' => 'Unlimited',
			),
		),
	),
	array(
		'name'      => 'Advanced',
		'price'     => '49.95',
		'desc'      => 'Adds federal court searches on top of full county coverage. Built for regulated industries and high-trust roles.',
		'popular'   => false,
		'tag'       => 'Recommended',
		'tag_style' => 'recommended',
		'cta'       => 'white',
		'features'  => array(
			array( 'key' => 'bio' ),
			array( 'key' => 'ssn' ),
			array( 'key' => 'ncd' ),
			array( 'key' => 'sor' ),
			array( 'key' => 'oig' ),
			array( 'key' => 'ofac' ),
			array( 'key' => 'glob' ),
			array(
				'key'  => 'cty',
				'sub'  => 'Unlimited counties of residence',
				'mark' => 'Unlimited',
			),
			array(
				'key'  => 'fed',
				'sub'  => 'Unlimited federal districts of residence',
				'mark' => 'Unlimited',
			),
		),
	),
);

$gc_quote_pills = array(
	'Pay per screen',
	'No setup fees',
	'No minimums',
	'No long-term contracts.',
);

$gc_quote_volume = array(
	'Hire candidates faster',
	'Integrated FCRA Compliance',
	'ATS and HRIS integrations',
	'Customized workflows',
);

$gc_quote_compare = array(
	array( 'key' => 'bio', 'cells' => array( '—', '✓', '✓' ) ),
	array( 'key' => 'ssn', 'cells' => array( '✓', '✓', '✓' ) ),
	array( 'key' => 'ncd', 'cells' => array( '✓', '✓', '✓' ) ),
	array( 'key' => 'sor', 'cells' => array( '✓', '✓', '✓' ) ),
	array( 'key' => 'oig', 'cells' => array( '✓', '✓', '✓' ) ),
	array( 'key' => 'ofac', 'cells' => array( '✓', '✓', '✓' ) ),
	array( 'key' => 'glob', 'cells' => array( '✓', '✓', '✓' ) ),
	array( 'key' => 'cty', 'cells' => array( 'Current county', 'Unlimited', 'Unlimited' ) ),
	array( 'key' => 'fed', 'cells' => array( '—', '—', 'Unlimited' ) ),
	array(
		'label' => 'Average turnaround',
		'cells' => array( '12-24 hrs', '12-24 hrs', '12-24 hrs' ),
	),
);

$gc_quote_compare_cell = static function ( $value ) use ( $gc_quote_check ) {
	if ( '✓' === $value ) {
		return $gc_quote_check;
	}

	if ( '—' === $value ) {
		return '<span class="pricing-compare__none">—</span>';
	}

	return '<strong>' . esc_html( $value ) . '</strong>';
};

$gc_editor_html = static function ( $html ) {
	$html = trim( (string) $html );
	$html = preg_replace( '#<p>\s*(?=<(?:div|ul|ol|h[1-6]|a|span)\b)#i', '', $html );
	$html = preg_replace( '#(</(?:div|ul|ol|h[1-6]|a|span)>)\s*</p>#i', '$1', $html );
	$html = preg_replace( '#<p>(\s|&nbsp;|<br\s*/?>)*</p>#i', '', $html );
	$html = preg_replace( '#(?<=>)\s*<br\s*/?>\s*(?=<)#i', '', $html );

	return trim( $html );
};

$gc_quote_layout  = function_exists( 'get_sub_field' ) ? strtolower( trim( (string) get_sub_field( 'pricing_w_quote_layout' ) ) ) : '';
$gc_quote_details = function_exists( 'get_sub_field' ) ? $gc_editor_html( get_sub_field( 'details', false ) ) : '';
$gc_quote_is_addon = in_array( $gc_quote_layout, array( 'add-on', 'addon', 'add on' ), true );
?>

<?php if ( 'included all' === $gc_quote_layout ) : ?>
	<?php
	$gc_included_head = $gc_quote_details;
	$gc_included_note = '';

	if ( preg_match( '/<p[^>]*class="[^"]*\bpricing-disclaimer\b[^"]*"[^>]*>.*?<\/p>/is', $gc_included_head, $gc_included_note_match ) ) {
		$gc_included_note = $gc_included_note_match[0];
		$gc_included_head = trim( str_replace( $gc_included_note_match[0], '', $gc_included_head ) );
	}
	?>
<section id="pricing" class="pricing-with-quote pricing-with-quote--included">
	<div class="container">
		<?php if ( '' !== trim( $gc_included_head ) ) : ?>
			<div class="pricing-header pricing-header--split">
				<?php echo $gc_included_head; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>

		<?php if ( function_exists( 'have_rows' ) && have_rows( 'cards' ) ) : ?>
			<div class="pricing-cards">
				<?php
				while ( have_rows( 'cards' ) ) :
					the_row();
					$gc_card_title   = (string) get_sub_field( 'h4' );
					$gc_card_details = $gc_editor_html( get_sub_field( 'details', false ) );
					$gc_card_badge   = '';

					if ( preg_match( '/<span[^>]*class="[^"]*\bpricing-card__badge\b[^"]*"[^>]*>.*?<\/span>/is', $gc_card_details, $gc_card_badge_match ) ) {
						$gc_card_badge   = $gc_card_badge_match[0];
						$gc_card_details = str_replace( $gc_card_badge_match[0], '', $gc_card_details );
					}

					$gc_card_popular = false !== strpos( $gc_card_badge, 'pricing-card__badge--popular' );
					?>
					<article class="pricing-card<?php echo $gc_card_popular ? ' is-popular is-selected' : ''; ?>">
						<div class="pricing-card__heading-row">
							<h4 class="pricing-card__title"><?php echo esc_html( $gc_card_title ); ?></h4>
							<?php echo $gc_card_badge; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="pricing-card__body">
							<?php echo $gc_card_details; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php echo $gc_included_note; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>

<?php elseif ( $gc_quote_is_addon ) : ?>
<section id="pricing" class="pricing-with-quote pricing-with-quote--addon">
	<div class="container">
		<div class="pricing-quote">
			<div class="pricing-quote__banner pricing-quote__banner--compare pricing-quote__banner--addon">
				<?php echo $gc_quote_details; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</div>
</section>

<?php else : ?>
<section id="pricing" class="pricing-with-quote">
	<div class="container">
		<div class="pricing-header">
			<div class="pricing-header__content">
				<h2 class="pricing-header__title">Pay Per Screen. No Surprises.</h2>
			</div>
			<div class="pricing-header__pills">
				<?php foreach ( $gc_quote_pills as $gc_quote_pill ) : ?>
					<span class="pricing-header__pill">
						<?php echo $gc_quote_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo esc_html( $gc_quote_pill ); ?>
					</span>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="pricing-cards">
			<?php foreach ( $gc_quote_plans as $gc_quote_plan ) : ?>
				<article class="pricing-card<?php echo ! empty( $gc_quote_plan['popular'] ) ? ' is-popular is-selected' : ''; ?>">
					<div class="pricing-card__header">
						<div class="pricing-card__heading-row">
							<h2 class="pricing-card__title"><?php echo esc_html( $gc_quote_plan['name'] ); ?></h2>
							<?php if ( ! empty( $gc_quote_plan['tag'] ) ) : ?>
								<span class="pricing-card__badge pricing-card__badge--<?php echo esc_attr( $gc_quote_plan['tag_style'] ); ?>"><?php echo esc_html( $gc_quote_plan['tag'] ); ?></span>
							<?php endif; ?>
						</div>
						<p class="pricing-card__description"><?php echo esc_html( $gc_quote_plan['desc'] ); ?></p>
					</div>
					<div class="pricing-card__price">
						<strong><?php echo esc_html( '$' . $gc_quote_plan['price'] ); ?></strong>
						<span>per background check*</span>
					</div>
					<a
						href="#quote"
						class="button <?php echo esc_attr( $gc_quote_plan['cta'] ); ?> pricing-card__cta"
						data-pkg="<?php echo esc_attr( $gc_quote_plan['name'] . ' ($' . $gc_quote_plan['price'] . '/check)' ); ?>"
					>Get Started Today</a>
					<div class="pricing-card__features">
						<ul>
							<?php foreach ( $gc_quote_plan['features'] as $gc_quote_feature ) : ?>
								<?php $gc_quote_feature_data = $gc_quote_features[ $gc_quote_feature['key'] ]; ?>
								<li>
									<?php echo $gc_quote_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<span class="pricing-card__feature-copy">
										<span class="pricing-card__feature-title"><?php echo esc_html( $gc_quote_feature_data['label'] ); ?></span>
										<?php if ( ! empty( $gc_quote_feature['sub'] ) ) : ?>
											<small>
												<?php if ( ! empty( $gc_quote_feature['mark'] ) && 0 === strpos( $gc_quote_feature['sub'], $gc_quote_feature['mark'] ) ) : ?>
													<span class="highlight"><?php echo esc_html( $gc_quote_feature['mark'] ); ?></span><?php echo esc_html( substr( $gc_quote_feature['sub'], strlen( $gc_quote_feature['mark'] ) ) ); ?>
												<?php else : ?>
													<?php echo esc_html( $gc_quote_feature['sub'] ); ?>
												<?php endif; ?>
											</small>
										<?php endif; ?>
									</span>
									<button
										type="button"
										class="pricing-card__tooltip"
										data-tooltip="<?php echo esc_attr( $gc_quote_feature_data['tip'] ); ?>"
										aria-label="<?php echo esc_attr( $gc_quote_feature_data['tip'] ); ?>"
									>
										<?php echo $gc_quote_tip; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</button>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<p class="pricing-disclaimer">*Additional third party fees may apply to some products and will be passed through with no markup.</p>

		<div class="pricing-compare">
			<button type="button" class="pricing-compare__toggle" data-compare-toggle aria-expanded="false" aria-controls="pricing-compare">
				<span>Compare all features</span>
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
			</button>
			<div class="pricing-compare__table" id="pricing-compare" data-compare hidden>
				<table>
					<thead>
						<tr>
							<th>What’s included</th>
							<?php foreach ( $gc_quote_plans as $gc_quote_index => $gc_quote_plan ) : ?>
								<th<?php echo 1 === $gc_quote_index ? ' class="is-highlight"' : ''; ?>>
									<?php echo esc_html( $gc_quote_plan['name'] ); ?>
									<small><?php echo esc_html( '$' . $gc_quote_plan['price'] ); ?></small>
								</th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $gc_quote_compare as $gc_quote_row ) : ?>
							<tr>
								<td><?php echo esc_html( isset( $gc_quote_row['label'] ) ? $gc_quote_row['label'] : $gc_quote_features[ $gc_quote_row['key'] ]['label'] ); ?></td>
								<?php foreach ( $gc_quote_row['cells'] as $gc_quote_cell_index => $gc_quote_cell ) : ?>
									<td<?php echo 1 === $gc_quote_cell_index ? ' class="is-highlight"' : ''; ?>>
										<?php echo $gc_quote_compare_cell( $gc_quote_cell ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="pricing-quote">
			<div class="pricing-quote__banner">
				<div class="pricing-quote__content">
					<h2>Running more than 50 background checks a year?</h2>
					<ul>
						<?php foreach ( $gc_quote_volume as $gc_quote_volume_item ) : ?>
							<li>
								<?php echo $gc_quote_check; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo esc_html( $gc_quote_volume_item ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<a class="button blue" href="#quote" data-pkg="Custom (50+ checks/year)" data-hires="51-100">Get a Custom Quote</a>
			</div>
		</div>

		<div class="pricing-trust">
			<p>Volume pricing and merit-based nonprofit discounts available.</p>
			<div class="pricing-trust__cta">Contact us to build a package that meets your needs. <a href="#quote" data-pkg="Nonprofit discount">Request nonprofit pricing →</a></div>
		</div>
	</div>
</section>
<?php endif; ?>
