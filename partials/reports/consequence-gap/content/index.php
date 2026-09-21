<?php
/**
 * Consequence Gap report body content.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/partials/reports/automation-anxiety/shared/content.php';
require_once get_template_directory() . '/partials/reports/consequence-gap/content/split-figure-card-graph.php';

$cgr_images_uri = get_template_directory_uri() . '/partials/reports/consequence-gap/content/images';
$cgr_img        = static function ( $file, $alt ) use ( $cgr_images_uri ) {
	return array(
		'src' => $cgr_images_uri . '/' . ltrim( $file, '/' ),
		'alt' => $alt,
	);
};

$cgr_room_got_tougher_bars = array(
	array( 'label' => 'More cynical than I used to be', 'value' => 40, 'tone' => 'royal' ),
	array( 'label' => 'Trust my coworkers less than I once did', 'value' => 40, 'tone' => 'royal' ),
	array( 'label' => 'More drained or short-tempered', 'value' => 40, 'tone' => 'royal' ),
	array( 'label' => 'Workplace tone has gotten worse', 'value' => 31, 'tone' => 'royal' ),
);

$cgr_the_bill_lands_on_the_bystanders_bars = array(
	array( 'label' => 'Dread about the workday increased', 'value' => 55, 'tone' => 'royal' ),
	array( 'label' => 'Short temper or irritability increased', 'value' => 49, 'tone' => 'royal' ),
	array( 'label' => 'Cynicism about work increased', 'value' => 40, 'tone' => 'royal' ),
	array( 'label' => 'Trust in coworkers decreased', 'value' => 39, 'tone' => 'royal' ),
	array( 'label' => 'Motivation or engagement decreased', 'value' => 32, 'tone' => 'royal' ),
	array( 'label' => 'Patience with others decreased', 'value' => 27, 'tone' => 'royal' ),
);

$cgr_era_exposed_bars = array(
	array( 'label' => 'Cynical', 'value' => 43, 'tone' => 'royal' ),
	array( 'label' => 'Trust less', 'value' => 44, 'tone' => 'royal' ),
	array( 'label' => 'Drained', 'value' => 42, 'tone' => 'royal' ),
	array( 'label' => 'Tone worse', 'value' => 34, 'tone' => 'royal' ),
);

$cgr_era_never_exposed_bars = array(
	array( 'label' => 'Never', 'value' => 25, 'tone' => 'black' ),
	array( 'label' => 'Never', 'value' => 20, 'tone' => 'black' ),
	array( 'label' => 'Never', 'value' => 24, 'tone' => 'black' ),
	array( 'label' => 'Never', 'value' => 15, 'tone' => 'black' ),
);

$cgr_what_happened_to_the_toxic_colleague_bars = array(
	array( 'label' => 'Adopted it', 'value' => 36, 'tone' => 'royal' ),
	array( 'label' => 'Changed for the worse', 'value' => 42, 'tone' => 'royal' ),
	array( 'label' => 'Saw it spread', 'value' => 58, 'tone' => 'royal' ),
	array( 'label' => 'Came through unchanged', 'value' => 28, 'tone' => 'royal' ),
);

$cgr_what_happened_to_the_toxic_colleague_removed_bars = array(
	array( 'label' => 'Removed', 'value' => 14, 'tone' => 'black' ),
	array( 'label' => 'Removed', 'value' => 20, 'tone' => 'black' ),
	array( 'label' => 'Removed', 'value' => 27, 'tone' => 'black' ),
	array( 'label' => 'Removed', 'value' => 55, 'tone' => 'black' ),
);

$cgr_what_would_most_help_keep_toxic_behavior_from_spreading_at_work_bars = array(
	array( 'label' => 'Managers addressing it early', 'value' => 61, 'tone' => 'royal' ),
	array( 'label' => 'Real consequences regardless of performance', 'value' => 52, 'tone' => 'royal' ),
	array( 'label' => 'Keeping and protecting the good people', 'value' => 50, 'tone' => 'royal' ),
	array( 'label' => 'A safe way to raise concerns', 'value' => 46, 'tone' => 'royal' ),
	array( 'label' => 'Leadership modeling better behavior', 'value' => 41, 'tone' => 'royal' ),	
);

$cgr_methodology_columns = array(
	'Design element',
	'Specification',
);

$cgr_methodology_rows = array(
	array( 'Sample', '1,500 US adults employed full-time, via Pollfish, census-weighted on age, gender, and region. Non-probability opt-in panel, with a modeled error estimate of about plus or minus 2.5 points on full-sample figures, which is not a classical margin of error.' ),
	array( 'Routing', 'Exposure-routed: 1,272 exposed workers answered the full instrument; 228 never-exposed answered baseline items only.' ),
	array( 'Key bases', 'Exposed 1,272; admitted adopters 254; adopters with an "after" 236; past-exposed 630; reward bands 283 / 477 / 476.' ),
	array( 'Labels', 'Every figure carries a question ID against the fielded instrument (Pollfish survey 395594484), a base n, and an INCIDENCE or PERCEPTION tag.' ),
	array( 'Discipline', 'No composite scores or toxicity index; matrix rows and multi-selects reported individually; no demographic analytical cuts; subgroups under 100 directional, under 30 excluded; whole-percent rounding.' ),
);

$cgr_references = array(
	array(
		'text' => 'GCheck. (2026). The Consequence Gap [Proprietary survey of 1,500 U.S. adults employed full-time].',
		'url'  => 'https://gcheck.com/whitepapers/consequence-gap-report',
	),
	array(
		'text' => 'GCheck. (2026). The 2026 trust in hiring report [Proprietary survey of 1,500 U.S. adults].',
		'url'  => 'https://gcheck.com/whitepapers/trust-in-hiring-report',
	),
	array(
		'text' => 'Society for Human Resource Management. (2019, September 25). SHRM reports toxic workplace cultures cost billions [Press release].',
		'url'  => 'https://www.shrm.org/about/press-room/shrm-reports-toxic-workplace-cultures-cost-billions',
	),
	array(
		'text' => 'U.S. Equal Employment Opportunity Commission. (2016). Select Task Force on the Study of Harassment in the Workplace: Report of co-chairs Chai R. Feldblum and Victoria A. Lipnic.',
		'url'  => 'https://www.eeoc.gov/select-task-force-study-harassment-workplace-report-co-chairs-chai-r-feldblum-victoria-lipnic',
	),
);
?>

<section class="content content--consequence-gap" aria-label="<?php esc_attr_e( 'Consequence Gap Report', 'gc-v2' ); ?>">
	<div class="container">
		<div class="frame">
			<div class="cgr-report-opening">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">Executive Summary</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-executive-summary">
								The Toughness Went <br class="cgr-report-br-desktop" aria-hidden="true">Everywhere Except Where It Was Aimed
							</h2>
						</div>
						<p>
						American workers describe a job market that has hardened around them: four in ten say they have become more cynical than they used to be, trust their coworkers less, and feel more drained or short-tempered than before. Against that backdrop, this study asked a pointed question. When one colleague's behavior consistently makes work life worse, an experience 85% of workers report, what actually happens to that colleague?
						</p>
					</div>
					<div class="aar-report-split-copy__column ">
						<?php
						gc_aar_report_render_image(
							$cgr_img( 'frame-1.webp', __( 'Worker walking through an office at sunset', 'gc-v2' ) ),
							'aar-report-image cgr-report-opening__image'
						);
						?>
					</div>
				</div>

				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<p>
						More than six times in ten, the person the toughness was supposedly for walked away untouched or better off: 38% faced no visible consequence, and 23% were rewarded, promoted, or protected. Only 36% eventually left or were removed. The gap widens with rank. Harmful managers were rewarded or protected far more often than harmful juniors, 36% against 24%, and removed at half the junior rate.
						</p>
					</div>
					<div class="aar-report-split-copy__column">
						<p>
						Everyone else absorbs the cost. Where that colleague was rewarded, workers adopted the behavior at two and a half times the rate, reported double the personal damage, and left the job before that colleague four times as often as where the organization acted. At least 21% of exposed workers admit they started acting like the colleague; asked behavior by behavior, roughly three times as many report at least one change; and 43% of those who adopted it carried it into jobs where the colleague never worked. The report closes with what workers say would stop the spread, and their answer is not a softer workplace. It is consequences that hold regardless of the person's performance.
						</p>
					</div>
				</div>

				<?php
				gc_aar_report_render_quote(
					array(
						'text'          => '&ldquo;The times made work harder.<br><strong>The consequence gap made it personal.</strong>&rdquo;',
						'wrapper_class' => 'cgr-report-opening__quote',
					)
				);
				?>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column cgr-report-premise">
						<div class="cgr-report-premise__intro">
							<div class="cgr-report-opening__heading">
								<p class="cgr-report-opening__eyebrow">The premise</p>
								<h2 class="cgr-report-opening__title" id="cgr-report-the-premise">
								American Work Got Harder. The Accountability Didn't.
								</h2>
							</div>
							<p>
							The standard explanation for a harder workplace is a harder market: tighter standards, leaner teams, tougher management. This study tested the part of that story nobody audits. If workplaces really got tougher on bad behavior, the one colleague whose conduct consistently made work life worse should be the first to feel it. 85% of workers have had one. In more than six in ten of those cases, nothing happened to them, or something good did.
							</p>
						</div>
						<div class="cgr-report-definition">
							<h3 class="cgr-report-definition__title">The Consequence Gap</h3>
							<p>
							The distance between how hard a workplace is on everyone and how hard it is on the specific person making it worse: the colleague whose behavior goes unpunished, or rewarded, while the pressure lands on the people around them.
							</p>
						</div>
					</div>
					<div class="aar-report-split-copy__column">
						<?php
						gc_aar_report_render_image(
							$cgr_img( 'frame-2.webp', __( 'Managers and employees', 'gc-v2' ) ),
							'aar-report-image cgr-report-opening__image'
						);
						?>
					</div>
				</div>

				<div class="panel panel--graphs">
					<?php
					gc_aar_report_render_figure_card_graph(
						array(
							'badge'       => 'Figure 1',
							'title'       => 'Workers Say The Room Got Tougher',
							'subtitle'    => 'Share of all workers agreeing with each statement about how work feels now.',
							'orientation' => 'horizontal',
							'max'         => 100,
							'motion'      => true,
							'bars'        => $cgr_room_got_tougher_bars,
							'footer'      => 'Base: 1,500 employed US adults, weighted. Each statement asked separately. PERCEPTION. | GCheck Consequence Gap 2026',
						)
					);
					?>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="cgr-report-premise">
					<div class="cgr-report-premise__intro">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">Who absorbs it</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-who-absorbs-it">
							The People Who Didn't Cause the Problem Carry It</h2>
						</div>
						<p>
						Workers exposed to a toxic colleague, meaning someone whose behavior consistently made their work life worse, report measurable change in themselves. What the colleague actually did clusters around constant complaining and draining negativity (59%), escalating minor issues or weaponizing rules (51%), directing people without authority (50%), staying friendly in person while undermining privately (49%), and taking credit for others' work (39%).
						</p>
						<p>
						And it is mostly not a boss story. In 47% of cases the toxic colleague was a peer; only 10% named their manager or a leader above them. The most common source of workplace harshness sits at the next desk, which is exactly why blanket toughness from above keeps missing it.
						</p>
						<div>
							<?php
							gc_aar_report_render_image(
								$cgr_img( 'frame-3.webp', __( 'Employee meeting with a coworker', 'gc-v2' ), 'right' ),
								'cgr-report-opening__image'
							);
							?>
						</div>
					</div>
				</div>

				<div class="panel panel--graphs">
					<?php
					gc_aar_report_render_figure_card_graph(
						array(
							'badge'       => 'Figure 2',
							'title'       => 'The bill lands on the bystanders',
							'subtitle'    => 'Change exposed workers report in themselves. Each change asked separately, of the 1,272 workers who have had such a colleague.',
							'orientation' => 'horizontal',
							'max'         => 100,
							'motion'      => true,
							'bars'        => $cgr_the_bill_lands_on_the_bystanders_bars,
							'footer'      => 'Base: 1,272 exposed workers, weighted. INCIDENCE. | GCheck Consequence Gap 2026',
						)
					);
					?>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column cgr-report-premise">
						<div class="cgr-report-premise__intro">
							<div class="cgr-report-opening__heading">
								<p class="cgr-report-opening__eyebrow">The correction</p>
								<h2 class="cgr-report-opening__title" id="cgr-report-the-correction">
								Isn't Everyone Just Meaner Now?
								</h2>
							</div>
							<p>
							Maybe the hardening is just the times. The design anticipated that objection: the workers who have never had such a colleague answered the same questions, and the gap between the groups is what this report claims. A quarter of the never-exposed report rising cynicism too, so some of the strain is simply the era.
							</p>
							<p>
							But exposure widens every erosion measure by 18 to 24 points, roughly doubling the trust and tone complaints. The general hardening of work and the specific damage of an unaddressed colleague are different problems, and the second one has an address.
							</p>
						</div>
					</div>
					<div class="aar-report-split-copy__column">
						<?php
						gc_aar_report_render_image(
							$cgr_img( 'frame-4.webp', __( 'Employee meeting with a coworker', 'gc-v2' ) ),
							'aar-report-image cgr-report-opening__image'
						);
						?>
					</div>
				</div>

				<div class="panel panel--graphs">
					<?php
					gc_cgr_report_render_split_figure_card_graph(
						array(
							'badge'    => 'Figure 3',
							'title'    => 'Some Of It Is The Era. Exposure Roughly Doubles It.',
							'subtitle' => 'Erosion measures among workers who have had a toxic colleague, set beside those who never have.',
							'max'      => 100,
							'motion'   => true,
							'legend'   => array(
								array( 'text' => 'Have had a toxic colleague (1,272)', 'tone' => 'royal' ),
								array( 'text' => 'Never have (228)', 'tone' => 'black' ),
							),
							'columns'  => array(
								array( 'bars' => $cgr_era_exposed_bars ),
								array( 'bars' => $cgr_era_never_exposed_bars ),
							),
							'footer'   => 'Base: 1,272 exposed vs 228 never-exposed, weighted. PERCEPTION. | GCheck Consequence Gap 2026',
						)
					);
					?>
				</div>

				<?php
				gc_aar_report_render_quote(
					array(
						'text'          => '&ldquo;The times made work harder.<br><strong>The consequence gap made it personal.</strong>&rdquo;',
						'wrapper_class' => 'cgr-report-opening__quote',
					)
				);
				?>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">The Bill</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-executive-summary">
							The Exits Follow What the Organization Did, Not What the Colleague Did
							</h2>
						</div>
						<p>
						Where the colleague was rewarded, four in ten workers left the job before that colleague did. Where the organization acted, one in ten. The Society for Human Resource Management has estimated that culture-driven turnover cost US organizations as much as $223 billion over five years (SHRM, 2019); this comparison shows how that bill gets run up, one team at a time. Turnover in these workplaces is not a mystery force. It is the bill for the consequence gap, paid by the people the toughness was never meant for.
						</p>
						<p>
						Workers also believe they can see the pattern: 44% say the best or healthiest people leave first when a toxic colleague goes unaddressed. The lived record is more mixed. Among past cases, the toxic colleague more often left first, 57%. Both are true at once: most toxic colleagues do eventually go, and where they are protected instead, the departures shift decisively to everyone else.
						</p>
					</div>
					<div class="aar-report-split-copy__column cgr-report-opening__graph">
					<div class="panel panel--graphs">
						<?php
						gc_aar_report_render_figure_card_graph(
							array(
								'badge'       => 'Figure 4',
								'title'       => 'Who left first: the worker or the toxic colleague?',
								'subtitle'    => 'Share of workers who left the job while the toxic colleague stayed, by what the organization did.',
								'orientation' => 'horizontal',
								'max'         => 100,
								'motion'      => true,
								'bars'        => array(
									array( 'label' => 'Colleague was rewarded or protected', 'value' => 40, 'tone' => 'royal' ),
									array( 'label' => 'Nothing happened to them', 'value' => 24, 'tone' => 'royal' ),
									array( 'label' => 'Colleague was removed', 'value' => 10, 'tone' => 'royal' ),
								),
								'footer'      => 'Base: reward bands of 283, 477, and 476 exposed workers, weighted. A pattern, not proof of cause. INCIDENCE. | GCheck Consequence Gap 2026',
							)
						);
						?>
					</div>
					</div>
				</div>

				<?php
				gc_aar_report_render_quote(
					array(
						'text'          => '&ldquo;Everyone got harder to be around <br>except the person who should have.&rdquo;',
						'wrapper_class' => 'cgr-report-opening__quote',
					)
				);
				?>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="cgr-report-feature" style="background-image: url(<?php echo esc_url( $cgr_images_uri . '/frame-5.webp' ); ?>);">
					<div class="cgr-report-feature__panel">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">Who receives it</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-who-receives-it">
							The Higher the Rank, the <br class="cgr-report-br-desktop" aria-hidden="true">Softer the Consequences
							</h2>
						</div>
						<p>
						In the era of tightened performance standards, workers saw harmful senior colleagues get protected more often than harmful junior ones, 36% against 24%, and removed at half the rate, 21% against 41%. Accountability, as experienced from below, flows downhill.<br><br>
						The damage flows the other way. Exposed to a toxic manager or senior leader, 76% of workers report increased dread about the workday, against 53% when the toxic colleague was a peer, and the share who say the exposure changed them for the worse rises from 26% to 36%. The cases the system is least willing to touch are the ones that hurt the most.						</p>
					</div>
				</div>

				<div class="panel panel--graphs">
					<?php
					gc_cgr_report_render_split_figure_card_graph(
						array(
							'badge'    => 'Figure 5',
							'title'    => 'What Happened To The Toxic Colleague, By Their Rank',
							'subtitle' => 'Comparing the outcomes workers saw for a toxic manager against a toxic junior colleague.',
							'max'      => 100,
							'motion'   => true,
							'legend'   => array(
								array( 'text' => 'Rewarded or protected', 'tone' => 'royal' ),
								array( 'text' => 'Removed or left', 'tone' => 'black' ),
							),
							'columns'  => array(
								array(
									'heading' => 'Toxic manager or senior leader (119 cases, directional)',
									'bars'    => array(
										array( 'label' => 'Rewarded or protected', 'value' => 36, 'tone' => 'royal' ),
										array( 'label' => 'Removed or left', 'value' => 21, 'tone' => 'royal' ),
									),
								),
								array(
									'heading' => 'Toxic junior colleague (342 cases)',
									'bars'    => array(
										array( 'label' => 'Rewarded or protected', 'value' => 24, 'tone' => 'black' ),
										array( 'label' => 'Removed or left', 'value' => 41, 'tone' => 'black' ),
									),
								),
							),
							'footer'   => 'Toxic peers (603 cases) sit between: 20% rewarded, 37% removed. Manager cases are a smaller group; read as directional. PERCEPTION of outcome.
							| GCheck Consequence Gap 2026',
						)
					);
					?>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="cgr-report-premise">
					<div class="cgr-report-premise__intro">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">What it costs</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-who-absorbs-it">
							When Bad Behavior Gets Rewarded, Everyone Notices</h2>
						</div>
						<div class="panel panel--graphs">
							<?php
							gc_cgr_report_render_split_figure_card_graph(
								array(
									'badge'    => 'Figure 6',
									'title'    => 'Outcomes among exposed workers, by what happened to the colleague',
									'subtitle' => 'Comparing the 283 workers whose colleague was rewarded with the 476 whose colleague was removed.',
									'max'      => 100,
									'motion'   => true,
									'legend'   => array(
										array( 'text' => 'Colleague rewarded or protected', 'tone' => 'royal' ),
										array( 'text' => 'Colleague removed', 'tone' => 'black' ),
									),
									'columns'  => array(
										array( 'bars' => $cgr_what_happened_to_the_toxic_colleague_bars ),
										array( 'bars' => $cgr_what_happened_to_the_toxic_colleague_removed_bars ),
									),
									'footer'   => 'Base: 1,272 exposed workers, weighted. INCIDENCE. | GCheck Consequence Gap 2026',
								)
							);
							?>
						</div>
					</div>
				</div>
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<p>
						The single variable that organizes the study is not the toxic colleague. It is what the organization did in response. Where the colleague was rewarded or protected, adoption of the behavior ran two and a half times higher, twice as many workers said the exposure changed them for the worse, and twice as many saw it spread to others. The number of workers who came through unchanged fell by half: rewarded toxicity leaves almost no bystanders. Adopters name the mechanism themselves; a third of those who admit picking up the behavior say they did it because that behavior got rewarded there.
						</p>
						<p>
						The same comparison holds a quieter finding. Workers who say the experience changed them for the better saw their colleague removed at nearly twice the rate of workers changed for the worse, 42% against 24%. A workplace that visibly resolves the problem appears to teach a different lesson than one that shrugs.
						</p>
					</div>
					<div class="aar-report-split-copy__column">
						<?php
						gc_aar_report_render_image(
							$cgr_img( 'frame-6.webp', __( 'Two employees talking in an office', 'gc-v2' ) ),
							'aar-report-image cgr-report-opening__image'
						);
						?>
					</div>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="cgr-report-premise">
					<div class="cgr-report-premise__intro">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">The contagion, up close</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-who-absorbs-it">
							One in Five Admit They Caught It. Three Times as Many Show It.</h2>
						</div>
						<div class="aar-report-split-copy">
							<div class="aar-report-split-copy__column">
								<p>
								Asked the global question, most workers say no; 21% admit they started acting like the colleague, even a little, and the true number is almost certainly higher. Asked behavior by behavior, 62% report at least one change they noticed in themselves, including 55% of the workers who had just declined the admission. The gap between what people admit and what they report doing is itself the finding. Drift is mostly invisible from the inside.
								</p>
							</div>
							<div class="aar-report-split-copy__column">
								<p>
								The motives make these workers the casualties of the consequence gap, not its beneficiaries: 94% of adopters cite at least one coping motive, to cope with the stress (57%), to protect themselves (49%), to stop being taken advantage of (47%), while purely competitive motives are rare. People were protecting themselves, not auditioning for promotion.
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel--graphs">
					<?php
					gc_aar_report_render_figure_card_graph(
						array(
							'badge'       => 'Figure 7',
							'title'       => 'Admitting it versus showing it',
							'subtitle'    => 'The same 1,272 exposed workers, asked two different ways. "None of these" was always an option.',
							'orientation' => 'horizontal',
							'max'         => 100,
							'motion'      => true,
							'bars'        => array(
								array( 'label' => 'Admit acting like the colleague', 'value' => 21, 'tone' => 'royal' ),
								array( 'label' => 'Report at least one adopted behavior', 'value' => 62, 'tone' => 'royal' ),
								array( 'label' => 'Said no or not sure, yet report a behavior', 'value' => 55, 'tone' => 'royal' ),
							),
							'footer'      => 'Base: 1,272 exposed workers, weighted. INCIDENCE. | GCheck Consequence Gap 2026',
						)
					);
					?>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">The mechanics</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-executive-summary">
							Proximity Is the Dose; <br class="cgr-report-br-desktop" aria-hidden="true">Negativity Travels First
							</h2>
						</div>
						<p>
						The spread moves through contact. Adoption runs at 7% for workers in occasional contact, 14% for those working nearby, and 26% for those on the same team in daily contact. How closely people worked together mattered; how long they endured it mattered much less.
						</p>
						<p>
						Not every behavior travels equally. Among workers who adopted anything, constant negativity was picked up most often, by 66%. And a toxic colleague does not need company: 65% of workers say one toxic person is enough to change a whole team's tone, a belief that runs highest, at 72%, among the workers whose organization removed the colleague. The people most convinced a single person matters are the ones who saw intervention work. 77% of exposed workers saw the behavior rub off on others, 36% clearly.
						</p>
					</div>
					<div class="aar-report-split-copy__column cgr-report-opening__graph">
						<div class="panel panel--graphs">
							<?php
							gc_aar_report_render_figure_card_graph(
								array(
									'badge'       => 'Figure 8',
									'title'       => 'Adoption, by how closely they worked with the colleague',
									'subtitle'    => 'Share of exposed workers who adopted the behavior.',
									'orientation' => 'horizontal',
									'max'         => 100,
									'motion'      => true,
									'bars'        => array(
										array( 'label' => 'Occasional (directional)', 'value' => 7, 'tone' => 'royal' ),
										array( 'label' => 'Regular contact', 'value' => 14, 'tone' => 'royal' ),
										array( 'label' => 'Same team, daily', 'value' => 26, 'tone' => 'royal' ),
									),
									'footer'      => 'Base: exposed workers, weighted. INCIDENCE. Negativity was re-adopted by 66% of adopters, the behavior most likely to rub off. | GCheck Consequence Gap 2026',
								)
							);
							?>
						</div>
					</div>
				</div>

				<div>
					<?php
					gc_aar_report_render_image(
						$cgr_img( 'frame-7.webp', __( 'Two employees talking in an office', 'gc-v2' ) ),
						'aar-report-image cgr-report-opening__image'
					);
					?>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<div class="cgr-report-opening__heading">
							<p class="cgr-report-opening__eyebrow">The longest cost</p>
							<h2 class="cgr-report-opening__title" id="cgr-report-the-longest-cost">
							Most People Heal. The Habits Travel<br class="cgr-report-br-desktop" aria-hidden="true">Anyway.							
							</h2>
						</div>
						<p>
						Recovery is the norm once the exposure ends: 58% of past-exposed workers bounced back quickly, 77% felt like themselves within weeks, and 71% say they fully recovered. The part that lasts is the costly part. One in ten never fully returned, 14% say some changes became permanent, and among those who admit adopting the behavior, more than four in ten still notice it in how they work, inside companies the original colleague never entered. Moods recover; habits travel. This is how one organization's consequence gap becomes another organization's culture problem.
						</p>
						<div class="cgr-report-stat-callout">
							<p class="cgr-report-stat-callout__value">43%</p>
							<p class="cgr-report-stat-callout__text">
							Base: the 236 workers who picked up the behavior and later worked somewhere the colleague was not. Their own account; a pattern, not proof.
							</p>
						</div>
					</div>
					<div class="aar-report-split-copy__column cgr-report-opening__media">
						<?php
						gc_aar_report_render_image(
							$cgr_img( 'frame-8.webp', __( 'Worker walking outdoors with a backpack and coffee', 'gc-v2' ) ),
							'aar-report-image cgr-report-opening__image'
						);
						?>
					</div>
				</div>

				<div class="cgr-report-journey" aria-label="<?php esc_attr_e( 'How the habit travels', 'gc-v2' ); ?>">
					<div class="cgr-report-journey__step">
						<h3 class="cgr-report-journey__title">1. At The Toxic Job</h3>
						<p>The worker starts picking up the colleague's behavior. At least 1 in 5 exposed workers admit this happened to them.</p>
					</div>
					<span class="cgr-report-journey__arrow" aria-hidden="true">
						<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M8.33594 20H31.6693" stroke="#CDD6E0" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20 8.3335L31.6667 20.0002L20 31.6668" stroke="#CDD6E0" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					<div class="cgr-report-journey__step">
						<h3 class="cgr-report-journey__title">2. They Move On</h3>
						<p>The mood recovers fast: most feel like their normal selves again within weeks.</p>
					</div>
					<span class="cgr-report-journey__arrow" aria-hidden="true">
						<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M8.33594 20H31.6693" stroke="#CDD6E0" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20 8.3335L31.6667 20.0002L20 31.6668" stroke="#CDD6E0" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					<div class="cgr-report-journey__step cgr-report-journey__step--dark">
						<h3 class="cgr-report-journey__title">3. At The Next Job</h3>
						<p>The habit rides along: 43% of those who picked up the behavior say it still shows up in how they work.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening">
				<div class="cgr-report-premise__intro">
					<div class="cgr-report-opening__heading">
						<p class="cgr-report-opening__eyebrow">The ask</p>
						<h2 class="cgr-report-opening__title" id="cgr-report-the-correction">
						The Demand Is Aim, Not Amnesty
						</h2>
					</div>	
					<div class="aar-report-split-copy">
						<div class="aar-report-split-copy__column">
							<p>
							Nothing workers name asks for gentler standards. The second-ranked remedy is explicitly harder than current practice: consequences that hold regardless of the person's performance, a direct answer to the consequence gap and the rank shield behind it. The fourth speaks to a gap the Equal Employment Opportunity Commission documented years ago: roughly three out of four people who experience workplace harassment never report it, most out of fear of disbelief, inaction, or retaliation (EEOC, 2016). SHRM's culture research locates the responsibility where workers do: 76% of employees say their manager sets the culture (SHRM, 2019).
							</p>
							<p>
							No monitoring option was offered on this survey, and none is endorsed. The remedy for a culture problem is management practice: intervene early, aim the consequences correctly, protect the people holding the culture up, and keep the reporting channels safe.
							</p>
						</div>
						<div class="aar-report-split-copy__column">
							<?php
							gc_aar_report_render_image(
								$cgr_img( 'frame-9.webp', __( 'Two employees talking in an office', 'gc-v2' ) ),
								'aar-report-image cgr-report-opening__image'
							);
							?>
						</div>
					</div>						
				</div>
		
				<div class="panel panel--graphs">
					<?php
					gc_aar_report_render_figure_card_graph(
						array(
							'badge'       => 'Figure 9',
							'title'       => 'What would most help keep toxic behavior from spreading at work?',
							'subtitle'    => 'All 1,500 workers answered; they could pick more than one.',
							'orientation' => 'horizontal',
							'max'         => 100,
							'motion'      => true,
							'bars'        => $cgr_what_would_most_help_keep_toxic_behavior_from_spreading_at_work_bars,
							'footer'      => 'Base: 1,500 employed US adults, weighted. PERCEPTION, multi-select. | GCheck Consequence Gap 2026',
						)
					);
					?>
				</div>

				<?php
				gc_aar_report_render_quote(
					array(
						'text'          => '&ldquo;Workers aren\'t asking companies to be <br>softer. They\'re asking them to aim.&rdquo;',
						'wrapper_class' => 'cgr-report-opening__quote',
					)
				);
				?>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-bottom-line">
				<div class="cgr-report-bottom-line__inner">
					<div class="cgr-report-opening__heading">
						<p class="cgr-report-opening__eyebrow">The bottom line</p>
						<h2 class="cgr-report-opening__title" id="cgr-report-the-bottom-line">
						The Harshness Found Everyone Except the Person It <br class="cgr-report-br-desktop" aria-hidden="true">Was For
						</h2>
					</div>
					<p>
					The comfortable version of workplace toxicity is a story about a hard market and thin skin. The data tells a harder one. Work did get tougher, and the toughness reached almost everyone, except the specific colleague whose behavior made it worse. That is the consequence gap, and its cost is not abstract. It is absorbed by the bystanders who grow more cynical, the workers who adopt the behavior to cope, and the good people who leave before the toxic colleague does.
					</p>
					<p>
					What decides how far the damage travels is not the toxic person's charisma or the team's resilience. It is whether the organization lets the behavior pay. Reward it, and adoption nearly triples while good people head for the door. Act, and the same behavior largely fails to travel. Workers already named the fix, and it is not amnesty. It is aim.
					</p>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-opening cgr-report-methodology">
				<div class="cgr-report-opening__heading">
					<p class="cgr-report-opening__eyebrow">Methodology and honesty notes</p>
					<h2 class="cgr-report-opening__title" id="cgr-report-methodology">
					How the Numbers Were Made
					</h2>
				</div>

				<div class="panel panel--table">
					<?php
					gc_aar_report_render_data_table(
						array(
							'column_widths' => array( 24, 76 ),
							'columns'       => $cgr_methodology_columns,
							'rows'          => $cgr_methodology_rows,
						)
					);
					?>
				</div>

				<div class="cgr-report-notes">
					<h3 class="cgr-report-notes__title">Findings that cut the other way</h3>
					<p>
					Not everyone is changed by a toxic colleague, and this report says so. 49% of exposed workers report no real change in the kind of employee they are, and 21% say the experience changed them for the better. Once the exposure ends, recovery is the norm: most feel like their normal selves again within weeks. And adoption does not deepen much with how long the exposure lasted; closeness, not time, is what moves it.
					</p>
				</div>

				<p class="cgr-report-notes__framing">
					<strong>Framing disciplines.</strong> All change measures are self-attributed and reported as association, not causation. Language about behavior "spreading" or "rubbing off" describes patterns in what workers report about themselves and their teams; it is a metaphor, never a clinical claim. The subject of this report is an incentive system, never a set of suspects, and no monitoring or surveillance remedy appears anywhere in it
				</p>
				<div class="cgr-report-notes cgr-report-references">
					<p class="cgr-report-references__item"><strong>References</strong></p>
					<?php foreach ( $cgr_references as $cgr_reference ) : ?>
						<p class="cgr-report-references__item">
							<?php echo esc_html( $cgr_reference['text'] ); ?>
							<a href="<?php echo esc_url( $cgr_reference['url'] ); ?>" rel="noopener noreferrer" target="_blank"><?php echo esc_html( $cgr_reference['url'] ); ?></a>
						</p>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="frame">
			<div class="cgr-report-related__intro">
				<p class="cgr-report-opening__eyebrow">Related GCheck Research</p>
				<h2 class="cgr-report-opening__title" id="cgr-report-related-research">
				The Consequence Gap Is the Fourth Study in The Trust Recession Series, Examining Trust Across the Employment Lifecycle.
				</h2>
			</div>
			<div class="cgr-report-related__grid">
				<article class="cgr-report-related__card">
					<div class="cgr-report-related__media">
						<?php
						gc_aar_report_render_image(
							array(
								'src' => get_template_directory_uri() . '/partials/reports/shadow-workforce/page-hero/images/frame-9.png',
								'alt' => __( 'The 2026 Trust in Hiring Report cover', 'gc-v2' ),
							),
							'cgr-report-related__image'
						);
						?>
					</div>
					<div class="cgr-report-related__body">
						<div class="cgr-report-related__card-heading">
							<h3 class="cgr-report-related__card-title">The 2026 Trust in Hiring Report</h3>
							<p class="cgr-report-related__card-text">
							Why candidates exaggerate and misrepresent themselves, and what it means for hiring integrity.
							</p>
						</div>
						<a class="cgr-report-related__link" href="<?php echo esc_url( home_url( '/whitepapers/trust-in-hiring-report/' ) ); ?>">
						Read the report <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9727 9.52734L9.59375 3.12305C9.53711 3.07422 9.46484 3.04688 9.38867 3.04688H7.66016C7.51562 3.04688 7.44922 3.22656 7.55859 3.32031L14.3984 9.25781H2.96875C2.88281 9.25781 2.8125 9.32812 2.8125 9.41406V10.5859C2.8125 10.6719 2.88281 10.7422 2.96875 10.7422H14.3965L7.55664 16.6797C7.44727 16.7754 7.51367 16.9531 7.6582 16.9531H9.44531C9.48242 16.9531 9.51953 16.9395 9.54688 16.9141L16.9727 10.4727C17.0403 10.4139 17.0945 10.3412 17.1316 10.2597C17.1688 10.1782 17.188 10.0896 17.188 10C17.188 9.9104 17.1688 9.82184 17.1316 9.7403C17.0945 9.65876 17.0403 9.58614 16.9727 9.52734Z" fill="#4F51FD"/>
</svg>
</span>
						</a>
					</div>
				</article>
				<article class="cgr-report-related__card">
					<div class="cgr-report-related__media">
						<?php
						gc_aar_report_render_image(
							array(
								'src' => get_template_directory_uri() . '/partials/reports/shadow-workforce/page-hero/images/frame-10.png',
								'alt' => __( 'The Automation Anxiety Report 2026 cover', 'gc-v2' ),
							),
							'cgr-report-related__image'
						);
						?>
					</div>
					<div class="cgr-report-related__body">
						<div class="cgr-report-related__card-heading">
							<h3 class="cgr-report-related__card-title">The Automation Anxiety Report 2026</h3>
							<p class="cgr-report-related__card-text">
							How AI is reshaping worker confidence and inflating the skills gap in the workplace.
							</p>
						</div>
						<a class="cgr-report-related__link" href="<?php echo esc_url( home_url( '/whitepapers/automation-anxiety-report/' ) ); ?>">
						Read the report <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9727 9.52734L9.59375 3.12305C9.53711 3.07422 9.46484 3.04688 9.38867 3.04688H7.66016C7.51562 3.04688 7.44922 3.22656 7.55859 3.32031L14.3984 9.25781H2.96875C2.88281 9.25781 2.8125 9.32812 2.8125 9.41406V10.5859C2.8125 10.6719 2.88281 10.7422 2.96875 10.7422H14.3965L7.55664 16.6797C7.44727 16.7754 7.51367 16.9531 7.6582 16.9531H9.44531C9.48242 16.9531 9.51953 16.9395 9.54688 16.9141L16.9727 10.4727C17.0403 10.4139 17.0945 10.3412 17.1316 10.2597C17.1688 10.1782 17.188 10.0896 17.188 10C17.188 9.9104 17.1688 9.82184 17.1316 9.7403C17.0945 9.65876 17.0403 9.58614 16.9727 9.52734Z" fill="#4F51FD"/>
</svg>
</span>
						</a>
					</div>
				</article>
				<article class="cgr-report-related__card">
					<div class="cgr-report-related__media">
						<?php
						gc_aar_report_render_image(
							$cgr_img( 'shadow-workforce-cover.png', __( 'The Rise of the Shadow Workforce cover', 'gc-v2' ) ),
							'cgr-report-related__image'
						);
						?>
					</div>
					<div class="cgr-report-related__body">
						<div class="cgr-report-related__card-heading">
							<h3 class="cgr-report-related__card-title">The Rise of the Shadow Workforce</h3>
							<p class="cgr-report-related__card-text">
							The workers, tools, and third parties operating behind the scenes, and why verification decays after hire.
							</p>
						</div>
						<a class="cgr-report-related__link" href="<?php echo esc_url( home_url( '/whitepapers/rise-of-the-shadow-workforce-report/' ) ); ?>">
						Read the report <span><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.9727 9.52734L9.59375 3.12305C9.53711 3.07422 9.46484 3.04688 9.38867 3.04688H7.66016C7.51562 3.04688 7.44922 3.22656 7.55859 3.32031L14.3984 9.25781H2.96875C2.88281 9.25781 2.8125 9.32812 2.8125 9.41406V10.5859C2.8125 10.6719 2.88281 10.7422 2.96875 10.7422H14.3965L7.55664 16.6797C7.44727 16.7754 7.51367 16.9531 7.6582 16.9531H9.44531C9.48242 16.9531 9.51953 16.9395 9.54688 16.9141L16.9727 10.4727C17.0403 10.4139 17.0945 10.3412 17.1316 10.2597C17.1688 10.1782 17.188 10.0896 17.188 10C17.188 9.9104 17.1688 9.82184 17.1316 9.7403C17.0945 9.65876 17.0403 9.58614 16.9727 9.52734Z" fill="#4F51FD"/>
</svg>
</span>
						</a>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>
