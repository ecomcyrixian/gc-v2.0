<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Section images — assets in content-ai-anxiety/images/
 */
$aar_images_uri = get_template_directory_uri() . '/partials/reports/automation-anxiety/content-ai-anxiety/images';
$aar_img        = static function ( $file, $alt, $position = null ) use ( $aar_images_uri ) {
	$image = array(
		'src' => $aar_images_uri . '/' . ltrim( $file, '/' ),
		'alt' => $alt,
	);
	if ( null !== $position ) {
		$image['position'] = 'right' === $position ? 'right' : 'left';
	}
	return $image;
};

$img_s1_automation_anxiety = $aar_img( 'Section-01.webp', 'Worker at a desk using a laptop', 'left' );
$img_s1_preparedness       = $aar_img( 'Section-02.webp', 'Worker at a desk using a laptop', 'left' );
$img_s2_skills_bubble      = $aar_img( 'Section-03.webp', 'Worker reviewing work on a laptop', 'right' );
$img_s3_generational       = $aar_img( 'Section-04.webp', 'Colleagues in a workplace discussion', 'left' );
$img_s4_structural_gaps    = $aar_img( 'Section-05.webp', 'Professional working with technology', 'right' );
$img_s5_double_distortion  = $aar_img( 'Section-06.webp', 'Team collaborating in an office', 'left' );
$img_s6_job_market         = $aar_img( 'Section-07.webp', 'Workers navigating a changing job market' );
$img_s6_ai_proof           = $aar_img( 'Section-08.webp', 'Worker reviews a laptop screen in a home office' );
$img_s7_verification_vacuum = $aar_img( 'Section-09.webp', 'HR leader reviewing workforce verification data' );

$belief_cards = array(
	array(
		'value' => '40%',
		'text'  => 'have personally observed AI tools that can already perform parts of their work',
	),
	array(
		'value' => '38%',
		'text'  => 'cite predictions in their field about AI replacing jobs',
	),
	array(
		'value' => '35%',
		'text'  => 'have seen company announcements about implementing AI tools',
	),
	array(
		'value' => '29%',
		'text'  => 'say AI has already taken over some of their job responsibilities',
	),
	array(
		'value' => '28%',
		'text'  => 'have seen tools improve to the point of matching or exceeding their own output quality',
	),
	array(
		'value' => '26%',
		'text'  => 'have seen colleagues or peers in their industry lose roles to AI or automation',
	),
);

$behavior_cards = array(
	array(
		'value' => '40%',
		'text'  => 'have spoken confidently about AI in meetings to avoid appearing behind',
	),
	array(
		'value' => '33%',
		'text'  => 'have let others assume they have stronger AI skills than they do',
	),
	array(
		'value' => '31%',
		'text'  => 'have exaggerated their experience with AI tools, rising to 50% for Gen Z, 38% for Millennials, 21% for Gen X, and 19% for Boomers',
	),
	array(
		'value' => '25%',
		'text'  => 'have taken credit for AI-assisted work as entirely their own',
	),
	array(
		'value' => '19%',
		'text'  => 'have acted as if using AI when they were not',
	),
	array(
		'value' => '18%',
		'text'  => 'have volunteered for AI tasks they were not qualified for, rising to 30% for Gen Z and 24% for Millennials',
	),
	array(
		'value' => '16%',
		'text'  => 'have explicitly lied about having AI skills they did not possess, rising to 29% for Gen Z and 24% for Millennials',
	),
);

$driver_cards = array(
	array(
		'value' => '76%',
		'text'  => 'plan to build the skills over time, even if they are overstating now',
	),
	array(
		'value' => '70%',
		'text'  => 'believe most people in their industry are also exaggerating their AI expertise',
	),
	array(
		'value' => '57%',
		'text'  => 'felt pressure to appear AI-capable even if their skills are not yet there',
	),
	array(
		'value' => '53%',
		'text'  => 'say the job market is so difficult they feared losing their job without AI skills',
	),
	array(
		'value' => '52%',
		'text'  => 'feel they have no choice or fear being seen as replaceable if they do not adapt',
	),
	array(
		'value' => '52%',
		'text'  => 'have not received proper training or support to actually learn AI tools',
	),
	array(
		'value' => '48%',
		'text'  => 'do not believe their employer has a reliable way to verify AI-related skills',
	),
	array(
		'value' => '46%',
		'text'  => 'feared they would be fired if they did not appear to have AI skills',
	),
);

$resistance_cards = array(
	array(
		'value' => '53%',
		'text'  => 'have preferred manual approaches specifically to avoid increasing reliance on AI',
	),
	array(
		'value' => '45%',
		'text'  => 'have raised risk concerns about AI more strongly than they personally believe those risks',
	),
	array(
		'value' => '28%',
		'text'  => 'have said using AI takes more time or effort than it actually does',
	),
	array(
		'value' => '24%',
		'text'  => 'have downplayed or dismissed AI tools as "not useful" when they had in fact helped',
	),
	array(
		'value' => '23%',
		'text'  => 'have acted as if AI outputs were inaccurate when they were acceptable',
	),
);

$resistance_driver_cards = array(
	array(
		'value' => '72%',
		'text'  => 'are concerned that widespread AI adoption will reduce job opportunities broadly',
	),
	array(
		'value' => '71%',
		'text'  => 'do not fully trust the quality or accuracy of AI outputs',
	),
	array(
		'value' => '63%',
		'text'  => 'worry that reliance on AI will erode their own skills over time',
	),
	array(
		'value' => '57%',
		'text'  => 'have not received enough training or support to use AI effectively',
	),
	array(
		'value' => '55%',
		'text'  => 'are concerned that relying on AI could make their role easier to replace',
	),
	array(
		'value' => '51%',
		'text'  => 'are concerned that increased AI use could reduce the need for their role',
	),
);

