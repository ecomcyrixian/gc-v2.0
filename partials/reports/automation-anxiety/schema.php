<?php
/**
 * Structured data (JSON-LD) for the Automation Anxiety report.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gc_report_automation_anxiety_schema( $post ) {
	$url    = esc_url_raw( get_permalink( $post ) );
	$org_id = home_url( '/' ) . '#organization';

	$variables_measured = array(
		array(
			'name'        => 'Believe AI is very or somewhat likely to automate parts of their job within 24 months',
			'value'       => 69,
			'description' => 'Base: 1,500 US adults employed full-time. 79% for Gen Z (n=132, small-sample caveat). PERCEPTION.',
		),
		array(
			'name'        => 'Have lied or exaggerated their AI skills to appear more knowledgeable',
			'value'       => 63,
			'description' => 'Base: 1,500 US adults employed full-time. 80% for Gen Z (n=132, small-sample caveat). INCIDENCE.',
		),
		array(
			'name'        => 'Spoke confidently about AI in meetings to avoid appearing behind',
			'value'       => 40,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Took credit for AI-assisted work as entirely their own',
			'value'       => 25,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Explicitly lied about having AI skills they did not have',
			'value'       => 16,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'List at least one AI skill on their resume or LinkedIn',
			'value'       => 71,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Of those listing AI skills, could confidently perform all of them at a professional level',
			'value'       => 34,
			'description' => 'Base: workers who list at least one AI skill. PERCEPTION.',
		),
		array(
			'name'        => 'List AI skills publicly and admit some or all exceed their actual ability',
			'value'       => 47,
			'description' => 'Base: 1,500 US adults employed full-time. The AI Skills Bubble. INCIDENCE.',
		),
		array(
			'name'        => 'Engaged in at least one behavior to discourage or limit AI use at work',
			'value'       => 81,
			'description' => 'Base: 1,500 US adults employed full-time. The Double Distortion. INCIDENCE.',
		),
		array(
			'name'        => 'Preferred manual approaches to avoid increasing reliance on AI',
			'value'       => 53,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Raised AI risk concerns more strongly than they personally believe',
			'value'       => 45,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Of those who exaggerate AI skills, cite no reliable employer verification as a reason',
			'value'       => 48,
			'description' => 'Base: workers reporting at least one AI skills exaggeration behavior (n=952). PERCEPTION.',
		),
		array(
			'name'        => 'Took at least one preemptive resume or skill action in the past six months because of AI concerns',
			'value'       => 78,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Currently engaged with the job market while employed full-time',
			'value'       => 54,
			'description' => 'Base: 1,500 US adults employed full-time. INCIDENCE.',
		),
		array(
			'name'        => 'Say their employer has not attempted to verify their AI skills',
			'value'       => 64,
			'description' => 'Base: 1,500 US adults employed full-time. The Verification Vacuum. INCIDENCE.',
		),
		array(
			'name'        => 'Believe their employer can effectively verify AI skills',
			'value'       => 39,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Believe most coworkers are exaggerating their AI skills',
			'value'       => 43,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Say misrepresenting AI skills puts businesses at risk',
			'value'       => 76,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Want human review of hiring decisions even when AI tools are used',
			'value'       => 61,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Want direct testing of AI competencies claimed on resumes',
			'value'       => 48,
			'description' => 'Base: 1,500 US adults employed full-time. PERCEPTION.',
		),
		array(
			'name'        => 'Would present themselves more honestly if employers disclosed what will be independently verified',
			'value'       => 29,
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

	$pdf_key = function_exists( 'gc_secure_pdf_automation_anxiety_report_key' ) ? gc_secure_pdf_automation_anxiety_report_key() : '';
	$pdf_url = ( $pdf_key && function_exists( 'gc_secure_pdf_stream_url' ) ) ? gc_secure_pdf_stream_url( $pdf_key ) : '';

	$dataset = array(
		'@type'            => 'Dataset',
		'@id'              => $url . '#dataset',
		'name'             => 'GCheck Automation Anxiety Survey 2026',
		'description'      => 'National online survey of 1,500 US adults employed full-time, fielded April 21 to 22, 2026 via Pollfish over a continuous 16-hour field window. All respondents passed an AI familiarity screener. The instrument measures expected AI impact on respondents\' jobs, AI skill exaggeration and its motives, behaviors that limit AI use and their motives, AI skills listed on resumes and self-rated ability to perform them, job market activity, employer verification of AI skills, and the hiring practices workers say would build trust. Margin of error of plus or minus 2.5 percentage points at 95% confidence on full-sample figures.',
		'url'              => $url,
		'identifier'       => 'Pollfish survey 395577040',
		'creator'          => array( '@id' => $org_id ),
		'publisher'        => array( '@id' => $org_id ),
		'isAccessibleForFree' => true,
		'datePublished'    => get_the_date( 'c', $post ),
		'dateModified'     => get_the_modified_date( 'c', $post ),
		'temporalCoverage' => '2026-04-21/2026-04-22',
		'spatialCoverage'  => array(
			'@type' => 'Country',
			'name'  => 'United States',
		),
		'measurementTechnique' => 'Online survey via Pollfish of US adults employed full-time who passed an AI familiarity screener',
		'keywords'         => array(
			'AI skills bubble',
			'double distortion',
			'verification vacuum',
			'automation anxiety',
			'AI skills exaggeration',
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
			'@id'         => $url . '#term-ai-skills-bubble',
			'name'        => 'AI Skills Bubble',
			'description' => 'A 2026 workforce phenomenon in which AI skill claims have outpaced workers\' actual ability to perform them, documented through self-reported inflation rather than inferred from external assessment.',
			'url'         => $url,
			'inDefinedTermSet' => array(
				'@type'     => 'DefinedTermSet',
				'name'      => 'GCheck Trust Recession research glossary',
				'publisher' => array( '@id' => $org_id ),
			),
		),
		array(
			'@type'       => 'DefinedTerm',
			'@id'         => $url . '#term-double-distortion',
			'name'        => 'Double Distortion',
			'description' => 'The pattern in which the same workforce simultaneously overstates its AI capabilities and understates AI\'s actual usefulness: two contradictory behaviors running in opposite directions, both at majority scale.',
			'url'         => $url,
			'inDefinedTermSet' => array(
				'@type'     => 'DefinedTermSet',
				'name'      => 'GCheck Trust Recession research glossary',
				'publisher' => array( '@id' => $org_id ),
			),
		),
		array(
			'@type'       => 'DefinedTerm',
			'@id'         => $url . '#term-verification-vacuum',
			'name'        => 'Verification Vacuum',
			'description' => 'The structural condition in which AI skill claims are made at scale while employer-side verification has not kept up, allowing inflated claims to persist.',
			'url'         => $url,
			'inDefinedTermSet' => array(
				'@type'     => 'DefinedTermSet',
				'name'      => 'GCheck Trust Recession research glossary',
				'publisher' => array( '@id' => $org_id ),
			),
		),
	);

	$key_findings = array(
		'69% of US workers expect parts of their job to be automated by AI within 24 months, rising to 79% for Gen Z.',
		'63% have lied or exaggerated their AI skills to appear more knowledgeable than they are, reaching 80% for Gen Z.',
		'81% report at least one behavior to discourage or limit AI use at work.',
		'64% have not had their AI skills verified by an employer, and 76% say AI misrepresentation creates business risk.',
		'29% would present themselves more honestly if employers disclosed what would be independently verified.',
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
		'name'            => 'Key findings of The Automation Anxiety Report 2026',
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
		$trust_in_hiring_post = get_page_by_path( 'trust-in-hiring-report', OBJECT, 'page' );
		if ( $trust_in_hiring_post && 'publish' === $trust_in_hiring_post->post_status ) {
			$citation[] = array( '@id' => esc_url_raw( get_permalink( $trust_in_hiring_post ) ) . '#report' );
		}

		$report_entity = gc_theme_build_report_entity_schema(
			$post,
			array(
				'headline'             => 'The Automation Anxiety Report 2026',
				'alternative_headline' => 'How AI is reshaping what US workers tell employers, coworkers, and themselves.',
				'description'          => 'A national survey of 1,500 US adults employed full-time on how automation anxiety is reshaping worker behavior, inflating AI skill claims, and outpacing employer verification.',
				'abstract'             => '69% of US adults employed full-time believe AI is likely to automate parts of their job within 24 months, rising to 79% for Gen Z. 63% have lied or exaggerated their AI skills to appear more knowledgeable, including 80% of Gen Z, and 16% have explicitly lied about having AI skills. Among workers who list AI skills, only 34% say they could confidently perform all of them at a professional level. At the same time, 81% have engaged in at least one behavior to discourage or limit AI use at work, a pattern the report calls the Double Distortion. 64% say their employer has never tried to verify their AI skills, only 39% believe employers can do so effectively, and 76% say AI misrepresentation creates business risk. Workers want human review of AI-related hiring decisions (61%) and direct testing of AI competencies (48%), and 29% would present themselves more honestly if employers disclosed in advance what would be independently verified.',
				'image'                => get_template_directory_uri() . '/partials/reports/automation-anxiety/page-hero/images/page-hero-bg.webp',
				'keywords'             => array(
					'AI skills bubble',
					'double distortion',
					'verification vacuum',
					'automation anxiety',
					'AI skills exaggeration',
					'AI at work',
					'AI adoption resistance',
					'skills verification',
					'workforce survey 2026',
				),
				'audience'             => 'HR leaders, talent acquisition teams, workplace researchers, and journalists',
				'report_number'        => 'The Trust Recession, Report 2',
				'series'               => $series_id ? array(
					'id'       => $series_id,
					'position' => 2,
				) : null,
				'pdf_key'              => $pdf_key,
				'citation'             => $citation,
			)
		);

		if ( $report_entity ) {
			$report_entity['about'] = array(
				array( '@id' => $url . '#term-ai-skills-bubble' ),
				array( '@id' => $url . '#term-double-distortion' ),
				array( '@id' => $url . '#term-verification-vacuum' ),
				array( '@id' => $url . '#dataset' ),
				array(
					'@type' => 'Thing',
					'name'  => 'AI skills misrepresentation',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Automation anxiety',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'AI adoption at work',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Skills verification',
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
