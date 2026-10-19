<?php
/**
 * Structured data (JSON-LD) for the Verified Entry page.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/static/verified-entry/content.php';

function gc_static_verified_entry_schema( $post ) {
	$ve         = gc_static_verified_entry_content();
	$url        = esc_url_raw( get_permalink( $post ) );
	$home       = home_url( '/' );
	$org_id     = $home . '#organization';
	$service_id = $url . '#service';
	$img_uri    = gc_static_verified_entry_images_uri();

	$organization = array(
		'@type' => 'Organization',
		'@id'   => $org_id,
		'name'  => 'GCheck',
		'url'   => $home,
		'logo'  => array(
			'@type' => 'ImageObject',
			'url'   => get_template_directory_uri() . '/assets/images/gcheck-white-logo.svg',
		),
	);

	$breadcrumbs = array(
		array(
			'name' => 'Home',
			'url'  => $home,
		),
	);
	foreach ( array_reverse( get_post_ancestors( $post ) ) as $ancestor_id ) {
		$breadcrumbs[] = array(
			'name' => wp_specialchars_decode( get_the_title( $ancestor_id ), ENT_QUOTES ),
			'url'  => esc_url_raw( get_permalink( $ancestor_id ) ),
		);
	}
	$breadcrumbs[] = array(
		'name' => $ve['title'],
		'url'  => $url,
	);

	$breadcrumb_items = array();
	foreach ( $breadcrumbs as $index => $crumb ) {
		$breadcrumb_items[] = array(
			'@type'    => 'ListItem',
			'position' => $index + 1,
			'name'     => $crumb['name'],
			'item'     => $crumb['url'],
		);
	}

	$webpage = array(
		'@type'         => 'WebPage',
		'@id'           => $url . '#webpage',
		'url'           => $url,
		'name'          => $ve['title'] . ' | GCheck',
		'description'   => $ve['description'],
		'inLanguage'    => 'en-US',
		'isPartOf'      => array(
			'@type' => 'WebSite',
			'@id'   => $home . '#website',
			'url'   => $home,
			'name'  => 'GCheck',
		),
		'about'         => array( '@id' => $service_id ),
		'mainEntity'    => array( '@id' => $service_id ),
		'breadcrumb'    => array( '@id' => $url . '#breadcrumb' ),
		'publisher'     => array( '@id' => $org_id ),
		'primaryImageOfPage' => array(
			'@type' => 'ImageObject',
			'url'   => $img_uri . 'phone-verified-entry-verified.webp',
		),
		'datePublished' => get_the_date( 'c', $post ),
		'dateModified'  => get_the_modified_date( 'c', $post ),
	);

	$service = array(
		'@type'       => 'Service',
		'@id'         => $service_id,
		'name'        => $ve['title'],
		'serviceType' => 'Biometric identity verification',
		'description' => $ve['description'],
		'url'         => $url,
		'image'       => array( $img_uri . 'phone-verified-entry-verified.webp', $img_uri . 'phone-credential-wallet-confirmed.webp' ),
		'provider'    => array( '@id' => $org_id ),
		'brand'       => array( '@id' => $org_id ),
		'areaServed'  => array(
			'@type' => 'Country',
			'name'  => 'United States',
		),
		'audience'    => array(
			'@type'        => 'BusinessAudience',
			'audienceType' => 'Employers, staffing agencies, youth and education programs, and in-home service providers',
		),
	);

	$questions = array();
	foreach ( $ve['faqs'] as $faq ) {
		$questions[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['a'],
			),
		);
	}

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			$organization,
			$webpage,
			array(
				'@type'           => 'BreadcrumbList',
				'@id'             => $url . '#breadcrumb',
				'itemListElement' => $breadcrumb_items,
			),
			$service,
			array(
				'@type'      => 'FAQPage',
				'@id'        => $url . '#faq',
				'url'        => $url,
				'isPartOf'   => array( '@id' => $url . '#webpage' ),
				'mainEntity' => $questions,
			),
		),
	);
}
