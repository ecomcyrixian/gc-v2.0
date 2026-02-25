/**
 * Blog V2 Expert Insight block
 * Structure (wrapper, see more, attribution) is output server-side to avoid CLS.
 * This script only toggles expand/collapse when "see more" is clicked.
 * Init delayed with requestIdleCallback to reduce main-thread work on mobile.
 */
(function () {
    'use strict';

    function runWhenIdle(cb) {
        var timeout = 2000;
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(cb, { timeout: timeout });
        } else {
            setTimeout(cb, 1);
        }
    }

    function init() {
        var buttons = document.querySelectorAll('.blog-v2-expert-insight__see-more');
        buttons.forEach(function (seeMore) {
            var wrapper = seeMore.closest('.blog-v2-expert-insight');
            if (!wrapper) return;

            seeMore.addEventListener('click', function () {
                var expanded = wrapper.classList.toggle('is-expanded');
                seeMore.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                seeMore.textContent = expanded ? 'show less' : '… show more';
            });
        });

        // Avatar image fallback to initials on error (structure is server-rendered)
        document.querySelectorAll('.blog-v2-expert-insight__attribution-img').forEach(function (img) {
            var initialsEl = img.closest('.blog-v2-expert-insight__attribution-avatar').querySelector('.blog-v2-expert-insight__attribution-avatar-initials');
            if (!initialsEl) return;
            var name = img.getAttribute('alt') || '';
            var parts = name.trim().split(/\s+/).filter(Boolean);
            var initials = parts.length >= 2 ? (parts[0].charAt(0) + parts[1].charAt(0)).toUpperCase() : name.substring(0, 2).toUpperCase();
            img.addEventListener('error', function () {
                img.style.display = 'none';
                initialsEl.textContent = initials;
                initialsEl.style.display = 'flex';
            });
        });
    }

    function runInit() {
        runWhenIdle(init);
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runInit);
    } else {
        runInit();
    }
})();
