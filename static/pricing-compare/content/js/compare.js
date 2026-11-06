(function () {
	'use strict';

	var cfg = window.gcPricingCompare || {};
	var coverages = cfg.coverages || {};
	var labels = cfg.bar_labels || {};
	var coverageText = cfg.coverage_text || {};
	var coverage = 'current';
	var range = document.getElementById('pc-hires');
	var numberInput = document.getElementById('pc-hires-num');
	var coverageButtons = document.querySelectorAll('#pc-cov button');

	if (!range || !numberInput || !coverages.current) {
		return;
	}

	function money(value) {
		return Number(value).toLocaleString('en-US', {
			style: 'currency',
			currency: 'USD',
			maximumFractionDigits: 0
		});
	}

	function render(count) {
		count = Math.max(1, Math.min(100000, Math.round(count) || 1));

		var prices = coverages[coverage] || coverages.current;
		var totals = prices.map(function (price) {
			return price === null ? null : Math.round(count * price * 100) / 100;
		});
		var published = totals.filter(function (total) {
			return total !== null;
		});
		var max = Math.max.apply(null, published);

		totals.forEach(function (total, index) {
			var bar = document.getElementById('pc-b' + index);
			var amount = document.getElementById('pc-a' + index);

			if (bar) {
				bar.style.width = (total === null || !max ? 0 : total / max * 100) + '%';
			}
			if (amount) {
				amount.textContent = total === null ? 'Not published' : money(total);
			}

			var label = document.getElementById('pc-l' + index);
			var set = labels[coverage] || [];

			if (label) {
				label.textContent = set[index] || '';
			}
		});

		var saved = document.getElementById('pc-save-v');
		var savedText = document.getElementById('pc-save-t');
		var next = Math.min.apply(null, published.slice(1));

		if (saved) {
			saved.textContent = money(next - totals[0]);
		}
		if (savedText) {
			savedText.textContent = 'less per year than the next lowest published price, at ' + count.toLocaleString('en-US') + ' checks ' + (coverageText[coverage] || '') + '.';
		}
	}

	range.addEventListener('input', function () {
		numberInput.value = range.value;
		render(Number(range.value));
	});

	numberInput.addEventListener('input', function () {
		if (numberInput.value) {
			range.value = Math.min(2000, Number(numberInput.value));
			render(Number(numberInput.value));
		}
	});

	coverageButtons.forEach(function (button) {
		button.addEventListener('click', function () {
			coverage = button.getAttribute('data-cov');
			coverageButtons.forEach(function (item) {
				item.setAttribute('aria-pressed', String(item === button));
			});
			render(Number(numberInput.value));
		});
	});

	if (numberInput.value !== numberInput.defaultValue) {
		render(Number(numberInput.value) || 250);
	}
})();
