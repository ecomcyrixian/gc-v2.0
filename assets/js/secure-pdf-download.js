/**
 * Secure whitepaper PDF links: GA4 file_download on click; browser follows href (signed stream URL).
 *
 * Markup: <a href="…" data-gc-pdf-key="registry_key" data-gc-pdf-filename="name.pdf">…</a>
 * One push per content_id per browser tab session (reduces double-count from repeat clicks).
 */
(function () {
	'use strict';

	var GA4_EVENT_FILE_DOWNLOAD = 'file_download';

	/**
	 * @param {string} key Server registry id (no public URL).
	 * @param {string} filename Suggested save-as name.
	 */
	function gcPushWhitepaperPdfDataLayer(key, filename) {
		if (!key) {
			return;
		}
		var payload = {
			event: GA4_EVENT_FILE_DOWNLOAD,
			file_extension: 'pdf',
			file_name: filename || '',
			content_id: key,
			content_type: 'whitepaper',
		};
		try {
			var storageKey = 'gc_gtm_pdf_dl_' + key;
			if (window.sessionStorage && sessionStorage.getItem(storageKey)) {
				return;
			}
			window.dataLayer = window.dataLayer || [];
			window.dataLayer.push(payload);
			if (window.sessionStorage) {
				sessionStorage.setItem(storageKey, '1');
			}
		} catch (e) {
			try {
				window.dataLayer = window.dataLayer || [];
				window.dataLayer.push(payload);
			} catch (e2) {}
		}
	}

	document.addEventListener(
		'click',
		function (event) {
			var link = event.target.closest('a[data-gc-pdf-key]');
			if (!link || link.tagName !== 'A') {
				return;
			}
			var key = link.getAttribute('data-gc-pdf-key');
			if (!key) {
				return;
			}
			var fileName = link.getAttribute('data-gc-pdf-filename') || 'report.pdf';
			gcPushWhitepaperPdfDataLayer(key, fileName);
		},
		true
	);
})();