$looking_cards = array(
	array(
		'value' => '26%',
		'text'  => 'career advancement or higher compensation',
	),
	array(
		'value' => '25%',
		'text'  => 'general job security anxiety, even though nothing specific has happened at their company',
	),
	array(
		'value' => '23%',
		'text'  => 'want to move into a field they believe is more resistant to AI automation',
	),
	array(
		'value' => '13%',
		'text'  => 'believe their current role may be automated or eliminated',
	),
	array(
		'value' => '9%',
		'text'  => 'dissatisfaction with role, manager, or company',
	),
	array(
		'value' => '4%',
		'text'  => 'want a different job or career path',
	),
	);


	$ai_proof_cards = array(
	array(
		'value' => '52%',
		'text'  => 'updated their resume or LinkedIn to emphasize AI-resistant skills',
	),
	array(
		'value' => '47%',
		'text'  => 'added AI-related skills, including some they cannot confidently perform',
	),
	array(
		'value' => '39%',
		'text'  => 'started or enrolled in an AI certification program',
	),
	array(
		'value' => '37%',
		'text'  => 'applied to roles outside their current qualification range that seem AI-proof',
	),
	array(
		'value' => '35%',
		'text'  => 'inflated their technical proficiency on resume or LinkedIn',
	),
	array(
		'value' => '30%',
		'text'  => 'started or enrolled in a reskilling program for an AI-resistant industry',
	),
	array(
		'value' => '30%',
		'text'  => 'removed or downplayed parts of their experience that overlap with what AI can do',
	),
);

$compliance_good_pillar_table_rows = array(
	array(
		'Transparent Compliance',
		'Communicate verification scope before candidates apply. Disclose what will be assessed. Make adverse-action reasoning visible. Provide candidates with the terms of their own screening.',
		'29% would present themselves more honestly if verification scope is disclosed',
	),
	array(
		'Fair Compliance',
		'Consistent verification standards applied equally to all candidates. Dispute and reconsideration transparency. Individualized assessment for AI-skill claims that recognizes self-development context.',
		'42% cite consistent standards as a top trust-builder; 48% want direct testing of AI competencies',
	),
	array(
		'Protective Compliance',
		'Verification infrastructure that can evaluate AI competency claims. Continuous monitoring for regulated roles. Protection against negligent hiring exposure from unverified AI skill claims.',
		'76% of workers themselves believe AI misrepresentation creates business risk',
	),
);

$aar_appendix_by_generation_columns = array(
	'Metric',
	'Gen Z (n=132)†',
	'Millennials (n=651)',
	'Gen X (n=563)',
	'Boomers (n=154)†',
);

$aar_appendix_by_generation_rows = array(
	array( 'Threat perception (Q1 top-2)', '79%', '78%', '60%', '55%' ),
	array( 'AI fluency theater (any Q5)', '80%', '70%', '55%', '53%' ),
	array( 'Exaggerated AI experience', '50%', '38%', '21%', '19%' ),
	array( 'Volunteered for AI tasks unqualified', '30%', '24%', '12%', '8%' ),
	array( 'Explicitly lied about AI skills', '29%', '24%', '6%', '8%' ),
	array( 'Preemptive resume/profile change', '91%', '84%', '71%', '73%' ),
	array( 'AI resistance behavior (any Q7)', '87%', '83%', '78%', '77%' ),
	array( 'Currently looking at jobs (Q12 Yes)', '69%', '65%', '46%', '26%' ),
);

$aar_appendix_by_race_columns = array(
	'Metric',
	'White (n=1,033)',
	'Black (n=187)',
	'Hispanic (n=133)',
	'Asian (n=90)†',
);

