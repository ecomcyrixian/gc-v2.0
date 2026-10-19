<?php
$gca_images_uri = get_template_directory_uri() . '/partials/home/gcheck-in-action/images';
$gca_get_started = home_url( '/contact-us/' );

$gca_g2_img_dir = get_template_directory_uri() . '/partials/home/grid-layout/images/';
$gca_stars = array( 0, 29.18, 58.36, 87.54, 116.72 );

$gca_g2_badges  = array(
	'hp.png'    => 'G2 High Performer',
	'roi.png'   => 'G2 Best Estimated ROI',
	'umltr.png' => 'G2 Users Most Likely To Recommend',
	'hua.png'   => 'G2 Highest User Adoption',
	'ulu.png'   => 'G2 Users Love Us',
);

$gca_steps = array(
	array(
		'slug'      => 'order',
		'tab_title' => 'Order',
		'tab_hint'  => 'Invite in seconds',
		'kicker'    => 'Order',
		'title'     => 'Your next hire is one invite away',
		'sub'       => 'Pick a package, add an email or phone number and send. GCheck collects everything else, so your team never chases paperwork.',
		'points'    => array(
			'No contracts, setup fees or minimums',
			'Invite one applicant or a whole list',
			'Third-party fees passed through at cost',
		),
		'stat'      => '$18.95',
		'stat_text' => 'Packages start at $18.95 per check',
		'link'      => array( 'label' => 'See Pricing', 'url' => home_url( '/pricing-packages/' ) ),
		'alt'       => 'Inviting an applicant in GCheck with the package and location selected',
	),
	array(
		'slug'      => 'candidate',
		'tab_title' => 'Candidate',
		'tab_hint'  => 'Done on their phone',
		'kicker'    => 'Candidate',
		'title'     => 'Candidates finish in minutes, not days',
		'sub'       => 'One branded link opens a guided checklist on any phone. No app, no password and no back-and-forth emails.',
		'points'    => array(
			'Clear steps with progress they can see',
			'Missing details flagged before they submit',
			'E-sign and live status in the same link',
		),
		'stat'      => 'No app',
		'stat_text' => 'Works in any mobile browser, by text or email',
		'link'      => array( 'label' => 'Next: Verify' ),
		'alt'       => 'GCheck applicant task hub on a phone showing completed and remaining steps',
	),
	array(
		'slug'      => 'verify',
		'tab_title' => 'Verify',
		'tab_hint'  => 'Prove who they are',
		'kicker'    => 'Verified Entry™',
		'title'     => 'Screen the real person, not a stolen identity',
		'sub'       => 'A liveness selfie and ID scan confirm the candidate matches their documents before the check runs, then a signed credential proves it on day one.',
		'points'    => array(
			'Liveness check stops photos and deepfakes',
			'Face matched to the government ID photo',
			'Credential scanned at onboarding or shift start',
		),
		'stat'      => '1 scan',
		'stat_text' => 'Confirms the person screened is the person who shows up',
		'link'      => array( 'label' => 'Explore Verified Entry', 'url' => home_url( '/identity/verified-entry/' ) ),
		'alt'       => 'Verified Entry identity results with face match, liveness and document checks on desktop and mobile',
	),
	array(
		'slug'      => 'decide',
		'tab_title' => 'Decide',
		'tab_hint'  => 'Hire with confidence',
		'kicker'    => 'Decide',
		'title'     => 'Make the offer while competitors are still waiting',
		'sub'       => 'Results land in one clear report, with anything that needs review flagged and compliant next steps built in.',
		'points'    => array(
			'Every search in one view',
			'Records explained in plain language',
			'Adverse action steps built in',
		),
		'stat'      => '12–24 hrs',
		'stat_text' => 'Average turnaround for most checks',
		'link'      => array( 'label' => 'Next: Order' ),
		'alt'       => 'GCheck report summary listing every search result in one view',
	),
);
?>
<section id="gcheck-in-action" aria-labelledby="gc-action-heading">
	<div class="container">

		<div class="heading">
			<h2 id="gc-action-heading">
				<span>GCheck in action</span>
				Background Checks That Keep Hiring Moving
			</h2>
			<p>One platform from offer to first shift. See every step the way your team and your candidates do.</p>
		</div>

		<div class="proof">
			<div class="rating">
				<span class="rating-label">Rated by Real Customers on G2</span>
				<span class="stars" role="img" aria-label="5 out of 5 stars">
					<svg width="142" height="24" viewBox="0 0 142 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<?php foreach ( $gca_stars as $offset ) : ?>
							<path transform="translate(<?php echo esc_attr( $offset ); ?> 0)" d="M13.2016 0.398693L16.4203 7.93086L24.5794 8.66068C24.9443 8.68875 25.2063 9.00688 25.1782 9.37179C25.1595 9.54957 25.0847 9.69928 24.9537 9.81156L18.7782 15.201L20.6028 23.1917C20.687 23.5472 20.4624 23.8934 20.1069 23.9776C19.9291 24.0151 19.742 23.9776 19.6016 23.8841L12.5841 19.6923L5.54782 23.9028C5.23905 24.0899 4.83671 23.987 4.64958 23.6782C4.55601 23.5285 4.53729 23.3507 4.57472 23.1917L6.39928 15.201L0.223845 9.81156C-0.0475002 9.57764 -0.0755704 9.15659 0.158348 8.88524C0.289342 8.74489 0.457763 8.6794 0.626184 8.67004L8.76653 7.94021L11.9852 0.398693C12.1256 0.0618508 12.5092 -0.0878568 12.8461 0.0524941C13.0145 0.117991 13.1361 0.248985 13.2016 0.398693Z" fill="#FF492C"/>
						<?php endforeach; ?>
					</svg>
				</span>
			</div>
			<ul class="badges" aria-label="G2 awards">
				<?php foreach ( $gca_g2_badges as $file => $alt ) : ?>
					<li><img src="<?php echo esc_url( $gca_g2_img_dir . $file ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="111" height="127" loading="lazy" decoding="async"></li>
				<?php endforeach; ?>
			</ul>
			<div class="buttons">
				<a class="button blue" href="<?php echo esc_url( $gca_get_started ); ?>">Get Started with GCheck</a>
				<a class="button white" href="<?php echo esc_url( home_url( '/book-a-demo/' ) ); ?>">Book a Demo</a>
			</div>
		</div>

		<div class="tabs" role="tablist" aria-label="GCheck in action">
			<?php foreach ( $gca_steps as $i => $step ) : ?>
				<button
					class="tab"
					type="button"
					role="tab"
					id="gc-action-tab-<?php echo esc_attr( $step['slug'] ); ?>"
					aria-controls="gc-action-panel-<?php echo esc_attr( $step['slug'] ); ?>"
					aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
					tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>"
				>
					<span class="step"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<span class="title"><?php echo esc_html( $step['tab_title'] ); ?></span>
					<span class="hint"><?php echo esc_html( $step['tab_hint'] ); ?></span>
					<span class="progress" aria-hidden="true"></span>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="panels">
		<?php foreach ( $gca_steps as $i => $step ) :
			$img = $gca_images_uri . '/gc-action-' . $step['slug'];
			?>
			<div
				class="cols cols2 panel"
				role="tabpanel"
				id="gc-action-panel-<?php echo esc_attr( $step['slug'] ); ?>"
				aria-labelledby="gc-action-tab-<?php echo esc_attr( $step['slug'] ); ?>"
				tabindex="0"
				<?php echo 0 === $i ? '' : 'hidden'; ?>
			>
				<div>
					<picture>
						<source media="(max-width: 767px)" srcset="<?php echo esc_url( $img . '-mobile.webp' ); ?>" width="960" height="960">
						<img
							src="<?php echo esc_url( $img . '-2x.webp' ); ?>"
							width="2400"
							height="1640"
							alt="<?php echo esc_attr( $step['alt'] ); ?>"
							loading="lazy"
							decoding="async"
						>
					</picture>
				</div>

				<div>
					<span class="kicker"><?php echo esc_html( $step['kicker'] ); ?></span>
					<h3><?php echo esc_html( $step['title'] ); ?></h3>
					<p><?php echo esc_html( $step['sub'] ); ?></p>

					<ul class="bullets">
						<?php foreach ( $step['points'] as $point ) : ?>
							<li><?php echo esc_html( $point ); ?></li>
						<?php endforeach; ?>
					</ul>

					<div class="stat">
						<strong><?php echo esc_html( $step['stat'] ); ?></strong>
						<span><?php echo esc_html( $step['stat_text'] ); ?></span>
					</div>

					<div class="buttons">
						<a class="button blue" href="<?php echo esc_url( $gca_get_started ); ?>">Get Started</a>
						<?php if ( ! empty( $step['link']['url'] ) ) : ?>
							<a class="link" href="<?php echo esc_url( $step['link']['url'] ); ?>"><?php echo esc_html( $step['link']['label'] ); ?></a>
						<?php else : ?>
							<button class="link" type="button" data-gc-next><?php echo esc_html( $step['link']['label'] ); ?></button>
						<?php endif; ?>
					</div>

					<p class="note">Pay per check. No setup fees, minimums or contracts.</p>
				</div>
			</div>
		<?php endforeach; ?>
		</div>

	</div>
</section>
