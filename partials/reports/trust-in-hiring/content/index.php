<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content.php';

$careerfishing_bars = array(
	array( 'label' => 'Exaggerated expertise', 'value' => 61, 'tone' => 'royal' ),
	array( 'label' => 'Inflated role scope', 'value' => 59, 'tone' => 'royal' ),
	array( 'label' => 'Made up interview stories', 'value' => 47, 'tone' => 'royal' ),
	array( 'label' => 'Allowed credential assumptions', 'value' => 46, 'tone' => 'cyan' ),
	array( 'label' => 'Adjusted employment dates', 'value' => 45, 'tone' => 'cyan' ),
	array( 'label' => 'Listed unperformable skills', 'value' => 41, 'tone' => 'royal' ),
	array( 'label' => 'Altered performance metrics', 'value' => 37, 'tone' => 'navy' ),
	array( 'label' => 'Inflated job title', 'value' => 34, 'tone' => 'royal' ),
	array( 'label' => 'Described termination as voluntary', 'value' => 34, 'tone' => 'cyan' ),
	array( 'label' => 'Removed work history (age)', 'value' => 34, 'tone' => 'cyan' ),
	array( 'label' => 'Removed graduation dates (age)', 'value' => 28, 'tone' => 'cyan' ),
	array( 'label' => 'Listed fake references', 'value' => 27, 'tone' => 'navy' ),
	array( 'label' => 'Listed fake education', 'value' => 25, 'tone' => 'navy' ),
);

$generation_series = array(
	array( 'label' => 'Gen Z (<=28)', 'tone' => 'royal' ),
	array( 'label' => 'Millennials (29-44)', 'tone' => 'cyan' ),
	array( 'label' => 'Gen X (45-60)', 'tone' => 'navy' ),
	array( 'label' => 'Boomers (60+)', 'tone' => 'lavender' ),
);

$generation_behaviors = array(
	array(
		'label'  => 'Exaggerated expertise',
		'values' => array( 71, 63, 55, 39 ),
	),
	array(
		'label'  => 'Inflated role scope',
		'values' => array( 67, 61, 54, 39 ),
	),
	array(
		'label'  => 'Interview stories',
		'values' => array( 59, 49, 40, 25 ),
	),
	array(
		'label'  => 'Adjusted dates',
		'values' => array( 55, 47, 39, 27 ),
	),
	array(
		'label'  => 'Unperformable skills',
		'values' => array( 52, 43, 35, 18 ),
	),
);

$trust_builders = array(
	array( 'label' => 'Clear explanation of what is being checked', 'value' => 82, 'tone' => 'royal' ),
	array( 'label' => 'Human review of findings (not fully automated)', 'value' => 81, 'tone' => 'navy' ),
	array( 'label' => 'Ability to review or dispute findings', 'value' => 77, 'tone' => 'cyan' ),
	array( 'label' => 'Secure data storage and deletion', 'value' => 76, 'tone' => 'navy' ),
	array( 'label' => 'Consistent screening standards for all', 'value' => 75, 'tone' => 'cyan' ),
	array( 'label' => 'Transparency about AI use in screening', 'value' => 74, 'tone' => 'royal' ),
);

$trust_pillars = array(
	array(
		'title' => 'Transparent Compliance',
		'tone'  => 'royal',
		'items' => array(
			'<strong>82%</strong> want to know what&rsquo;s checked',
			'<strong>74%</strong> want AI transparency',
		),
	),
	array(
		'title' => 'Fair Compliance',
		'tone'  => 'cyan',
		'items' => array(
			'<strong>77%</strong> want dispute ability',
			'<strong>75%</strong> want consistent standards',
		),
	),
	array(
		'title' => 'Protective Compliance',
		'tone'  => 'navy',
		'items' => array(
			'<strong>81%</strong> want human review',
			'<strong>76%</strong> want secure data handling',
		),
	),
);

$trust_model_principles = array(
	array(
		'title'       => 'Transparency as a Standard',
		'value'       => 82,
		'tone'        => 'royal',
		'label'       => 'Candidates Wants Clarity',
		'description' => 'With 82% of candidates wanting clarity, organizations must communicate verification practices openly rather than relying on opaque screening processes.',
	),
	array(
		'title'       => 'Commitment to Fair Opportunity',
		'value'       => 46,
		'tone'        => 'cyan',
		'label'       => 'Candidates Conceal Identity',
		'description' => 'As 46% of candidates report concealing aspects of their identity to avoid perceived bias, verification must be standardized and context-aware to support objective evaluation.',
	),
	array(
		'title'       => 'Human-Centric Decision Making',
		'value'       => 81,
		'tone'        => 'navy',
		'label'       => 'Respondents Call for Human Oversight',
		'description' => 'With 81% of respondents calling for human oversight, automated systems should be overseen and manually verified by trained human review to ensure accuracy and proper context.',
	),
);

