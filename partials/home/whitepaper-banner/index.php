<?php
$wb_report_url = home_url( '/whitepapers/trust-in-hiring-report/' );
?>
<div id="whitepaper-banner">
    <div class="wb-card">
        <div class="wb-content">
            <pre>Whitepaper</pre>
            <h2><a href="<?php echo esc_url( $wb_report_url ); ?>">93% of Job Seekers Are Lying. It Goes Further Than You Think.</a></h2>
        </div>
        <div class="wb-thumbnail">
            <a href="<?php echo esc_url( $wb_report_url ); ?>" aria-label="<?php esc_attr_e( 'The 2026 Trust in Hiring Report', 'GCheck v2.0' ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/partials/home/whitepaper-banner/images/Whitepaper-Thumbnail.webp' ); ?>" alt="<?php esc_attr_e( 'The 2026 Trust in Hiring Report', 'GCheck v2.0' ); ?>" loading="lazy" decoding="async">
            </a>
        </div>
        <div class="wb-info">
            <p>Discover how to detect deception and make the hiring process faster and more reliable. From entering candidate information to receiving fully compliant background reports, every step is automated to save you time and ensure accuracy.</p>
            <a href="<?php echo esc_url( $wb_report_url ); ?>" class="button blue">Get the Report</a>
        </div>
    </div>
</div>
