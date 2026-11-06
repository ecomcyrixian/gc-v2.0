<?php
/**
 * Pricing compare copy, shared by the template, the calculator, and the JSON-LD schema.
 * Prices here drive the comparison table, the annual calculator, and compare.js.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_static_pricing_compare_config' ) ) {
	function gc_static_pricing_compare_config() {
		$base                = 18.95;
		$standard            = 39.95;
		$advanced            = 49.95;
		$bg_basic            = 29.99;
		$bg_complete         = 44.99;
		$bg_complete_fed     = 54.98;
		$fa_basic            = 29;
		$fa_standard         = 44;
		$fa_choice           = 65;
		$checkr_basic        = 29.99;
		$checkr_essential    = 59.99;
		$checkr_complete     = 94.99;
		$goodhire_basic      = 29.99;
		$goodhire_essential  = 59.99;
		$goodhire_complete   = 94.99;

		return array(
			'base'               => $base,
			'standard'           => $standard,
			'advanced'           => $advanced,
			'bgBasic'            => $bg_basic,
			'bgComplete'         => $bg_complete,
			'bgPro'              => 76.99,
			'bgFederal'          => 9.99,
			'bgCompleteFed'      => $bg_complete_fed,
			'bgId'               => 2.00,
			'bgIdList'           => 5.00,
			'bgState'            => 14.99,
			'bgMvr'              => 14.99,
			'faBasic'            => $fa_basic,
			'faStandard'         => $fa_standard,
			'faChoice'           => $fa_choice,
			'faPremium'          => 75,
			'checkrBasic'        => $checkr_basic,
			'checkrCounty'       => 15,
			'checkrEssential'    => $checkr_essential,
			'checkrComplete'     => $checkr_complete,
			'checkrId'           => 4.99,
			'goodhireBasic'      => $goodhire_basic,
			'goodhireEssential'  => $goodhire_essential,
			'goodhireComplete'   => $goodhire_complete,
			'checks'             => 250,
			'updated'            => 'November 2026',
			'updated_iso'        => '2026-11',
			'faDriving'          => 6.24,
			'faEducation'        => 12.48,
			'faEmployment'       => 15.60,
			'verified'           => 'November 2026',
			'verified_chip'      => 'Nov 2026',
			'coverages'          => array(
				'current' => array( $base, $bg_complete, $checkr_essential, $goodhire_essential, $fa_standard ),
				'all'     => array( $standard, $bg_complete, $checkr_essential, $goodhire_essential, $fa_choice ),
				'fed'     => array( $advanced, $bg_complete_fed, $checkr_complete, $goodhire_complete, null ),
			),
			'bar_labels'         => array(
				'current' => array( '', '(Complete, unlimited counties)', '(Essential, unlimited counties)', '(Essential, unlimited counties)', '' ),
				'all'     => array( '', '', '', '', '' ),
				'fed'     => array( '', '', '', '', '' ),
			),
			'coverage_text'      => array(
				'current' => 'with one county search',
				'all'     => 'with unlimited county searches',
				'fed'     => 'with unlimited county and federal searches',
			),
			'bars'               => array(
				array( 'name' => 'GCheck', 'index' => 0, 'us' => true ),
				array( 'name' => 'First Advantage', 'index' => 4 ),
				array( 'name' => 'BackgroundChecks.com', 'index' => 1 ),
				array( 'name' => 'Checkr', 'index' => 2 ),
				array( 'name' => 'GoodHire', 'index' => 3 ),
			),
		);
	}

	function gc_static_pricing_compare_money( $amount, $decimals = 2 ) {
		$amount = round( (float) $amount, $decimals );

		return '$' . number_format( $amount, $decimals );
	}

	function gc_static_pricing_compare_kses( $html ) {
		return wp_kses(
			$html,
			array(
				'a'    => array(
					'href' => true,
					'rel'  => true,
				),
				'b'    => array(
					'class' => true,
				),
				'sup'  => array(),
				'br'   => array(),
				'span' => array(
					'class' => true,
				),
			)
		);
	}

	/**
	 * Annual spend at each provider's published price for one coverage level.
	 * Totals follow the coverage arrays in config: GCheck, BackgroundChecks.com, Checkr, GoodHire, First Advantage.
	 */
	function gc_static_pricing_compare_annual( $checks = 250, $coverage = 'current' ) {
		$c         = gc_static_pricing_compare_config();
		$checks    = max( 1, (int) $checks );
		$coverage  = isset( $c['coverages'][ $coverage ] ) ? $coverage : 'current';
		$prices    = $c['coverages'][ $coverage ];
		$totals    = array();
		$published = array();

		foreach ( $prices as $price ) {
			$total     = null === $price ? null : round( $checks * (float) $price, 2 );
			$totals[]  = $total;

			if ( null !== $total ) {
				$published[] = $total;
			}
		}

		$next = count( $published ) > 1 ? min( array_slice( $published, 1 ) ) : 0;

		return array(
			'checks'   => $checks,
			'coverage' => $coverage,
			'totals'   => $totals,
			'max'      => empty( $published ) ? 0 : max( $published ),
			'save'     => round( $next - $totals[0], 2 ),
			'text'     => $c['coverage_text'][ $coverage ],
		);
	}

	function gc_static_pricing_compare_content() {
		static $content = null;

		if ( null !== $content ) {
			return $content;
		}

		$c       = gc_static_pricing_compare_config();
		$m       = 'gc_static_pricing_compare_money';
		$base    = $m( $c['base'] );
		$packages   = esc_url( home_url( '/pricing-packages/' ) );
		$contact    = home_url( '/contact-us/' );
		$compliance = esc_url( home_url( '/compliance-for-good/' ) );
		$gap_fa     = $m( round( $c['faStandard'] - $c['base'], 2 ) );
		$gap_bg     = $m( round( $c['bgComplete'] - $c['standard'], 2 ) );

		$content = array(
			'title'       => 'Compare',
			'name'        => 'Background Check Pricing Compared (2026): GCheck vs Checkr',
			'headline'    => 'Background check pricing compared (2026): GCheck vs Checkr, GoodHire, HireRight, BackgroundChecks.com, First Advantage and Sterling',
			'description' => 'GCheck Basic is ' . $base . ' with a county criminal search. Compare published 2026 prices from Checkr, GoodHire, HireRight, First Advantage and more.',
			'lede'        => 'Of the seven providers compared, the lowest published price for a background check that includes a county criminal search is <b>' . $base . '</b> (GCheck Basic: national criminal database search plus a county criminal search of the current county of residence), as of November 2026.',
			'verified'    => $c['verified'],
			'contact'     => $contact,
			'demo'        => home_url( '/book-a-demo/' ),

			'badges'      => array(
				'hp.png'    => 'G2 High Performer',
				'roi.png'   => 'G2 Best Estimated ROI',
				'umltr.png' => 'G2 Users Most Likely To Recommend',
				'hua.png'   => 'G2 Highest User Adoption',
				'ulu.png'   => 'G2 Users Love Us',
			),

			'chips'       => array(
				array( 'icon' => 'shield', 'label' => 'SOC 2 Type II attested' ),
				array( 'icon' => 'lock', 'label' => 'HIPAA compliance program' ),
				array( 'icon' => 'scale', 'label' => 'Built for FCRA compliance' ),
				array( 'icon' => 'receipt', 'label' => 'Prices checked ' . $c['verified_chip'] ),
			),

			'toc'         => array(
				array( 'href' => '#pc-quick', 'label' => 'Quick answer' ),
				array( 'href' => '#pc-compare', 'label' => 'Prices by coverage' ),
				array( 'href' => '#pc-calc', 'label' => 'Savings calculator' ),
				array( 'href' => '#pc-county', 'label' => 'Database vs. county' ),
				array( 'href' => '#pc-provs', 'label' => 'Provider by provider' ),
				array( 'href' => '#pc-method', 'label' => 'Methodology' ),
				array( 'href' => '#faq', 'label' => 'FAQ' ),
				array( 'href' => '#pc-sources', 'label' => 'Sources' ),
			),

			'next'        => array(
				array(
					'label' => 'Next lowest with a county search',
					'items' => array(
						array( 'price' => $m( $c['faStandard'], 0 ), 'name' => 'First Advantage' ),
						array( 'price' => $m( $c['bgComplete'] ), 'name' => 'BackgroundChecks.com' ),
						array( 'price' => $m( $c['checkrEssential'] ), 'name' => 'Checkr, GoodHire' ),
					),
				),
				array(
					'label' => 'Quote only',
					'items' => array(
						array( 'name' => 'HireRight' ),
						array( 'name' => 'Sterling (now First Advantage)' ),
					),
				),
			),

			'ticket'      => array(
				array(
					'strong' => 'County criminal search included',
					'text'   => 'Current county of residence',
				),
				array( 'text' => 'SSN trace and address history' ),
				array( 'text' => 'National criminal database search' ),
				array( 'text' => 'Nationwide sex offender registry search' ),
				array( 'text' => 'OIG, OFAC and global watchlists' ),
			),

			'quick'       => array(
				array(
					'n'    => '1',
					'id'   => 'gcheck',
					'name' => 'GCheck',
					'text' => 'GCheck Basic <b class="num">' . $base . '</b> includes a national criminal database search and the current county; GCheck Standard <b class="num">' . $m( $c['standard'] ) . '</b> adds unlimited counties.<sup>1</sup>',
				),
				array(
					'n'    => '2',
					'id'   => 'first-advantage',
					'name' => 'First Advantage',
					'text' => '<b class="num">' . $m( $c['faStandard'], 0 ) . '</b> with a county search (First Advantage Standard; county scope not listed); <b class="num">' . $m( $c['faChoice'], 0 ) . '</b> for seven years of counties (First Advantage Choice). Small-business prices shown in its signup flow.<sup>3</sup>',
				),
				array(
					'n'    => '3',
					'id'   => 'backgroundchecks',
					'name' => 'BackgroundChecks.com',
					'text' => '<b class="num">' . $m( $c['bgComplete'] ) . '</b> for unlimited counties over a 7-year address history (BackgroundChecks.com Complete). BackgroundChecks.com Basic lists no county search. A HireRight company.<sup>2</sup>',
				),
				array(
					'n'    => '4',
					'id'   => 'checkr',
					'name' => 'Checkr',
					'text' => '<b class="num">' . $m( $c['checkrEssential'] ) . '</b> (Checkr Essential, unlimited counties). Checkr Basic (' . $m( $c['checkrBasic'] ) . ') runs county searches only if the national search identifies potential records, for ' . $m( $c['checkrCounty'], 0 ) . ' plus court fees, so its final price varies.<sup>4</sup>',
				),
				array(
					'n'    => '5',
					'id'   => 'goodhire',
					'name' => 'GoodHire',
					'text' => '<b class="num">' . $m( $c['goodhireEssential'] ) . '</b> (GoodHire Essential, unlimited counties). Tied with Checkr on price. GoodHire Basic lists no county search.<sup>5</sup>',
				),
				array(
					'n'    => '–',
					'id'   => 'hireright',
					'name' => 'HireRight',
					'text' => 'Pricing by quote only.<sup>6</sup>',
				),
				array(
					'n'    => '–',
					'id'   => 'sterling',
					'name' => 'Sterling',
					'text' => 'Now part of First Advantage. Enterprise pricing by quote only.<sup>7</sup>',
				),
			),

			'stats'       => array(
				array(
					'value' => $base,
					'text'  => 'GCheck Basic (' . $base . ') is the lowest published entry price among the seven providers compared.',
					'tone'  => 'blue',
				),
				array(
					'value' => 'Only one',
					'text'  => 'GCheck Basic is the only entry package among the seven providers compared that always includes a county criminal search.',
					'tone'  => 'soft',
				),
				array(
					'value' => $gap_fa . ' less',
					'text'  => 'For a check with a county search, GCheck Basic (' . $base . ') costs ' . $gap_fa . ' less than the next lowest published price, First Advantage Standard (' . $m( $c['faStandard'], 0 ) . ').',
					'tone'  => 'soft',
				),
				array(
					'value' => $gap_bg . ' less',
					'text'  => 'For unlimited county searches, GCheck Standard (' . $m( $c['standard'] ) . ') costs ' . $gap_bg . ' less than the next lowest published price, BackgroundChecks.com Complete (' . $m( $c['bgComplete'] ) . ').',
					'tone'  => 'soft',
				),
			),

			'stats_source' => 'Lowest published per-check prices, before court access fees, checked ' . $c['verified'] . '. See <a href="#pc-method">methodology</a> and <a href="#pc-sources">sources</a>.',

			'columns'     => array(
				array( 'label' => 'Entry package' ),
				array(
					'label' => 'One county search',
					'note'  => 'Current county of residence',
					'key'   => true,
				),
				array(
					'label' => 'Unlimited counties',
					'note'  => 'Every county of residence',
				),
				array( 'label' => 'Counties + federal' ),
				array( 'label' => 'Identity verification' ),
				array( 'label' => 'Prices published' ),
			),

			'rows'        => array(
				array(
					'id'   => 'gcheck',
					'name' => 'GCheck',
					'note' => 'Published',
					'us'   => true,
					'cells' => array(
						array( 'strong' => $base, 'sup' => '1', 'text' => 'Basic. National database and county search included' ),
						array( 'tag' => 'ok', 'tag_label' => 'Included', 'strong' => $base, 'text' => 'Basic' ),
						array( 'strong' => $m( $c['standard'] ), 'text' => 'Standard' ),
						array( 'strong' => $m( $c['advanced'] ), 'text' => 'Advanced' ),
						array( 'text' => 'Biometric, in Standard and Advanced' ),
						array( 'yes' => 'Yes' ),
					),
				),
				array(
					'id'   => 'first-advantage',
					'name' => 'First Advantage',
					'note' => 'Small business; signup flow',
					'cells' => array(
						array( 'strong' => $m( $c['faBasic'], 0 ), 'sup' => '3', 'text' => 'Basic. No county search listed' ),
						array( 'strong' => $m( $c['faStandard'], 0 ), 'text' => 'Standard (county scope not listed)' ),
						array( 'strong' => $m( $c['faChoice'], 0 ), 'text' => 'Choice. 7-year address history' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'Not published' ),
						array( 'yes' => 'Yes', 'after' => 'In signup flow only' ),
					),
				),
				array(
					'id'   => 'backgroundchecks',
					'name' => 'BackgroundChecks.com',
					'note' => 'A HireRight company',
					'cells' => array(
						array( 'strong' => $m( $c['bgBasic'] ), 'sup' => '2', 'text' => 'Basic. No county search' ),
						array( 'strong' => $m( $c['bgComplete'] ), 'text' => 'Complete (unlimited counties; no one-county option)' ),
						array( 'strong' => $m( $c['bgComplete'] ), 'text' => 'Complete' ),
						array( 'strong' => $m( $c['bgCompleteFed'] ), 'text' => 'Complete + ' . $m( $c['bgFederal'] ) . ' federal add-on' ),
						array( 'text' => $m( $c['bgId'] ) . ' add-on (shown discounted from ' . $m( $c['bgIdList'] ) . ')' ),
						array( 'yes' => 'Yes' ),
					),
				),
				array(
					'id'   => 'checkr',
					'name' => 'Checkr',
					'note' => 'Published',
					'cells' => array(
						array( 'strong' => $m( $c['checkrBasic'] ), 'sup' => '4', 'text' => 'Basic. County searches for ' . $m( $c['checkrCounty'], 0 ) . ' plus court fees, only if the national search identifies potential records' ),
						array( 'strong' => $m( $c['checkrEssential'] ), 'text' => 'Essential' ),
						array( 'strong' => $m( $c['checkrEssential'] ), 'text' => 'Essential' ),
						array( 'strong' => $m( $c['checkrComplete'] ), 'text' => 'Complete. Also adds statewide' ),
						array( 'text' => 'In Essential and Complete; ' . $m( $c['checkrId'] ) . ' add-on' ),
						array( 'yes' => 'Yes' ),
					),
				),
				array(
					'id'   => 'goodhire',
					'name' => 'GoodHire',
					'note' => 'Published; owned by Checkr',
					'cells' => array(
						array( 'strong' => $m( $c['goodhireBasic'] ), 'sup' => '5', 'text' => 'Basic. No county search' ),
						array( 'strong' => $m( $c['goodhireEssential'] ), 'text' => 'Essential' ),
						array( 'strong' => $m( $c['goodhireEssential'] ), 'text' => 'Essential' ),
						array( 'strong' => $m( $c['goodhireComplete'] ), 'text' => 'Complete. Also adds statewide' ),
						array( 'text' => 'In Essential and Complete' ),
						array( 'yes' => 'Yes' ),
					),
				),
				array(
					'id'   => 'hireright',
					'name' => 'HireRight',
					'note' => 'Quote only',
					'cells' => array(
						array( 'tag' => 'q', 'tag_label' => 'Not published', 'sup' => '6' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'No (quote form)' ),
					),
				),
				array(
					'id'   => 'sterling',
					'name' => 'Sterling',
					'note' => 'Now First Advantage; quote only',
					'cells' => array(
						array( 'tag' => 'q', 'tag_label' => 'Not published', 'sup' => '7' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'Not published' ),
						array( 'dim' => 'No (quote form)' ),
					),
				),
			),

			'compare_note' => 'Prices checked ' . $c['verified'] . ' on each provider\'s own website; court access fees excluded for all providers.<sup>8</sup> Competitor prices can change after we check them; confirm current prices on each provider\'s site. Entry packages without a county search start from a national database search, and some add a county search only when the database flags a record; <a href="#pc-county">see why that matters</a>. Trademarks belong to their respective owners.',

			'county'      => array(
				array(
					'title' => 'National criminal database',
					'text'  => 'A combined database of records that states, counties and agencies choose to send in. Coverage, how often records are updated and how complete case outcomes are all vary by jurisdiction. Some jurisdictions contribute few or no records.',
				),
				array(
					'title' => 'County criminal search',
					'text'  => 'A search of the county court\'s own records, which is where most U.S. criminal cases are filed. Results typically show the current status and outcome of each case.',
				),
				array(
					'title' => 'Why database hits get checked at the source',
					'text'  => 'When a provider reports public-record information for employment purposes that is likely to hurt a candidate\'s chances, the FCRA requires it either to notify the candidate at the time or to maintain strict procedures to make sure the record is complete and up to date.<sup>9</sup> Providers must also follow reasonable procedures to assure maximum possible accuracy.<sup>10</sup> Many providers meet these duties by confirming database hits with the county court.',
				),
				array(
					'title' => 'The blind spot in database-only searching',
					'text'  => 'Some packages use database hits to decide which counties to search; Checkr Basic, for example, runs county searches (for ' . $m( $c['checkrCounty'], 0 ) . ', plus court fees) only where the national search identifies potential records.<sup>4</sup> If a county doesn\'t send records to the database, no hit appears, so that county never gets searched. Searching the candidate\'s current county, or every county in their address history, doesn\'t depend on database coverage.',
				),
			),

			'why'         => array(
				'eyebrow' => 'Compliance for Good®',
				'title'   => 'Why GCheck doesn\'t offer a database-only background check',
				'body'    => array(
					'Background checks help organizations keep their workplaces safe and protect the people they serve, including children, older adults and patients. <a href="' . $compliance . '">Compliance for Good®</a> is GCheck\'s commitment to responsible, accessible screening, and to making a background check that does that job affordable for every organization. Organizations that serve vulnerable populations, support humanitarian relief, work in underprivileged communities or promote public safety may qualify for preferential pricing, including volume-based and merit-based considerations.',
					'A national criminal database search on its own can miss records from counties that don\'t report to the database, and an organization may not know what was missed. That\'s why all three GCheck employment background check packages (Basic, Standard and Advanced) include a county criminal search alongside the national database search. GCheck Basic (' . $base . ') searches the candidate\'s current county of residence. GCheck Standard (' . $m( $c['standard'] ) . ') and Advanced (' . $m( $c['advanced'] ) . ') search every county in the candidate\'s address history.',
				),
				'note'    => 'No background check can find every record. Search results are one input into a hiring decision. Employers are responsible for complying with the FCRA and applicable state and local laws, including disclosure and authorization before a check and the pre-adverse and adverse action process. GCheck doesn\'t provide legal advice.',
			),

			'compliance'  => 'Compliance for Good® is GCheck\'s belief that screening should do more than satisfy a requirement: it should be a force for good for the candidate, the employer and the public. Every GCheck package runs on the same three commitments, whatever you pay, and all three employment background check packages include a county criminal search (<a href="#pc-why-county">why GCheck doesn\'t offer a database-only check</a>). Organizations that serve vulnerable populations, support humanitarian relief, work in underprivileged communities or promote public safety may qualify for preferential pricing. <a href="' . $compliance . '">Learn about Compliance for Good®</a>',

			'coverages'   => array(
				array( 'id' => 'current', 'label' => 'Current county' ),
				array( 'id' => 'all', 'label' => 'All counties' ),
				array( 'id' => 'fed', 'label' => 'All counties + federal' ),
			),

			'providers'   => array(
				array(
					'id'    => 'gcheck',
					'n'     => '1.',
					'name'  => 'GCheck',
					'us'    => true,
					'lead'  => 'GCheck publishes three per-check packages: Basic ' . $base . ', Standard ' . $m( $c['standard'] ) . ' and Advanced ' . $m( $c['advanced'] ) . '. GCheck Basic includes a national criminal database search and a county criminal search of the candidate\'s current county of residence, the lowest published price for a check with a county search among the seven providers compared.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $base . ' · Standard ' . $m( $c['standard'] ) . ' · Advanced ' . $m( $c['advanced'] ) ),
						array( 'County searches', 'Current county in GCheck Basic; unlimited counties of residence in GCheck Standard and GCheck Advanced' ),
						array( 'Best for', 'Employers who want county coverage in the entry price and pay per check, with no setup fees, no minimums and no long-term contracts. 12 to 24 hour average turnaround.' ),
						array( 'Trade-offs', 'GCheck Basic covers the current county only, so candidates who have moved need GCheck Standard. GCheck Advanced doesn\'t include statewide criminal searches; Checkr Complete and GoodHire Complete do.' ),
					),
				),
				array(
					'id'    => 'first-advantage',
					'n'     => '2.',
					'name'  => 'First Advantage',
					'lead'  => 'First Advantage sells small-business packages through a self-serve signup flow, from ' . $m( $c['faBasic'], 0 ) . ': Basic ' . $m( $c['faBasic'], 0 ) . ' (no county search listed), Standard ' . $m( $c['faStandard'], 0 ) . ' (adds a county criminal search), Choice ' . $m( $c['faChoice'], 0 ) . ' (seven years of county searches and global sanctions) and Premium ' . $m( $c['faPremium'], 0 ) . ' (adds a driving record). Enterprise programs are quoted.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $m( $c['faBasic'], 0 ) . ' · Standard ' . $m( $c['faStandard'], 0 ) . ' · Choice ' . $m( $c['faChoice'], 0 ) . ' · Premium ' . $m( $c['faPremium'], 0 ) . ' · Enterprise by quote' ),
						array( 'County searches', 'A county criminal search in First Advantage Standard (' . $m( $c['faStandard'], 0 ) . '; scope not listed); seven years of addresses in First Advantage Choice (' . $m( $c['faChoice'], 0 ) . ')' ),
						array( 'Best for', 'Small businesses that want a self-serve account with a large provider, and enterprises that want background checks, drug testing and other screening under one contract.' ),
						array( 'Trade-offs', 'Full package prices appear only in the signup flow; the main site gives a starting price. First Advantage Basic lists no county search. No published federal tier. Owns Sterling, so the two aren\'t independent quotes.' ),
					),
				),
				array(
					'id'    => 'backgroundchecks',
					'n'     => '3.',
					'name'  => 'BackgroundChecks.com',
					'lead'  => 'BackgroundChecks.com, a HireRight company, publishes three packages: Basic ' . $m( $c['bgBasic'] ) . ', Complete ' . $m( $c['bgComplete'] ) . ' (unlimited counties over a 7-year address history) and Professional ' . $m( $c['bgPro'] ) . ' per applicant.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $m( $c['bgBasic'] ) . ' · Complete ' . $m( $c['bgComplete'] ) . ' · Professional ' . $m( $c['bgPro'] ) ),
						array( 'County searches', 'Unlimited in BackgroundChecks.com Complete and Professional; none listed in Basic' ),
						array( 'Best for', 'Small businesses that want self-serve checks from a HireRight company, with published add-ons: federal ' . $m( $c['bgFederal'] ) . ', statewide ' . $m( $c['bgState'] ) . ', MVR ' . $m( $c['bgMvr'] ) . '.' ),
						array( 'Trade-offs', 'BackgroundChecks.com Basic has no county search. County searches may carry surcharges. Identity verification is a paid add-on.' ),
					),
				),
				array(
					'id'    => 'checkr',
					'n'     => '4.',
					'name'  => 'Checkr',
					'lead'  => 'Checkr publishes three self-serve packages: Basic ' . $m( $c['checkrBasic'] ) . ', Essential ' . $m( $c['checkrEssential'] ) . ' and Complete ' . $m( $c['checkrComplete'] ) . ' per report. County criminal searches start at Checkr Essential, which includes unlimited counties.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $m( $c['checkrBasic'] ) . ' · Essential ' . $m( $c['checkrEssential'] ) . ' · Complete ' . $m( $c['checkrComplete'] ) . ' · Enterprise by quote' ),
						array( 'County searches', 'Unlimited, from Checkr Essential (' . $m( $c['checkrEssential'] ) . ')' ),
						array( 'Best for', 'Teams that want published self-serve pricing, and roles that need unlimited county plus statewide and federal searches in one tier.' ),
						array( 'Trade-offs', 'Checkr Basic runs county searches only when the national search identifies potential records, for ' . $m( $c['checkrCounty'], 0 ) . ' plus court fees, so its final price varies by candidate. Court and DMV fees are added at cost.' ),
					),
				),
				array(
					'id'    => 'goodhire',
					'n'     => '5.',
					'name'  => 'GoodHire',
					'lead'  => 'GoodHire, a Checkr company, lists the same three packages at the same prices: Basic ' . $m( $c['goodhireBasic'] ) . ', Essential ' . $m( $c['goodhireEssential'] ) . ' and Complete ' . $m( $c['goodhireComplete'] ) . ' per check.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $m( $c['goodhireBasic'] ) . ' · Essential ' . $m( $c['goodhireEssential'] ) . ' · Complete ' . $m( $c['goodhireComplete'] ) . ' · Custom quote for volume' ),
						array( 'County searches', 'Unlimited, from GoodHire Essential (' . $m( $c['goodhireEssential'] ) . ')' ),
						array( 'Best for', 'Small businesses that want Checkr\'s package structure through a separate small-business account.' ),
						array( 'Trade-offs', 'GoodHire Basic lists no county search, so county searches start at GoodHire Essential (' . $m( $c['goodhireEssential'] ) . ').' ),
					),
				),
				array(
					'id'    => 'hireright',
					'n'     => '6.',
					'name'  => 'HireRight',
					'lead'  => 'HireRight doesn\'t publish prices; small businesses and enterprises both buy through its sales team. HireRight also owns BackgroundChecks.com, a separate self-serve brand listed above.',
					'facts' => array(
						array( 'Published pricing', 'Quote only' ),
						array( 'County searches', 'Price not published' ),
						array( 'Best for', 'Employers of any size that want a sales-led account, including those hiring across countries. HireRight states coverage of more than 200 countries and territories.' ),
						array( 'Trade-offs', 'You need a quote to compare the price of a check with a county search.' ),
					),
				),
				array(
					'id'    => 'sterling',
					'n'     => '7.',
					'name'  => 'Sterling (now First Advantage)',
					'lead'  => 'First Advantage completed its acquisition of Sterling Check on October 31, 2024, and Sterling\'s site now says it is First Advantage. Sterling\'s enterprise screening is priced by quote; no per-check prices are published under the Sterling name.',
					'facts' => array(
						array( 'Published pricing', 'Quote only' ),
						array( 'County searches', 'Price not published' ),
						array( 'Best for', 'Existing Sterling customers and large employers in regulated sectors such as healthcare and financial services.' ),
						array( 'Trade-offs', 'No published price. Sterling and First Advantage are now one company, so their quotes aren\'t independent. Small businesses are better served by First Advantage\'s self-serve packages.' ),
					),
				),
			),

			'method'      => array(
				array(
					'title' => 'Which providers',
					'text'  => 'Six U.S. employment screening providers that employers most often compare against GCheck, plus GCheck. Sterling is listed separately from its owner, First Advantage, because employers still search for it by name. BackgroundChecks.com, a HireRight company, is listed separately because it publishes its own prices.',
				),
				array(
					'title' => 'What we counted',
					'text'  => 'The lowest per-check price each provider publishes on its own website, including signup and order pages, for the stated coverage. A county search means a search of the county criminal court, not a national database. Court and DMV fees, volume discounts and enterprise contracts are excluded for every provider, and if a provider doesn\'t publish a price, we say "Not published" instead of estimating.',
				),
			),

			'moments'     => array(
				array(
					'icon'  => 'eye',
					'title' => 'Transparent Compliance',
					'text'  => 'Candidates know what is being searched and can see what comes back.',
				),
				array(
					'icon'  => 'scale',
					'title' => 'Fair Compliance',
					'text'  => 'Every applicant in a package gets the same search and a real chance to dispute a finding.',
				),
				array(
					'icon'  => 'lock',
					'title' => 'Protective Compliance',
					'text'  => 'Personal data is protected by SOC 2 Type II attested security controls and handled under FCRA requirements.',
				),
			),

			'faqs'        => array(
				array(
					'q' => 'How much does a background check cost in 2026?',
					'a' => 'Among the seven providers compared here, published per-check prices for a background check with a county criminal search ranged from ' . $base . ' (GCheck Basic) to ' . $m( $c['checkrEssential'] ) . ' (Checkr and GoodHire Essential) as of November 2026, with First Advantage at ' . $m( $c['faStandard'], 0 ) . ' and BackgroundChecks.com at ' . $m( $c['bgComplete'] ) . '. Entry packages ranged from ' . $base . ' (GCheck Basic, which includes a county search) to ' . $m( $c['bgBasic'] ) . ' (BackgroundChecks.com, Checkr and GoodHire Basic), with First Advantage Basic at ' . $m( $c['faBasic'], 0 ) . '; none of the competitor entry packages always includes a county search. HireRight and Sterling quote prices individually. Every provider here that publishes prices lists court and DMV access fees as extra.',
				),
				array(
					'q' => 'Which background check companies publish their prices?',
					'a' => 'Of the seven providers compared here, GCheck, BackgroundChecks.com, Checkr and GoodHire publish full per-check package prices on their websites. First Advantage shows small-business package prices in its signup flow. HireRight and Sterling publish no prices.',
				),
				array(
					'q' => 'What is the difference between a national criminal database search and a county criminal search?',
					'a' => 'A national criminal database search checks a multi-source database built from records that jurisdictions choose to contribute. A county criminal search checks the county court directly. County courts hold most U.S. criminal records, and database coverage varies by jurisdiction.',
				),
				array(
					'q' => 'Is a national criminal database search enough on its own?',
					'a' => 'Usually not. National criminal databases are built from records that jurisdictions choose to contribute, so coverage and how current the records are vary. Some jurisdictions contribute few or no records. Under the FCRA, a provider that reports a public record likely to hurt a candidate\'s chances must either notify the candidate at the time or maintain strict procedures to make sure the record is complete and up to date. Many providers do this by confirming the record with the county court. Running at least one county criminal search, starting with the candidate\'s current county, covers records a database can miss.',
				),
				array(
					'q' => 'Why doesn\'t GCheck offer a national criminal database-only background check?',
					'a' => 'Under Compliance for Good®, GCheck\'s commitment to responsible, accessible screening, GCheck believes background checks are essential to safe workplaces and to protecting vulnerable people, and that they should be affordable for every organization. Organizations that serve vulnerable populations, support humanitarian relief, work in underprivileged communities or promote public safety may qualify for preferential pricing. Because a national criminal database search on its own can miss records from counties that don\'t report to the database, all three GCheck employment background check packages include a county criminal search alongside the national database search. GCheck Basic (' . $base . ') searches the candidate\'s current county of residence; GCheck Standard (' . $m( $c['standard'] ) . ') and Advanced (' . $m( $c['advanced'] ) . ') search every county in the candidate\'s address history.',
				),
				array(
					'q' => 'Does GCheck Basic include a national criminal database search?',
					'a' => 'Yes. GCheck Basic (' . $base . ') includes a national criminal database search, SSN trace and nationwide sex offender registry search, plus a county criminal search of the candidate’s current county of residence. The county search is in addition to the national database search, not a replacement for it. GCheck Standard (' . $m( $c['standard'] ) . ') extends the county search to unlimited counties across the candidate’s seven-year address history.',
				),
				array(
					'q' => 'Does GCheck\'s ' . $base . ' Basic package include a county criminal search?',
					'a' => 'Yes. GCheck Basic includes a county criminal search of the candidate’s current county of residence in addition to a national criminal database search, SSN trace and nationwide sex offender registry search. For candidates who have lived in other counties, GCheck Standard (' . $m( $c['standard'] ) . ') covers unlimited counties of residence.',
				),
				array(
					'q' => 'Are there background checks cheaper than ' . $base . '?',
					'a' => 'Some providers list entry prices below ' . $base . ', but those packages typically leave out a county criminal search or charge extra for it. GCheck Basic (' . $base . ') includes a county criminal search of the candidate’s current county of residence.',
				),
				array(
					'q' => 'Is Sterling part of First Advantage?',
					'a' => 'Yes. First Advantage completed its acquisition of Sterling Check on October 31, 2024, and Sterling now operates as First Advantage. Sterling doesn’t publish per-check prices; First Advantage’s small-business packages start at ' . $m( $c['faBasic'], 0 ) . ', with a county criminal search from ' . $m( $c['faStandard'], 0 ) . '.',
				),
				array(
					'q' => 'Does GCheck charge setup fees or require a contract?',
					'a' => 'No. GCheck charges per check, with no setup fees, no minimums and no long-term contracts. Third-party fees are passed through with no markup.',
				),
				array(
					'q' => 'Does GCheck offer volume pricing?',
					'a' => 'Yes. Employers running more than 50 background checks a year can request custom volume pricing, and merit-based nonprofit discounts are available.',
				),
				array(
					'q' => 'Why are court fees excluded from the comparison?',
					'a' => 'Some counties and states charge their own record access fees. Every provider here that publishes prices lists them as extra, and the amount depends on where the candidate has lived, so they are excluded for all providers equally.',
				),
			),

			'sources'     => array(
				'GCheck: <a href="' . $packages . '">gcheck.com/pricing-packages</a>, checked November 2026. Basic ' . $base . ' (SSN trace, national criminal database, nationwide sex offender registry, OIG/OFAC and global watchlists, current county criminal search), Standard ' . $m( $c['standard'] ) . ', Advanced ' . $m( $c['advanced'] ) . ' per check. Third-party fees passed through with no markup.',
				'BackgroundChecks.com (a HireRight company): <a href="https://app.backgroundchecks.com/order-report" rel="nofollow">order page</a>, checked November 2026. Basic ' . $m( $c['bgBasic'] ) . ' (county-level criminal search not included); Complete ' . $m( $c['bgComplete'] ) . ' (unlimited county criminal search on 7-year address history); Professional ' . $m( $c['bgPro'] ) . '. Add-ons: federal criminal ' . $m( $c['bgFederal'] ) . ', statewide ' . $m( $c['bgState'] ) . ', MVR ' . $m( $c['bgMvr'] ) . ', identity verification ' . $m( $c['bgId'] ) . ' (shown discounted from ' . $m( $c['bgIdList'] ) . '). No standalone county search add-on. County criminal and county civil searches may add passthrough surcharges by jurisdiction.',
				'First Advantage: <a href="https://fadv.com/solutions/small-business-background-checks/" rel="nofollow">small business background checks</a> (“for as little as ' . $m( $c['faBasic'], 0 ) . '”) and the Background Direct <a href="https://smb.fadv.com/order/online/package" rel="nofollow">package signup page</a>, checked November 2026. Basic FA ' . $m( $c['faBasic'], 0 ) . ' (sex offender, national criminal record, SSN trace; no county search listed), Standard FA ' . $m( $c['faStandard'], 0 ) . ' (adds county criminal search; scope not listed), Choice FA ' . $m( $c['faChoice'], 0 ) . ' (adds global sanctions; 7-year county criminal search), Premium FA ' . $m( $c['faPremium'], 0 ) . ' (adds driving record). All plus out-of-pocket fees. Add-ons: driving record ' . $m( $c['faDriving'] ) . ', education verification (highest education) ' . $m( $c['faEducation'] ) . ', employment verification (most recent employer) ' . $m( $c['faEmployment'] ) . '. Enterprise pricing by quote.',
				'Checkr: <a href="https://checkr.com/pricing" rel="nofollow">checkr.com/pricing</a> and <a href="https://checkr.com/pricing/passthrough-fees" rel="nofollow">passthrough fees</a>, checked November 2026. Basic ' . $m( $c['checkrBasic'] ) . ', Essential ' . $m( $c['checkrEssential'] ) . ' (unlimited county criminal search, identity verification), Complete ' . $m( $c['checkrComplete'] ) . ' (adds unlimited state and federal criminal search). Identity verification add-on ' . $m( $c['checkrId'] ) . '. Basic package tooltip (verbatim): "If a national criminal search identifies potential records, Checkr automatically completes criminal searches in relevant counties for ' . $m( $c['checkrCounty'], 0 ) . '. Court fees for each county may apply."',
				'GoodHire: <a href="https://www.goodhire.com/pricing/" rel="nofollow">goodhire.com/pricing</a>, checked November 2026. Basic ' . $m( $c['goodhireBasic'] ) . ' (SSN trace, sex offender registry, global watchlist, national criminal search; no county search listed), Essential ' . $m( $c['goodhireEssential'] ) . ' (adds identity verification and unlimited county criminal search), Complete ' . $m( $c['goodhireComplete'] ) . ' (adds unlimited state criminal search and federal criminal search).',
				'HireRight: <a href="https://www.hireright.com/pricing" rel="nofollow">hireright.com/pricing</a> (quote request; no prices published), <a href="https://www.hireright.com/global" rel="nofollow">hireright.com/global</a> ("more than 200 countries and territories") and <a href="https://www.hireright.com/industries/business-size/small-business" rel="nofollow">hireright.com/industries/business-size/small-business</a> (small businesses buy through HireRight\'s sales team), checked November 2026.',
				'Sterling: <a href="https://www.sterlingcheck.com/" rel="nofollow">sterlingcheck.com</a>, checked November 2026. Site states Sterling is now First Advantage; no per-check prices published. Acquisition completed October 31, 2024 (<a href="https://www.sec.gov/Archives/edgar/data/1210677/000095017024119269/fa-20241030.htm" rel="nofollow">First Advantage Form 8-K</a>).',
				'County court and DMV access fees vary by jurisdiction and are excluded from every price shown, for every provider.',
				'Fair Credit Reporting Act §613, <a href="https://www.law.cornell.edu/uscode/text/15/1681k">15 U.S.C. §1681k</a>: public record information likely to have an adverse effect, reported for employment purposes.',
				'Fair Credit Reporting Act §607(b), <a href="https://www.law.cornell.edu/uscode/text/15/1681e">15 U.S.C. §1681e(b)</a>: reasonable procedures to assure maximum possible accuracy.',
			),

			'source_change' => 'Competitor prices can change after we check them; confirm current prices on each provider\'s site.',
			'source_note' => 'Found a price change? <a href="' . esc_url( $contact ) . '">Tell us</a> and we\'ll update this page.',
		);

		return $content;
	}
}