$modern_employer_cards = array(
	array(
		'value' => 'Proactive Disclosure',
		'text'  => 'Communicating verification standards in job postings is the most cost-effective intervention to discourage embellishment before it starts. ',
		'icon'  => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="40" height="40" rx="4.92308" fill="#F2F3FF"/>
<path d="M33.8466 6.15381V18.7959M19.3984 9.76585V15.1839M23.6125 15.0334V16.9899C23.6125 18.3198 24.6906 19.398 26.0205 19.398C27.3504 19.398 28.4285 18.3198 28.4285 16.9899V16.2374M8.61891 11.0626C10.2173 11.0446 11.7311 10.3418 12.7764 9.13254C13.8219 10.3403 15.3352 11.0417 16.9326 11.059M15.4457 17.2488L12.7764 21.452L10.1299 17.2319M19.3984 13.9799L33.8466 17.5919V7.35782L19.3984 10.9699V13.9799ZM8.56232 10.3679C8.56232 12.6952 10.449 14.5819 12.7764 14.5819C15.1037 14.5819 16.9904 12.6952 16.9904 10.3679C16.9904 8.0405 15.1037 6.15381 12.7764 6.15381C10.449 6.15381 8.56232 8.0405 8.56232 10.3679ZM12.7764 16.3879C14.8958 16.3858 16.7393 17.8396 17.2312 19.9012L19.3984 27.8261H15.8382L14.5691 33.8461H10.9571L9.68808 27.8261H6.1543L8.32754 19.9012C8.81896 17.8418 10.6592 16.3886 12.7764 16.3879Z" stroke="#2231A0" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	),
	array(
		'value' => 'Independent Verification',
		'text'  => 'Validating employment and education history directly from the source closes the gaps left by relying on self-reported narratives.',
		'icon'  => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="40" height="40" rx="4.92308" fill="#F2F3FF"/>
<path d="M23.0103 17.5884V12.1691H9.76323V27.8235L16.9889 27.8247M26.6231 16.3841V9.76054C26.6231 9.09544 26.084 8.55626 25.4189 8.55626H20.0622C19.4239 7.09685 17.9821 6.15381 16.3892 6.15381C14.7963 6.15381 13.3545 7.09685 12.7161 8.55626H7.35467C6.68956 8.55626 6.15039 9.09544 6.15039 9.76054V30.2333C6.15039 30.8984 6.68956 31.4376 7.35467 31.4376H18.1932M13.3761 15.7819H19.3975M13.3761 19.3948H19.3975M13.3761 23.0076H16.9889M33.8488 33.8461L29.9373 29.9358M20.6017 26.0544C20.6017 29.0667 23.0437 31.5086 26.0559 31.5086C29.0682 31.5086 31.5101 29.0667 31.5101 26.0544C31.5101 23.0422 29.0682 20.6003 26.0559 20.6003C23.0437 20.6003 20.6017 23.0422 20.6017 26.0544Z" stroke="#2231A0" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	),
	array(
		'value' => 'Biometric & Deep Fake Detection',
		'text'  => 'Deploying advanced AI safeguards and live-proctored assessments effectively counters identity fraud and real-time AI answer generation. ',
		'icon'  => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="40.0001" height="40" rx="4.92309" fill="#F2F3FF"/>
<path d="M6.1543 11.4461V7.38458C6.1543 6.64612 6.64661 6.15381 7.38507 6.15381H11.3236M33.8467 11.4461V7.38458C33.8467 6.64612 33.3543 6.15381 32.6159 6.15381H28.6774M6.1543 28.6769V32.6153C6.1543 33.3538 6.64661 33.8461 7.38507 33.8461H11.3236M33.8467 28.6769V32.6153C33.8467 33.3538 33.3543 33.8461 32.6159 33.8461H28.6774M11.2004 18.7076H29.0466M20.1851 11.323V29.7845M23.6313 24.3692C21.662 26.3384 18.5851 26.3384 16.6159 24.3692M29.2928 13.7845C29.2928 12.4307 28.1851 11.323 26.8313 11.323H13.2928C11.9389 11.323 10.8312 12.4307 10.8312 13.7845V21.1691C10.8312 26.2153 15.0158 30.3999 20.062 30.3999C25.1082 30.3999 29.2928 26.2153 29.2928 21.1691V13.7845Z" stroke="#2231A0" stroke-width="1.33334" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	),
	array(
		'value' => 'Human-Centric Review',
		'text'  => 'Manual human review of all findings ensures accuracy and context, reduces bias-driven concealment, and maintains FCRA and EEOC Compliance (U.S. Equal Employment Opportunity Commission, 2012).',
		'icon'  => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="40" height="40" rx="4.92308" fill="#F2F3FF"/>
<path d="M14.462 11.6923C14.462 8.63346 16.9416 6.15381 20.0005 6.15381M12.001 9.84652L14.462 12.3075L17.5394 9.84652M11.6928 25.5384C8.63395 25.5384 6.1543 23.0588 6.1543 20M9.84701 27.9994L12.308 25.5384L9.84701 22.461M25.5389 28.3077C25.5389 31.3665 23.0593 33.8461 20.0005 33.8461M27.9999 30.1534L25.5389 27.6924L22.4615 30.1534M28.3081 14.4615C31.367 14.4615 33.8466 16.9412 33.8466 20M30.1539 12.0005L27.6929 14.4615L30.1539 17.539M18.1764 31.5513C16.3339 31.2626 14.5879 30.535 13.0858 29.4298M31.5518 21.824C31.3078 23.3776 30.7516 24.8656 29.9167 26.1982M21.9269 8.46431C23.7337 8.76368 25.4444 9.48517 26.9199 10.5701M8.44915 18.1759C8.73828 16.3336 9.46586 14.5877 10.5706 13.0853M27.2113 19.7592C27.4606 20.0836 27.4606 20.5352 27.2113 20.8596C26.2782 22.0841 23.7124 24.9244 20.0137 24.9244C16.315 24.9244 13.7528 22.0829 12.8161 20.8596C12.5668 20.5352 12.5668 20.0836 12.8161 19.7592C13.7504 18.5347 16.3162 15.6944 20.0137 15.6944C23.7112 15.6944 26.277 18.5383 27.2113 19.7592ZM20.0125 18.1759C21.1921 18.1759 22.1484 19.1322 22.1484 20.3118C22.1484 21.4914 21.1921 22.4477 20.0125 22.4477C18.8329 22.4477 17.8766 21.4914 17.8766 20.3118C17.8766 19.1322 18.8329 18.1759 20.0125 18.1759Z" stroke="#2231A0" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	),
	array(
		'value' => 'Audit-Ready Infrastructure',
		'text'  => 'Standardizing hiring criteria and adverse action documentation protects the organization from potential legal challenges. ',
		'icon'  => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="40" height="40" rx="4.92308" fill="#F2F3FF"/>
<path d="M24.2145 21.204V33.8461M24.2145 21.204C23.2171 21.204 22.4085 20.3954 22.4085 19.398M24.2145 21.204C25.2119 21.204 26.0205 20.3954 26.0205 19.398M20.6025 27.8261C20.6025 29.4884 19.2548 30.8361 17.5924 30.8361C15.93 30.8361 14.5824 29.4884 14.5824 27.8261L17.5924 19.398L20.6025 27.8261ZM14.5824 27.8261H20.6025M22.4085 19.398C22.4085 18.4005 23.2171 17.5919 24.2145 17.5919C25.2119 17.5919 26.0205 18.4005 26.0205 19.398M22.4085 19.398H16.3884M26.0205 19.398H32.0406M20.6025 33.8461H27.8265M27.8265 27.8261C27.8265 29.4884 29.1742 30.8361 30.8366 30.8361C32.499 30.8361 33.8466 29.4884 33.8466 27.8261L30.8366 19.398L27.8265 27.8261ZM33.8466 27.8261H27.8265M16.9904 33.8461H7.35831C6.69335 33.8461 6.1543 33.3071 6.1543 32.6421V7.35782C6.1543 6.69286 6.69335 6.15381 7.35831 6.15381H18.1944C18.9565 6.19513 19.6816 6.49545 20.2497 7.00505L24.5673 11.3226C25.0769 11.8907 25.3772 12.6158 25.4185 13.3779V15.1839M19.3984 6.44879V10.9699C19.3984 11.6348 19.9375 12.1739 20.6025 12.1739H25.1235M9.76634 12.1739H12.7764M9.76634 15.7859H16.3884" stroke="#2231A0" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	),
	array(
		'value' => 'Transparency as a Talent Magnet',
		'text'  => 'Leading with clear communication about screening practices attracts candidates who value integrity, helping build a more reliable talent pool. ',
		'icon'  => '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="40.001" height="40" rx="4.9232" fill="#F2F3FF"/>
<path d="M28.1097 21.0772H23.38M16.6227 21.0772H11.8931M23.7015 14.7028C23.4551 12.8476 21.8729 11.4617 20.0014 11.4617C18.1299 11.4617 16.5477 12.8476 16.3012 14.7028M15.0297 11.9659C13.9545 11.3631 12.6511 11.3299 11.5466 11.8773C10.4422 12.4247 9.67918 13.4821 9.50781 14.7028M24.973 11.9659C26.0482 11.3631 27.3517 11.3299 28.4562 11.8773C29.5606 12.4247 30.3236 13.4821 30.495 14.7028M23.38 17.0905V25.4697C23.3797 27.3354 21.8671 28.8477 20.0014 28.8477C18.1357 28.8477 16.6231 27.3354 16.6227 25.4697V17.0905H11.8931V25.7394C11.8941 30.2168 15.524 33.8458 20.0014 33.8458C24.4787 33.8458 28.1086 30.2168 28.1097 25.7394V17.0905H23.38ZM11.0719 8.28985C11.0719 9.46956 12.0283 10.4259 13.208 10.4259C14.3877 10.4259 15.344 9.46956 15.344 8.28985C15.344 7.11015 14.3877 6.15381 13.208 6.15381C12.0283 6.15381 11.0719 7.11015 11.0719 8.28985ZM17.8653 8.28985C17.8654 9.46956 18.8217 10.4259 20.0014 10.4259C21.1811 10.4259 22.1374 9.46956 22.1374 8.28985C22.1374 7.11015 21.1811 6.15381 20.0014 6.15381C18.8217 6.15381 17.8653 7.11015 17.8653 8.28985ZM24.6588 8.28985C24.6588 9.46956 25.6151 10.4259 26.7948 10.4259C27.9745 10.4259 28.9309 9.46956 28.9309 8.28985C28.9309 7.11015 27.9745 6.15381 26.7948 6.15381C25.6151 6.15381 24.6588 7.11015 24.6588 8.28985Z" stroke="#2231A0" stroke-width="1.33337" stroke-linecap="round" stroke-linejoin="round"/>
</svg>',
	),
);

