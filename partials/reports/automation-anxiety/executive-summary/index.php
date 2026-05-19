<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$executive_findings = array(
	array(
		'title' => 'AI anxiety is widespread and personal.',
		'body'  => '69% of workers believe AI will automate parts of their role within 24 months. The concern is grounded in direct experience: 40% of workers who expect AI impact have personally observed AI tools doing parts of their work.',
	),
	array(
		'title' => 'AI skills misinformation is becoming the new normal.',
		'body'  => '63% of workers have lied or exaggerated their AI skills, with 80% of Gen Z and 70% of men reporting the behavior. Only 34% of workers who list AI skills can confidently perform all of them at a professional level.',
	),
	array(
		'title' => 'The exaggeration shows up across the workplace.',
		'body'  => '40% speak confidently about AI in meetings to avoid appearing behind. 25% take credit for AI-assisted work as their own. 16% explicitly lie about having AI skills.',
	),
	array(
		'title' => 'A second contradiction runs in the opposite direction.',
		'body'  => '81% of workers admit to discouraging or limiting AI use at work, including 53% who prefer manual approaches and 45% who raise risk concerns more strongly than they personally believe.',
	),
	array(
		'title' => 'Verification infrastructure has not kept up.',
		'body'  => '64% of workers have not had their AI skills tested by their employer. 39% believe their employer can effectively verify AI skills. 43% believe most coworkers are exaggerating.',
	),
	array(
		'title' => 'The mandate for reform is coming from the workforce itself.',
		'body'  => '76% of workers say AI misrepresentation creates business risk. 61% want human review of AI-related hiring decisions. 29% would be more honest if verification scope were clearly disclosed.',
	),
);

$methodology_subsample_rows = array(
	array( 'Full sample', '1,500', '±2.5 pts', 'Primary' ),
	array( 'Millennials (30-45)', '651', '±3.8 pts', 'Primary' ),
	array( 'Gen X (46-61)', '563', '±4.1 pts', 'Primary' ),
	array( 'Gen Z (18-29)', '132', '±8.5 pts', 'Small-sample caveat' ),
	array( 'Baby Boomers (62-80)', '154', '±7.9 pts', 'Small-sample caveat' ),
	array( 'White', '1,033', '±3.0 pts', 'Primary' ),
	array( 'Black or African American', '187', '±7.2 pts', 'Primary' ),
	array( 'Hispanic', '133', '±8.5 pts', 'Primary' ),
	array( 'Asian', '90', '±10.3 pts', 'Directional only' ),
);
?>
<section class="aar-report-opening">
	<div class="container">
		<div class="aar-executive-summary" id="executive-summary" aria-labelledby="aar-executive-summary-title">
			<h2 id="aar-executive-summary-title" class="aar-executive-summary__title">Executive Summary</h2>
			<div class="aar-executive-summary__intro">
				<div class="aar-executive-summary__copy">
					<p>
					AI is creating the next wave of workforce disruption. The Automation Anxiety Report™ 2026, based on a national survey of 1,500 US full-time employed adults, finds that the disruption is not only operational. It is a credibility crisis. Workers expect AI to reshape their jobs but do not feel fully prepared for it. In response, they are overstating their capabilities, while simultaneously resisting the AI adoption their employers are paying for. Employers, in turn, lack consistent ways to verify the new category of skill claim now appearing on resumes and in workplaces. The result is a growing gap between perceived and actual capability, with measurable risk for both employees and organizations.
					</p>
				</div>

				<?php
				gc_aar_report_render_quote(
					array(
						'text'          => '&ldquo;Automation anxiety <strong>is not just about job loss</strong>. It is reshaping behavior, distorting skill signals, and challenging the credibility of the modern workforce.&rdquo;',
						'wrapper_class' => 'aar-executive-summary__quote',
						'text_class'    => 'aar-executive-summary__quote-text',
					)
				);
				?>
			</div>

			<ol class="aar-report-item-list">
				<?php foreach ( $executive_findings as $index => $finding ) : ?>
					<li class="aar-report-item-list__item">
						<span class="aar-report-item-list__number" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
						<p class="aar-report-item-list__text">
							<strong><?php echo esc_html( $finding['title'] ); ?></strong>
							<?php echo esc_html( ' ' . $finding['body'] ); ?>
						</p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>

		<div class="aar-methodology" id="methodology" aria-labelledby="aar-methodology-title">
			<h2 id="aar-methodology-title" class="aar-methodology__title">Methodology</h2>

			<div class="aar-methodology__intro">
				<div class="aar-methodology__copy">
					<p>
					Online quantitative survey (Pollfish instrument ID 395577040) of n=1,500 US adults employed full-time. Fielded April 21–22, 2026, over a continuous 16-hour field window. Median completion time: 4 minutes 44 seconds. Margin of error: ±2.5 percentage points at 95% confidence at full sample.<br><br>
					Sample composition: 56% male (n=837), 44% female (n=663). Generational breakdown: Gen Z 18–29 (n=132), Millennials 30–45 (n=651), Gen X 46–61 (n=563), Baby Boomers 62–80 (n=154). Race and ethnicity: White (n=1,033), Black or African American (n=187), Hispanic (n=133), Asian (n=90). 63% hold a Bachelor’s degree or higher. All respondents passed an AI familiarity screener; 98% reported substantive familiarity with AI tools.
					<br><br>
					<strong>Subsample sizes and margins of error. Subsamples below n=100 are reported as directional only. The Asian cohort (n=90) sits just below this threshold and is flagged accordingly. The Baby Boomer cohort (n=154) and the Gen Z cohort (n=132) carry small-sample caveats per GCheck protocol.</strong>	
					</p>
				</div>
			</div>

			<div class="aar-methodology__content">
				<h3 class="aar-methodology__table-title">Subsample sizes and margins of error</h3>
				<?php
				gc_aar_report_render_data_table(
					array(
						'caption' => 'Subsample sizes and margins of error',
						'columns' => array( 'Cohort', 'n', 'MoE (95% CI)', 'Reporting posture' ),
						'rows'    => $methodology_subsample_rows,
					)
				);
				?>				
			</div>
			<div class="aar-methodology__content aar-methodology__content--footnotes">
				<p>
				Conditional questions are reported against their conditional base rather than the full sample. Q6 (reasons for AI fluency theater) is reported against n=952 respondents who selected at least one Q5 behavior. Q8 (reasons for AI resistance) is reported against n=1,212 respondents who selected at least one Q7 behavior. Q11 (self-rated ability) is reported against n=1,062 respondents who listed at least one AI skill in Q10. Q13 (primary reason for shadow search) is reported against n=813 respondents who answered Yes to Q12. Multi-select questions allow totals exceeding 100%. <br><br>
				The cross-study bridge in the closing chapter references Trust in Hiring 2026. The two samples are designed as complementary populations, not matched samples. Convergence and divergence readings are valid at the population level, not the individual level. All percentages are unweighted; results reflect sentiment within the survey window and may shift with subsequent AI market developments.
				</p>
			</div>
		</div>
	</div>
</section>
