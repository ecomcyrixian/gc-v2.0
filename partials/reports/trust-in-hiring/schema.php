<?php
/**
 * Structured data (JSON-LD) for the Trust in Hiring report.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gc_report_trust_in_hiring_schema( $post ) {
	$url    = esc_url_raw( get_permalink( $post ) );
	$org_id = home_url( '/' ) . '#organization';

	$variables_measured = array(
		array(
			'name'        => 'Job seekers who embellished or misrepresented at least once during hiring',
			'value'       => 93,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Exaggerated expertise in a skill to match a job description',
			'value'       => 61,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Inflated the impact or scope of previous roles',
			'value'       => 59,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Exaggerated or made up stories during interviews',
			'value'       => 47,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Adjusted employment dates to hide gaps',
			'value'       => 45,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Listed references that were fake or did not exist',
			'value'       => 27,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Listed education or credential programs not attended or completed',
			'value'       => 25,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Coached a reference on what to say',
			'value'       => 45,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Had a friend or family member pose as a professional reference',
			'value'       => 41,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Asked a coworker to pose as a manager or supervisor reference',
			'value'       => 33,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Believe full honesty would have cost them the job',
			'value'       => 60,
			'description' => 'The Honesty Tax. Compared with 26% who say discrepancies are actually detected.',
		),
		array(
			'name'        => 'Report that discrepancies in their claims are actually detected',
			'value'       => 26,
			'description' => 'The Honesty Tax. Base: candidates who embellished.',
		),
		array(
			'name'        => 'Embellishers who experienced post-hire stress or anxiety',
			'value'       => 39,
			'description' => 'Base: respondents who embellished during hiring.',
		),
		array(
			'name'        => 'Embellishers who faced negative workplace consequences from a skills mismatch',
			'value'       => 25,
			'description' => 'Base: respondents who embellished during hiring.',
		),
		array(
			'name'        => 'Respondents who say candidate misrepresentation puts businesses at risk',
			'value'       => 88,
			'description' => 'Base: 1,500 recent US job applicants. PERCEPTION.',
		),
		array(
			'name'        => 'Used an AI avatar of themselves to conduct a virtual job meeting',
			'value'       => 25,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Used AI during a live interview to generate answers in real time',
			'value'       => 27,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Working mothers with children under 18 who avoided mentioning caregiving during hiring',
			'value'       => 50,
			'description' => 'Compared with 38% of fathers in the same situation. INCIDENCE.',
		),
		array(
			'name'        => 'Avoided posting honest views online because of how employers interpret social media',
			'value'       => 80,
			'description' => 'Base: 1,500 recent US job applicants. INCIDENCE.',
		),
		array(
			'name'        => 'Say ongoing or periodic background screening is important',
			'value'       => 80,
			'description' => 'Base: 1,500 recent US job applicants. 31% for all roles, 49% for safety-sensitive roles. PERCEPTION.',
		),
		array(
			'name'        => 'Want a clear explanation of what is being checked',
			'value'       => 82,
			'description' => 'Base: 1,500 recent US job applicants. PERCEPTION.',
		),
		array(
			'name'        => 'Want human review of findings rather than fully automated decisions',
			'value'       => 81,
			'description' => 'Base: 1,500 recent US job applicants. PERCEPTION.',
		),
		array(
			'name'        => 'Want the ability to review or dispute findings',
			'value'       => 77,
			'description' => 'Base: 1,500 recent US job applicants. PERCEPTION.',
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

	$pdf_key = function_exists( 'gc_secure_pdf_primary_trust_report_key' ) ? gc_secure_pdf_primary_trust_report_key() : '';
	$pdf_url = ( $pdf_key && function_exists( 'gc_secure_pdf_stream_url' ) ) ? gc_secure_pdf_stream_url( $pdf_key ) : '';

	$dataset = array(
		'@type'            => 'Dataset',
		'@id'              => $url . '#dataset',
		'name'             => 'GCheck Trust in Hiring Survey 2026',
		'description'      => 'National online survey of 1,500 US adults employed full-time who actively applied for at least one job in the past 18 months, fielded February 14 to 22, 2026 via Pollfish. The instrument measures embellishment and misrepresentation behaviors across resumes, interviews, and references; motivations and consequences among those who embellished; AI use during the job search; social media self-censorship; beliefs about employer verification; and the screening practices candidates say would build trust. Margin of error of plus or minus 2.5 percentage points at 95% confidence on full-sample figures, wider for subgroups.',
		'url'              => $url,
		'identifier'       => 'Pollfish survey 395565641',
		'creator'          => array( '@id' => $org_id ),
		'publisher'        => array( '@id' => $org_id ),
		'isAccessibleForFree' => true,
		'datePublished'    => get_the_date( 'c', $post ),
		'dateModified'     => get_the_modified_date( 'c', $post ),
		'temporalCoverage' => '2026-02-14/2026-02-22',
		'spatialCoverage'  => array(
			'@type' => 'Country',
			'name'  => 'United States',
		),
		'measurementTechnique' => 'Online survey via Pollfish of US adults employed full-time who applied for a job in the past 18 months',
		'keywords'         => array(
			'careerfishing',
			'honesty tax',
			'resume embellishment',
			'hiring integrity',
			'AI in hiring',
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
			'@id'         => $url . '#term-careerfishing',
			'name'        => 'Careerfishing',
			'description' => 'The systematic embellishment, distortion, or fabrication of professional qualifications across resumes, interviews, and references as a deliberate competitive strategy, driven by market pressure and weak verification expectations.',
			'url'         => $url,
			'inDefinedTermSet' => array(
				'@type'     => 'DefinedTermSet',
				'name'      => 'GCheck Trust Recession research glossary',
				'publisher' => array( '@id' => $org_id ),
			),
		),
		array(
			'@type'       => 'DefinedTerm',
			'@id'         => $url . '#term-honesty-tax',
			'name'        => 'Honesty Tax',
			'description' => 'A structural pattern in hiring in which candidates are penalized for accuracy and rewarded for optimization: transparent, realistic candidates are more likely to be filtered out, while embellished or AI-enhanced profiles are more likely to advance.',
			'url'         => $url,
			'inDefinedTermSet' => array(
				'@type'     => 'DefinedTermSet',
				'name'      => 'GCheck Trust Recession research glossary',
				'publisher' => array( '@id' => $org_id ),
			),
		),
	);

	$key_findings = array(
		'93% of recent job seekers have embellished or lied during the hiring process.',
		'61% exaggerated their expertise in a skill and 59% inflated the scope of previous roles.',
		'41% had a friend or family member pose as a professional reference.',
		'25% used an AI avatar of themselves to conduct a virtual job meeting.',
		'88% say candidate misrepresentation puts businesses at risk.',
		'82% want a clear explanation of what is being checked, and 81% want human review of findings.',
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
		'name'            => 'Key findings of The 2026 Trust in Hiring Report',
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

		$report_entity = gc_theme_build_report_entity_schema(
			$post,
			array(
				'headline'             => "93% of Job Seekers Are Lying to You. Here's What They Admitted.",
				'alternative_headline' => 'How careerfishing, AI deception, and resume verification are eroding trust on both sides of the hiring process.',
				'description'          => 'New research from 1,500 recent job applicants on how careerfishing, AI deception, and resume verification are eroding trust on both sides of the hiring process, and what HR leaders can do about it.',
				'abstract'             => 'In a national survey of 1,500 US adults employed full-time who applied for a job in the past 18 months, 93% admitted to at least one form of embellishment or misrepresentation. The most common behaviors were exaggerating expertise in a skill (61%) and inflating the scope of previous roles (59%); 27% listed fake references and 25% claimed education they never completed. 60% of candidates believe full honesty would cost them the job, while only 26% report that discrepancies are actually detected, a pattern the report calls the Honesty Tax. 25% used an AI avatar of themselves in a virtual meeting and 80% have avoided posting honest views online because of employer concerns. 88% say candidate misrepresentation puts businesses at risk. Candidates support screening that is transparent and human-led: 82% want a clear explanation of what is being checked and 81% want human review rather than fully automated decisions.',
				'image'                => get_template_directory_uri() . '/partials/reports/trust-in-hiring/page-hero/images/Tih-Report-Hero.webp',
				'keywords'             => array(
					'careerfishing',
					'honesty tax',
					'job seekers lying',
					'resume embellishment',
					'fake references',
					'AI avatar interviews',
					'hiring integrity',
					'employment verification',
					'background screening',
					'hiring survey 2026',
				),
				'audience'             => 'HR leaders, talent acquisition teams, workplace researchers, and journalists',
				'mentions'             => array(
					array(
						'@type'          => 'Organization',
						'name'           => 'Society for Human Resource Management',
						'alternateName'  => 'SHRM',
						'url'            => 'https://www.shrm.org/',
					),
					array(
						'@type'          => 'GovernmentOrganization',
						'name'           => 'U.S. Equal Employment Opportunity Commission',
						'alternateName'  => 'EEOC',
						'url'            => 'https://www.eeoc.gov/',
					),
				),
				'report_number'        => 'The Trust Recession, Report 1',
				'series'               => $series_id ? array(
					'id'       => $series_id,
					'position' => 1,
				) : null,
				'pdf_key'              => $pdf_key,
			)
		);

		if ( $report_entity ) {
			$report_entity['about'] = array(
				array( '@id' => $url . '#term-careerfishing' ),
				array( '@id' => $url . '#term-honesty-tax' ),
				array( '@id' => $url . '#dataset' ),
				array(
					'@type' => 'Thing',
					'name'  => 'Candidate misrepresentation',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Resume embellishment',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Reference checks',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'AI in hiring',
				),
				array(
					'@type' => 'Thing',
					'name'  => 'Hiring integrity',
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