$honesty_tax_items = array(
	'Skills described with precision losing to inflated “expert” claims',
	'Realistic salary expectations reducing leverage',
	'Employment gaps penalized relative to constructed narratives',
	'Honest work style preferences interpreted as lack of fit',
);
?>

<section class="content content--trust-in-hiring">
	<div class="container">
		<div class="frame-1">
			<div class="panel panel--blue-box">
				<div class="aar-report-blue-box tih-report-blue-box">
					<div class="tih-report-blue-box__content">
						<h2 class="tih-report-blue-box__title">In Today's Hiring Market, Exaggeration Is the Norm</h2>
						<div class="tih-report-blue-box__stat">
							<span class="tih-report-blue-box__stat-value">93%</span>
							<span class="tih-report-blue-box__stat-text">of recent job seekers have embellished or lied during the hiring process.</span>
						</div>
					</div>
					<p class="aar-report-blue-box-copy tih-report-blue-box__copy">
						The Professional Background Screening Association (PBSA, 2023) has consistently reported that over 95% of employers conduct some form of background screening. The Society for Human Resource Management (SHRM, 2024) has documented rising concerns about candidate misrepresentation. But the scale of these findings goes well beyond what most HR leaders expect, or what existing screening processes are designed to catch. The most common behaviors were exaggerating expertise in a skill (61%) and inflating the scope of previous roles (59%). At the far end of the spectrum: 27% listed fake references and 25% claimed educational credentials they never earned.
					</p>
				</div>
			</div>
			<div class="panel panel--graphs">
				<div class="tih-report-graph-card">
					<?php
					gc_aar_report_render_graph(
						array(
							'title' => 'The Careerfishing Spectrum: <br/>13 Embellishment Behaviors Ranked by Prevalence',
							'orientation' => 'horizontal',
							'layout'      => 'single',
							'motion'      => true,
							'panels'      => array(
								array(
									'max'    => 70,
									'ticks'  => array( 0, 10, 20, 30, 40, 50, 60, 70 ),
									'x_label' => 'Percentage of respondents (%)',
									'bars'   => $careerfishing_bars,
									'legend' => array(
										array(
											'color' => 'indigo',
											'text'  => 'Fabrication',
										),
										array(
											'color' => 'royal',
											'text'  => 'Inflation / Exaggeration',
										),
										array(
											'color' => 'cyan',
											'text'  => 'Concealment / Omission',
										),
									),
									'footer' => 'n=1,500 | GCheck 2026 Trust in Hiring Report',
								),
							),
						)
					);
					?>
				</div>
			</div>
		</div>
		<div class="frame-2">
			<div class="panel panel--copy">
				<div class="tih-report-copy">
					<h2 class="tih-report-copy__title">The Generational Divide</h2>
					<div class="tih-report-copy__intro">
						<div class="tih-report-copy__copy">
							<p>
								Baby Boomers reported the highest overall embellishment rate at 97%, but every generation participated at very high levels: 96% of Gen Z, 93% of Millennials and 91% of Gen X. The generational differences become more pronounced on fabrication behaviors: 40% of Gen Z listed fake references compared to 7% of Boomers, and 37% of Gen Z claimed unearned educational credentials compared to 17% of Boomers. Similarly, 41% of Gen Zers have described a job departure as voluntary when they were actually terminated, compared to 17% of Boomers. Gender differences were comparatively modest (95% of men vs. 91% of women). Embellishment is a market problem, not a demographic one.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel--graphs">
				<figure class="aar-report-graph aar-report-graph--vertical aar-report-graph--single aar-report-graph--motion tih-generation-graph" data-aar-graph-motion="true">
					<figcaption class="aar-report-graph__title">
						Embellishment Knows No Generation:<br>
						Top 5 Behaviors by Age Cohort
					</figcaption>
					<div class="aar-report-graph__chart-frame">
						<div class="tih-generation-graph__inner">
							<div class="tih-generation-graph__legend" aria-label="Chart legend">
								<?php foreach ( $generation_series as $series ) : ?>
									<div class="tih-generation-graph__legend-item">
										<span class="tih-generation-graph__legend-swatch aar-report-graph__bar--tone-<?php echo esc_attr( $series['tone'] ); ?>" aria-hidden="true"></span>
										<span><?php echo esc_html( $series['label'] ); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="tih-generation-graph__plot" style="--tih-generation-y-max: 80;">
								<div class="tih-generation-graph__y-axis" aria-hidden="true">
									<?php foreach ( array( 80, 70, 60, 50, 40, 30, 20, 10, 0 ) as $tick ) : ?>
										<span><?php echo esc_html( (string) $tick ); ?></span>
									<?php endforeach; ?>
								</div>
								<p class="tih-generation-graph__axis-label tih-generation-graph__axis-label--y">Percentage (%)</p>
								<div class="tih-generation-graph__groups">
									<?php foreach ( $generation_behaviors as $behavior ) : ?>
										<div class="tih-generation-graph__group">
											<div class="tih-generation-graph__bars">
												<?php foreach ( $behavior['values'] as $index => $value ) : ?>
													<?php
													$series = $generation_series[ $index ];
													$height = ( $value / 80 ) * 100;
													?>
														<div class="tih-generation-graph__bar-wrap" style="--aar-value: <?php echo esc_attr( number_format( $height, 4, '.', '' ) ); ?>;">
														<span class="tih-generation-graph__value"><?php echo esc_html( (string) $value ); ?>%</span>
														<span
															class="aar-report-graph__bar aar-report-graph__bar--tone-<?php echo esc_attr( $series['tone'] ); ?> tih-generation-graph__bar"
															aria-label="<?php echo esc_attr( $series['label'] . ': ' . $value . '%' ); ?>"
														></span>
													</div>
												<?php endforeach; ?>
											</div>
											<p class="tih-generation-graph__category"><?php echo esc_html( $behavior['label'] ); ?></p>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<p class="aar-report-graph__footer">n: Gen Z=245, Millennials=717, Gen X=494, Boomers=44 | GCheck 2026</p>
						</div>
					</div>
				</figure>
			</div>
		</div>
		<div class="frame-3">
			<div class="panel panel--copy">
				<div class="tih-report-copy">
					<h2 class="tih-report-copy__title">Reference Manipulation</h2>
					<div class="tih-report-copy__intro">
						<div class="tih-report-copy__copy">
							<p>Reference checks are widely treated as a final validation of a candidate’s claims. The findings suggest that trust may be misplaced. When nearly half of candidates actively prepare their references to deliver a scripted narrative, the signal-to-noise ratio in traditional reference checking drops substantially.</p>
						</div>
					</div>
				</div>
				<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'intro'       => '',
						'title'       => 'References Under Fire: <br/> How Candidates Game the Verification Process',
						'orientation' => 'horizontal',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'max'     => 60,
								'x_label' => '',
								'ticks'   => array( 0, 10, 20, 30, 40, 50, 60 ),
								'bars'    => array(
									array( 'label' => 'Coached a reference on what to say', 'value' => 45, 'tone' => 'royal' ),
									array( 'label' => 'Had friend/family pose as professional reference', 'value' => 41, 'tone' => 'cyan' ),
									array( 'label' => 'Asked coworker to pose as manager/supervisor', 'value' => 33, 'tone' => 'indigo' ),
								),
								'footer'  => 'n=1,500 | GCheck 2026 Trust in Hiring Report',
							),
						),
					)
				);
				?>
				</div>
			</div>
			<div class="panel panel--cyan-box">
				<div class="aar-report-cyan-box tih-report-cyan-box">
					<div class="tih-report-cyan-box__content">
						<p class="tih-report-cyan-box__copy"><strong>Careerfishing</strong> is the systematic embellishment, distortion, or fabrication of professional qualifications across resumes, interviews, and references as a deliberate competitive strategy, driven by market pressure and weak verification expectations.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="frame-4">
			<div class="panel panel--copy">
				<div class="tih-report-copy">
					<h2 class="tih-report-copy__title">Why Candidates Feel Forced to Exaggerate</h2>
					<div class="tih-report-copy__intro">
						<div class="tih-report-copy__copy">
							<p>Among those who engaged in embellishment, the motivational factors point decisively toward structural incentives rather than individual dishonesty. Competitive pressure was the single most cited driver, followed by extended job searches and the assumption that other candidates were doing the same. Sixty percent said they would not have been hired if they had presented their experience fully accurately.</p>
						</div>
					</div>
				</div>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/partials/reports/trust-in-hiring/page-hero/images/frame-4.webp' ); ?>" alt="Why Candidates Feel Forced to Exaggerate" class="tih-report-frame-4__image" loading="lazy" decoding="async">
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'title' => 'Why Candidates Exaggerate: The Five Drivers of Careerfishing',
						'orientation' => 'horizontal',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'max'    => 80,
								'ticks'  => array( 0, 10, 20, 30, 40, 50, 60, 70, 80 ),
								'x_label' => '',
								'bars'   => array(
									array( 'label' => 'Competitive market pressured me to exaggerate', 'value' => 72, 'tone' => 'royal' ),
									array( 'label' => 'Minor exaggeration necessary to stay competitive', 'value' => 71, 'tone' => 'royal' ),
									array( 'label' => 'Extended job search made exaggeration necessary', 'value' => 62, 'tone' => 'royal' ),
									array( 'label' => 'Would not have been hired if fully honest', 'value' => 60, 'tone' => 'royal' ),
									array( 'label' => 'Assumed other candidates were doing the same', 'value' => 57, 'tone' => 'royal' ),
								),
								'footer' => 'n=1,394 (embellishers only) | GCheck 2026 Trust in Hiring Report',
							),
						),
					)
				);
				?>
			</div>
		</div>
		<div class="frame-5">
			<div class="panel panel--copy">
				<div class="tih-report-copy">
					<h2 class="tih-report-copy__title">The Verification Feedback Loop</h2>
					<div class="tih-report-copy__intro">
						<div class="tih-report-copy__copy">
							<p>Competitive pressure alone does not fully explain why embellishment has become so pervasive. A second, self-reinforcing mechanism is at work: weak employer verification creates the expectation of weak verification, which incentivizes further inflation. Just over half of those who embellished (53%) did so because they believed employers would not verify everything. That belief is not unfounded. Only 26% reported that someone actually verified their claims and found a discrepancy, while only 28% lost an opportunity over a detected exaggeration. When the probability of detection is this low, embellishment becomes a rational calculation.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel--blue-box">
				<div class="aar-report-blue-box">
					<h2 class="aar-report-blue-box__heading">COMPLIANCE FOR GOOD™: <br/>Transparent Compliance</h2>
					<p class="aar-report-blue-box__text aar-report-blue-box-copy">The verification feedback loop thrives in opacity. When candidates do not know what will be checked (56% report this concern), they assume the answer is minimal and calibrate their embellishment accordingly. Organizations that clearly communicate what will be verified before candidates apply can disrupt this cycle at its root.</p>
				</div>
			</div>
		</div>
		<div class="frame-6">
			<div class="tih-report-fallout">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/partials/reports/trust-in-hiring/page-hero/images/frame-6.webp' ); ?>"
					alt=""
					class="tih-report-fallout__image"
					loading="lazy"
					decoding="async"
					aria-hidden="true"
				>
				<div class="tih-report-fallout__content">
					<h2 class="tih-report-copy__title">The Fallout: Stress, Mismatch, and Workplace Risk</h2>
					<div class="tih-report-copy__copy">Among those who embellished, 39% experienced stress or anxiety once hired, 29% said their overstatement became clear after starting the role, and 25% faced negative workplace consequences because their skills did not match their resume. The burden was not distributed equally: Hispanic respondents reported the highest post-hire stress (55%), and Gen Z faced the sharpest workplace fallout (38% experienced negative outcomes).</div>
					<div class="tih-report-fallout__stats-title">The Candidate Toll: What Happens After the Hire</div>
					<div class="tih-report-fallout__stats" aria-label="Candidate toll after hire">
						<div class="tih-report-fallout__cards">
							<div class="tih-report-fallout__card tih-report-fallout__card--royal">
								<span class="tih-report-fallout__card-value">39%</span>
								<span class="tih-report-fallout__card-text">Experienced post-hire stress or anxiety</span>
							</div>
							<div class="tih-report-fallout__card tih-report-fallout__card--cyan">
								<span class="tih-report-fallout__card-value">29%</span>
								<span class="tih-report-fallout__card-text">Overstated experience became clear on the job</span>
							</div>
							<div class="tih-report-fallout__card tih-report-fallout__card--navy">
								<span class="tih-report-fallout__card-value">25%</span>
								<span class="tih-report-fallout__card-text">Faced negative workplace consequences</span>
							</div>
						</div>
						<p class="aar-report-graph__footer">n=1,394 (embellishers only) | GCheck 2026</p>
					</div>
					<div class="tih-report-fallout__card-text">
					The report’s central paradox emerges from a separate finding: 88% of all respondents agree that candidate misrepresentation puts businesses at risk (28% “significant risk,” 60% “some risk”). This near-universal acknowledgment, from a population in which 93% embellished, is not hypocrisy. It is a market failure. Candidates embellish because the system incentivizes it and simultaneously recognize that the cumulative effect is corrosive.
					</div>
				</div>
			</div>
		</div>
		<div class="frame-7">
			<div class="tih-report-paradox">
				<div class="panel panel--copy">
					<h2 class="tih-report-copy__title">The Careerfishing Paradox</h2>
					<div class="tih-report-fallout__stats" aria-label="Careerfishing paradox">
						<div class="tih-report-fallout__cards">
							<div class="tih-report-fallout__card tih-report-fallout__card--navy">
								<span class="tih-report-fallout__card-value">93%</span>
								<span class="tih-report-fallout__card-text">have embellished</span>
							</div>
							<div class="tih-report-fallout__card tih-report-fallout__card--royal">
								<span class="tih-report-fallout__card-value">88%</span>
								<span class="tih-report-fallout__card-text">know it creates risk</span>
							</div>
						</div>
					</div>
					<p class="tih-report-paradox__caption">The paradox is the point. Candidates are rational participants in a broken system.</p>
					<div class="tih-report-paradox__copy">
						<div class="tih-report-paradox__copy-title">COMPLIANCE FOR GOOD™: Protective Compliance</div>
						<div class="tih-report-paradox__copy-text">
							When candidates themselves acknowledge that misrepresentation creates organizational risk, the case for consistent verification processes is self-evident. Protective screening reduces negligent hiring exposure and reduces the post-hire anxiety that embellishers carry into their new roles.
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'type'   => 'pie',
						'title'  => 'Do Misrepresenting Candidates Put Business at Risk?',
						'layout' => 'half',
						'motion' => true,
						'panels' => array(
							array(
								'max'          => 100,
								'center_value' => '88%',
								'center_label' => 'agree it creates risk',
								'bars'         => array(
									array( 'label' => 'No risk', 'value' => 12, 'tone' => 'gray' ),
									array( 'label' => 'Some risk', 'value' => 60, 'tone' => 'royal' ),
									array( 'label' => 'Significant risk', 'value' => 28, 'tone' => 'cyan' ),
								),
							),
						),
					)
				);
				?>
			</div>
		</div>
		<div class="frame-8">
			<div class="tih-report-fallout">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/partials/reports/trust-in-hiring/page-hero/images/frame-8.webp' ); ?>"
					alt=""
					class="tih-report-fallout__image"
					loading="lazy"
					decoding="async"
					aria-hidden="true"
				>
				<div class="tih-report-fallout__content">
					<h2 class="tih-report-copy__title">Bias and Digital Scrutiny Are Reshaping Candidate Behavior</h2>
					<div class="tih-report-copy__copy">Beyond credential embellishment, the survey documents a parallel phenomenon: systematic identity concealment. When candidates alter their appearance, change their name, or hide their children from prospective employers, the motivation is not competitive advantage. It is self-protection in a system they experience as biased. Forty-six percent of all respondents altered their appearance or communication style for interviews, with rates significantly higher among candidates of color.</div>
				</div>
			</div>
			<div class="panel panel--graphs">
				<div class="tih-report-graph-card">
					<?php
					gc_aar_report_render_graph(
						array(
							'title' => 'Altered to Fit In: Identity Modification by Race and Ethnicity',
							'orientation' => 'horizontal',
							'layout'      => 'single',
							'motion'      => true,
							'panels'      => array(
								array(
									'max'    => 70,
									'ticks'  => array( 0, 10, 20, 30, 40, 50, 60, 70 ),
									'x_label' => '',
									'bars'   => array(
										array( 'label' => 'Hispanic', 'value' => 64, 'tone' => 'royal' ),
										array( 'label' => 'Black', 'value' => 56, 'tone' => 'cyan' ),
										array( 'label' => 'White', 'value' => 39, 'tone' => 'navy' ),
										array( 'label' => 'Asian', 'value' => 38, 'tone' => 'lavender' ),
									),
									'footer' => 'n=1,394 (embellishers only) | GCheck 2026 Trust in Hiring Report',
								),
							),
						)
					);
					?>
				</div>
			</div>
		</div>
		<div class="frame-9">
			<div class="panel panel--copy">
				<div class="tih-report-copy tih-report-copy--stat">
					<div class="tih-report-blue-box__stat">
						<span class="tih-report-blue-box__stat-value">50%</span>
						<span class="tih-report-blue-box__stat-text">of working mothers with children under 18 avoided mentioning caregiving responsibilities during the hiring process.</span>
					</div>
					<div class="tih-report-copy__copy">
						<p>Among fathers in the same situation, the rate was 38%. The 12-point gap reflects the documented motherhood penalty in hiring. Additional identity concealment behaviors included removing cultural or identity-related details from resumes (31% overall, 40% among Asian respondents), using a gender-neutral version of their name (24%) using a different name to avoid ethnicity questions (21%, rising to 32% among Black respondents) and concealing age indicators (36%, rising to 47% for Baby Boomers).</p>
					</div>
				</div>
				<div class="panel panel--blue-box">
					<div class="aar-report-blue-box">
						<h2 class="aar-report-blue-box__heading">Digital Self-Censorship</h2>
						<p class="aar-report-blue-box__text aar-report-blue-box-copy">Employer scrutiny of social media has created a culture of digital self-censorship. Eighty percent of respondents reported that concerns about employer interpretation have caused them to avoid posting honest views online. The behavioral modifications go further: 58% made accounts private during a job search, 53% stopped posting certain opinions, and 48% paused posting altogether.</p>
					</div>
				</div>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'title' => 'Digital Self-Censorship: How Job Seekers Manage Their Online Presence',
						'orientation' => 'horizontal',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'max'    => 70,
								'ticks'  => array( 0, 10, 20, 30, 40, 50, 60, 70),
								'x_label' => '',
								'bars'   => array(
									array( 'label' => 'Made accounts private', 'value' => 58, 'tone' => 'royal' ),
									array( 'label' => 'Stopped posting opinions/topics', 'value' => 53, 'tone' => 'royal' ),
									array( 'label' => 'Paused posting altogether', 'value' => 48, 'tone' => 'royal' ),
									array( 'label' => 'Created separate professional/personal accounts', 'value' => 44, 'tone' => 'royal' ),
									array( 'label' => 'Deleted past posts or photos', 'value' => 43, 'tone' => 'royal' ),
									array( 'label' => 'Asked others to remove/untag them', 'value' => 33, 'tone' => 'royal' ),
								),
								'footer' => 'n=1,500 | GCheck 2026 Trust in Hiring Report',
							),
						),
					)
				);
				?>
			</div>
		</div>
		<div class="frame-10">
			<div class="panel panel--copy">
				<div class="tih-report-copy tih-report-copy--stat">
					<div class="tih-report-frame-10__header">
						<h2 class="tih-report-copy__title">AI as Accomplice: Technology Is Blurring Preparation and Deception</h2>
						<div class="tih-report-blue-box__stat">
							<span class="tih-report-blue-box__stat-value">25%</span>
							<span class="tih-report-blue-box__stat-text">used an AI avatar of themselves to conduct a virtual job meeting.</span>
						</div>
					</div>
					<div class="tih-report-copy__copy">
						<p>One in four respondents reported using an AI-generated avatar in a video interview or meeting, a finding that represents a fundamental shift in what remote hiring verification can assume. The broader AI picture is equally consequential: 61% used AI to practice interview answers until they sounded more impressive than authentic, 48% used AI to complete take-home assignments, and 27% used AI during live interviews for real-time answer generation.</p>
					</div>
				</div>
			</div>
			<?php
			gc_aar_report_render_graph(
				array(
					'title'       => 'AI in the Job Search: From Assistance to Impersonation',
					'orientation' => 'horizontal',
					'layout'      => 'single',
					'motion'      => true,
					'panels'      => array(
						array(
							'max'      => 70,
							'ticks'    => array( 0, 10, 20, 30, 40, 50, 60, 70 ),
							'x_label'  => '',
							'bars'     => array(
								array( 'label' => 'Practiced interview answers.', 'sublabel' => 'impressive > authentic', 'value' => 61, 'tone' => 'royal' ),
								array( 'label' => 'Wrote cover letter', 'value' => 54, 'tone' => 'royal' ),
								array( 'label' => 'Tailored resume without meeting requirements', 'value' => 50, 'tone' => 'royal' ),
								array( 'label' => 'Completed take-home assignments', 'value' => 48, 'tone' => 'lavender' ),
								array( 'label' => 'Generated overstated resume bullets', 'value' => 43, 'tone' => 'lavender' ),
								array( 'label' => 'Wrote untrue application answers', 'value' => 42, 'tone' => 'lavender' ),
								array( 'label' => 'Communicated with hiring managers', 'value' => 36, 'tone' => 'cyan' ),
								array( 'label' => 'Used AI during live interview', 'value' => 27, 'tone' => 'cyan' ),
								array( 'label' => 'Used AI avatar in virtual meeting', 'value' => 25, 'tone' => 'cyan' ),
							),
							'dividers' => array(
								array( 'after' => 3 ),
							),
							'legend'   => array(
								array(
									'color' => 'royal',
									'text'  => 'Assistance / Preparation',
								),
								array(
									'color' => 'lavender',
									'text'  => 'Gray Area',
								),
								array(
									'color' => 'cyan',
									'text'  => 'Active Misrepresentation',
								),
							),
							'footer'   => 'n=1,500 | Threshold categorization is editorial | GCheck 2026',
						),
					),
				)
			);
			?>
		</div>
		<div class="frame-11">
			<div class="panel panel--copy">
				<div class="tih-report-copy">
					<h2 class="tih-report-copy__title">Trust in Screening Is Conditional, Not Absent</h2>
					<div class="tih-report-copy__copy">
						<p>Despite high embellishment rates, 80% of respondents said ongoing or periodic background screening is important, either for all roles (31%) or for safety-sensitive roles (49%). Their support, however, comes with specific conditions. The most widely shared concern (56%) is not understanding what employers can see or verify. The most widely requested feature (82%) is a clear explanation of what is being checked. Close behind, 81% want human review of findings rather than fully automated decision-making. These six trust-building factors map directly to the principles of transparent, fair, and protective compliance.</p>
					</div>
				</div>
			</div>
			<?php
			gc_aar_report_render_graph(
				array(
					'title'       => 'What Would Build Your Trust? The Candidate Mandate for Modern Screening',
					'orientation' => 'horizontal',
					'layout'      => 'single',
					'motion'      => true,
					'panels'      => array(
						array(
							'max'     => 120,
							'ticks'   => array( 0, 20, 40, 60, 80, 100, 120 ),
							'x_label' => '',
							'bars'    => $trust_builders,
							'legend'  => array(
								array(
									'color' => 'royal',
									'text'  => 'Transparent Compliance',
								),
								array(
									'color' => 'cyan',
									'text'  => 'Fair Compliance',
								),
								array(
									'color' => 'navy',
									'text'  => 'Protective Compliance',
								),
							),
							'footer'  => 'n=1,500 | Pillar mapping is editorial | GCheck 2026 Trust in Hiring Report',
						),
					),
				)
			);
			?>	
			<div class="tih-report-pillar-summary" aria-label="Compliance pillar summary">
				<?php foreach ( $trust_pillars as $pillar ) : ?>
					<div class="tih-report-pillar-summary__column tih-report-pillar-summary__column--<?php echo esc_attr( $pillar['tone'] ); ?>">
						<div class="tih-report-pillar-summary__heading"><?php echo esc_html( $pillar['title'] ); ?></div>
						<ul class="tih-report-pillar-summary__list">
							<?php foreach ( $pillar['items'] as $item ) : ?>
								<li><?php echo wp_kses_post( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="frame-12">
			<div class="tih-report-fallout">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/partials/reports/trust-in-hiring/page-hero/images/frame-12.webp' ); ?>"
					alt=""
					class="tih-report-fallout__image"
					loading="lazy"
					decoding="async"
					aria-hidden="true"
				>
				<div class="tih-report-fallout__content">
					<h2 class="tih-report-copy__title">The Path Forward: Rebuilding Credibility in Hiring</h2>
					<div class="tih-report-copy__copy">
						<p>The data reveals a hiring ecosystem under significant strain. Candidates increasingly feel pressure to exaggerate qualifications to remain competitive, while employers face growing difficulty verifying credentials efficiently and fairly. As technology expands both opportunity and risk, trust in the hiring process is weakening on both sides.</p>
						<p>Restoring credibility requires modern verification practices that balance rigor with fairness, use technology responsibly, and provide candidates with clear visibility into the process. The future of hiring depends not only on identifying talent but on rebuilding trust in an increasingly AI-driven environment.</p>
					</div>
				</div>
			</div>
			<div class="panel panel--graphs tih-report-principles">
				<div class="tih-report-principles__header">
					<h3 class="tih-report-principles__title">Foundational Principles for a Trust-Based Model</h3>
					<p class="tih-report-principles__intro">Addressing the “careerfishing” trend requires alignment around three core principles reflected in candidate feedback:</p>
				</div>
				<div class="tih-report-principles__grid">
					<?php foreach ( $trust_model_principles as $principle ) : ?>
						<div class="tih-report-principles__card">
							<h4 class="tih-report-principles__card-title"><?php echo esc_html( $principle['title'] ); ?></h4>
							<?php
							gc_aar_report_render_graph(
								array(
									'type'   => 'pie',
									'layout' => 'whole',
									'motion' => true,
									'panels' => array(
										array(
											'max'          => 100,
											'center_value' => (string) $principle['value'] . '%',
											'bars'         => array(
												array( 'label' => '', 'value' => $principle['value'], 'tone' => $principle['tone'] ),
												array( 'label' => '', 'value' => 100 - $principle['value'], 'tone' => 'gray' ),
											),
										),
									),
								)
							);
							?>
							<div class="tih-report-principles__card-label"><?php echo esc_html( $principle['label'] ); ?></div>
							<p class="tih-report-principles__card-copy"><?php echo esc_html( $principle['description'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="frame-13">
			<img
				src="<?php echo esc_url( get_template_directory_uri() . '/partials/reports/trust-in-hiring/page-hero/images/frame-13.webp' ); ?>"
				alt=""
				class="tih-report-frame-13__bg"
				loading="lazy"
				decoding="async"
				aria-hidden="true"
			>
			<div class="tih-report-modern-employer">
				<?php
					gc_aar_report_render_stat_cards(
						array(
							'columns' => 3,
							'cards'   => $modern_employer_cards,
							'title'   => 'Operational Responses for the Modern Employer',
							'intro'   => 'The findings highlight practical shifts that can reduce risk while improving the candidate experience: ',
						)
					);
				?>
				<p class="tih-report-modern-employer__bottom-line">
					<strong>The Bottom Line:</strong> Rebuilding trust in hiring isn&rsquo;t just about catching embellishments; it&rsquo;s about creating an environment where integrity is expected, verified, and rewarded.
				</p>
			</div>
			<div class="tih-report-honesty-tax">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/home-header-bg.jpg' ); ?>"
					alt=""
					class="tih-report-honesty-tax__bg"
					loading="lazy"
					decoding="async"
					aria-hidden="true"
				>
				<div class="tih-report-honesty-tax__header">
					<p class="tih-report-honesty-tax__eyebrow">The Honesty Tax:</p>
					<h2 class="tih-report-honesty-tax__title">A Defining Dynamic in Modern Hiring</h2>
				</div>
				<div class="tih-report-honesty-tax__body">
					<div class="tih-report-honesty-tax__copy">
						<p>Taken together, the findings in this report point to a structural pattern in hiring: candidates are often penalized for accuracy and rewarded for optimization.<br><br>
						This pattern is reflected in what we describe as The Honesty Tax. Transparent, realistic candidates are more likely to be filtered out, while embellished or AI-enhanced profiles are more likely to advance.<br><br>
						The dynamic aligns with earlier findings: 60% of candidates believe full honesty would cost them the job, while only 26% report that discrepancies are actually detected.</p>
					</div>
					<div class="tih-report-honesty-tax__list-panel">
						<div class="tih-report-honesty-tax__list-title">In practice, this appears as:</div>
						<ul class="tih-report-honesty-tax__list">
							<?php foreach ( $honesty_tax_items as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div class="tih-report-honesty-tax__footer">
					<p>The implications extend beyond hiring. Candidates absorb the cost upfront, but organizations carry the downstream impact. Mismatch, underperformance, and early attrition are predictable outcomes of a system in which optimization is rewarded over accuracy.</p>
					<p>As organizations implement more transparent, consistent, and human-centered screening practices, reducing this imbalance becomes central to sustaining long-term trust in hiring.</p>
				</div>
			</div>
		</div>
	</div>
</section>
