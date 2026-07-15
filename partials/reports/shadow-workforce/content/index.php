<?php
/**
 * Shadow Workforce report body content.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content.php';

$swr_images_uri = get_template_directory_uri() . '/partials/reports/shadow-workforce/page-hero/images';
$swr_img        = static function ( $file, $alt, $position = 'left' ) use ( $swr_images_uri ) {
	return array(
		'src'      => $swr_images_uri . '/' . ltrim( $file, '/' ),
		'alt'      => $alt,
		'position' => 'right' === $position ? 'right' : 'left',
	);
};

$recognition_gap_bars = array(
	array( 'label' => 'Fully remote', 'value' => 40, 'tone' => 'royal' ),
	array( 'label' => 'Hybrid', 'value' => 26, 'tone' => 'cyan' ),
	array( 'label' => 'Fully in person', 'value' => 19, 'tone' => 'navy' ),
);

$hiring_gaming_bars = array(
	array( 'label' => 'Candidates exaggerate experience', 'value' => 57, 'tone' => 'royal' ),
	array( 'label' => 'People have lied to secure jobs', 'value' => 54, 'tone' => 'royal' ),
	array( 'label' => 'Coworkers not fully honest', 'value' => 52, 'tone' => 'royal' ),
	array( 'label' => 'Interview better than they perform', 'value' => 52, 'tone' => 'royal' ),
	array( 'label' => 'Inflate technical / AI skills', 'value' => 44, 'tone' => 'royal' ),
	array( 'label' => 'Employers fail to verify', 'value' => 39, 'tone' => 'royal' ),
);

$ai_generation_bars = array(
	array( 'label' => 'Gen Z', 'value' => 22, 'tone' => 'royal' ),
	array( 'label' => 'Millennials', 'value' => 21, 'tone' => 'cyan' ),
	array( 'label' => 'Gen X', 'value' => 8, 'tone' => 'navy' ),
	array( 'label' => 'Boomers', 'value' => 2, 'tone' => 'black' ),
);

$ai_role_bars = array(
	array( 'label' => 'Individual contributors', 'value' => 9, 'tone' => 'royal' ),
	array( 'label' => 'Managers', 'value' => 18, 'tone' => 'cyan' ),
	array( 'label' => 'Senior leaders & executives', 'value' => 30, 'tone' => 'navy' ),
);

$warning_signs_bars = array(
	array( 'label' => 'Repeated excuses for missed work', 'value' => 46, 'tone' => 'royal' ),
	array( 'label' => 'Sudden changes in comm. style', 'value' => 23, 'tone' => 'royal' ),
	array( 'label' => 'Consistently keeping cameras off', 'value' => 21, 'tone' => 'royal' ),
	array( 'label' => 'Refusing to join live meetings', 'value' => 19, 'tone' => 'royal' ),
);

$verification_confidence_bars = array(
	array( 'label' => 'Strongly support stronger skills and identity verification', 'value' => 78, 'tone' => 'royal' ),
	array( 'label' => 'Proof candidates can actually do the job', 'value' => 60, 'tone' => 'royal' ),
	array( 'label' => 'Stronger identity verification', 'value' => 59, 'tone' => 'royal' ),
	array( 'label' => 'Verification applied consistently to every hire', 'value' => 54, 'tone' => 'royal' ),
	array( 'label' => 'Greater transparency into what is verified', 'value' => 40, 'tone' => 'royal' ),
	array( 'label' => 'Ongoing verification and monitoring after hire', 'value' => 37, 'tone' => 'royal' ),
);

$mandate_columns = array(
	array(
		'label'   => 'Pillar',
		'colspan' => 1,
	),
	array(
		'label'   => 'What Employees Are Asking For',
		'colspan' => 2,
	),
);

$mandate_rows = array(
	array( 'Transparent Compliance', 'Clear communication of what is verified before and after hire, so expectations are set up front rather than discovered later.', '40% want transparency into what is verified' ),
	array( 'Fair Compliance', 'Consistent verification standards applied to every hire within the same job category, with human review of findings.', '54% want consistent checks within job category' ),
	array( 'Protective Compliance', 'Verification that extends beyond hire, reconfirming identity, capability, and accountability throughout the employee lifecycle.', '37% want verification that continues after day one' ),
);

$methodology_columns = array(
	'Segment',
	'Group',
	'Sample (N)',
	'Share',
);

$methodology_rows = array(
	array( 'Gender', 'Male', '737', '49%' ),
	array( 'Gender', 'Female', '763', '51%' ),
	array( 'Generation', 'Gen Z (18–29)', '136', '9%' ),
	array( 'Generation', 'Millennials (30–45)', '590', '39%' ),
	array( 'Generation', 'Gen X (46–61)', '694', '46%' ),
	array( 'Generation', 'Baby Boomers (62–80)', '80', '5%' ),
	array( 'Work mode', 'Fully in-person', '865', '58%' ),
	array( 'Work mode', 'Hybrid', '403', '27%' ),
	array( 'Work mode', 'Fully remote', '232', '15%' ),
);

?>
<section class="content content--shadow-workforce" aria-label="<?php esc_attr_e( 'Shadow Workforce Report', 'gc-v2' ); ?>">
	<div class="container">
		<div class="frame frame-1">
			<div class="swr-report-opening">
				<div class="swr-report-opening__title">Executive Summary</div>
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<p>
						As organizations embrace remote work, distributed teams, AI tools, contract labor, and global hiring, a new workforce challenge is emerging. Employers increasingly struggle to verify who is actually performing work, whether workers possess the skills they claim, and whether the person they hired is the person doing the job.
						</p>
						<?php
						gc_aar_report_render_image(
							$swr_img( 'frame-1.webp', __( 'Professional reviewing credentials at a desk', 'gc-v2' ) ),
							'aar-report-image swr-report-opening__image'
						);
						?>
					</div>
					<div class="aar-report-split-copy__column">
						<p>
						New data from GCheck, based on a national survey of 1,500 employed U.S. adults, shows that employees are firsthand witnesses to the rise of what is best described as a Shadow Workforce: a growing layer of workers, technologies, and third parties operating behind the scenes, often outside traditional visibility and verification processes.
						</p>
						<div class="panel panel--quote">
							<?php
								gc_aar_report_render_quote(
									array(
										'text'          => '"Not knowing who you are working with is only part of the problem. <strong>Employees increasingly believe organizations are hiring people</strong> who are not who, or what, they claim to be."',
										'wrapper_class' => 'aar-report-quote',
										'text_class'    => 'aar-report-quote__text',
									)
								);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="frame frame-2">
			<div class="swr-report-recognition aar-report-split-copy">
				<div class="aar-report-split-copy__column">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">Working Alongside Strangers</p>
						<h2 class="swr-report-recognition__title" id="swr-report-section-recognition-gap">
							Employees Say They Do Not<br class="swr-report-br-desktop" aria-hidden="true"> Really Know Who They Work<br class="swr-report-br-desktop" aria-hidden="true"> With
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					Remote and hybrid work has widened a basic visibility gap: many employees could not identify colleagues in person, or say they would not know if a coworker was doing their job at all.
					</p>
				</div>
				<div class="swr-report-recognition__media aar-report-split-copy__column">
					<?php
					gc_aar_report_render_image(
						$swr_img( 'frame-2.webp', __( 'Employee working remotely while on a phone call', 'gc-v2' ), 'right' ),
						'swr-report-recognition__image'
					);
					?>
				</div>
			</div>
			<div class="panel panel--stat-cards no-card-icon">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => '',
						'intro'   => '',
						'columns' => 3,
						'cards'   => array(
							array(
								'value' => '52%',
								'text' => 'say remote and hybrid work has made it harder to truly know their coworkers.',
							),
							array(
								'value' => '24%',
								'text' => 'say they would not recognize many colleagues in person, rising to 40% among fully remote workers versus 19% for fully in-person workers.',
							),
							array(
								'value' => '36%',
								'text' => 'say they would not know if coworkers were actually performing their jobs throughout the day.',
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_figure_card_graph(
					array(
						'badge'       => 'Figure 1',
						'title'       => 'Remote work widens the recognition gap',
						'subtitle'    => 'Employees who say they would not recognize many colleagues in person, by work arrangement.',
						'orientation' => 'vertical',
						'max'         => 50,
						'motion'   => true,
						'bars'     => $recognition_gap_bars,
						'footer'   => 'Base: 1,500 employed U.S. adults, weighted.  |  GCheck Shadow Workforce Report 2026',
					)
				);
				?>
			</div>
		</div>

		<div class="frame frame-3">
			<div class="swr-report-recognition swr-report-recognition--no-image">
				<div class="swr-report-recognition__copy">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">Faking it to make it</p>
						<h2 class="swr-report-recognition__title" id="swr-report-section-faking-it">
						Employees Believe Hiring Is Gamed at Nearly Every Stage
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					Not knowing who you work with is only part of the problem. Employees increasingly believe organizations are hiring people who are not as qualified as they claim, and in some cases, are not who they claim to be at all.
					</p>
					<div class="aar-report-split-copy gap-40">
						<div>
						Nearly three-quarters (71%) say they have worked with someone who turned out not to be what they claimed professionally, while 81% have worked for an organization that hired someone who ultimately could not perform the job. More than three-quarters (77%) have had to cover for, fix, or take on extra work because a coworker lacked the necessary skills, including 22% who do so frequently.
						</div>
						<div>
						Employees are not just questioning whether people can do the job. They are questioning whether they are doing the job at all: nearly 1 in 3 believe coworkers have had other people perform work on their behalf (30%), and a similar share believe coworkers are working multiple jobs during the workday (30%).
						</div>
					</div>
				</div>
			</div>
			<div class="swr-report-recognition__media">
				<?php
				gc_aar_report_render_image(
					$swr_img( 'frame-3.webp', __( 'Employee meeting with a coworker', 'gc-v2' ), 'right' ),
					'swr-report-recognition__media'
				);
				?>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_figure_card_graph(
					array(
						'badge'       => 'Figure 2',
						'title'       => 'Hiring Is Gamed at Nearly Every Stage',
						'subtitle'    => 'Share agreeing with each statement about how candidates and coworkers present themselves.',
						'orientation' => 'horizontal',
						'max'         => 100,
						'motion'      => true,
						'bars'        => $hiring_gaming_bars,
						'footer'      => 'Base: 1,500 employed U.S. adults, weighted.  |  GCheck Shadow Workforce Report 2026',
					)
				);
				?>
			</div>
		</div>

		<div class="frame frame-4">
			<div class="swr-report-recognition aar-report-split-copy">
				<div class="aar-report-split-copy__column">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">The Illusion of Productivity</p>
						<h2 class="swr-report-recognition__title" id="swr-report-section-recognition-gap">
						Appearing Productive Creates Cover for the Shadow Workforce
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					The Shadow Workforce often hides in plain sight, blending into everyday activity and making it harder to separate meaningful work from visible activity.					
					</p>
					<p class="swr-report-recognition__body">
					Many employees (84%) believe coworkers exaggerate how busy they are, while nearly half (45%) believe colleagues intentionally create the appearance of productivity without actually being productive. Workers themselves admit to engaging in behaviors that blur the line between activity and output.					
					</p>
				</div>
				<div class="swr-report-recognition__media aar-report-split-copy__column">
					<?php
					gc_aar_report_render_image(
						$swr_img( 'frame-4.webp', __( 'Employee wearing a mask', 'gc-v2' ), 'right' ),
						'swr-report-recognition__image'
					);
					?>
				</div>
			</div>
			<div class="panel panel--stat-cards no-card-icon">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => '',
						'intro'   => '',
						'columns' => 3,
						'cards'   => array(
							array(
								'value' => '17%',
								'text' => 'have pretended to be working while doing something else.',
							),
							array(
								'value' => '14%',
								'text' => 'have used AI to complete work while allowing employers to believe they completed it themselves, especially common among Gen Z (22%) and Millennials (21%), versus Gen X (8%) and Boomers (2%).',
							),
							array(
								'value' => '8%',
								'text' => 'admit taking credit for work completed by someone or something else.',
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_figure_card_graph(
					array(
						'badge'       => 'Figure 3',
						'title'       => 'Younger workers are far likelier to pass off AI work as their own',
						'subtitle'    => 'Used AI to complete work while letting employers believe they did it themselves, by generation.',
						'orientation' => 'vertical',
						'max'         => 30,
						'motion'   => true,
						'bars'     => $ai_generation_bars,
						'footer'   => 'Base: 1,500 employed U.S. adults, weighted. Boomer estimate directional (n<100).',
					)
				);
				?>
			</div>
		</div>

		<div class="frame frame-5">
			<div class="swr-report-recognition swr-report-recognition--no-image">
			<div class="swr-report-recognition__copy">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">The Executive Exception</p>
						<h2 class="swr-report-recognition__title" id="swr-report-section-faking-it">
						Covert AI Use Rises With Seniority
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					Seniority runs in a direction many would not expect. Rather than declining as responsibility rises, quietly passing off AI work climbs with rank.
					</p>
					<div class="aar-report-split-copy gap-40">
						<div>
						Fewer than 1 in 10 individual contributors (9%) report quietly passing off AI work, compared with 18% of managers and 30% of senior leaders and executives. Because the three groups are similar in age, this is not a generational effect. The people most responsible for setting standards are the likeliest to sidestep the honesty they expect of their teams.
						</div>
						<div>
						Employees also report other behaviors that make workplace activity harder to verify, including manipulating online status indicators (11%), working another job during work hours (8%), and delegating substantial portions of work without employer knowledge (7%).
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_figure_card_graph(
					array(
						'badge'       => 'Figure 4',
						'title'       => 'Covert AI use rises with seniority',
						'subtitle'    => 'Used AI to complete work while letting employers believe they did it themselves, by role.',
						'max'         => 40,
						'motion'   => true,
						'bars'     => $ai_role_bars,
						'footer'   => 'Base: 1,500 employed U.S. adults, weighted.',
					)
				);
				?>
			</div>
		</div>

		<div class="frame frame-6">
			<div class="swr-report-recognition aar-report-split-copy">
				<div class="aar-report-split-copy__column">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">Ghost Workers</p>
						<h2 class="swr-report-recognition__title" id="swr-report-section-recognition-gap">
						Ghost Workers Are the Most Extreme Form of the Shadow Workforce
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					Most employees have never heard the term "ghost worker," someone who uses a stolen or fake identity to get hired, or who has someone else do their job. Yet many have already observed the behaviors associated with one.					
					</p>
				</div>
				<div class="swr-report-recognition__media aar-report-split-copy__column">
					<div class="panel panel--stat-cards no-card-icon">
						<?php
						gc_aar_report_render_stat_cards(
							array(
								'title'   => '',
								'intro'   => '',
								'columns' => 1,
								'cards'   => array(
									array(
										'value' => '28%',
										'text' => 'have suspected a coworker was not the person hired',
									),
									array(
										'value' => '33%',
										'text' => 'have either heard of or personally know of situations where someone was offered money to let another person use their identity or work authorization to obtain employment.',
									),
								),
							)
						);
						?>
					</div>
				</div>
			</div>
			<div class="swr-report-recognition__body">
			Employees point to a growing list of warning signs associated with potential ghost worker activity, from repeated excuses for missed work to sudden changes in communication style.					
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_figure_card_graph(
					array(
						'badge'       => 'Figure 5',
						'title'       => 'The Warning Signs Employees Notice Most',
						'subtitle'    => 'Behaviors that have made employees question a coworker\'s credibility.',
						'orientation' => 'horizontal',
						'max'         => 100,
						'motion'      => true,
						'bars'        => $warning_signs_bars,
						'footer'      => 'Base: 1,500 employed U.S. adults, weighted.',
					)
				);
				?>
			</div>
		</div>

		<div class="frame frame-7">
			<div class="swr-report-recognition swr-report-recognition--no-image">
				<div class="swr-report-recognition__copy">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">Verification Becomes the New Workforce Imperative</p>
						<h2 class="swr-report-recognition__title" id="swr-report-section-faking-it">
						The Assurance of a One-Time Check Starts to Decay the Moment Onboarding Ends
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					Ghost workers may be the most extreme expression of the Shadow Workforce, but the findings suggest the conditions that allow them to exist are already taking shape.
					</p>
				</div>
			</div>

			<div class="swr-report-concept">
				<img
					src="<?php echo esc_url( $swr_images_uri . '/frame-6.webp' ); ?>"
					alt=""
					class="swr-report-concept__bg"
					loading="lazy"
					decoding="async"
					aria-hidden="true"
				>
				<div class="swr-report-concept__content">
					<div class="swr-report-concept__content-inner">
					<p class="swr-report-concept__eyebrow">The Concept</p>
					<h2 class="swr-report-concept__title">The Verification Half-Life™</h2>
					</div>
					<p class="swr-report-concept__body">
						The assurance an employer buys with a one-time background check at hire begins to decay the moment onboarding ends. A background check confirms identity, history, and credentials as they stand on a single day, and nothing reconfirms that the person hired is still who they were, still qualified, and still the one doing the work. Every day since the last check leaves an employer knowing a little less than it thinks it does.
					</p>
					<div class="swr-report-concept__stat">
						<span class="swr-report-concept__stat-value">97%</span>
						<span class="swr-report-concept__stat-text">believe misrepresenting skills or identity creates business risk, including 52% who say it creates significant risk.</span>
					</div>
				</div>
			</div>
			
			<div class="swr-report-recognition__verification aar-report-split-copy">
				<div class="aar-report-split-copy__column">
					<p class="swr-report-recognition__body">
						Yet employees have little confidence that current safeguards are sufficient. Only 14% believe employers are doing enough today to verify workers, while fewer than 1 in 4 (24%) are very confident their employer would catch someone who significantly misrepresented their skills, experience, or identity.					
					</p>
					<div class="panel panel--graphs">
						<?php
						gc_aar_report_render_figure_card_graph(
							array(
								'badge'       => '',
								'title'       => '',
								'subtitle'    => '',
								'orientation' => 'horizontal',
								'max'         => 100,
								'motion'      => true,
								'bars'        => $verification_confidence_bars,
								'footer'      => '',
							)
						);
						?>
					</div>
				</div>
				<div class="swr-report-recognition__media aar-report-split-copy__column">
					<?php
					gc_aar_report_render_image(
						$swr_img( 'frame-7.webp', __( 'Employee wearing a mask', 'gc-v2' ), 'right' ),
						'swr-report-recognition__image'
					);
					?>
				</div>
			</div>
		</div>

		<div class="frame frame-8">
			<div class="swr-report-concept__media">
				<?php
				gc_aar_report_render_image(
					$swr_img( 'frame-8.webp', __( 'Operational Responses to the Verification Half-Life™', 'gc-v2' ), 'left' ),
					'swr-report-recognition__media'
				);
				?>
			</div>
			<div class="swr-report-recognition swr-report-recognition--no-image">
				<div class="swr-report-recognition__copy">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">Operational Responses</p>
						<h2 class="swr-report-recognition__title" id="swr-report-section-faking-it">
						Operational Responses to the Verification Half-Life™
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					A background check is a snapshot in time, accurate the day it runs and no longer. Each response below resets the clock, reconfirming identity, capability, or accountability rather than assuming it after day one.
					</p>
				</div>
			</div>
			<div class="panel panel--stat-cards no-card-icon panel--stat-cards--feature">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => '',
						'intro'   => '',
						'columns' => 3,
						'cards'   => array(
							array(
								'value'  => 'Verification Bound to the Person',
								'text'   => 'A reusable, biometric-bound identity credential, re-presented at each checkpoint, so the person who verified is the one who shows up.',
								'accent' => '33% know of identity-for-hire schemes',
							),
							array(
								'value'  => 'Source Verification, Not Self-Report',
								'text'   => 'Employment, education, and credentials confirmed directly with the source, closing the gaps embellishment depends on.',
								'accent' => '57% say candidates exaggerate experience',
							),
							array(
								'value'  => 'Same Checks, Same Job Category',
								'text'   => 'Every hire in the same job category gets the same checks, with human review of findings, so results stay consistent and compliant.',
								'accent' => '54% want consistent checks within job category',
							),
							array(
								'value'  => 'Transparency as a Talent Magnet',
								'text'   => 'Verification standards stated up front, discouraging embellishment and attracting candidates who value integrity.',
								'accent' => '40% want transparency into what is verified',
							),
							array(
								'value'  => 'Continuous Monitoring, Matched to Your Risk',
								'text'   => 'Ongoing rescreening reruns the checks that matter most for the industry: criminal records, licenses, drug testing, healthcare sanctions, and MVR.',
								'accent' => '37% want verification that continues after day one',
							),
						),
					)
				);
				?>
			</div>
		</div>

		<div class="frame frame-9">
			<div class="panel panel--table panel--mandate-table">
				<h3 class="aar-methodology__table-title" id="swr-report-mandate-table">Mapping the Mandate to Compliance for Good®</h3>
				<p class="aar-methodology__table-subtitle">The Compliance for Good framework rests on three pillars: Transparent Compliance, Fair Compliance, and Protective Compliance. The 2026 data operates as the framework's operating agenda for the Shadow Workforce era.</p>
				<div class="aar-methodology__content">
					<?php
					gc_aar_report_render_data_table(
						array(
							'column_widths' => array( 28, 44, 28 ),
							'columns'       => $mandate_columns,
							'rows'          => $mandate_rows,
						)
					);
					?>
				</div>
			</div>
		</div>

		<div class="frame frame-10">
			<div class="swr-report-recognition aar-report-split-copy">
				<div class="aar-report-split-copy__column">
					<div class="swr-report-recognition__heading">
						<p class="swr-report-recognition__eyebrow">The Bottom Line</p>
						<h2 class="swr-report-recognition__title aar-report-title--line-break" id="swr-report-section-recognition-gap">
						The Challenge Is No Longer <br>Simply Verifying Workers at the Point of Hire
						</h2>
					</div>
					<p class="swr-report-recognition__body">
					Ghost workers may be the most extreme expression of the Shadow Workforce, but the findings suggest the conditions that allow them to exist are already taking shape. They are a warning sign of a broader workforce challenge: one where organizations increasingly struggle to verify who workers are, what they are capable of doing, and whether they are actually doing the work they were hired to do.					
					</p>
					<p class="swr-report-recognition__body">
					As work becomes more digital, distributed, and AI-enabled, those questions become harder to answer, and more important for employers to get right. The challenge is no longer simply verifying workers at the point of hire. It is maintaining confidence that the person hired remains the person doing the work, that critical skills are genuine, and that accountability does not disappear after onboarding.					
					</p>
				</div>
				<div class="swr-report-recognition__media aar-report-split-copy__column">
					<?php
					gc_aar_report_render_image(
						$swr_img( 'frame-5.webp', __( 'Message from employees: the assumption that the person hired is the person doing the work can no longer be taken for granted.', 'gc-v2' ), 'right' ),
						'swr-report-recognition__image'
					);
					?>
					<div class="swr-report-recognition__content">
						<p class="swr-report-recognition__body">
						The message from employees is clear: the assumption that the person hired is the person doing the work can no longer be taken for granted.					
						</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>

	<div class="frame frame-11">
		<div class="container">
			<div class="panel panel--table panel--mandate-table">
				<h3 class="aar-methodology__table-title" id="swr-report-methodology-table">Methodology</h3>
				<p class="aar-methodology__table-subtitle">Findings are based on a GCheck survey of 1,500 employed U.S. adults, fielded in June 2026 via Pollfish and weighted, with a margin of error of approximately ±2.5% at 95% confidence, wider for subgroups. Employees' own reported behaviors and their perceptions of colleagues are reported separately and never combined in a single figure. Subgroups below 100 respondents, most notably Baby Boomers, are shown for directional comparison only.</p>
				<div class="aar-methodology__content">
					<?php
					gc_aar_report_render_data_table(
						array(
							'column_widths' => array( 28, 28, 22, 22 ),
							'columns'       => $methodology_columns,
							'rows'          => $methodology_rows,
							'footnote'      => 'All figures are weighted proportions, rounded to whole numbers, so a total may differ from its components by a point. Single-select questions report the share choosing a response; multi-select questions report the share selecting each item, so their totals can exceed 100%. Where a question was asked of a subset, the base is that subset. No index or composite scores are used.',
						)
					);
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="frame frame-12">
		<div class="container">
			<div class="swr-report-related">
				<div class="swr-report-related__intro">
					<p class="swr-report-related__eyebrow">Related GCheck Research</p>
					<h2 class="swr-report-related__title">
					The Rise of the Shadow Workforce is the third study in a GCheck <br>research trilogy examining trust across the employment lifecycle.
					</h2>
				</div>
				<div class="swr-report-related__grid">
					<article class="swr-report-related__card">
						<div class="swr-report-related__media">
							<?php
							gc_aar_report_render_image(
								$swr_img( 'frame-9.webp', __( 'The 2026 Trust in Hiring Report cover', 'gc-v2' ) ),
								'swr-report-related__image'
							);
							?>
						</div>
						<div class="swr-report-related__body">
							<h3 class="swr-report-related__card-title">
							The 2026 Trust in Hiring Report
						</h3>
							<p class="swr-report-related__card-text">
							Why candidates exaggerate and misrepresent themselves — and what it means for hiring integrity.
							</p>
							<a class="swr-report-related__link" href="<?php echo esc_url( home_url( '/whitepapers/trust-in-hiring-report/' ) ); ?>">
							Read the report <span aria-hidden="true">&rarr;</span>
							</a>
						</div>
					</article>
					<article class="swr-report-related__card">
						<div class="swr-report-related__media">
							<?php
							gc_aar_report_render_image(
								$swr_img( 'frame-10.webp', __( 'The Automation Anxiety Report 2026 cover', 'gc-v2' ) ),
								'swr-report-related__image'
							);
							?>
						</div>
						<div class="swr-report-related__body">
							<h3 class="swr-report-related__card-title">
							The Automation Anxiety Report 2026
							</h3>
							<p class="swr-report-related__card-text">
							How AI is reshaping worker confidence and inflating the skills gap in the workplace.
							</p>
							<a class="swr-report-related__link" href="<?php echo esc_url( home_url( '/whitepapers/automation-anxiety-report/' ) ); ?>">
							Read the report <span aria-hidden="true">&rarr;</span>
							</a>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
</section>
