/**
 * Whitepaper PDF: POST admin-ajax (nonce) → blob download (real file URL not in markup).
 *
 * GTM / GA4: pushes GA4’s recommended `file_download` event (see GA4 event reference).
 * One push per pdf `content_id` per browser tab session (reduces double-count from repeat clicks).
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

	document.addEventListener('click', async function (event) {
		var link = event.target.closest('a.custom-whitepaper-hero__download-pdf-blob');
		if (!link || link.tagName !== 'A') {
			return;
		}
		event.preventDefault();
		var root = link.closest('[data-gc-pdf-ajax]');
		if (!root) {
			return;
		}
		var ajaxUrl = root.getAttribute('data-gc-pdf-ajax');
		var nonce = root.getAttribute('data-gc-pdf-nonce');
		var key = link.getAttribute('data-gc-pdf-key');
		if (!ajaxUrl || !nonce || !key || link.getAttribute('aria-busy') === 'true') {
			return;
		}
		link.setAttribute('aria-busy', 'true');
		try {
			var fd = new FormData();
			fd.append('action', 'gc_secure_pdf');
			fd.append('nonce', nonce);
			fd.append('key', key);
			var res = await fetch(ajaxUrl, { method: 'POST', credentials: 'same-origin', body: fd });
			var ct = (res.headers.get('Content-Type') || '').toLowerCase();
			if (!res.ok || !ct.includes('application/pdf')) {
				throw new Error('bad response');
			}
			var blob = await res.blob();
			var fileName = link.getAttribute('data-gc-pdf-filename') || 'report.pdf';
			var u = URL.createObjectURL(blob);
			var a = document.createElement('a');
			a.download = fileName;
			a.href = u;
			a.rel = 'noopener';
			document.body.appendChild(a);
			a.click();
			a.remove();
			URL.revokeObjectURL(u);
			gcPushWhitepaperPdfDataLayer(key, fileName);
		} catch (e) {
			window.location.reload();
		} finally {
			link.removeAttribute('aria-busy');
		}
	});
})();
