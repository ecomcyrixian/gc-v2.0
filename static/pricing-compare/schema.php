<?php
/**
 * Structured data (JSON-LD) for the pricing compare page.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/static/pricing-compare/content.php';

function gc_static_pricing_compare_schema( $post ) {
	$pc       = gc_static_pricing_compare_content();
	$c        = gc_static_pricing_compare_config();
	$url      = esc_url_raw( get_permalink( $post ) );
	$home     = home_url( '/' );
	$theme    = get_template_directory_uri();
	$packages = esc_url_raw( home_url( '/pricing-packages/' ) );
	$image    = $theme . '/assets/images/new-header.webp';
	$price    = function ( $amount, $decimals = 2 ) {
		return number_format( round( (float) $amount, $decimals ), $decimals, '.', '' );
	};
	$offer    = function ( $name, $amount, $description, $offer_url, $decimals = 2, $valid_from = '' ) use ( $price ) {
		$item = array(
			'@type'         => 'Offer',
			'name'          => $name,
			'price'         => $price( $amount, $decimals ),
			'priceCurrency' => 'USD',
			'description'   => $description,
			'url'           => $offer_url,
		);

		if ( $valid_from ) {
			$item['validFrom'] = $valid_from;
		}

		return $item;
	};

	$questions = array();
	foreach ( $pc['faqs'] as $faq ) {
		$questions[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['a'],
			),
		);
	}

	$service = function ( $name, $fragment, $provider_id, $extra ) use ( $url ) {
		$item = array(
			'@type'       => 'Service',
			'name'        => $name,
			'serviceType' => 'Employment background check',
			'provider'    => array( '@id' => $provider_id ),
			'url'         => $url . '#' . $fragment,
		);

		return array_merge( $item, $extra );
	};

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type' => 'Organization',
				'@id'   => $home . '#organization',
				'name'  => 'GCheck',
				'url'   => $home,
				'logo'  => array(
					'@type' => 'ImageObject',
					'url'   => $theme . '/assets/images/gcheck-black-logo-new.svg',
				),
			),
			array(
				'@type'     => 'WebSite',
				'@id'       => $home . '#website',
				'url'       => $home,
				'name'      => 'GCheck',
				'publisher' => array( '@id' => $home . '#organization' ),
			),
			array(
				'@type'              => 'WebPage',
				'@id'                => $url . '#webpage',
				'url'                => $url,
				'name'               => $pc['name'],
				'description'        => $pc['description'],
				'inLanguage'         => 'en-US',
				'isPartOf'           => array( '@id' => $home . '#website' ),
				'breadcrumb'         => array( '@id' => $url . '#breadcrumb' ),
				'primaryImageOfPage' => array(
					'@type' => 'ImageObject',
					'url'   => $image,
				),
				'datePublished'      => '2026-10-24',
				'dateModified'       => '2026-11-05',
				'lastReviewed'       => '2026-11-05',
				'mainEntity'         => array( '@id' => $url . '#article' ),
			),
			array(
				'@type'            => 'Article',
				'@id'              => $url . '#article',
				'headline'         => $pc['headline'],
				'description'      => $pc['description'],
				'image'            => $image,
				'inLanguage'       => 'en-US',
				'datePublished'    => '2026-10-24',
				'dateModified'     => '2026-11-05',
				'author'           => array( '@id' => $home . '#organization' ),
				'publisher'        => array( '@id' => $home . '#organization' ),
				'mainEntityOfPage' => array( '@id' => $url . '#webpage' ),
				'isPartOf'         => array( '@id' => $url . '#webpage' ),
				'about'            => array(
					array( '@type' => 'Thing', 'name' => 'Background check pricing' ),
					array( '@type' => 'Thing', 'name' => 'Employment background check' ),
					array( '@type' => 'Thing', 'name' => 'County criminal search' ),
				),
				'mentions'         => array(
					array( '@id' => $url . '#org-backgroundcheckscom' ),
					array( '@id' => $url . '#org-verifiedfirst' ),
					array( '@id' => $url . '#org-first' ),
					array( '@id' => $url . '#org-checkr' ),
					array( '@id' => $url . '#org-goodhire' ),
					array( '@id' => $url . '#org-hireright' ),
					array( '@id' => $url . '#org-sterling' ),
				),
				'citation'         => array(
					$packages,
					'https://app.backgroundchecks.com/order-report',
					'https://fadv.com/solutions/small-business-background-checks/',
					'https://fadv.com/article/first-advantage-background-checks-for-growing-businesses/',
					'https://checkr.com/pricing',
					'https://checkr.com/pricing/passthrough-fees',
					'https://www.goodhire.com/pricing/',
					'https://www.goodhire.com/about/',
					'https://verifiedfirst.com/pricing/',
					'https://www.backgroundchecks.com/about',
					'https://www.hireright.com/pricing',
					'https://www.sterlingcheck.com/',
					'https://www.hireright.com/global',
					'https://www.hireright.com/industries/business-size/small-business',
					'https://www.sec.gov/Archives/edgar/data/1210677/000095017024119269/fa-20241030.htm',
				),
				'hasPart'          => array(
					array( '@id' => $url . '#providers' ),
					array( '@id' => $url . '#faq' ),
				),
			),
			array(
				'@type'           => 'BreadcrumbList',
				'@id'             => $url . '#breadcrumb',
				'itemListElement' => array(
					array(
						'@type'    => 'ListItem',
						'position' => 1,
						'name'     => 'Home',
						'item'     => $home,
					),
					array(
						'@type'    => 'ListItem',
						'position' => 2,
						'name'     => 'Pricing',
						'item'     => $packages,
					),
					array(
						'@type'    => 'ListItem',
						'position' => 3,
						'name'     => 'Background check pricing comparison',
						'item'     => $url,
					),
				),
			),
			array(
				'@type'           => 'ItemList',
				'@id'             => $url . '#providers',
				'name'            => 'Background check providers compared by published price',
				'description'     => 'Ranked by lowest published per-check price for a check that includes a county criminal search, checked November 2026. Court and DMV fees excluded.',
				'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
				'numberOfItems'   => 5,
				'itemListElement' => array(
					array(
						'@type'    => 'ListItem',
						'position' => 1,
						'name'     => 'GCheck',
						'url'      => $url . '#gcheck',
						'item'     => $service(
							'GCheck background checks',
							'gcheck',
							$home . '#organization',
							array(
								'offers' => array(
									$offer( 'GCheck Basic', $c['base'], 'Includes a national criminal database search, SSN trace, nationwide sex offender registry search and a county criminal search of the current county of residence. If the national search finds possible records in other counties, those counties are automatically searched for $9.95 each. Third-party court fees may also apply.', $packages, 2, '2026-10-01' ),
									$offer( 'GCheck Standard', $c['standard'], 'Unlimited counties of residence, last 7 years, plus biometric ID verification. If the national search finds possible records in other counties, those counties are automatically searched for $9.95 each. Third-party court fees may also apply.', $packages, 2, '2026-10-01' ),
									$offer( 'GCheck Advanced', $c['advanced'], 'Unlimited counties of residence, last 7 years, plus federal criminal search and biometric ID verification. If the national search finds possible records in other counties, those counties are automatically searched for $9.95 each. Third-party court fees may also apply.', $packages, 2, '2026-10-01' ),
								),
							)
						),
					),
					array(
						'@type'    => 'ListItem',
						'position' => 2,
						'name'     => 'BackgroundChecks.com',
						'url'      => $url . '#backgroundchecks',
						'item'     => $service(
							'BackgroundChecks.com background checks',
							'backgroundchecks',
							$url . '#org-backgroundcheckscom',
							array(
								'offers' => array(
									$offer( 'BackgroundChecks.com Basic', $c['bgBasic'], 'No county search. Published price as checked November 2026.', 'https://app.backgroundchecks.com/order-report' ),
									$offer( 'BackgroundChecks.com Complete', $c['bgComplete'], 'Unlimited counties, 7-year address history. Published price as checked November 2026.', 'https://app.backgroundchecks.com/order-report' ),
									$offer( 'BackgroundChecks.com Professional', $c['bgPro'], 'Expanded package. Published price as checked November 2026.', 'https://app.backgroundchecks.com/order-report' ),
								),
							)
						),
					),
					array(
						'@type'    => 'ListItem',
						'position' => 3,
						'name'     => 'Verified First',
						'url'      => $url . '#verified-first',
						'item'     => $service(
							'Verified First background checks',
							'verified-first',
							$url . '#org-verifiedfirst',
							array(
								'offers' => array(
									$offer( 'Verified First Basic', $c['vfBasic'], 'Nationwide criminal search, sex offender registry, address trace and global watch list; no county search listed. Published price as checked November 2026.', 'https://verifiedfirst.com/pricing/' ),
									$offer( 'Verified First Essential', $c['vfEssential'], 'Adds unlimited county criminal search. Published price as checked November 2026.', 'https://verifiedfirst.com/pricing/' ),
									$offer( 'Verified First Premium', $c['vfPremium'], 'Adds employment and education verification. Published price as checked November 2026.', 'https://verifiedfirst.com/pricing/' ),
								),
							)
						),
					),
					array(
						'@type'    => 'ListItem',
						'position' => 4,
						'name'     => 'Checkr',
						'url'      => $url . '#checkr',
						'item'     => $service(
							'Checkr background checks',
							'checkr',
							$url . '#org-checkr',
							array(
								'offers' => array(
									$offer( 'Checkr Basic', $c['checkrBasic'], 'National criminal search. The price includes no county criminal search. If the national search finds possible records, the relevant counties are automatically searched for $15. Third-party court fees may also apply. Published price as checked November 2026.', 'https://checkr.com/pricing' ),
									$offer( 'Checkr Essential', $c['checkrEssential'], 'Unlimited county criminal search and identity verification. Published price as checked November 2026.', 'https://checkr.com/pricing' ),
									$offer( 'Checkr Complete', $c['checkrComplete'], 'Adds unlimited state and federal criminal search. Published price as checked November 2026.', 'https://checkr.com/pricing' ),
								),
							)
						),
					),
					array(
						'@type'    => 'ListItem',
						'position' => 5,
						'name'     => 'GoodHire',
						'url'      => $url . '#goodhire',
						'item'     => $service(
							'GoodHire background checks',
							'goodhire',
							$url . '#org-goodhire',
							array(
								'offers' => array(
									$offer( 'GoodHire Basic', $c['goodhireBasic'], 'No county search listed. Published price as checked November 2026.', 'https://www.goodhire.com/pricing/' ),
									$offer( 'GoodHire Essential', $c['goodhireEssential'], 'Unlimited county criminal search and identity verification. Published price as checked November 2026.', 'https://www.goodhire.com/pricing/' ),
									$offer( 'GoodHire Complete', $c['goodhireComplete'], 'Adds unlimited state and federal criminal search. Published price as checked November 2026.', 'https://www.goodhire.com/pricing/' ),
								),
							)
						),
					),
				),
			),
			array(
				'@type'      => 'FAQPage',
				'@id'        => $url . '#faq',
				'isPartOf'   => array( '@id' => $url . '#webpage' ),
				'mainEntity' => $questions,
			),
			array(
				'@type'                => 'Organization',
				'@id'                  => $url . '#org-backgroundcheckscom',
				'name'                 => 'BackgroundChecks.com',
				'url'                  => 'https://www.backgroundchecks.com/',
				'parentOrganization'   => array( '@id' => $url . '#org-hireright' ),
			),
			array(
				'@type' => 'Organization',
				'@id'   => $url . '#org-first',
				'name'  => 'First Advantage',
				'url'   => 'https://fadv.com/',
			),
			array(
				'@type' => 'Organization',
				'@id'   => $url . '#org-checkr',
				'name'  => 'Checkr',
				'url'   => 'https://checkr.com/',
			),
			array(
				'@type'              => 'Organization',
				'@id'                => $url . '#org-goodhire',
				'name'               => 'GoodHire',
				'url'                => 'https://www.goodhire.com/',
				'parentOrganization' => array( '@id' => $url . '#org-checkr' ),
			),
			array(
				'@type' => 'Organization',
				'@id'   => $url . '#org-verifiedfirst',
				'name'  => 'Verified First',
				'url'   => 'https://verifiedfirst.com/',
			),
			array(
				'@type' => 'Organization',
				'@id'   => $url . '#org-hireright',
				'name'  => 'HireRight',
				'url'   => 'https://www.hireright.com/',
			),
			array(
				'@type'              => 'Organization',
				'@id'                => $url . '#org-sterling',
				'name'               => 'Sterling',
				'url'                => 'https://www.sterlingcheck.com/',
				'parentOrganization' => array( '@id' => $url . '#org-first' ),
			),
		),
	);
}
