<?php
/**
 * Report page asset helpers.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/partials/reports/automation-anxiety/schema.php';
require_once get_template_directory() . '/partials/reports/trust-in-hiring/schema.php';
require_once get_template_directory() . '/partials/reports/shadow-workforce/schema.php';
require_once get_template_directory() . '/partials/reports/consequence-gap/schema.php';

function gc_theme_is_parallax_report_page( $post = null, $allowed_slugs = array() ) {
	if ( ! is_page_template( 'page-parallax.php' ) || ! function_exists( 'gc_theme_static_html_resolve_slug_for_post' ) ) {
		return false;
	}

	$post = $post instanceof WP_Post ? $post : get_post();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	$page_slug = gc_theme_static_html_resolve_slug_for_post( $post );
	$allowed_slugs = $allowed_slugs ? $allowed_slugs : array( 'automation-anxiety-report', 'trust-in-hiring-report', 'shadow-workforce-report', 'rise-of-the-shadow-workforce-report', 'consequence-gap-report' );

	return in_array( $page_slug, $allowed_slugs, true );
}

add_filter(
	'wp_resource_hints',
	static function ( $urls, $relation_type ) {
		if ( 'preconnect' !== $relation_type || ! gc_theme_is_parallax_report_page() ) {
			return $urls;
		}

		$cdnjs_origin = 'https://cdnjs.cloudflare.com';
		if ( ! in_array( $cdnjs_origin, $urls, true ) ) {
			$urls[] = $cdnjs_origin;
		}

		return $urls;
	},
	10,
	2
);

function gc_theme_get_parallax_report_scss_dependencies() {
	$theme_dir = get_template_directory();

	return array(
		$theme_dir . '/assets/css/parallax-report.scss',
		$theme_dir . '/partials/reports/automation-anxiety/shared/css/_report-data-table.scss',
		$theme_dir . '/partials/reports/automation-anxiety/shared/css/_report-content-shared.scss',
		$theme_dir . '/partials/reports/automation-anxiety/shared/css/_report-graph.scss',
		$theme_dir . '/partials/reports/automation-anxiety/executive-summary/css/_executive-summary.scss',
		$theme_dir . '/partials/reports/automation-anxiety/page-hero/css/_page-hero.scss',
		$theme_dir . '/partials/reports/automation-anxiety/content-ai-anxiety/css/_content-ai-anxiety.scss',
		$theme_dir . '/partials/reports/trust-in-hiring/page-hero/css/_page-hero.scss',
		$theme_dir . '/partials/reports/trust-in-hiring/executive-summary/css/_executive-summary.scss',
		$theme_dir . '/partials/reports/trust-in-hiring/content/css/_content.scss',
		$theme_dir . '/partials/reports/shadow-workforce/page-hero/css/_page-hero.scss',
		$theme_dir . '/partials/reports/shadow-workforce/content/css/_content.scss',
		$theme_dir . '/partials/reports/shadow-workforce/content/css/_figure-card-graph.scss',
		$theme_dir . '/partials/reports/consequence-gap/page-hero/css/_page-hero.scss',
		$theme_dir . '/partials/reports/consequence-gap/content/css/_content.scss',
		$theme_dir . '/partials/reports/consequence-gap/content/css/_figure-card-graph.scss',
		$theme_dir . '/partials/reports/consequence-gap/footer/css/_footer.scss',
	);
}

function gc_theme_enqueue_report_core_page_style( $dependency_files = array() ) {
	$core_page_css  = get_template_directory() . '/assets/css/core-page-new.css';
	$core_page_scss = get_template_directory() . '/assets/css/core-page-new.scss';
	$page_hero_scss = get_template_directory() . '/core-pages/page-hero/css/_page-hero.scss';

	wp_enqueue_style(
		'page-style',
		get_template_directory_uri() . '/assets/css/core-page-new.css',
		array( 'global-style' ),
		gc_theme_asset_version(
			$core_page_css,
			array_merge(
				array(
					$core_page_scss,
					$page_hero_scss,
				),
				$dependency_files
			)
		),
		'screen'
	);
}

function gc_theme_enqueue_report_motion_scripts( $graph_handle, $animations_handle ) {
	$report_graph_js         = get_template_directory() . '/assets/js/report-graph.js';
	$report_graph_js_version = gc_theme_asset_version( $report_graph_js );
	$report_anim_js          = get_template_directory() . '/assets/js/report-animations.js';
	$report_anim_js_version  = gc_theme_asset_version( $report_anim_js );

	wp_enqueue_script(
		'gsap',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
		array(),
		null,
		true
	);
	wp_script_add_data( 'gsap', 'strategy', 'defer' );

	wp_enqueue_script(
		'gsap-scroll-trigger',
		'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
		array( 'gsap' ),
		null,
		true
	);
	wp_script_add_data( 'gsap-scroll-trigger', 'strategy', 'defer' );

	wp_enqueue_script(
		$graph_handle,
		get_template_directory_uri() . '/assets/js/report-graph.js',
		array( 'gsap', 'gsap-scroll-trigger' ),
		$report_graph_js_version,
		true
	);
	wp_script_add_data( $graph_handle, 'strategy', 'defer' );

	wp_enqueue_script(
		$animations_handle,
		get_template_directory_uri() . '/assets/js/report-animations.js',
		array( 'gsap' ),
		$report_anim_js_version,
		true
	);
	wp_script_add_data( $animations_handle, 'strategy', 'defer' );
}

function gc_theme_enqueue_parallax_report_assets( $post ) {
	if ( ! gc_theme_is_parallax_report_page( $post ) ) {
		return false;
	}

	$page_slug   = gc_theme_static_html_resolve_slug_for_post( $post );
	$theme_dir   = get_template_directory();
	$report_css  = $theme_dir . '/assets/css/parallax-report.css';
	$core_deps   = array();

	if ( in_array( $page_slug, array( 'automation-anxiety-report', 'shadow-workforce-report', 'rise-of-the-shadow-workforce-report', 'consequence-gap-report' ), true ) ) {
		$core_deps = array(
			$theme_dir . '/core-pages/custom-whitepaper/css/_custom-whitepaper-hero.scss',
			$theme_dir . '/core-pages/cards/css/_cards.scss',
		);
	}

	gc_theme_enqueue_report_core_page_style( $core_deps );

	$report_version = gc_theme_asset_version(
		$report_css,
		gc_theme_get_parallax_report_scss_dependencies()
	);

	wp_enqueue_style(
		'report-parallax',
		get_template_directory_uri() . '/assets/css/parallax-report.css',
		array( 'global-style', 'page-style' ),
		$report_version,
		'screen'
	);

	gc_theme_enqueue_report_motion_scripts(
		'report-parallax-graph',
		'report-parallax-animations'
	);

	return true;
}

function gc_theme_build_report_entity_schema( $post, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'headline'             => get_the_title( $post ),
			'name'                 => get_the_title( $post ),
			'alternative_headline' => '',
			'description'          => '',
			'abstract'             => '',
			'image'                => '',
			'genre'                => 'Original research',
			'keywords'             => array(),
			'audience'             => '',
			'mentions'             => array(),
			'citation'             => array(),
			'pdf_key'              => '',
			'report_number'        => '',
			'series'               => null,
			'is_accessible_for_free' => true,
		)
	);

	$url    = esc_url_raw( get_permalink( $post ) );
	$org_id = home_url( '/' ) . '#organization';

	$node = array(
		'@type'                 => array( 'Report', 'Article' ),
		'@id'                   => $url . '#report',
		'mainEntityOfPage'      => array( '@id' => $url ),
		'headline'              => $args['headline'],
		'name'                  => $args['name'],
		'description'           => $args['description'],
		'url'                   => $url,
		'author'                => array( '@id' => $org_id ),
		'publisher'             => array( '@id' => $org_id ),
		'copyrightHolder'       => array( '@id' => $org_id ),
		'copyrightYear'         => (int) get_the_date( 'Y', $post ),
		'datePublished'         => get_the_date( 'c', $post ),
		'dateModified'          => get_the_modified_date( 'c', $post ),
		'inLanguage'            => 'en-US',
		'isAccessibleForFree'   => (bool) $args['is_accessible_for_free'],
		'genre'                 => $args['genre'],
		'isBasedOn'             => array( '@id' => $url . '#dataset' ),
		'about'                 => array( '@id' => $url . '#dataset' ),
	);

	if ( $args['alternative_headline'] ) {
		$node['alternativeHeadline'] = $args['alternative_headline'];
	}

	if ( $args['abstract'] ) {
		$node['abstract'] = $args['abstract'];
	}

	if ( $args['image'] ) {
		$node['image'] = array(
			'@type' => 'ImageObject',
			'url'   => esc_url_raw( $args['image'] ),
		);
	}

	if ( $args['keywords'] ) {
		$node['keywords'] = is_array( $args['keywords'] ) ? implode( ', ', $args['keywords'] ) : $args['keywords'];
	}

	if ( $args['audience'] ) {
		$node['audience'] = array(
			'@type'        => 'Audience',
			'audienceType' => $args['audience'],
		);
	}

	if ( $args['mentions'] ) {
		$node['mentions'] = $args['mentions'];
	}

	if ( $args['citation'] ) {
		$node['citation'] = $args['citation'];
	}

	if ( $args['report_number'] ) {
		$node['reportNumber'] = $args['report_number'];
	}

	if ( is_array( $args['series'] ) && ! empty( $args['series']['id'] ) ) {
		$node['isPartOf'] = array( '@id' => $args['series']['id'] );
		if ( isset( $args['series']['position'] ) ) {
			$node['position'] = (int) $args['series']['position'];
		}
	}

	if ( $args['pdf_key'] && function_exists( 'gc_secure_pdf_stream_url' ) ) {
		$pdf_url = gc_secure_pdf_stream_url( $args['pdf_key'] );
		if ( $pdf_url ) {
			$node['encoding'] = array(
				'@type'          => 'MediaObject',
				'name'           => $args['headline'] . ' (PDF)',
				'contentUrl'     => esc_url_raw( $pdf_url ),
				'encodingFormat' => 'application/pdf',
			);
		}
	}

	return $node;
}

function gc_theme_get_trust_recession_series_node() {
	$reports = array(
		'trust-in-hiring-report' => array(
			'title'       => 'The 2026 Trust in Hiring Report',
			'description' => 'Why candidates exaggerate and misrepresent themselves, and what it means for hiring integrity.',
			'position'    => 1,
		),
		'automation-anxiety-report' => array(
			'title'       => 'The Automation Anxiety Report 2026',
			'description' => 'How AI is reshaping worker confidence and inflating the skills gap in the workplace.',
			'position'    => 2,
		),
		'rise-of-the-shadow-workforce-report' => array(
			'title'       => 'The Rise of the Shadow Workforce',
			'description' => 'The workers, tools, and third parties operating behind the scenes, and why verification decays after hire.',
			'position'    => 3,
		),
		'consequence-gap-report' => array(
			'title'       => 'The Consequence Gap Report',
			'description' => 'Companies got harsher with everyone except the people the harshness was for.',
			'position'    => 4,
		),
	);

	$org_id      = home_url( '/' ) . '#organization';
	$report_refs = array();
	$stub_nodes  = array();

	foreach ( $reports as $slug => $meta ) {
		$report_post = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $report_post || 'publish' !== $report_post->post_status ) {
			continue;
		}

		$report_url = esc_url_raw( get_permalink( $report_post ) );
		$report_id  = $report_url . '#report';

		$report_refs[] = array( '@id' => $report_id );
		$stub_nodes[]   = array(
			'@type'       => 'Report',
			'@id'         => $report_id,
			'name'        => $meta['title'],
			'description' => $meta['description'],
			'url'         => $report_url,
			'author'      => array( '@id' => $org_id ),
			'publisher'   => array( '@id' => $org_id ),
			'position'    => $meta['position'],
		);
	}

	if ( empty( $report_refs ) ) {
		return array(
			'series' => null,
			'stubs'  => array(),
		);
	}

	$hub_url = gc_theme_get_whitepaper_hub_url();

	$series = array(
		'@type'       => 'CreativeWorkSeries',
		'@id'         => ( $hub_url ? $hub_url : home_url( '/' ) ) . '#trust-recession',
		'name'        => 'The Trust Recession',
		'description' => "GCheck's research series examining trust across the employment lifecycle, from hiring through tenure.",
		'url'         => $hub_url ? $hub_url : home_url( '/' ),
		'publisher'   => array( '@id' => $org_id ),
		'hasPart'     => $report_refs,
	);

	return array(
		'series' => $series,
		'stubs'  => $stub_nodes,
	);
}

function gc_theme_get_whitepaper_hub_url() {
	static $hub_url = null;

	if ( null !== $hub_url ) {
		return $hub_url;
	}

	$hub_pages = get_posts(
		array(
			'post_type'      => 'page',
			'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => 'whitepaper.php', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	$hub_url = ! empty( $hub_pages ) ? esc_url_raw( get_permalink( $hub_pages[0] ) ) : '';

	return $hub_url;
}

function gc_theme_get_whitepaper_datacatalog_id() {
	$hub_url = gc_theme_get_whitepaper_hub_url();
	return $hub_url ? $hub_url . '#datacatalog' : '';
}

function gc_theme_get_parallax_report_schema_builders() {
	return array(
		'automation-anxiety-report'           => 'gc_report_automation_anxiety_schema',
		'trust-in-hiring-report'              => 'gc_report_trust_in_hiring_schema',
		'shadow-workforce-report'              => 'gc_report_shadow_workforce_schema',
		'rise-of-the-shadow-workforce-report' => 'gc_report_shadow_workforce_schema',
		'consequence-gap-report'              => 'gc_report_consequence_gap_schema',
	);
}

function gc_theme_render_parallax_report_schema() {
	$post = get_post();

	if ( ! gc_theme_is_parallax_report_page( $post ) ) {
		return;
	}

	$page_slug = gc_theme_static_html_resolve_slug_for_post( $post );
	$builders  = gc_theme_get_parallax_report_schema_builders();

	if ( ! isset( $builders[ $page_slug ] ) || ! function_exists( $builders[ $page_slug ] ) ) {
		return;
	}

	$schema = call_user_func( $builders[ $page_slug ], $post );

	if ( empty( $schema ) ) {
		return;
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'gc_theme_render_parallax_report_schema' );

function gc_theme_render_whitepaper_datacatalog_schema() {
	if ( ! is_page_template( 'whitepaper.php' ) ) {
		return;
	}

	$report_slugs = array_keys( gc_theme_get_parallax_report_schema_builders() );
	$datasets     = array();

	foreach ( $report_slugs as $report_slug ) {
		$report_post = get_page_by_path( $report_slug, OBJECT, 'page' );

		if ( ! $report_post || 'publish' !== $report_post->post_status ) {
			continue;
		}

		$datasets[] = array(
			'@id' => esc_url_raw( get_permalink( $report_post ) ) . '#dataset',
		);
	}

	if ( empty( $datasets ) ) {
		return;
	}

	$schema = array(
		'@context'  => 'https://schema.org',
		'@type'     => 'DataCatalog',
		'@id'       => esc_url_raw( get_permalink() ) . '#datacatalog',
		'name'      => 'GCheck Whitepaper Research Library',
		'description' => 'GCheck original research surveys on workplace trust, hiring integrity, AI use, and accountability, drawn from proprietary US worker and job-seeker surveys.',
		'url'       => esc_url_raw( get_permalink() ),
		'publisher' => array( '@id' => home_url( '/' ) . '#organization' ),
		'dataset'   => $datasets,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'gc_theme_render_whitepaper_datacatalog_schema' );
