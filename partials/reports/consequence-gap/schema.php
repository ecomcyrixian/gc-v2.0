<?php
/**
 * Structured data (JSON-LD) for the Consequence Gap report.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gc_report_consequence_gap_schema( $post ) {
	$url    = esc_url_raw( get_permalink( $post ) );
	$org_id = home_url( '/' ) . '#organization';

	$variables_measured = array(
		array(
			'name'        => 'Workers who have worked closely with a colleague whose behavior consistently made work life worse',
			'value'       => 85,
			'description' => 'Base: 1,500 employed US adults, weighted. INCIDENCE.',
		),
		array(
			'name'        => 'Toxic colleagues who faced no visible consequence',
			'value'       => 38,
			'description' => 'Base: 1,272 exposed workers, weighted. PERCEPTION of outcome.',
		),
		array(
			'name'        => 'Toxic colleagues who were rewarded, promoted, or protected',
			'value'       => 23,
			'description' => 'Base: 1,272 exposed workers, weighted. PERCEPTION of outcome.',
		),
		array(
			'name'        => 'Toxic colleagues who eventually left or were removed',
			'value'       => 36,
			'description' => 'Base: 1,272 exposed workers, weighted. PERCEPTION of outcome.',
		),
		array(
			'name'        => 'Toxic colleague was a peer',
			'value'       => 47,
			'description' => 'Base: 1,272 exposed workers, weighted. INCIDENCE.',
		),
		array(
			'name'        => 'Toxic managers or senior leaders rewarded or protected',
			'value'       => 36,
			'description' => 'Base: 119 manager cases, directional. Compared with 24% for toxic junior colleagues (342 cases). PERCEPTION of outcome.',
		),
		array(
			'name'        => 'Workers who left before the colleague where the colleague was rewarded or protected',
			'value'       => 40,
			'description' => 'Base: 283 exposed workers, weighted. Compared with 10% where the colleague was removed (476). INCIDENCE; a pattern, not proof of cause.',
		),
		array(
			'name'        => 'Behavior adoption where the colleague was rewarded or protected',
			'value'       => 36,
			'description' => 'Base: 283 exposed workers, weighted. Compared with 14% where the colleague was removed (476). INCIDENCE.',
		),
		array(
			'name'        => 'Exposed workers who admit acting like the colleague',
			'value'       => 21,
			'description' => 'Base: 1,272 exposed workers, weighted. INCIDENCE; a conservative floor.',
		),
		array(
			'name'        => 'Exposed workers reporting at least one specific adopted behavior',
			'value'       => 62,
			'description' => 'Base: 1,272 exposed workers, weighted. INCIDENCE.',
		),
		array(
			'name'        => 'Adopters who say the behavior still shows up at later jobs',
			'value'       => 43,
			'description' => 'Base: 236 adopters who later worked somewhere the colleague was not. Self-reported; a pattern, not proof.',
		),
		array(
			'name'        => 'Exposed workers reporting increased dread about the workday',
			'value'       => 55,
			'description' => 'Base: 1,272 exposed workers, weighted. INCIDENCE.',
		),
		array(
			'name'        => "Workers who say one toxic person is enough to change a whole team's tone",
			'value'       => 65,
			'description' => 'PERCEPTION.',
		),
		array(
			'name'        => 'Workers naming managers addressing toxic behavior early as a top remedy',
			'value'       => 61,
			'description' => 'Base: 1,500 employed US adults, weighted. PERCEPTION, multi-select.',
		),
		array(
			'name'        => 'Workers naming real consequences regardless of performance as a top remedy',
			'value'       => 52,
			'description' => 'Base: 1,500 employed US adults, weighted. PERCEPTION, multi-select.',
		),
	);

	$variable_measured_nodes = array();
	foreach ( $variables_measured as $variable ) {
		$variable_measured_nodes[] = array(
			'@type'       => 'PropertyValue',
			'name'        => $variable['name'],
			'value'       => $variable['value'],
			'unitText'    => 'percent',
			'description' => $variable['description'],
		);
	}

	$pdf_key = function_exists( 'gc_secure_pdf_consequence_gap_report_key' ) ? gc_secure_pdf_consequence_gap_report_key() : '';
	$pdf_url = ( $pdf_key && function_exists( 'gc_secure_pdf_stream_url' ) ) ? gc_secure_pdf_stream_url( $pdf_key ) : '';

	$dataset = array(
		'@type'            => 'Dataset',
		'@id'              => $url . '#dataset',
		'name'             => 'GCheck Consequence Gap Survey 2026',
		'description'      => 'National survey of 1,500 US adults employed full-time, fielded in August 2026 via the Pollfish online panel and census-weighted on age, gender, and region. The instrument measures exposure to a colleague whose behavior consistently made work life worse, what the organization did in response, self-reported behavior adoption, turnover, recovery, and the remedies workers endorse. Exposure-routed design: 1,272 exposed workers answered the full instrument; 228 never-exposed workers answered baseline items only. Non-probability opt-in sample with a modeled error estimate of about plus or minus 2.5 points on full-sample figures.',
		'url'              => $url,
		'identifier'       => 'Pollfish survey 395594484',
		'creator'          => array( '@id' => $org_id ),
		'publisher'        => array( '@id' => $org_id ),
		'isAccessibleForFree' => true,
		'datePublished'    => get_the_date( 'c', $post ),
		'dateModified'     => get_the_modified_date( 'c', $post ),
		'temporalCoverage' => '2026-08',
		'spatialCoverage'  => array(
			'@type' => 'Country',
			'name'  => 'United States',
		),
		'measurementTechnique' => 'Online survey, Pollfish non-probability opt-in panel, census-weighted on age, gender, and region',
		'keywords'         => array(
			'toxic coworkers',
			'workplace accountability',
			'employee turnover',
			'workplace culture',
			'survey data',
		),
		'variableMeasured' => $variable_measured_nodes,
	);

	if ( $pdf_url ) {
		$dataset['distribution'] = array(
			'@type'          => 'DataDownload',
			'encodingFormat' => 'application/pdf',
			'contentUrl'     => esc_url_raw( $pdf_url ),
		);
	}

	if ( function_exists( 'gc_theme_get_whitepaper_datacatalog_id' ) ) {
		$datacatalog_id = gc_theme_get_whitepaper_datacatalog_id();
		if ( $datacatalog_id ) {
			$dataset['includedInDataCatalog'] = array( '@id' => $datacatalog_id );
		}
	}

	$term = array(
		'@type'       => 'DefinedTerm',
		'@id'         => $url . '#term',
		'name'        => 'Consequence Gap',
		'description' => 'The distance between how hard a workplace is on everyone and how hard it is on the specific person making it worse: the colleague whose behavior goes unpunished, or rewarded, while the pressure lands on the people around them.',
		'url'         => $url,
		'inDefinedTermSet' => array(
			'@type'     => 'DefinedTermSet',
			'name'      => 'GCheck Trust Recession research glossary',
			'publisher' => array( '@id' => $org_id ),
		),
	);

	$key_findings = array(
		'85% of US workers have worked closely with a colleague whose behavior consistently made work life worse.',
		'61% of those colleagues faced no visible consequence, or were rewarded, promoted, or protected.',
		'Workers were 2.5 times likelier to adopt the behavior where the colleague was rewarded than where the colleague was removed.',
		'Four times as many workers left before the colleague did where the behavior was rewarded (40% vs. 10%).',
		'43% of workers who adopted the behavior carried it into jobs where the colleague never worked.',
	);

	$key_findings_list_items = array();
	foreach ( $key_findings as $index => $finding ) {
		$key_findings_list_items[] = array(
			'@type'    => 'ListItem',
			'position' => $index + 1,
			'name'     => $finding,
		);
	}

	$key_findings_list = array(
		'@type'          => 'ItemList',
		'@id'            => $url . '#key-findings',
		'name'           => 'Key findings of The 2026 Consequence Gap Report',
		'itemListOrder'  => 'https://schema.org/ItemListOrderAscending',
		'numberOfItems'  => count( $key_findings_list_items ),
		'itemListElement' => $key_findings_list_items,
		'url'            => $url,
	);

	$report_entity = null;
	if ( function_exists( 'gc_theme_build_report_entity_schema' ) ) {
		$series_id = null;
		if ( function_exists( 'gc_theme_get_whitepaper_hub_url' ) ) {
			$hub_url   = gc_theme_get_whitepaper_hub_url();
			$series_id = ( $hub_url ? $hub_url : home_url( '/' ) ) . '#trust-recession';
		}

		$report_entity = gc_theme_build_report_entity_schema(
			$post,
			array(
				'headline'             => 'The 2026 Consequence Gap',
				'alternative_headline' => 'Companies got harsher with everyone except the people the harshness was for.',
				'description'          => 'An August 2026 national survey of 1,500 US workers on who absorbs workplace pressure, who escapes it, and what unaccountable behavior costs a team.',
				'abstract'             => '85% of US workers have worked closely with a colleague whose behavior consistently made work life worse. In 61% of those cases the colleague faced no visible consequence (38%) or was rewarded, promoted, or protected (23%); only 36% eventually left or were removed. Harmful managers were rewarded or protected more often than harmful junior colleagues (36% vs. 24%) and removed at half the rate (21% vs. 41%). Where the colleague was rewarded, workers adopted the behavior at 2.5 times the rate and left the job before that colleague four times as often (40% vs. 10%) as where the colleague was removed. 21% of exposed workers admit they started acting like the colleague, 62% report at least one specific adopted behavior, and 43% of those who adopted it say it still shows up in later jobs. Workers\' top remedies are managers addressing behavior early (61%) and real consequences regardless of performance (52%).',
				'image'                => get_template_directory_uri() . '/partials/reports/consequence-gap/page-hero/images/page-hero.webp',
				'keywords'             => array(
					'consequence gap',
					'toxic coworkers',
					'toxic workplace',
					'workplace accountability',
					'toxic manager',
					'employee turnover',
					'workplace culture',
					'behavior contagion',
					'workplace survey 2026',
					'HR research',
				),
				'audience'             => 'HR leaders, people managers, workplace researchers, and journalists',
				'mentions'             => array(
					array(
						'@type'       => 'Organization',
						'name'        => 'Society for Human Resource Management',
						'alternateName' => 'SHRM',
						'url'         => 'https://www.shrm.org/',
					),
					array(
						'@type'       => 'GovernmentOrganization',
						'name'        => 'U.S. Equal Employment Opportunity Commission',
						'alternateName' => 'EEOC',
						'url'         => 'https://www.eeoc.gov/',
					),
				),
				'citation'             => array(
					array(
						'@type'         => 'CreativeWork',
						'name'          => 'SHRM reports toxic workplace cultures cost billions',
						'author'        => array(
							'@type' => 'Organization',
							'name'  => 'Society for Human Resource Management',
						),
						'datePublished' => '2019-09-25',
						'url'           => 'https://www.shrm.org/about/press-room/shrm-reports-toxic-workplace-cultures-cost-billions',
					),
					array(
						'@type'         => 'Report',
						'name'          => 'Select Task Force on the Study of Harassment in the Workplace: Report of Co-Chairs Chai R. Feldblum and Victoria A. Lipnic',
						'author'        => array(
							'@type' => 'GovernmentOrganization',
							'name'  => 'U.S. Equal Employment Opportunity Commission',
						),
						'datePublished' => '2016',
						'url'           => 'https://www.eeoc.gov/select-task-force-study-harassment-workplace-report-co-chairs-chai-r-feldblum-victoria-lipnic',
					),
				),
				'report_number'        => 'The Trust Recession, Report 4',
				'series'               => $series_id ? array(
					'id'       => $series_id,
					'position' => 4,
				) : null,
				'pdf_key'              => $pdf_key,
			)
		);

		if ( $report_entity ) {
			$report_entity['about'] = array(
				array( '@id' => $url . '#dataset' ),
				array( '@id' => $url . '#term' ),
				array(
					'@type' => 'Thing',
					'name'  => 'Toxic workplace behavior',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Organizational accountability',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Employee turnover',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Workplace culture',
				),
			);

			if ( isset( $series_id ) && function_exists( 'gc_theme_get_trust_recession_series_node' ) ) {
				$trust_in_hiring_post = get_page_by_path( 'trust-in-hiring-report', OBJECT, 'page' );
				if ( $trust_in_hiring_post && 'publish' === $trust_in_hiring_post->post_status ) {
					$report_entity['citation'][] = array(
						'@id' => esc_url_raw( get_permalink( $trust_in_hiring_post ) ) . '#report',
					);
				}
			}
		}
	}

	$graph = array( $dataset, $term, $key_findings_list );

	if ( $report_entity ) {
		$graph[] = $report_entity;
	}

	if ( function_exists( 'gc_theme_get_trust_recession_series_node' ) ) {
		$series_data = gc_theme_get_trust_recession_series_node();
		if ( ! empty( $series_data['series'] ) ) {
			$graph[] = $series_data['series'];
			foreach ( $series_data['stubs'] as $stub ) {
				if ( isset( $stub['url'] ) && $stub['url'] === $url ) {
					continue; // The full node above already covers this page.
				}
				$graph[] = $stub;
			}
		}
	}

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
}
