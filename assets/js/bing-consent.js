(function () {
	'use strict';

	var STORAGE_KEY = 'gc_uet_ad_storage_consent';

	function getStoredConsent() {
		try {
			return window.localStorage.getItem(STORAGE_KEY);
		} catch (e) {
			return null;
		}
	}

	function setStoredConsent(value) {
		try {
			window.localStorage.setItem(STORAGE_KEY, value);
		} catch (e) {}
	}

	function pushUetGranted() {
		window.uetq = window.uetq || [];
		window.uetq.push('consent', 'update', {
			ad_storage: 'granted',
		});
	}

	function hideBar() {
		var bar = document.getElementById('gc-bing-consent-bar');
		if (!bar) {
			return;
		}
		bar.setAttribute('hidden', '');
		bar.classList.remove('gc-bing-consent-bar--visible');
		bar.setAttribute('aria-hidden', 'true');
	}

	function showBar() {
		var bar = document.getElementById('gc-bing-consent-bar');
		if (!bar) {
			return;
		}
		bar.removeAttribute('hidden');
		bar.classList.add('gc-bing-consent-bar--visible');
		bar.setAttribute('aria-hidden', 'false');
	}

	function init() {
		var stored = getStoredConsent();
		if (stored === 'granted') {
			pushUetGranted();
			return;
		}
		if (stored === 'denied') {
			return;
		}
		showBar();
	}

	var acceptBtn = document.getElementById('gc-bing-consent-accept');
	if (acceptBtn) {
		acceptBtn.addEventListener('click', function () {
			setStoredConsent('granted');
			pushUetGranted();
			hideBar();
		});
	}

	var rejectBtn = document.getElementById('gc-bing-consent-reject');
	if (rejectBtn) {
		rejectBtn.addEventListener('click', function () {
			setStoredConsent('denied');
			hideBar();
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
