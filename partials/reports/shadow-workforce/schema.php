<?php
/**
 * Structured data (JSON-LD) for the Rise of the Shadow Workforce report.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gc_report_shadow_workforce_schema( $post ) {
	$url    = esc_url_raw( get_permalink( $post ) );
	$org_id = home_url( '/' ) . '#organization';

	$variables_measured = array(
		array(
			'name'        => 'Worked with someone who turned out not to be what they claimed professionally',
			'value'       => 71,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Worked for an employer that hired someone unable to do the job',
			'value'       => 81,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Had to cover for, fix, or take on extra work for a coworker who lacked the skills',
			'value'       => 77,
			'description' => 'Base: 1,500 US adults employed full-time, including 22% who do so frequently. INCIDENCE.',
		),
		array(
			'name'        => 'Say remote or hybrid work has made it harder to truly know coworkers',
			'value'       => 52,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Would not know whether coworkers were performing their jobs throughout the day',
			'value'       => 36,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Say hires who cannot do the job usually overstated their experience',
			'value'       => 57,
			'description' => 'Base: 1,500 US adults employed full-time. Multi-select. PERCEPTION.',
		),
		array(
			'name'        => 'Believe some colleagues lied to get their job',
			'value'       => 54,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Believe coworkers exaggerate how busy they are',
			'value'       => 84,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Believe colleagues intentionally create the appearance of productivity',
			'value'       => 45,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Admit making it seem they were working while doing other things',
			'value'       => 17,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Admit using AI to complete tasks their employer believes they do personally',
			'value'       => 14,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Have suspected a coworker was not the person hired or not doing their own work',
			'value'       => 28,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Have heard of someone offered money to let another person use their identity or work eligibility',
			'value'       => 33,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Say misrepresenting skills or identity creates business risk',
			'value'       => 97,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Believe employers clearly do enough to verify workers',
			'value'       => 14,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
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

	$pdf_key = function_exists( 'gc_secure_pdf_shadow_workforce_report_key' ) ? gc_secure_pdf_shadow_workforce_report_key() : '';
	$pdf_url = ( $pdf_key && function_exists( 'gc_secure_pdf_stream_url' ) ) ? gc_secure_pdf_stream_url( $pdf_key ) : '';

	$dataset = array(
		'@type'            => 'Dataset',
		'@id'              => $url . '#dataset',
		'name'             => 'GCheck Shadow Workforce Survey 2026',
		'description'      => 'National online survey of 1,500 US adults employed full-time, fielded June 12, 2026 via Pollfish. The instrument measures how well employees know the colleagues they work with, experience with coworkers who misrepresented their skills or identity, covering for colleagues who could not do the job, perceptions of productivity appearance, awareness of ghost workers and identity misuse, self-reported delegation and AI use, confidence in employer verification, and the verification practices employees would support. Margin of error of approximately plus or minus 2.5 percentage points at 95% confidence, wider for subgroups. Subgroups below 100 respondents, most notably Baby Boomers, are shown for directional comparison only.',
		'url'              => $url,
		'identifier'       => 'Pollfish survey 395585242',
		'creator'          => array( '@id' => $org_id ),
		'publisher'        => array( '@id' => $org_id ),
		'isAccessibleForFree' => true,
		'datePublished'    => get_the_date( 'c', $post ),
		'dateModified'     => get_the_modified_date( 'c', $post ),
		'temporalCoverage' => '2026-06-12',
		'spatialCoverage'  => array(
			'@type' => 'Country',
			'name'  => 'United States',
		),
		'measurementTechnique' => 'Online survey via Pollfish of US adults employed full-time',
		'keywords'         => array(
			'shadow workforce',
			'verification half-life',
			'ghost workers',
			'identity verification',
			'skills verification',
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

	$terms = array(
		array(
			'@type'       => 'DefinedTerm',
			'@id'         => $url . '#term-shadow-workforce',
			'name'        => 'Shadow Workforce',
			'description' => 'A growing layer of workers, technologies, and third parties operating behind the scenes, often outside traditional visibility and verification.',
			'url'         => $url,
			'inDefinedTermSet' => array(
				'@type'     => 'DefinedTermSet',
				'name'      => 'GCheck Trust Recession research glossary',
				'publisher' => array( '@id' => $org_id ),
			),
		),
		array(
			'@type'       => 'DefinedTerm',
			'@id'         => $url . '#term-verification-half-life',
			'name'        => 'Verification Half-Life',
			'description' => 'The steady erosion of certainty that follows a one-time check when nothing reconfirms who a worker is, what they can do, and whether they are the one doing the work.',
			'url'         => $url,
			'inDefinedTermSet' => array(
				'@type'     => 'DefinedTermSet',
				'name'      => 'GCheck Trust Recession research glossary',
				'publisher' => array( '@id' => $org_id ),
			),
		),
	);

	$key_findings = array(
		'71% have worked with someone who turned out not to be what they claimed professionally.',
		'81% have worked for an organization that hired someone who could not perform the job.',
		'77% have had to cover for or correct the work of a coworker who lacked the necessary skills.',
		'84% believe coworkers exaggerate how busy they are.',
		'97% say misrepresenting skills or identity creates business risk, yet only 14% believe employers do enough to verify workers.',
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
		'@type'           => 'ItemList',
		'@id'             => $url . '#key-findings',
		'name'            => 'Key findings of The Rise of the Shadow Workforce',
		'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
		'numberOfItems'   => count( $key_findings_list_items ),
		'itemListElement' => $key_findings_list_items,
		'url'             => $url,
	);

	$report_entity = null;
	if ( function_exists( 'gc_theme_build_report_entity_schema' ) ) {
		$series_id = null;
		if ( function_exists( 'gc_theme_get_whitepaper_hub_url' ) ) {
			$hub_url   = gc_theme_get_whitepaper_hub_url();
			$series_id = ( $hub_url ? $hub_url : home_url( '/' ) ) . '#trust-recession';
		}

		$citation = array();
		foreach ( array( 'trust-in-hiring-report', 'automation-anxiety-report' ) as $sibling_slug ) {
			$sibling_post = get_page_by_path( $sibling_slug, OBJECT, 'page' );
			if ( $sibling_post && 'publish' === $sibling_post->post_status ) {
				$citation[] = array( '@id' => esc_url_raw( get_permalink( $sibling_post ) ) . '#report' );
			}
		}

		$report_entity = gc_theme_build_report_entity_schema(
			$post,
			array(
				'headline'    => 'The Rise of the Shadow Workforce',
				'description' => 'New research from 1,500 employed US adults on the Shadow Workforce: colleagues employees cannot verify, AI-assisted work passed off as human, the rise of ghost workers, and why verification decays after hire.',
				'abstract'    => '71% of US adults employed full-time have worked with someone who turned out not to be what they claimed professionally, and 81% have worked for an employer that hired someone who could not do the job. 77% have had to cover for, fix, or take on extra work because a coworker lacked the necessary skills. 52% say remote and hybrid work has made it harder to truly know their coworkers. 84% believe coworkers exaggerate how busy they are, and 45% believe colleagues intentionally create the appearance of productivity. 28% have suspected a coworker was not the person hired or was not doing their own work, and 33% have heard of someone being offered money to let another person use their identity or work authorization. 97% say misrepresenting skills or identity creates business risk, yet only 14% believe employers do enough to verify workers. The report calls the erosion of certainty after a one-time check the Verification Half-Life.',
				'image'       => get_template_directory_uri() . '/partials/reports/shadow-workforce/page-hero/images/swr-bg.webp',
				'keywords'    => array(
					'shadow workforce',
					'ghost workers',
					'verification half-life',
					'identity verification',
					'skills misrepresentation',
					'remote work trust',
					'post-hire verification',
					'workforce survey 2026',
				),
				'audience'      => 'HR leaders, talent acquisition teams, workplace researchers, and journalists',
				'report_number' => 'The Trust Recession, Report 3',
				'series'        => $series_id ? array(
					'id'       => $series_id,
					'position' => 3,
				) : null,
				'pdf_key'       => $pdf_key,
				'citation'      => $citation,
			)
		);

		if ( $report_entity ) {
			$report_entity['about'] = array(
				array( '@id' => $url . '#term-shadow-workforce' ),
				array( '@id' => $url . '#term-verification-half-life' ),
				array( '@id' => $url . '#dataset' ),
				array(
					'@type' => 'Thing',
					'name'  => 'Workforce identity verification',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Ghost workers',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Skills misrepresentation',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Remote and hybrid work',
				),
			);
		}
	}

	$graph = array_merge( array( $dataset ), $terms, array( $key_findings_list ) );

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
