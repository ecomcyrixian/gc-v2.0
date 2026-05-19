<?php
$wb_images_uri = get_template_directory_uri() . '/partials/home/whitepaper-banner/images';

$wb_slides = array(
	array(
		'url'            => home_url( '/whitepapers/trust-in-hiring-report/' ),
		'title'          => '93% of Job Seekers Are Lying. It Goes Further Than You Think.',
		'description'    => 'Discover how to detect deception and make the hiring process faster and more reliable. From entering candidate information to receiving fully compliant background reports, every step is automated to save you time and ensure accuracy.',
		'thumbnail'      => $wb_images_uri . '/Whitepaper-Thumbnail.webp',
		'thumbnail_alt'  => __( 'The 2026 Trust in Hiring Report', 'GCheck v2.0' ),
		'thumbnail_aria' => __( 'The 2026 Trust in Hiring Report', 'GCheck v2.0' ),
	),
	array(
		'url'            => home_url( '/whitepapers/automation-anxiety-report/' ),
		'title'          => '63% of Workers Are Faking AI Skills. Here’s What They Admitted.',
		'description'    => 'New research from 1,500 US full-time employed adults reveals how the AI Skills Bubble, the Double Distortion, and the Verification Vacuum are reshaping what workers tell their employers, and what HR leaders can do about it.',
		'thumbnail'      => $wb_images_uri . '/Whitepaper-Thumbnail-2.webp',
		'thumbnail_alt'  => __( 'Automation Anxiety Report', 'GCheck v2.0' ),
		'thumbnail_aria' => __( 'Automation Anxiety Report', 'GCheck v2.0' ),
	),
);
?>
<div id="whitepaper-banner">
	<div
		class="wb-swiper-shell swiper wb-swiper"
		aria-roledescription="<?php esc_attr_e( 'carousel', 'GCheck v2.0' ); ?>"
		aria-label="<?php esc_attr_e( 'Featured reports', 'GCheck v2.0' ); ?>"
	>
		<div class="swiper-wrapper">
			<?php foreach ( $wb_slides as $index => $slide ) : ?>
				<div class="swiper-slide" role="group" aria-label="<?php echo esc_attr( sprintf( __( 'Slide %1$d of %2$d', 'GCheck v2.0' ), $index + 1, count( $wb_slides ) ) ); ?>">
					<div class="wb-card">
						<div class="wb-content">
							<pre><?php esc_html_e( 'Whitepaper', 'GCheck v2.0' ); ?></pre>
							<h2>
								<a href="<?php echo esc_url( $slide['url'] ); ?>">
									<?php echo esc_html( $slide['title'] ); ?>
								</a>
							</h2>
						</div>
						<div class="wb-thumbnail">
							<a href="<?php echo esc_url( $slide['url'] ); ?>" aria-label="<?php echo esc_attr( $slide['thumbnail_aria'] ); ?>">
								<img
									src="<?php echo esc_url( $slide['thumbnail'] ); ?>"
									alt="<?php echo esc_attr( $slide['thumbnail_alt'] ); ?>"
									<?php echo 0 === $index ? 'fetchpriority="high"' : 'loading="lazy"'; ?>
									decoding="async"
								>
							</a>
						</div>
						<div class="wb-info">
							<p><?php echo esc_html( $slide['description'] ); ?></p>
							<a href="<?php echo esc_url( $slide['url'] ); ?>" class="button blue"><?php esc_html_e( 'Get the Report', 'GCheck v2.0' ); ?></a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="swiper-pagination wb-swiper__pagination"></div>
	</div>
</div>
<div id="as-featured-in">
	<div class="container">
		<div class="as-featured-in-title"><?php esc_html_e( 'As Featured In', 'GCheck v2.0' ); ?></div>
	</div>
	<div class="as-featured-in-logos">
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/forbes-logo.webp' ); ?>" alt="<?php esc_attr_e( 'Forbes-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/inc-logo.webp' ); ?>" alt="<?php esc_attr_e( 'Inc-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/hr-1-logo.webp' ); ?>" alt="<?php esc_attr_e( 'HR-1-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/shrm-logo.webp' ); ?>" alt="<?php esc_attr_e( 'SHRM-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/hr-2-logo.webp' ); ?>" alt="<?php esc_attr_e( 'HR-2-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/pulse-logo.webp' ); ?>" alt="<?php esc_attr_e( 'Pulse-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/advisor-logo.webp' ); ?>" alt="<?php esc_attr_e( 'Advisor-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
		<div class="as-featured-in-logos-item">
			<img src="<?php echo esc_url( $wb_images_uri . '/hrd-logo.webp' ); ?>" alt="<?php esc_attr_e( 'HRD-logo', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
		</div>
	</div>
</div>
