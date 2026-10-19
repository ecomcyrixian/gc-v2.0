<?php
/**
 * Verified Entry page copy, shared by the content template and the JSON-LD schema.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gc_static_verified_entry_content' ) ) {
	function gc_static_verified_entry_images_uri() {
		return get_template_directory_uri() . '/static/verified-entry/images/';
	}

	/**
	 * Escapes text and wraps every ™ so it can be sized by context.
	 */
	function gc_static_verified_entry_tm( $text, $modifier = '' ) {
		$class = 've-tm' . ( $modifier ? ' ve-tm--' . $modifier : '' );
		return str_replace( '™', '<span class="' . esc_attr( $class ) . '">™</span>', esc_html( $text ) );
	}

	function gc_static_verified_entry_content() {
		static $content = null;

		if ( null !== $content ) {
			return $content;
		}

		$phones = array(
			'before' => array(
				'label' => 'Before the check',
				'count' => '4 steps',
				'items' => array(
					array( 'img' => 'phone-verified-entry-liveness-selfie', 'title' => 'Liveness selfie', 'text' => 'A real person, not a photo or deepfake.' ),
					array( 'img' => 'phone-verified-entry-id-scan', 'title' => 'Scan the ID', 'text' => 'Security features checked, barcode read.' ),
					array( 'img' => 'phone-verified-entry-id-info', 'title' => 'Confirm the details', 'text' => 'Filled in straight from the ID.' ),
					array( 'img' => 'phone-verified-entry-verified', 'title' => 'Identity verified', 'text' => 'Verified Entry complete. Background check in progress.' ),
				),
			),
			'after'  => array(
				'label' => 'After the check',
				'count' => '4 steps',
				'items' => array(
					array( 'img' => 'phone-credential-wallet-issued', 'title' => 'Credential issued', 'text' => 'Signed by GCheck once identity is verified.' ),
					array( 'img' => 'phone-credential-wallet-wallet', 'title' => 'Saved to the wallet', 'text' => 'Ready on the worker’s phone.' ),
					array( 'img' => 'phone-credential-wallet-show-to-scan', 'title' => 'Show and scan', 'text' => 'Anyone scans with a phone camera.' ),
					array( 'img' => 'phone-credential-wallet-confirmed', 'title' => 'Identity confirmed', 'text' => 'The right person showed up.' ),
				),
			),
		);

		$content = array(
			'title'       => 'Verified Entry™',
			'headline'    => 'Stop candidate fraud before day one, and prove identity on every shift after',
			'description' => 'Stop candidate fraud before day one, and prove identity on every shift after. Verified Entry confirms identity with ID forensics, face match and liveness before the background check runs, then issues a signed credential anyone can scan later.',

			'phones'      => $phones,

			'badges'      => array(
				'hp.png'    => 'G2 High Performer',
				'roi.png'   => 'G2 Best Estimated ROI',
				'umltr.png' => 'G2 Users Most Likely To Recommend',
				'hua.png'   => 'G2 Highest User Adoption',
				'ulu.png'   => 'G2 Users Love Us',
			),

			'compliance'  => array( 'SOC 2 Type 2', 'HIPAA', 'PBSA Member', 'FCRA compliant' ),

			'stats'       => array(
				array( 'value' => '28%', 'text' => 'of workers have suspected a coworker wasn’t the person hired, or wasn’t doing their own work.', 'tone' => 'blue' ),
				array( 'value' => '33%', 'text' => 'have heard of someone being paid to let another person use their identity to get a job.', 'tone' => 'soft' ),
				array( 'value' => '14%', 'text' => 'believe employers are doing enough today to verify workers.', 'tone' => 'warm' ),
			),
			'stats_source' => 'Source: GCheck, “The Rise of the Shadow Workforce,” survey of 1,500 employed U.S. adults.',

			'moments'     => array(
				array(
					'pill'   => 'Before the check',
					'title'  => 'Prove they are who they say they are',
					'text'   => 'A liveness selfie and ID scan run before any search is ordered, so every result is tied to a confirmed person.',
					'points' => array( 'Liveness blocks photos, replays and deepfakes', 'ID forensics catch altered or fake documents', 'Details filled in straight from the ID' ),
					'phones' => 'before',
				),
				array(
					'pill'   => 'After the check',
					'title'  => 'Confirm the same person shows up',
					'text'   => 'Verified people carry a signed credential on their phone. Anyone can scan it at the field, the front desk or the door to confirm it’s them.',
					'points' => array( 'Scan with any phone camera, no app or login', 'Works in person or over a video call', 'Expires on the date you set' ),
					'phones' => 'after',
				),
			),

			'benefits'    => array(
				array( 'icon' => 'user', 'title' => 'Identity before screening', 'text' => 'Every check starts from a confirmed person, not a typed-in name.' ),
				array( 'icon' => 'file-search', 'title' => 'Government ID, verified', 'text' => 'Forensics and barcode checks confirm the ID is real and unaltered.' ),
				array( 'icon' => 'check', 'title' => 'Face match and liveness', 'text' => 'The person holding the ID is the person on it, and actually there.' ),
				array( 'icon' => 'dashboard', 'title' => 'Fewer errors and reorders', 'text' => 'Verified details cut name mismatches that slow searches down.' ),
				array( 'icon' => 'lock', 'title' => 'Fraud stopped at the door', 'text' => 'Synthetic identities and deepfakes flagged before onboarding, not after.' ),
				array( 'icon' => 'file', 'title' => 'Audit-ready records', 'text' => 'Every verification is logged with the screening file.' ),
			),

			'steps'       => array(
				array( 'title' => 'Capture the ID', 'text' => 'The candidate photographs their government ID from any phone.' ),
				array( 'title' => 'Check it’s genuine', 'text' => 'Forensics and barcode analysis spot tampering or forgery.' ),
				array( 'title' => 'Match the face', 'text' => 'A live selfie is matched to the ID photo and checked for liveness.' ),
				array( 'title' => 'Verify and screen', 'text' => 'Results are recorded and the background check runs on verified data.' ),
			),

			'uses'        => array(
				array(
					'icon'  => 'team',
					'title' => 'Youth and education',
					'items' => array(
						array( 'title' => 'Youth sports', 'text' => 'Coaches, refs and volunteers at field and tournament check-in' ),
						array( 'title' => 'K-12 volunteers and chaperones', 'text' => 'Verified before building access or a field trip' ),
						array( 'title' => 'Camps and after-school', 'text' => 'Counselors, seasonal staff and enrichment vendors at drop-off' ),
						array( 'title' => 'Tutoring and mentoring', 'text' => 'In-home tutors and mentors show families at the door' ),
						array( 'title' => 'Faith-based programs', 'text' => 'Nursery, youth group and mission-trip volunteers' ),
					),
				),
				array(
					'icon'  => 'home',
					'title' => 'In-home services',
					'items' => array(
						array( 'title' => 'Home services and trades', 'text' => 'Plumbers, HVAC techs, cleaners and movers, before entry' ),
						array( 'title' => 'Gig and marketplace workers', 'text' => 'The person at the door is the person screened' ),
						array( 'title' => 'Childcare and nannies', 'text' => 'Caregivers confirmed at every placement' ),
						array( 'title' => 'Senior and in-home care', 'text' => 'Aides and companions verified on arrival' ),
						array( 'title' => 'Utility and field techs', 'text' => 'Residents confirm a tech is legitimate' ),
					),
				),
				array(
					'icon'  => 'lock',
					'title' => 'Facilities and workforce',
					'items' => array(
						array( 'title' => 'Contractor and vendor access', 'text' => 'Hospitals, schools and data centers, no physical badge' ),
						array( 'title' => 'Construction sites', 'text' => 'Subcontractor crews verified before work starts' ),
						array( 'title' => 'Staffing agencies', 'text' => 'Proof of onboarding carried to every client site' ),
						array( 'title' => 'Healthcare staffing', 'text' => 'Travel nurses and per-diem clinicians at check-in' ),
						array( 'title' => 'Property management', 'text' => 'Maintenance vendors and leasing agents' ),
					),
				),
				array(
					'icon'  => 'calendar',
					'title' => 'Events and public roles',
					'items' => array(
						array( 'title' => 'Event and venue staff', 'text' => 'Security, concessions and crews at staff entrances' ),
						array( 'title' => 'Nonprofit and disaster response', 'text' => 'Volunteers verified at intake' ),
						array( 'title' => 'Real estate showings', 'text' => 'Agents and buyers verify each other first' ),
						array( 'title' => 'Rider transportation', 'text' => 'School bus, special-needs and senior shuttle drivers at pickup' ),
					),
				),
			),

			'persona'     => array(
				array( 'when' => 'MON · 6:58 AM', 'title' => 'Bluefield Logistics, Austin DC', 'text' => 'Shift supervisor scans him in at Dock 4.' ),
				array( 'when' => 'SAT · 8:30 AM', 'title' => 'Eastside Youth Soccer', 'text' => 'Tournament staff check coaches in at the field.' ),
				array( 'when' => 'SUN · 9:15 AM', 'title' => 'Grace Community Church', 'text' => 'The nursery lead confirms volunteers at the door.' ),
			),

			'replaces'    => array(
				array( 'today' => 'Printed badges and lanyards', 'breaks' => 'Easy to copy or lend. They never expire.', 'with' => 'Tied to a verified ID, with an expiration date' ),
				array( 'today' => 'Clearance lists and sign-in sheets', 'breaks' => 'Staff match names, not faces.', 'with' => 'Each scan shows the verified person’s photo and issuer' ),
				array( 'today' => 'Visitor kiosks and badge printers', 'breaks' => 'Hardware needed at every site.', 'with' => 'Any phone, any location' ),
				array( 'today' => 'Emailed or screenshotted results', 'breaks' => 'No way to tell if they’re still current.', 'with' => 'A live verification page on every scan' ),
			),

			'faqs'        => array(
				array( 'q' => 'What is Verified Entry™?', 'a' => 'It confirms a candidate’s identity with ID forensics, face match and liveness before the background check runs, then issues a signed credential employers can scan later.' ),
				array( 'q' => 'How does it improve background check accuracy?', 'a' => 'Searches use verified details from the ID instead of typed-in data, so fewer name mismatches, typos and reorders.' ),
				array( 'q' => 'Is candidate consent required?', 'a' => 'Yes. Candidates consent before any biometric or document data is processed, and consent is stored with the record.' ),
				array( 'q' => 'Does it work for remote hiring?', 'a' => 'Yes. Candidates verify from their own phone, with no site visit or in-person check.' ),
				array( 'q' => 'How does it detect fraud?', 'a' => 'Document forensics catch altered IDs, liveness blocks replays and synthetic media, and face match confirms the ID belongs to the person holding it.' ),
				array( 'q' => 'How are biometrics kept secure?', 'a' => 'Verified Entry™ never keeps biometric data. It converts the selfie and ID photo into mathematical facial vectors, uses them only to return a pass/fail match in under 10 seconds, then deletes them immediately. ID and selfie images may still be retained for compliance under the GCheck Privacy Policy.' ),
				array( 'q' => 'How long does it take?', 'a' => 'About two minutes for most candidates when the ID photo and selfie are clear.' ),
				array( 'q' => 'Are results documented for audits?', 'a' => 'Yes. Every verification event and outcome is recorded with the screening file for compliance reviews.' ),
				array( 'q' => 'Does the person scanning need an app?', 'a' => 'No. Only the verified person uses the app. Anyone checking just points their phone camera at the code, with no download or account.' ),
				array( 'q' => 'Can someone just show a screenshot?', 'a' => 'No. Each scan opens a live verification page from GCheck, so an expired or inactive credential won’t pass.' ),
				array( 'q' => 'We already run background checks. Why add this?', 'a' => 'A background check screens a name. Verified Entry™ proves the person in front of you is that name.' ),
				array( 'q' => 'Who benefits most?', 'a' => 'Any organization that lets screened people on-site: youth sports and schools, home and in-home services, contractor and vendor access, staffing, healthcare and event teams.' ),
			),
		);

		return $content;
	}
}
