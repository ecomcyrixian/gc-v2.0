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
		$checkr_current      = 54.99;
		$checkr_essential_fed = 69.99;
		$goodhire_basic      = 29.99;
		$goodhire_essential  = 59.99;
		$goodhire_complete   = 94.99;
		$vf_basic            = 29.99;
		$vf_essential        = 54.99;
		$vf_premium          = 79.99;

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
			'checkrCurrent'      => $checkr_current,
			'checkrEssentialFed' => $checkr_essential_fed,
			'vfBasic'            => $vf_basic,
			'vfEssential'        => $vf_essential,
			'vfPremium'          => $vf_premium,
			'extraCounty'        => 9.95,
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
				'current' => array( $base, $bg_complete, $checkr_current, $goodhire_essential, $vf_essential ),
				'all'     => array( $standard, $bg_complete, $checkr_essential, $goodhire_essential, $vf_essential ),
				'fed'     => array( $advanced, $bg_complete_fed, $checkr_essential_fed, $goodhire_complete, null ),
			),
			'bar_labels'         => array(
				'current' => array(
					'(Basic: current county of residence included)',
					'(Complete: unlimited counties; no one-county option)',
					'(Basic + county search add-on, $25)',
					'(Essential: unlimited counties; no one-county option)',
					'(Essential: unlimited counties; no one-county option)',
				),
				'all'     => array(
					'(Standard: unlimited counties of residence, last 7 years)',
					'(Complete: unlimited counties, 7-year address history)',
					'(Essential: unlimited counties)',
					'(Essential: unlimited counties)',
					'(Essential: unlimited counties)',
				),
				'fed'     => array(
					'(Advanced: unlimited counties of residence, last 7 years + federal)',
					'(Complete + $9.99 federal add-on)',
					'(Essential + $10 federal add-on)',
					'(Complete: also adds statewide)',
					'(No federal option published)',
				),
			),
			'coverage_text'      => array(
				'current' => 'with one county search',
				'all'     => 'with unlimited county searches',
				'fed'     => 'with unlimited county and federal searches',
			),
			'bars'               => array(
				array( 'name' => 'GCheck', 'index' => 0, 'us' => true ),
				array( 'name' => 'BackgroundChecks.com', 'index' => 1 ),
				array( 'name' => 'Checkr', 'index' => 2 ),
				array( 'name' => 'GoodHire', 'index' => 3 ),
				array( 'name' => 'Verified First', 'index' => 4 ),
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
	 * Totals follow the coverage arrays in config: GCheck, BackgroundChecks.com, Checkr, GoodHire, Verified First.
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
		$gap_bg     = $m( round( $c['bgComplete'] - $c['standard'], 2 ) );

		$content = array(
			'title'       => 'Compare',
			'name'        => 'Background Check Pricing Compared (2026): GCheck vs Checkr',
			'headline'    => 'Background check pricing compared (2026): GCheck vs Checkr, GoodHire, HireRight, BackgroundChecks.com, Verified First, First Advantage and Sterling',
			'description' => 'GCheck Basic is ' . $base . ' with a county criminal search. Compare published 2026 prices from Checkr, GoodHire, BackgroundChecks.com and more.',
			'lede'        => 'Of the eight providers compared, the lowest published price for a background check that includes a county criminal search is <b>' . $base . '</b> (GCheck Basic), as of November 2026. The price includes a national criminal database search and a county criminal search of the candidate\'s current county. If the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply.',
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
						array( 'price' => $m( $c['bgComplete'] ), 'name' => 'BackgroundChecks.com' ),
						array( 'price' => $m( $c['vfEssential'] ), 'name' => 'Verified First' ),
						array( 'price' => $m( $c['checkrEssential'] ), 'name' => 'Checkr, GoodHire' ),
					),
				),
				array(
					'label' => 'No published prices',
					'items' => array(
						array( 'name' => 'First Advantage' ),
						array( 'name' => 'HireRight' ),
						array( 'name' => 'Sterling (now First Advantage)' ),
					),
				),
			),

			'ticket'      => array(
				array(
					'strong' => 'County criminal search included in the price',
					'text'   => 'Candidate\'s current county',
				),
				array(
					'icon' => 'receipt',
					'text' => 'Other counties: ' . $m( $c['extraCounty'] ) . ' each, searched automatically if the national search finds possible records there. Third-party court fees may also apply.',
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
					'text' => 'GCheck Basic <b class="num">' . $base . '</b> includes a national criminal database search and a county search of the candidate\'s current county in the price. If the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply. GCheck Standard <b class="num">' . $m( $c['standard'] ) . '</b> adds unlimited counties of residence, last 7 years, and biometric ID verification.<sup>1</sup>',
				),
				array(
					'n'    => '2',
					'id'   => 'backgroundchecks',
					'name' => 'BackgroundChecks.com',
					'text' => '<b class="num">' . $m( $c['bgComplete'] ) . '</b> for unlimited counties over a 7-year address history (BackgroundChecks.com Complete). BackgroundChecks.com Basic lists no county search. A HireRight company.<sup>2</sup>',
				),
				array(
					'n'    => '3',
					'id'   => 'verified-first',
					'name' => 'Verified First',
					'text' => '<b class="num">' . $m( $c['vfEssential'] ) . '</b> (Verified First Essential, unlimited counties). Verified First Basic (' . $m( $c['vfBasic'] ) . ') lists no county search.<sup>11</sup>',
				),
				array(
					'n'    => '4',
					'id'   => 'checkr',
					'name' => 'Checkr',
					'text' => '<b class="num">' . $m( $c['checkrEssential'] ) . '</b> (Checkr Essential, unlimited counties). Checkr Basic (' . $m( $c['checkrBasic'] ) . ') includes no county search in its price. If the national search finds possible records, the relevant counties are automatically searched for ' . $m( $c['checkrCounty'], 0 ) . '. Third-party court fees may also apply.<sup>4</sup>',
				),
				array(
					'n'    => '5',
					'id'   => 'goodhire',
					'name' => 'GoodHire',
					'text' => '<b class="num">' . $m( $c['goodhireEssential'] ) . '</b> (GoodHire Essential, unlimited counties). Tied with Checkr on price. GoodHire Basic lists no county search.<sup>5</sup>',
				),
				array(
					'n'    => '–',
					'id'   => 'first-advantage',
					'name' => 'First Advantage',
					'text' => 'No published price list; small-business prices are shown after creating an account.<sup>3</sup>',
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
					'text'  => 'GCheck Basic (' . $base . ') is the lowest published entry price among the eight providers compared.',
					'tone'  => 'blue',
				),
				array(
					'value' => 'Only one',
					'text'  => 'Of the five providers that publish prices, GCheck Basic is the only entry package whose price includes a county criminal search (the candidate\'s current county).',
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
				array(
					'label' => 'Entry package',
					'note'  => 'Each provider\'s lowest-priced package',
					'key'   => true,
				),
				array(
					'label' => 'Middle package',
					'note'  => 'The next package up',
				),
				array(
					'label' => 'Top package',
					'note'  => 'The highest package compared',
				),
			),

			'callout'     => '<b>What the entry price includes:</b> GCheck Basic (' . $base . ') includes a county criminal search of the candidate\'s current county. Checkr Basic (' . $m( $c['checkrBasic'] ) . ') includes no county search. In both, if the national search finds possible records in counties the package doesn\'t cover, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each (GCheck) or ' . $m( $c['checkrCounty'], 0 ) . ' (Checkr). Third-party court fees may also apply. BackgroundChecks.com, GoodHire and Verified First list no county search in their entry packages. <a href="#pc-county">Why a county search in the price matters</a>',

			'rows'        => array(
				array(
					'id'    => 'gcheck',
					'name'  => 'GCheck',
					'us'    => true,
					'cells' => array(
						array( 'strong' => $base, 'sup' => '1', 'text' => 'Basic. National database + current county search. Other counties: ' . $m( $c['extraCounty'] ) . ' each, searched automatically if the national search finds possible records. Court fees may apply.' ),
						array( 'strong' => $m( $c['standard'] ), 'text' => 'Standard. Unlimited counties of residence, last 7 years + biometric ID verification. Other counties: ' . $m( $c['extraCounty'] ) . ' each, searched automatically if the national search finds possible records. Court fees may apply.' ),
						array( 'strong' => $m( $c['advanced'] ), 'text' => 'Advanced. Unlimited counties of residence, last 7 years + federal + biometric ID verification. Other counties: ' . $m( $c['extraCounty'] ) . ' each, searched automatically if the national search finds possible records. Court fees may apply.' ),
					),
				),
				array(
					'id'    => 'backgroundchecks',
					'name'  => 'BackgroundChecks.com',
					'note'  => 'A HireRight company',
					'cells' => array(
						array( 'strong' => $m( $c['bgBasic'] ), 'sup' => '2', 'text' => 'Basic. National database + watchlists; no county search' ),
						array( 'strong' => $m( $c['bgComplete'] ), 'text' => 'Complete. Unlimited counties, 7-year address history' ),
						array( 'strong' => $m( $c['bgPro'] ), 'text' => 'Professional. Unlimited counties + federal + education and employment verification' ),
					),
				),
				array(
					'id'    => 'verified-first',
					'name'  => 'Verified First',
					'note'  => 'Privately owned, Idaho',
					'cells' => array(
						array( 'strong' => $m( $c['vfBasic'] ), 'sup' => '11', 'text' => 'Basic. National database + watchlist; no county search listed' ),
						array( 'strong' => $m( $c['vfEssential'] ), 'text' => 'Essential. Unlimited counties' ),
						array( 'strong' => $m( $c['vfPremium'] ), 'text' => 'Premium. Unlimited counties + employment and education verification' ),
					),
				),
				array(
					'id'    => 'checkr',
					'name'  => 'Checkr',
					'cells' => array(
						array( 'strong' => $m( $c['checkrBasic'] ), 'sup' => '4', 'text' => 'Basic. National database + watchlist. No county search. Counties: ' . $m( $c['checkrCounty'], 0 ) . ', searched automatically if the national search finds possible records. Court fees may apply.' ),
						array( 'strong' => $m( $c['checkrEssential'] ), 'text' => 'Essential. Unlimited counties + ID verification' ),
						array( 'strong' => $m( $c['checkrComplete'] ), 'text' => 'Complete. Unlimited counties + statewide + federal + ID verification' ),
					),
				),
				array(
					'id'    => 'goodhire',
					'name'  => 'GoodHire',
					'note'  => 'A Checkr company',
					'cells' => array(
						array( 'strong' => $m( $c['goodhireBasic'] ), 'sup' => '5', 'text' => 'Basic. National database + watchlist; no county search listed' ),
						array( 'strong' => $m( $c['goodhireEssential'] ), 'text' => 'Essential. Unlimited counties + ID verification' ),
						array( 'strong' => $m( $c['goodhireComplete'] ), 'text' => 'Complete. Unlimited counties + statewide + federal + ID verification' ),
					),
				),
				array(
					'span'  => true,
					'links' => array(
						array( 'id' => 'first-advantage', 'name' => 'First Advantage' ),
						array( 'id' => 'hireright', 'name' => 'HireRight' ),
						array( 'id' => 'sterling', 'name' => 'Sterling' ),
					),
					'note'  => 'Sterling is now First Advantage',
					'cells' => array(
						array(
							'colspan'   => 3,
							'tag'       => 'q',
							'tag_label' => 'No published prices',
							'sup'       => '3, 6, 7',
							'after'     => 'None publishes per-check package prices. First Advantage shows small-business prices after you create an account; HireRight and Sterling sell through a sales team.',
						),
					),
				),
			),

			'compare_note' => 'Prices checked ' . $c['verified'] . ' on each provider\'s own website; court access fees excluded for all providers.<sup>8</sup> If the national search finds possible records in counties a package doesn\'t cover, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each with GCheck (all packages) and ' . $m( $c['checkrCounty'], 0 ) . ' with Checkr Basic. Third-party court fees may also apply. Competitor prices can change after we check them; confirm current prices on each provider\'s site. <a href="#pc-county">Why county searches matter</a>. Trademarks belong to their respective owners.',

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
					'text'  => 'When a provider reports public-record information for employment purposes that is likely to hurt a candidate\'s chances, the FCRA requires it either to notify the candidate at the time or to maintain strict procedures to make sure the record is complete and up to date.<sup>9</sup> Providers must also follow reasonable procedures to assure maximum possible accuracy.<sup>10</sup> Many providers meet these duties by confirming database hits with the county court. Some state laws, including California\'s, may be stricter.',
				),
				array(
					'title' => 'The blind spot in database-only searching',
					'text'  => 'Some packages use database hits to decide which counties to search; Checkr Basic, for example, includes no county search; if the national search finds possible records, the relevant counties are automatically searched for ' . $m( $c['checkrCounty'], 0 ) . '.<sup>4</sup> If a county doesn\'t send records to the database, no hit appears, so that county never gets searched. GCheck Basic works the same way for counties other than the candidate\'s current county: if the national search finds possible records there, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Searching the candidate\'s current county, or every county in their address history, doesn\'t depend on database coverage.',
				),
			),

			'why'         => array(
				'eyebrow' => 'Compliance for Good®',
				'title'   => 'Why GCheck doesn\'t offer a database-only background check',
				'body'    => array(
					'Background checks help organizations keep their workplaces safe and protect the people they serve, including children, older adults and patients. <a href="' . $compliance . '">Compliance for Good®</a> is GCheck\'s commitment to responsible, accessible screening, and to making a background check that does that job affordable for every organization. Organizations that serve vulnerable populations, support humanitarian relief, work in underprivileged communities or promote public safety may qualify for preferential pricing, including volume-based and merit-based considerations.',
					'A national criminal database search on its own can miss records from counties that don\'t report to the database, and an organization may not know what was missed. That\'s why all three GCheck employment background check packages (Basic, Standard and Advanced) include a county criminal search alongside the national database search. The GCheck Basic price (' . $base . ') includes a county criminal search of the candidate\'s current county. GCheck Standard (' . $m( $c['standard'] ) . ') and Advanced (' . $m( $c['advanced'] ) . ') include unlimited counties of residence, last 7 years. In all three packages, if the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply.',
				),
				'note'    => 'No background check can find every record. Search results are one input into a hiring decision. Employers are responsible for complying with the FCRA and applicable state and local laws, including disclosure and authorization before a check and the pre-adverse and adverse action process. GCheck doesn\'t provide legal advice.',
			),

			'compliance'  => 'Compliance for Good® is GCheck\'s belief that screening should do more than satisfy a requirement: it should be a force for good for the candidate, the employer and the public. Every GCheck package runs on the same three commitments, whatever you pay, and all three employment background check packages include a county criminal search (<a href="#pc-why-county">why GCheck doesn\'t offer a database-only check</a>). Organizations that serve vulnerable populations, support humanitarian relief, work in underprivileged communities or promote public safety may qualify for preferential pricing. <a href="' . $compliance . '">Learn about Compliance for Good®</a>',

			'save_note'   => 'Based on published prices, before court fees. Totals include only what each package lists. They don\'t include extra county searches: if the national search finds possible records in counties a package doesn\'t cover, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each with GCheck and ' . $m( $c['checkrCounty'], 0 ) . ' with Checkr Basic. Third-party court fees may also apply. Most providers offer volume pricing, so your quote may differ.',

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
					'lead'  => 'GCheck lists three per-check packages: Basic ' . $base . ', Standard ' . $m( $c['standard'] ) . ' and Advanced ' . $m( $c['advanced'] ) . '. The GCheck Basic price includes a national criminal database search and a county criminal search of the candidate\'s current county of residence, the lowest published price for a check with a county search among the eight providers compared. GCheck Standard and Advanced add unlimited counties of residence, last 7 years, and biometric ID verification.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $base . ' · Standard ' . $m( $c['standard'] ) . ' · Advanced ' . $m( $c['advanced'] ) ),
						array( 'County searches', 'GCheck Basic includes the current county. GCheck Standard and GCheck Advanced include unlimited counties of residence, last 7 years. In all three, if the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply.' ),
						array( 'Good to know', 'Statewide criminal searches are available with every GCheck package as an add-on rather than included in the price. No setup fees, no minimums and no long-term contracts.' ),
					),
				),
				array(
					'id'    => 'backgroundchecks',
					'n'     => '2.',
					'name'  => 'BackgroundChecks.com',
					'lead'  => 'BackgroundChecks.com, a HireRight company, lists three packages: Basic ' . $m( $c['bgBasic'] ) . ', Complete ' . $m( $c['bgComplete'] ) . ' (unlimited counties over a 7-year address history) and Professional ' . $m( $c['bgPro'] ) . ' per applicant.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $m( $c['bgBasic'] ) . ' · Complete ' . $m( $c['bgComplete'] ) . ' · Professional ' . $m( $c['bgPro'] ) ),
						array( 'County searches', 'Unlimited in BackgroundChecks.com Complete and Professional; none listed in Basic' ),
						array( 'Good to know', 'BackgroundChecks.com Basic has no county search, so county searches start at BackgroundChecks.com Complete (' . $m( $c['bgComplete'] ) . '). Published add-ons: federal ' . $m( $c['bgFederal'] ) . ', statewide ' . $m( $c['bgState'] ) . ', MVR ' . $m( $c['bgMvr'] ) . ' and identity verification ' . $m( $c['bgId'] ) . '. County searches may add passthrough surcharges by jurisdiction.' ),
					),
				),
				array(
					'id'    => 'verified-first',
					'n'     => '3.',
					'name'  => 'Verified First',
					'lead'  => 'Verified First, a privately owned provider based in Meridian, Idaho, publishes three packages: Basic ' . $m( $c['vfBasic'] ) . ', Essential ' . $m( $c['vfEssential'] ) . ' (adds unlimited county criminal search) and Premium ' . $m( $c['vfPremium'] ) . ' (adds employment and education verification). Enterprise pricing is custom.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $m( $c['vfBasic'] ) . ' · Essential ' . $m( $c['vfEssential'] ) . ' · Premium ' . $m( $c['vfPremium'] ) . ' · Enterprise custom' ),
						array( 'County searches', 'Unlimited, from Verified First Essential (' . $m( $c['vfEssential'] ) . '); none listed in Basic' ),
						array( 'Good to know', 'Verified First Basic lists no county search, so county searches start at Verified First Essential (' . $m( $c['vfEssential'] ) . '). No federal, statewide or add-on prices are published. Its pricing page states no long-term contracts, annual commitments or minimums.' ),
					),
				),
				array(
					'id'    => 'checkr',
					'n'     => '4.',
					'name'  => 'Checkr',
					'lead'  => 'Checkr lists three self-serve packages: Basic ' . $m( $c['checkrBasic'] ) . ', Essential ' . $m( $c['checkrEssential'] ) . ' and Complete ' . $m( $c['checkrComplete'] ) . ' per report. County criminal searches start at Checkr Essential, which includes unlimited counties.',
					'facts' => array(
						array( 'Published pricing', 'Basic ' . $m( $c['checkrBasic'] ) . ' · Essential ' . $m( $c['checkrEssential'] ) . ' · Complete ' . $m( $c['checkrComplete'] ) . ' · Enterprise by quote' ),
						array( 'County searches', 'Unlimited, from Checkr Essential (' . $m( $c['checkrEssential'] ) . ')' ),
						array( 'Good to know', 'Checkr Basic includes no county search in its price. If the national search finds possible records, the relevant counties are automatically searched for ' . $m( $c['checkrCounty'], 0 ) . '. Unlimited county searches start at Checkr Essential (' . $m( $c['checkrEssential'] ) . '), and Checkr Complete adds statewide and federal searches. Third-party court fees are passed through at cost.' ),
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
						array( 'Good to know', 'GoodHire Basic lists no county search, so county searches start at GoodHire Essential (' . $m( $c['goodhireEssential'] ) . '). Checkr is GoodHire\'s parent company.' ),
					),
				),
				array(
					'id'    => 'first-advantage',
					'n'     => '6.',
					'name'  => 'First Advantage',
					'lead'  => 'First Advantage says it does not publish a single universal price list; pricing is generally customized by services, volume, locations and integrations. Small businesses can order through a self-serve account with pay-as-you-go pricing, no setup fees and no minimum volume, and prices are shown after creating the account.',
					'facts' => array(
						array( 'Published pricing', 'No published price list' ),
						array( 'County searches', 'County court record searches in over 3,100 U.S. counties; price not published' ),
						array( 'Good to know', 'You need to create an account or request a quote to see prices. First Advantage says it "may be a strong fit for businesses with 100 or more employees." First Advantage owns Sterling.' ),
					),
				),
				array(
					'id'    => 'hireright',
					'n'     => '7.',
					'name'  => 'HireRight',
					'lead'  => 'HireRight doesn\'t publish prices; small businesses and enterprises both buy through its sales team. HireRight also owns BackgroundChecks.com, a separate self-serve brand listed above.',
					'facts' => array(
						array( 'Published pricing', 'Quote only' ),
						array( 'County searches', 'Price not published' ),
						array( 'Good to know', 'You need a quote to see prices. HireRight states coverage of more than 200 countries and territories.' ),
					),
				),
				array(
					'id'    => 'sterling',
					'n'     => '8.',
					'name'  => 'Sterling (now First Advantage)',
					'lead'  => 'First Advantage completed its acquisition of Sterling Check on October 31, 2024, and Sterling\'s site now says it is First Advantage. Sterling\'s enterprise screening is priced by quote; no per-check prices are published under the Sterling name.',
					'facts' => array(
						array( 'Published pricing', 'Quote only' ),
						array( 'County searches', 'Price not published' ),
						array( 'Good to know', 'You need a quote to see prices. Sterling\'s site now presents it as First Advantage.' ),
					),
				),
			),

			'method'      => array(
				array(
					'title' => 'Which providers',
					'text'  => 'Seven U.S. employment screening providers that employers most often compare against GCheck, plus GCheck. Sterling is listed separately from its owner, First Advantage, because employers still search for it by name. BackgroundChecks.com, a HireRight company, is listed separately because it publishes its own prices.',
				),
				array(
					'title' => 'What we counted',
					'text'  => 'The lowest per-check price each provider publishes on its own website, including public order pages, for the stated coverage. Prices shown only after creating an account aren\'t used. A county search means a search of the county criminal court, not a national database. Court and DMV fees, volume discounts and enterprise contracts are excluded for every provider, and if a provider doesn\'t publish a price, we say "Not published" instead of estimating.',
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
					'a' => 'Among the eight providers compared here, published per-check prices for a background check with a county criminal search ranged from ' . $base . ' (GCheck Basic) to ' . $m( $c['checkrEssential'] ) . ' (Checkr and GoodHire Essential) as of November 2026, with BackgroundChecks.com at ' . $m( $c['bgComplete'] ) . ' and Verified First at ' . $m( $c['vfEssential'] ) . '. Entry packages ranged from ' . $base . ' (GCheck Basic, whose price includes a current-county search) to ' . $m( $c['bgBasic'] ) . ' (BackgroundChecks.com, Checkr, GoodHire and Verified First Basic); no competitor\'s entry package price includes a county search. First Advantage, HireRight and Sterling don\'t publish per-check prices. Court and DMV access fees are excluded from every price compared here.',
				),
				array(
					'q' => 'Which background check companies publish their prices?',
					'a' => 'Of the eight providers compared here, GCheck, BackgroundChecks.com, Checkr, GoodHire and Verified First publish full package prices on their websites. First Advantage says it does not publish a single universal price list; its small-business prices are shown after you create an account. HireRight and Sterling publish no prices.',
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
					'a' => 'Under Compliance for Good®, GCheck\'s commitment to responsible, accessible screening, GCheck believes background checks are essential to safe workplaces and to protecting vulnerable people, and that they should be affordable for every organization. Organizations that serve vulnerable populations, support humanitarian relief, work in underprivileged communities or promote public safety may qualify for preferential pricing. Because a national criminal database search on its own can miss records from counties that don\'t report to the database, all three GCheck employment background check packages include a county criminal search alongside the national database search. The GCheck Basic price (' . $base . ') includes a county criminal search of the candidate\'s current county. GCheck Standard (' . $m( $c['standard'] ) . ') and Advanced (' . $m( $c['advanced'] ) . ') include unlimited counties of residence, last 7 years. In all three packages, if the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply.',
				),
				array(
					'q' => 'Does GCheck Basic include a national criminal database search?',
					'a' => 'Yes. GCheck Basic (' . $base . ') includes a national criminal database search, SSN trace and nationwide sex offender registry search, plus a county criminal search of the candidate’s current county of residence. The county search is in addition to the national database search, not a replacement for it. If the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply. GCheck Standard (' . $m( $c['standard'] ) . ') extends the county search to unlimited counties of residence, last 7 years.',
				),
				array(
					'q' => 'Does GCheck’s ' . $base . ' Basic package include a county criminal search?',
					'a' => 'Yes. The GCheck Basic price includes a county criminal search of the candidate’s current county of residence in addition to a national criminal database search, SSN trace and nationwide sex offender registry search. For candidates who have lived in other counties, GCheck Standard (' . $m( $c['standard'] ) . ') covers unlimited counties of residence, last 7 years. In both packages, if the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply.',
				),
				array(
					'q' => 'Are there background checks cheaper than ' . $base . '?',
					'a' => 'Among the eight providers compared on this page, none publishes a lower entry price than GCheck Basic (' . $base . '). Providers not compared here may publish lower prices, so check whether a package’s price includes a county criminal search. The GCheck Basic price (' . $base . ') includes a county criminal search of the candidate’s current county of residence. If the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party court fees may also apply.',
				),
				array(
					'q' => 'Is Sterling part of First Advantage?',
					'a' => 'Yes. First Advantage completed its acquisition of Sterling Check on October 31, 2024, and Sterling now operates as First Advantage. Neither Sterling nor First Advantage publishes per-check prices.',
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
					'a' => 'Some counties and states charge their own record access fees. Most providers here with published prices list them as extra, and the amount depends on where the candidate has lived, so they are excluded for all providers equally.',
				),
			),

			'sources'     => array(
				'GCheck: <a href="' . $packages . '">gcheck.com/pricing-packages</a>, checked November 2026. Basic ' . $base . ' (SSN trace, national criminal database, nationwide sex offender registry, OIG/OFAC and global watchlists, current county criminal search), Standard ' . $m( $c['standard'] ) . ', Advanced ' . $m( $c['advanced'] ) . ' per check (Standard and Advanced: unlimited counties of residence, last 7 years, plus biometric ID verification). The GCheck Basic price includes the candidate\'s current county. In all three packages, if the national search finds possible records in other counties, those counties are automatically searched for ' . $m( $c['extraCounty'] ) . ' each. Third-party fees passed through with no markup.',
				'BackgroundChecks.com (a HireRight company): <a href="https://app.backgroundchecks.com/order-report" rel="nofollow">order page</a> (public; prices shown at step 1 of ordering, before any account details) and <a href="https://www.backgroundchecks.com/about" rel="nofollow">about page</a> (“As a HireRight company”), checked November 2026. Basic ' . $m( $c['bgBasic'] ) . ' (county-level criminal search not included); Complete ' . $m( $c['bgComplete'] ) . ' (unlimited county criminal search on 7-year address history); Professional ' . $m( $c['bgPro'] ) . '. Add-ons: federal criminal ' . $m( $c['bgFederal'] ) . ', statewide ' . $m( $c['bgState'] ) . ', MVR ' . $m( $c['bgMvr'] ) . ', identity verification ' . $m( $c['bgId'] ) . ' (shown discounted from ' . $m( $c['bgIdList'] ) . '). No standalone county search add-on. County criminal and county civil searches may add passthrough surcharges by jurisdiction.',
				'First Advantage: <a href="https://fadv.com/article/first-advantage-background-checks-for-growing-businesses/" rel="nofollow">pricing article</a> (September 2026: “First Advantage does not publish a single universal price list for configurable, growing business programs”) and <a href="https://fadv.com/solutions/small-business-background-checks/" rel="nofollow">small business background checks</a> (pay-as-you-go pricing, no setup fees, no minimum volume; prices shown after creating an account), checked November 2026. The article also says First Advantage “may be a strong fit for businesses with 100 or more employees.” County court record searches offered in over 3,100 U.S. counties. No published per-check prices.',
				'Checkr: <a href="https://checkr.com/pricing" rel="nofollow">checkr.com/pricing</a> and <a href="https://checkr.com/pricing/passthrough-fees" rel="nofollow">passthrough fees</a>, checked November 2026. Basic ' . $m( $c['checkrBasic'] ) . ', Essential ' . $m( $c['checkrEssential'] ) . ' (unlimited county criminal search, identity verification), Complete ' . $m( $c['checkrComplete'] ) . ' (adds unlimited state and federal criminal search). Add-ons: county criminal search $25, state criminal search from $10, federal criminal search $10, MVR $9.50, employment or education verification from $12.50, identity verification ' . $m( $c['checkrId'] ) . '; third-party fees extra where noted. Basic package tooltip (verbatim): “If a national criminal search identifies potential records, Checkr automatically completes criminal searches in relevant counties for ' . $m( $c['checkrCounty'], 0 ) . '. Court fees for each county may apply.” Pricing page note: third-party court and database access fees are passed through at cost.',
				'GoodHire: <a href="https://www.goodhire.com/pricing/" rel="nofollow">goodhire.com/pricing</a> and <a href="https://www.goodhire.com/about/" rel="nofollow">about page</a> (“Checkr Is Our Parent Company”; GoodHire is part of Inflection, which Checkr acquired in April 2022), checked November 2026. Basic ' . $m( $c['goodhireBasic'] ) . ' (SSN trace, sex offender registry, global watchlist, national criminal search; no county search listed), Essential ' . $m( $c['goodhireEssential'] ) . ' (adds identity verification and unlimited county criminal search), Complete ' . $m( $c['goodhireComplete'] ) . ' (adds unlimited state criminal search and federal criminal search).',
				'HireRight: <a href="https://www.hireright.com/pricing" rel="nofollow">hireright.com/pricing</a> (quote request; no prices published), <a href="https://www.hireright.com/global" rel="nofollow">hireright.com/global</a> (“more than 200 countries and territories”) and <a href="https://www.hireright.com/industries/business-size/small-business" rel="nofollow">hireright.com/industries/business-size/small-business</a> (small businesses buy through HireRight\'s sales team), checked November 2026.',
				'Sterling: <a href="https://www.sterlingcheck.com/" rel="nofollow">sterlingcheck.com</a>, checked November 2026. Site states Sterling is now First Advantage; no per-check prices published. Acquisition completed October 31, 2024 (First Advantage <a href="https://www.sec.gov/Archives/edgar/data/1210677/000095017024119269/fa-20241030.htm">Form 8-K</a>).',
				'County court and DMV access fees vary by jurisdiction and are excluded from every price shown, for every provider.',
				'Fair Credit Reporting Act §613, <a href="https://www.law.cornell.edu/uscode/text/15/1681k">15 U.S.C. §1681k</a>: public record information likely to have an adverse effect, reported for employment purposes.',
				'Fair Credit Reporting Act §607(b), <a href="https://www.law.cornell.edu/uscode/text/15/1681e">15 U.S.C. §1681e(b)</a>: reasonable procedures to assure maximum possible accuracy.',
				'Verified First: <a href="https://verifiedfirst.com/pricing/" rel="nofollow">verifiedfirst.com/pricing</a>, checked November 2026. Basic ' . $m( $c['vfBasic'] ) . ' (nationwide criminal search, national sex offender registry, Social Security address trace, global security watch list; no county search listed), Essential ' . $m( $c['vfEssential'] ) . ' (adds unlimited county criminal search), Premium ' . $m( $c['vfPremium'] ) . ' (adds employment and education verification), Enterprise custom. Package prices as shown on the page; no add-on, court-fee or federal search prices published. “No long-term contracts, no annual commitments, and no minimum screening requirements.”',
			),

			'source_change' => 'Competitor prices can change after we check them; confirm current prices on each provider\'s site.',
			'source_note' => 'Found a price change? <a href="' . esc_url( $contact ) . '">Tell us</a> and we\'ll update this page.',
		);

		return $content;
	}
}
