<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="gc-bing-consent-bar" class="gc-bing-consent-bar" role="dialog" aria-labelledby="gc-bing-consent-title" aria-live="polite" hidden>
	<div class="gc-bing-consent-inner">
		<p id="gc-bing-consent-title" class="gc-bing-consent-text">
			We use cookies and similar technologies for advertising and measurement. By accepting, you agree to ad-related storage for Microsoft Advertising (Bing UET) as described in our
			<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>.
		</p>
		<div class="gc-bing-consent-actions">
			<button type="button" class="gc-bing-consent-btn gc-bing-consent-btn--secondary" id="gc-bing-consent-reject">Reject</button>
			<button type="button" class="gc-bing-consent-btn gc-bing-consent-btn--primary" id="gc-bing-consent-accept">Accept</button>
		</div>
	</div>
</div>