$aar_appendix_by_race_rows = array(
	array( 'Threat perception (Q1 top-2)', '66%', '77%', '77%', '73%' ),
	array( 'AI fluency theater (any Q5)', '61%', '74%', '74%', '58%' ),
	array( 'Preemptive resume/profile change', '76%', '87%', '89%', '80%' ),
	array( 'Lists AI skills publicly (Q10)', '67%', '81%', '84%', '79%' ),
	array( 'AI fluency inflation (Q11 overstated)', '44%', '49%', '56%', '66%' ),
	array( 'Currently looking at jobs (Q12 Yes)', '49%', '66%', '69%', '61%' ),
);
?>
<section class="content content--ai-anxiety" id="ai-anxiety-widespread" aria-labelledby="aar-report-content-ai-anxiety-title">
	<div class="container">
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'AI Anxiety Is Widespread and Personal',
						'subtitle' => 'Automation anxiety is no longer abstract. It is immediate and personal for the US workforce.',
						'id'       => 'aar-report-content-ai-anxiety-title',
						'index'    => '1',
					)
				);
				?>
			</div>
			<div class="panel panel--feature">
				<?php
				gc_aar_report_render_media_feature(
					array(
						'image'    => $img_s1_automation_anxiety,
						'blue_box' => array(
							'position' => 'right',
							'h2'       => '69%',
							'text'     => 'of US adults employed full-time believe it is very or somewhat likely that parts of their current job responsibilities will be automated by AI in the next 24 months. The figure rises to 79% for Gen Z and drops to 55% for Baby Boomers. Acute concern, the share who say automation is "very likely" within 24 months, sits at 21% of the workforce overall and 30% among Gen Z.',
						),
						'body'     => array(
							'text' => 'What sets the 2026 reading apart from earlier waves of technology anxiety is that the concern is not speculative. Workers who expect AI to affect their role describe a set of grounded, observable triggers: AI tools they have personally watched perform parts of their work, company announcements about implementing AI, and predictions in their industry that name their roles directly. Anxiety about AI is no longer driven by what workers read in the news. It is driven by what they see at their desks.',
						),
					)
				);
				?>
			</div>
			<div class="panel panel--stat-cards">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => 'Why workers believe AI will affect them',
						'intro'   => 'Among the 1,032 workers who say AI is very or somewhat likely to automate parts of their role, the influences are concrete and accumulating.',
						'columns' => 3,
						'cards'   => $belief_cards,
					)
				);
				?>
			</div>
			<div class="panel panel--feature">
				<?php
				gc_aar_report_render_media_feature(
					array(
						'image'    => $img_s1_preparedness,
						'body'     => array(
							'title' => 'Preparedness is uneven',
							'text' => 'Workers who expect disruption do not necessarily feel equipped to navigate it. Only 38% feel very or extremely prepared to use AI tools effectively. The remaining 62% fall into moderate or lower readiness: 40% would need training to adapt, and 22% say they would struggle or could not use AI tools effectively at all. The result is a workforce that anticipates change, sees it arriving, and feels the gap between what they can credibly claim about AI and what they can demonstrate.',
						),
						'quote'    => '“Anxiety about AI is no longer driven by what workers read in the news. It is driven by <strong>what they see at their desks</strong>.”',
					)
				);
				?>
			</div>
		</div>
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'The AI Skills Bubble',
						'subtitle' => 'How a workforce under pressure inflated a credential category it has not yet mastered.',
						'id'       => 'aar-report-content-ai-skills-bubble-title',
						'index'    => '2',
					)
				);
				?>
			</div>
			<div class="panel panel--feature">
				<?php
				gc_aar_report_render_media_feature(
					array(
						'image'    => $img_s2_skills_bubble,
						'blue_box' => array(
							'position' => 'right',
							'h2'       => '63%',
							'text'     => 'of US employed workers have lied or exaggerated their AI skills to appear more knowledgeable than they are. The behavior is broadly distributed, but unevenly: 80% of Gen Z, 70% of Millennials, 55% of Gen X, and 53% of Baby Boomers. 70% of men report the behavior, compared to 55% of women. The aggregate effect is what this report calls the AI Skills Bubble: a category of skill claim now inflated beyond what the underlying workforce can actually perform.',
						),
						'body'     => array(
							'text' => 'In response to the pressure, workers are not simply adapting. They are overstating. The AI Skills Bubble now functions as a category of workplace and labor-market distortion in its own right.',
						),
					)
				);
				?>
			</div>
			<div class="panel panel--content">
				<div class="aar-methodology__content">
					<h3 class="aar-methodology__table-title bubble-def-title">Self-declared inflation, by the numbers</h3>
					<p>The inflation does not require external auditing. It is self-reported in the survey. Among the 1,062 workers who list at least one AI skill on their resume or LinkedIn, only 34% say they could confidently perform all of those skills at a professional level if asked to demonstrate them today. Half say they could perform most but some are still developing or overstated. Fifteen percent admit several of their listed skills exceed their actual ability. One percent cannot confidently perform any of the skills they listed.</p>
					<p class="bubble-def-figure">Figure 1. 63% of US Workers Have Lied or Exaggerated AI Skills</p>
				</div>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'orientation' => 'vertical',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'title'     => 'By generation',
								'y_label'   => '(%) reporting AI fluency theater',
								'max'       => 80,
								'reference' => array(
									'value' => 63,
									'label' => 'Total: 63%',
								),
								'bars'      => array(
									array( 'label' => 'Gen Z', 'sublabel' => 'n=132', 'value' => 80, 'tone' => 'royal' ),
									array( 'label' => 'Millennials', 'sublabel' => 'n=651', 'value' => 70, 'tone' => 'cyan' ),
									array( 'label' => 'Gen X', 'sublabel' => 'n=563', 'value' => 55, 'tone' => 'navy' ),
									array( 'label' => 'Boomers', 'sublabel' => 'n=154', 'value' => 53, 'tone' => 'lavender' ),
								),
								'footer'    => '1,500 US employed full-time | GCheck 2026 | Q5 any-selection',
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'orientation' => 'vertical',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'title'   => 'By gender',
								'y_label' => 'Percentage (%)',
								'max'     => 80,
								'bars'    => array(
									array( 'label' => 'Men', 'sublabel' => 'n=837', 'value' => 70, 'tone' => 'royal' ),
									array( 'label' => 'Women', 'sublabel' => 'n=663', 'value' => 55, 'tone' => 'cyan' ),
								),
								'footer'  => '1,500 US employed full-time | GCheck 2026 | Q5 any-selection',
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--split-narrative">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<h3 class="aar-report-split-copy__heading">AI skills appear widely on resumes</h3>
						<p>AI-related skills now appear on the majority of US worker resumes and LinkedIn profiles. 71% of US employed workers list at least one AI skill publicly. Only 29% list none at all. The most commonly claimed skills span the full gradient from broad familiarity to specialist expertise: AI tool proficiency at 40%, AI content creation at 39%, AI-assisted data analysis at 30%, AI for productivity at 23%, machine learning at 13%, and AI product development at 15%. Specialist credentials appear at base rates that far exceed actual labor-market supply for those skills.</p>
						<div class="aar-report-split-copy__callout-slot">
							<?php
							gc_aar_report_render_callout_card(
								array(
									'title' => 'The AI Skills Bubble',
									'text'  => 'A 2026 workforce phenomenon in which AI skill claims have outpaced workers&rsquo; actual ability to perform them, documented at industrial scale through self-reported inflation rather than inferred from external assessment.',
									'quote' => '47% of US employed workers list AI skills publicly and privately admit some or all exceed their actual ability.',
								)
							);
							?>
						</div>
					</div>
					<div class="aar-report-split-copy__column">
						<h3 class="aar-report-split-copy__heading">Self-rated ability tells a different story</h3>
						<p>Workers themselves describe a gap between what they list and what they can do. Among the 71% who list AI skills publicly, only 34% say they could confidently perform all of those skills at a professional level if asked to demonstrate them today. Half can perform most but say some are still developing or overstated. 15% admit they have only basic familiarity, with several listed skills exceeding their actual ability. 1% cannot confidently perform any of the skills they listed.</p>
						<p>Expressed as a share of the full workforce, 47% of US employed workers list AI skills publicly and privately acknowledge that some or all of those skills exceed their actual ability. This is the AI Skills Bubble in its most mechanically defensible form: documented in workers' own self-assessment, not inferred from external evaluation.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'From Subtle Inflation to Direct Misrepresentation',
						'subtitle' => 'The behaviors that translate AI anxiety into daily workplace performance.',
						'index'    => '3',
					)
				);
				?>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'intro'       => 'The exaggeration takes multiple forms, many of which extend beyond resumes into everyday workplace behavior. The behaviors span a spectrum from soft impression management to explicit fabrication. Even at the conservative end, one in six US workers has explicitly lied to colleagues or managers about having AI skills they do not have.',
						'title'       => 'Figure 2. From Subtle Inflation to Direct Misrepresentation',
						'orientation' => 'horizontal',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'max'     => 50,
								'x_label' => '% of US employed workers (Q5 any = 63%)',
								'dividers' => array(
									array(
										'after' => 3,
										'label' => 'subtle inflation ↑ / direct misrepresentation ↓',
									),
								),
								'bars'    => array(
									array( 'label' => 'Spoke confidently in meetings - to avoid appearing behind', 'value' => 40, 'tone' => 'royal' ),
									array( 'label' => 'Let others assume stronger AI skills than I have', 'value' => 33, 'tone' => 'royal' ),
									array( 'label' => 'Exaggerated experience with AI tools', 'value' => 31, 'tone' => 'royal' ),
									array( 'label' => 'Took credit for AI-assisted work as my own', 'value' => 25, 'tone' => 'cyan' ),
									array( 'label' => 'Acted as if using AI when I was not', 'value' => 19, 'tone' => 'cyan' ),
									array( 'label' => 'Volunteered for AI tasks I was not qualified for', 'value' => 18, 'tone' => 'cyan' ),
									array( 'label' => 'Explicitly lied about having AI skills I did not', 'value' => 16, 'tone' => 'cyan' ),
								),
								'footer'  => 'n=1,500 US employed full-time | GCheck 2026 | Q5 multi-select items',
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--stat-cards">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => 'Seven behaviors of workplace AI inflation',
						'intro'   => 'The distribution matters because it separates workers who are hedging their professional image from those who are actively misrepresenting their capabilities. The top three behaviors are best classified as impression management. The bottom four constitute direct misrepresentation.',
						'columns' => 4,
						'cards'   => $behavior_cards,
					)
				);
				?>
			</div>
			<div class="panel panel--feature">
				<?php
				gc_aar_report_render_media_feature(
					array(
						'image'    => $img_s3_generational,
						'body'     => array(
							'title' => 'The generational concentration',
							'text' => 'Across every behavior in this section, the generational gradient is consistent and sharp. Workers earliest in their careers report inflation behaviors at roughly two and a half times the rate of workers nearest retirement. The pattern is most pronounced on the explicit-lying item: 29% among Gen Z compared to 6% among Gen X and 8% among Boomers. The honesty cost of AI anxiety is being paid disproportionately by workers with the longest career runways still ahead of them.',
						),
						'quote'    => '“Even at the conservative end of the distribution, <strong>one in six US workers</strong> has explicitly lied about having AI skills they do not have.”',
					)
				);
				?>
			</div>
		</div>
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'Why Workers Feel Compelled to Exaggerate',
						'subtitle' => 'Fear, competition, and the verification gap.',
						'index'    => '4',
					)
				);
				?>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'intro'       => 'Among the 952 workers who report at least one AI fluency theater behavior, the motivations form a composite of skill-building intent, competitive pressure, structural training gaps, and fear. The single most common reason is anticipatory: workers who plan to learn AI eventually but have decided to claim the credential first. The next most common is normative: the belief that everyone else is doing the same thing.',
						'title'       => 'Figure 3. Why Workers Feel Compelled to Exaggerate',
						'orientation' => 'horizontal',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'max'     => 90,
								'x_label' => '% of those who engaged in Al fluency theater',
								'bars'    => array(
									array( 'label' => 'Plan to build these skills over time', 'value' => 76, 'tone' => 'royal' ),
									array( 'label' => 'Most in industry are also exaggerating', 'value' => 70, 'tone' => 'royal' ),
									array( 'label' => 'Felt pressure to appear AI-capable', 'value' => 57, 'tone' => 'cyan' ),
									array( 'label' => 'Job market so difficult, feared losing job', 'value' => 53, 'tone' => 'cyan' ),
									array( 'label' => 'No choice or will be seen as replaceable', 'value' => 52, 'tone' => 'cyan' ),
									array( 'label' => 'Have not received proper training', 'value' => 52, 'tone' => 'indigo' ),
									array( 'label' => 'No reliable verification from employer', 'value' => 48, 'tone' => 'indigo' ),
									array( 'label' => 'Feared being fired without AI skills', 'value' => 46, 'tone' => 'indigo' ),
								),
								'footer'  => 'n=1,500 US employed full-time | GCheck 2026 | Q6 conditional, n=952 (those reporting Q5 any)',
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--stat-cards">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => 'Eight drivers of AI skills inflation',
						'intro'   => 'Workers who admit to AI skills inflation describe a motivational structure that mixes anticipatory skill-building, normative pressure, infrastructure failure, and threat perception.',
						'columns' => 4,
						'cards'   => $driver_cards,
					)
				);
				?>
			</div>
			<div class="panel panel--feature">
				<?php
				gc_aar_report_render_media_feature(
					array(
						'image'    => $img_s4_structural_gaps,
						'body'     => array(
							'title' => 'Structural gaps reinforce the cycle',
							'text' => 'Two of the eight drivers point to structural rather than psychological causes. 52% of those who inflate cite the absence of proper training. 48% cite the absence of reliable employer verification. The cycle is self-sustaining: pressure to compete drives exaggeration, weak verification allows the exaggeration to continue, and the perception that everyone is doing it normalizes the behavior across industries. 70% of inflators believe their industry peers are also exaggerating, which the data confirms is approximately accurate.',
						),
						'quote'    => '“ Pressure to compete drives exaggeration. Weak verification allows it to continue. The <strong>perception that everyone is doing it normalizes the behavior</strong> across industries.”',
					)
				);
				?>
			</div>
		</div>
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'The Double Distortion',
						'subtitle' => 'Two contradictory behaviors. Same workforce. Both at majority scale.',
						'index'    => '5',
					)
				);
				?>
			</div>
			<div class="panel panel--feature">
				<?php
				gc_aar_report_render_media_feature(
					array(
						'image'    => $img_s5_double_distortion,
						'blue_box' => array(
							'position' => 'right',
							'h2'       => '81%',
							'text'     => 'of US employed workers admit to discouraging or limiting the use of AI at work, which runs in the opposite direction from the inflation behavior we&rsquo;ve observed. This report calls the combined pattern the Double Distortion: workers simultaneously overstating their ability to use AI and understating AI&rsquo;s actual value, in the same workforce, at the same time.',
						),
						'body'     => array(
							'text' => 'The Double Distortion does not stop at skills. Workers are also misrepresenting AI&rsquo;s capabilities. The same workforce that inflates its AI fluency in resumes and meetings is, from a different angle, actively limiting the AI adoption their employers are paying for. Five behaviors capture the form this resistance takes.',
						),
					)
				);
				?>
			</div>
			<div class="panel panel--stat-cards">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => 'Five behaviors of workplace AI resistance',
						'intro'   => '',
						'columns' => 5,
						'cards'   => $resistance_cards,
					)
				);
				?>
			</div>
			<div class="panel panel--stat-cards">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => 'What is driving the resistance',
						'intro'   => 'Among the 1,212 workers who report at least one resistance behavior, the stated motivations form a composite of macroeconomic concern, skill-preservation, and quality skepticism.',
						'columns' => 3,
						'cards'   => $resistance_driver_cards,
					)
				);
				?>
			</div>
			<div class="panel panel--split-narrative">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column">
						<h3 class="aar-report-split-copy__heading">The implication for AI return on investment</h3>
						<p>The practical consequence for organizations is consequential. The Double Distortion is not a fringe behavior at this scale; it is a workforce-wide pattern. Organizations measuring AI return through surface-level adoption metrics are measuring the visible signal of AI use, not the underlying productivity gain. The suppression of that signal, conducted quietly by four in five workers, will continue to understate AI's ceiling for as long as the behavior goes unnamed and unaddressed. The workforce is not refusing AI loudly. It is slowing AI quietly, and the slow rolls into the productivity numbers.</p>
					</div>
					<div class="aar-report-split-copy__column">
					<div class="aar-report-split-copy__callout-slot">
							<?php
							gc_aar_report_render_callout_card(
								array(
									'title' => 'The Double Distortion',
									'text'  => 'The 2026 workforce is simultaneously overstating its AI capabilities and understating AI’s actual usefulness. Two contradictory behaviors, running in opposite directions, in the same workforce, both at majority scale.',
									'quote' => '63% have inflated their AI skills to appear more knowledgeable. 81% have engaged in behaviors to limit or discourage AI use at work.',
								)
							);
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel--quote">
				<?php
					gc_aar_report_render_quote(
						array(
							'text'          => '“Workers are simultaneously overstating their ability to <strong>use AI and understating AI\'s actual value</strong>. The Double Distortion is the story.”	',
							'wrapper_class' => 'aar-report-quote',
							'text_class'    => 'aar-report-quote__text',
						)
					);
				?>
			</div>
		</div>
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'Career Movement and Workforce Instability',
						'subtitle' => 'How AI anxiety is reshaping where US workers are looking.',
						'index'    => '6',
					)
				);
				?>
			</div>
			<div class="panel panel--blue-box">
				<div class="aar-report-blue-box">
					<h2 class="aar-report-blue-box__heading">54%</h2>
					<p class="aar-report-blue-box__text aar-report-blue-box-copy">of US employed workers are currently engaged with the job market, either actively applying or casually browsing. The number itself is a meaningful labor-market signal. The composition of the underlying motivations, in which AI-related reasons displace traditional career drivers, is more meaningful still.</p>
				</div>
			</div>
			<div class="panel panel--stat-cards">
				<?php
				gc_aar_report_render_stat_cards(
					array(
						'title'   => 'Why workers are looking',
						'intro'   => 'Among the 813 workers who are actively or casually looking, primary reasons distribute across both AI-driven and traditional motivations. When the three AI-linked reasons are combined, they account for 61% of all stated motivations.',
						'columns' => 3,
						'cards'   => $looking_cards,
					)
				);
				?>
			</div>
			<div class="panel panel--image">
				<?php gc_aar_report_render_image( $img_s6_job_market ); ?>
			</div>
			<div class="panel panel--feature-stat-split">
				<div class="aar-report-feature-stat-split">
					<div class="aar-report-feature-stat-split__copy">
						<h2 class="aar-report-feature-stat-split__heading">Workers are actively trying to AI-proof themselves</h2>
						<p class="aar-report-feature-stat-split__intro">
						Beyond shadow searching, workers are taking concrete steps to reposition themselves for an AI-shaped market. In the past six months, the share of US employed workers who have made specific resume or skill changes specifically because of AI concerns is substantial. 78% have taken at least one preemptive action.
						</p>
						<?php gc_aar_report_render_image( $img_s6_ai_proof, 'aar-report-feature-stat-split__image' ); ?>
					</div>
					<div class="aar-report-feature-stat-split__stats">
						<?php foreach ( $ai_proof_cards as $row ) : ?>
							<?php
							$row_value = isset( $row['value'] ) ? (string) $row['value'] : '';
							$row_text  = isset( $row['text'] ) ? (string) $row['text'] : '';
							if ( '' === $row_value && '' === $row_text ) {
								continue;
							}
							?>
							<div class="aar-report-feature-stat-split__stat">
								<div class="aar-report-feature-stat-split__stat-value"><?php echo esc_html( $row_value ); ?></div>
								<p class="aar-report-feature-stat-split__stat-text"><?php echo esc_html( $row_text ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="panel panel--quote">
				<p class="aar-report-quote__attribution quote-text">Automation anxiety is not just influencing perception. It is actively reshaping career decisions and labor-market movement. The workers who are leaving are leaving because they believe their current trajectory runs into AI displacement. An effective retention response requires more than compensation adjustment. It requires honest communication about which roles are genuinely at risk, real investment in AI skill development for workers who want to stay, and verification infrastructure that makes AI-skill claims meaningful at the point of hire.</p>
				<?php
					gc_aar_report_render_quote(
						array(
							'text'          => '“ Workers are not just leaving for higher pay.<strong> They are leaving because they believe their current trajectory runs into AI displacement</strong>, and because they believe their employer does not see it coming.”',
							'wrapper_class' => 'aar-report-quote',
							'text_class'    => 'aar-report-quote__text',
						)
					);
				?>
			</div>
		</div>
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'The Verification Vacuum',
						'subtitle' => 'The structural condition that lets the AI Skills Bubble keep inflating.',
						'index'    => '7',
					)
				);
				?>
			</div>
			<div class="panel panel--blue-box">
				<div class="aar-report-blue-box">
					<h2 class="aar-report-blue-box__heading">76%</h2>
					<p class="aar-report-blue-box__text aar-report-blue-box-copy">of US employed workers say misrepresenting AI-related skills puts businesses at risk. Yet only 39% believe employers can effectively verify these skills, and just 26% report that their employer has tested AI capabilities within the workforce. 43% believe most coworkers are exaggerating their AI skills. This report calls the resulting condition the Verification Vacuum: the structural absence that allows the AI Skills Bubble to keep inflating.</p>
				</div>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'title'       => 'Figure 4. The Verification Vacuum: Verification is Limited but Expected',
						'orientation' => 'vertical',
						'layout'      => 'duo',
						'motion'      => true,
						'panels'      => array(
							array(
								'title'   => 'Employer-side verification is limited',
								'y_label' => 'Percentage (%)',
								'max'     => 70,
								'bars'    => array(
									array( 'label' => '39% believe employer can effectively verify', 'value' => 39, 'tone' => 'royal' ),
									array( 'label' => '26% employer has tested AI capabilities', 'value' => 26, 'tone' => 'cyan' ),
									array( 'label' => '64% employer has not tried to verify', 'value' => 64, 'tone' => 'red' ),
								),
								'footer'  => 'n=1,500 US employed full-time | GCheck 2026 | Q9, Q14, Q15, Q18',
							),
							array(
								'title'   => 'Workforce already sees the risk',
								'y_label' => 'Percentage (%)',
								'max'     => 90,
								'bars'    => array(
									array( 'label' => '43% believe coworkers are exaggerating', 'value' => 43, 'tone' => 'royal' ),
									array( 'label' => '76% say AI misrep puts business at risk', 'value' => 76, 'tone' => 'cyan' ),
								),
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--split-narrative">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column aar-report-split-copy__column--items">
						<div class="aar-report-split-copy__item">
							<h3 class="aar-report-split-copy__heading">Workers see the Vacuum clearly</h3>
							<p>Despite widespread participation in the AI Skills Bubble documented in Sections 2 through 4, workers themselves are not in denial about its consequences. The same workforce that inflates AI claims also names the risk those inflated claims create for the organizations doing the hiring. The acknowledgment is not hypothetical. 27% of all workers say AI misrepresentation creates significant business risk, and another 49% say it creates some risk.</p>
						</div>
						<div class="aar-report-split-copy__item">
							<h3 class="aar-report-split-copy__heading">Employer-side verification has not caught up</h3>
							<p>64% of US workers say their employer has not attempted to verify their AI skills. 26% say their employer has tested or evaluated those skills. 10% are unsure. The asymmetry between the prevalence of inflated claims and the rarity of verification is the Verification Vacuum in concrete operational terms. It is also the structural condition that allows the inflation cycle in Section 4 to perpetuate. When 48% of inflators cite the absence of reliable verification as a reason they overstate, and 64% of all workers can confirm that absence from direct experience, the Vacuum is no longer a perception. It is a documented condition.</p>
						</div>
						<div class="aar-report-split-copy__item">
							<h3 class="aar-report-split-copy__heading">What the Verification Vacuum costs</h3>
							<p>The cost of the Vacuum distributes across both sides of the employment relationship. For workers, the cost is the post-hire stress of carrying an unverified claim into a role they cannot fully execute. For organizations, the cost is misallocation of work, delayed AI adoption, and the slow-burn risk of negligent hiring exposure when AI-skill claims that were never tested at hire-time later prove false in a high-stakes context. Neither side benefits from the current equilibrium. The 76% of workers who say misrepresentation creates business risk are also describing their own working conditions.</p>
						</div>
					</div>
					<div class="aar-report-split-copy__column aar-report-split-copy__column--items">
						<?php gc_aar_report_render_image( $img_s7_verification_vacuum ); ?>
						<div class="aar-report-split-copy__callout-slot">
							<?php
							gc_aar_report_render_callout_card(
								array(
									'title' => 'The Verification Vacuum',
									'text'  => 'The structural condition in which AI-skill claims are made at scale while employer-side verification has not kept up. Workers know it. So do their colleagues. The vacuum is the condition that allows the inflation cycle to perpetuate.',
									'quote' => '64% of workers have never been tested by their employer. 48% of inflators cite the absence of reliable verification as a reason they overstate.',
								)
							);
							?>
						</div>
						<div class="quote-text">
							<?php
							gc_aar_report_render_quote(
								array(
									'text'          => '“ The same workforce that inflates AI claims also names the risk those claims create. <strong>The Verification Vacuum is not a perception problem.</strong> It is a structural one.”',
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
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'What Workers Want: Transparency, Verification, Human Oversight',
						'subtitle' => 'The mandate for screening reform is coming from the workforce itself.',
						'index'    => '8',
					)
				);
				?>
			</div>
			<div class="panel panel--graphs">
				<?php
				gc_aar_report_render_graph(
					array(
						'intro'       => 'Workers are not opposed to verification. They are asking for it. 61% want human review of hiring decisions even when AI tools are used. 48% want testing of AI competencies. 47% want transparent explanations of how AI is used in hiring. 46% want clear communication about what will be verified. 42% want consistent standards applied across candidates.',
						'title'       => 'Figure 5. What Workers Want: Transparency, Verification, Human Oversight',
						'orientation' => 'horizontal',
						'layout'      => 'single',
						'motion'      => true,
						'panels'      => array(
							array(
								'max'     => 70,
								'x_label' => '% of US employed workers',
								'bars'    => array(
									array( 'label' => 'Human review of hiring decisions even with AI', 'value' => 61, 'tone' => 'royal' ),
									array( 'label' => 'Direct testing of AI competencies', 'value' => 48, 'tone' => 'cyan' ),
									array( 'label' => 'Transparent explanations of how AI is used', 'value' => 47, 'tone' => 'cyan' ),
									array( 'label' => 'Clear communication of what will be verified', 'value' => 46, 'tone' => 'cyan' ),
									array( 'label' => 'Consistent standards across candidates', 'value' => 42, 'tone' => 'cyan' ),
									array( 'label' => 'Outside references for AI skill verification', 'value' => 25, 'tone' => 'navy' ),
								),
								'footer'  => 'n=1,500 US employed full-time | GCheck 2026 | Q19 multi-select, Q20 conditional',
								'callout' => '29% would be more honest if verification scope was disclosed in advance (Q20)',
							),
						),
					)
				);
				?>
			</div>
			<div class="panel panel--split-narrative">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column aar-report-split-copy__column--items">
						<div class="aar-report-split-copy__item">
							<h3 class="aar-report-split-copy__heading">The disclosure dividend</h3>
							<p>29% of US employed workers say they would be more honest about their qualifications if employers clearly communicated what would be independently verified. The figure represents a quantifiable behavioral lever, not a hypothetical preference. It signals that stronger, clearer screening processes could directly reduce AI skills misrepresentation. The implication for employer practice is specific: transparency is not only an ethical commitment. It is the highest-yield single intervention available for closing the Verification Vacuum documented in Section 7.</p>
							<p>A complementary finding qualifies the ceiling. 13% of workers say they would still overstate their qualifications even if employers disclosed verification scope. The hardened fraction defines the upper limit of what disclosure alone can accomplish. Between the 29% who would respond and the 13% who would not lies the realistic operating range for transparency-driven screening reform.</p>
						</div>
					</div>
					<div class="aar-report-split-copy__column aar-report-split-copy__column--items">
						<div class="aar-report-split-copy__item">
							<h3 class="aar-report-split-copy__heading">Mapping the mandate to Compliance for Good</h3>
							<p>The Compliance for Good™ framework rests on three pillars: Transparent, Fair, and Protective Compliance. The 2026 data operates as the framework’s operating agenda for the automation era. Each pillar maps to a specific workforce mandate documented in this report.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel--table">
				<div class="aar-methodology__content">
					<?php
					gc_aar_report_render_data_table(
						array(
							'columns' => array(
								'Pillar',
								'What Workers Are Asking For',
								'Anchor Statistic',
							),
							'rows'    => $compliance_good_pillar_table_rows,
						)
					);
					?>
				</div>
			</div>
			<div class="panel panel--split-narrative">
				<div class="aar-report-split-copy aar-report-split-copy--center-content">
					<div class="aar-report-split-copy__column aar-report-split-copy__column--items">
						<div class="aar-report-split-copy__item">
							<h3 class="aar-report-split-copy__heading"><a href="<?php echo esc_url( home_url( '/whitepapers/trust-in-hiring-report/' ) ); ?>">Bridge to Trust in Hiring 2026</a></h3>
							<p>When the same screening-reform demands are put to US active job seekers and to US employed workers, the direction is identical. Job seekers demand transparency, fair standards, and human review at 74 to 82%. Employed workers demand the same things at 42 to 61%. The magnitude difference reflects proximity to the screening event. The directional convergence is what matters for policy: the workforce, taken as a whole, supports reform that makes screening more transparent, more consistent, and more human. Both populations cross the majority threshold on human review, at 81% and 61% respectively. This is the stakeholder consensus on which modern screening reform stands.</p>
						</div>
					</div>
					<div class="aar-report-split-copy__column aar-report-split-copy__column--items">
						<div class="aar-report-split-copy__item">
							<div class="quote-text">
								<?php
								gc_aar_report_render_quote(
									array(
										'text'          => '“ Workers are not opposed to verification. They are asking for it. The <strong>mandate for modern screening </strong> is coming from the people most affected by it. ”',
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
		</div>
		<div class="frame">
			<div class="panel panel--heading">
				<?php
				gc_aar_report_render_section_heading(
					array(
						'title'    => 'The Bottom Line: Automation Anxiety Is Driving a New Trust Challenge',
						'subtitle' => '',
						'index'    => '9',
					)
				);
				?>
			</div>
			<div class="panel panel--split-narrative">
				<div class="aar-report-split-copy">
					<div class="aar-report-split-copy__column aar-report-split-copy__column">
						<p>AI is creating the next wave of workforce disruption, and with it, a new kind of trust problem. Three structural conditions, all documented in this report, define the 2026 landscape: the AI Skills Bubble, the Double Distortion, and the Verification Vacuum. The Bubble is the inflated category of AI skill claim now appearing on resumes and in workplaces at industrial scale. The Double Distortion is the contradictory pattern of a workforce that simultaneously overstates AI capability and understates AI usefulness. The Vacuum is the absence of verification infrastructure that lets the first two persist. Together they describe a workforce caught between two pressures that point in opposite directions, operating inside an employer environment that cannot yet test the claims being made.<br><br>
						Employers operate inside the Verification Vacuum. The skill claims of the AI Skills Bubble have outpaced the infrastructure designed to evaluate them. 64% of workers have not had their AI skills tested. 39% believe their employer can effectively verify those skills. 43% believe their coworkers are exaggerating. The result is a growing distance between perceived and actual capability, and a measurable risk profile for both employees and organizations.</p>
					</div>
					<div class="aar-report-split-copy__column aar-report-split-copy__column">
						<div class="panel panel--blue-box">
							<div class="aar-report-blue-box">
								<p class="aar-report-blue-box__text aar-report-blue-box-copy">The path forward is not to screen more aggressively. It is to close the Verification Vacuum. The workforce itself has provided the mandate: transparency about what is being verified, consistent standards across candidates, human review of decisions in which AI tools are used, and direct testing of the new category of skill claim. <br><br>29% of workers would meaningfully change their behavior in response to disclosure alone, the highest-yield intervention available against the AI Skills Bubble. Compliance for Good in the automation era is a response to a workforce-generated mandate for screening that catches up with how workers actually behave in 2026.<br><br>The data does not argue that employers should screen more aggressively. It argues that employers should screen more credibly, and that the workers most affected by the resulting process have already given their consent for it to happen.</p>
							</div>
						</div>	
					</div>
				</div>
			</div>
			<div class="panel panel--quote">
				<?php
					gc_aar_report_render_quote(
						array(
							'text'          => '“ Compliance for Good in the automation era is not a brand position. It is <strong>a response to a workforce-generated mandate for screening</strong> that catches up with how workers actually behave in 2026. ”',
							'wrapper_class' => 'aar-report-quote',
							'text_class'    => 'aar-report-quote__text',
						)
					);
				?>
			</div>
		</div>
		<div class="frame">
			<div class="panel panel--table panel--appendix-demographics">
				<h3 class="aar-methodology__table-title" id="aar-appendix-demographic-cuts">Appendix. Demographic Cuts on Headline Metrics</h3>
				<div class="aar-methodology__content">
					<h4 class="aar-methodology__table-subtitle">By Generation</h4>
					<?php
					gc_aar_report_render_data_table(
						array(
							'caption'        => 'By Generation',
							'wrap_class'     => 'aar-report-data-table-wrap--appendix',
							'table_class'    => 'aar-report-data-table--appendix',
							'column_widths'  => array( 34, 16.5, 16.5, 16.5, 16.5 ),
							'columns'        => $aar_appendix_by_generation_columns,
							'rows'           => $aar_appendix_by_generation_rows,
							'footnote'       => '† Reported with small-sample caveat. Directional interpretation appropriate.',
						)
					);
					?>
				</div>
				<div class="aar-methodology__content">
					<h4 class="aar-methodology__table-subtitle">By Race and Ethnicity</h4>
					<?php
					gc_aar_report_render_data_table(
						array(
							'caption'        => 'By Race and Ethnicity',
							'wrap_class'     => 'aar-report-data-table-wrap--appendix',
							'table_class'    => 'aar-report-data-table--appendix',
							'column_widths'  => array( 34, 16.5, 16.5, 16.5, 16.5 ),
							'columns'        => $aar_appendix_by_race_columns,
							'rows'           => $aar_appendix_by_race_rows,
							'footnote'       => '† Asian subsample (n=90) reported as directional only.',
						)
					);
					?>
				</div>
				<p class="aar-appendix-read">Read: Hispanic and Black workers report systematically higher threat perception, AI fluency theater, preemptive behavior, and shadow job-search activity than White workers. The gradient is consistent across constructs. Workers of color carry a disproportionate share of the behavioral cost of AI anxiety.</p>
			</div>
		</div>
	</div>
</section>
