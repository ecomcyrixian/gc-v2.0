<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image = get_template_directory_uri() . '/partials/reports/automation-anxiety/page-hero/images/page-hero-bg.webp';
$hero_stats = array(
	array(
		'value' => '69%',
		'text'  => 'of US workers expect parts of their job to be automated by AI within 24 months. The figure rises to 79% for Gen Z.',
	),
	array(
		'value' => '63%',
		'text'  => 'have lied or exaggerated their AI skills to appear more knowledgeable than they are. The figure reaches 80% for Gen Z and 70% for men.',
	),
	array(
		'value' => '81%',
		'text'  => 'of workers report engaging in at least one behavior to discourage or limit AI use at work, while simultaneously overstating their own AI skills.',
	),
	array(
		'value' => '64%',
		'text'  => 'of workers have not had their AI skills verified by an employer. 76% say AI misrepresentation creates business risk.',
	),
	array(
		'value' => '29%',
		'text'  => 'of workers would present themselves more honestly if employers clearly disclosed what would be independently verified.',
	),
);
?>
<section class="aar-report-hero" aria-labelledby="aar-report-hero-title">
	<div class="aar-report-hero__background" aria-hidden="true">
		<img
			src="<?php echo esc_url( $hero_image ); ?>"
			alt=""
			class="aar-report-hero__background-image"
			fetchpriority="high"
			loading="eager"
			decoding="async"
		>
	</div>

	<div class="container">
		<div class="aar-report-hero__content">
			<p class="aar-report-hero__badge">2026</p>
			<h1 id="aar-report-hero-title" class="aar-report-hero__title">The Automation Anxiety Report</h1>
			<p class="aar-report-hero__subtitle">
			How AI Is Reshaping What US Workers Tell Employers, Coworkers, and Themselves
			</p>
			<a href="<?php echo esc_url( gc_aar_report_pdf_view_url() ); ?>" class="button white aar-report-hero__cta custom-whitepaper-hero__download-pdf-blob" aria-label="<?php esc_attr_e( 'Download the Report', 'gc-v2' ); ?>"<?php echo gc_aar_report_pdf_download_data_attrs(); ?>>
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
<path d="M9.87695 12.9102C9.89157 12.9288 9.91024 12.9439 9.93156 12.9543C9.95288 12.9647 9.97629 12.9701 10 12.9701C10.0237 12.9701 10.0471 12.9647 10.0684 12.9543C10.0898 12.9439 10.1084 12.9288 10.123 12.9102L12.3105 10.1426C12.3906 10.041 12.3184 9.89062 12.1875 9.89062H10.7402V3.28125C10.7402 3.19531 10.6699 3.125 10.584 3.125H9.41211C9.32617 3.125 9.25586 3.19531 9.25586 3.28125V9.88867H7.8125C7.68164 9.88867 7.60938 10.0391 7.68945 10.1406L9.87695 12.9102ZM17.1484 12.2266H15.9766C15.8906 12.2266 15.8203 12.2969 15.8203 12.3828V15.3906H4.17969V12.3828C4.17969 12.2969 4.10938 12.2266 4.02344 12.2266H2.85156C2.76562 12.2266 2.69531 12.2969 2.69531 12.3828V16.25C2.69531 16.5957 2.97461 16.875 3.32031 16.875H16.6797C17.0254 16.875 17.3047 16.5957 17.3047 16.25V12.3828C17.3047 12.2969 17.2344 12.2266 17.1484 12.2266Z" fill="#4F51FD"/>
</svg>

				<span><?php esc_html_e( 'Download the Report', 'gc-v2' ); ?></span>
			</a>
		</div>

		<div class="cards fundamentals card-same-height aar-report-hero__stats">
			<div class="card-cont cols5 card-same-height">
				<?php foreach ( $hero_stats as $stat ) : ?>
					<div class="card-item">
						<h4><span><?php echo esc_html( $stat['value'] ); ?></span></h4>
						<div class="card-item__divider" aria-hidden="true"></div>
						<p><?php echo esc_html( $stat['text'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
