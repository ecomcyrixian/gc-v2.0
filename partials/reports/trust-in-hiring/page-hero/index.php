<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_img_url   = get_template_directory_uri() . '/partials/reports/trust-in-hiring/page-hero/images/Tih-Report-Hero.webp';
$trust_view_url = function_exists( 'gc_secure_pdf_view_url' ) && function_exists( 'gc_secure_pdf_primary_trust_report_key' )
	? gc_secure_pdf_view_url( gc_secure_pdf_primary_trust_report_key(), get_permalink() )
	: '';
$trust_data_attrs = function_exists( 'gc_secure_pdf_download_data_attrs' ) && function_exists( 'gc_secure_pdf_primary_trust_report_key' )
	? gc_secure_pdf_download_data_attrs( gc_secure_pdf_primary_trust_report_key() )
	: '';
?>
<section class="tih-report-hero" aria-labelledby="tih-report-hero-title">
	<div class="container">
		<div class="tih-report-hero__content">
			<div class="tih-report-hero__content-inner">
				<div class="tih-report-hero__eyebrow">The 2026 Trust in Hiring Report</div>
				<h1 id="tih-report-hero-title" class="tih-report-hero__title">
					93% of Job Seekers Are Lying to You. <span>Here's<br/> What They Admitted.</span>
				</h1>
				<p class="tih-report-hero__subtitle">
					New research from 1,500 recent job applicants reveals how career-fishing,<br/> AI deception, and resume verification are eroding trust on both sides<br/> of the hiring process, and what HR leaders can do about it.
				</p>
			</div>
			<a
				class="button blue tih-report-hero__cta custom-whitepaper-hero__download-pdf-blob"
				href="<?php echo esc_url( $trust_view_url ); ?>"
				aria-label="Download the Report"
				<?php echo $trust_data_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M9.87695 12.9102C9.89157 12.9288 9.91024 12.9439 9.93156 12.9543C9.95288 12.9647 9.97629 12.9701 10 12.9701C10.0237 12.9701 10.0471 12.9701 10.0684 12.9543C10.0898 12.9439 10.1084 12.9288 10.123 12.9102L12.3105 10.1426C12.3906 10.041 12.3184 9.89062 12.1875 9.89062H10.7402V3.28125C10.7402 3.19531 10.6699 3.125 10.584 3.125H9.41211C9.32617 3.125 9.25586 3.19531 9.25586 3.28125V9.88867H7.8125C7.68164 9.88867 7.60938 10.0391 7.68945 10.1406L9.87695 12.9102ZM17.1484 12.2266H15.9766C15.8906 12.2266 15.8203 12.2969 15.8203 12.3828V15.3906H4.17969V12.3828C4.17969 12.2969 4.10938 12.2266 4.02344 12.2266H2.85156C2.76562 12.2266 2.69531 12.2969 2.69531 12.3828V16.25C2.69531 16.5957 2.97461 16.875 3.32031 16.875H16.6797C17.0254 16.875 17.3047 16.5957 17.3047 16.25V12.3828C17.3047 12.2969 17.2344 12.2266 17.1484 12.2266Z" fill="white"/>
				</svg>
				Download the Report
			</a>
		</div>
		<div class="tih-report-hero__media">
			<img class="tih-report-hero__image" fetchpriority="high" src="<?php echo esc_url( $hero_img_url ); ?>" alt="The 2026 Trust in Hiring Report" loading="eager" decoding="async">
		</div>
	</div>
</section>
