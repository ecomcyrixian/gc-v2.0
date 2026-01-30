/**
 * Blog V2 Expert Insight block
 * Wraps Gutenberg pale-cyan-blue paragraphs, adds "see more" expand and Charm Paz attribution.
 */
(function () {
    'use strict';

    var charmAvatarUrl = typeof blogV2ExpertInsight !== 'undefined' && blogV2ExpertInsight.charmAvatarUrl
        ? blogV2ExpertInsight.charmAvatarUrl
        : '';

    function init() {
        var content = document.querySelector('.blog-v2-content');
        if (!content) return;

        var paragraphs = content.querySelectorAll('p.has-pale-cyan-blue-background-color.has-background.has-medium-font-size');
        if (!paragraphs.length) return;

        paragraphs.forEach(function (p) {
            if (p.closest('.blog-v2-expert-insight')) return;

            var wrapper = document.createElement('div');
            wrapper.className = 'blog-v2-expert-insight';

            p.parentNode.insertBefore(wrapper, p);
            wrapper.appendChild(p);

            // Remove "EXPERT INSIGHT:" strong
            var firstStrong = p.querySelector('strong');
            if (firstStrong && /^\s*EXPERT INSIGHT\s*:?\s*$/i.test(firstStrong.textContent.trim())) {
                firstStrong.remove();
            }

            // Unwrap strong that wraps author attribution (e.g. "— Charm Paz, CHRP")
            var strongs = p.querySelectorAll('strong');
            strongs.forEach(function (el) {
                var text = el.textContent.trim();
                if (/^[—\-–]\s*Charm Paz/i.test(text) || /^Charm Paz,?\s*CHRP/i.test(text)) {
                    el.parentNode.replaceChild(document.createTextNode(el.textContent), el);
                }
            });

            // Remove author link and preceding dash (e.g. " – <a href="...">Charm Paz, CHRP</a>")
            var authorLinks = p.querySelectorAll('a[href*="author/charm"], a[href*="author/charm-paz"]');
            authorLinks.forEach(function (a) {
                var text = a.textContent.trim();
                if (!/Charm Paz/i.test(text)) return;
                // Trim preceding " – ", " - ", "— " from previous sibling text node
                var prev = a.previousSibling;
                if (prev && prev.nodeType === Node.TEXT_NODE) {
                    prev.textContent = prev.textContent.replace(/\s*[–\-—]\s*$/, '');
                }
                a.remove();
            });

            var needsTruncate = p.textContent.trim().length > 180;

            if (needsTruncate) {
                var seeMore = document.createElement('button');
                seeMore.type = 'button';
                seeMore.className = 'blog-v2-expert-insight__see-more';
                seeMore.setAttribute('aria-expanded', 'false');
                seeMore.textContent = '… see more';
                wrapper.appendChild(seeMore);

                seeMore.addEventListener('click', function () {
                    var expanded = wrapper.classList.toggle('is-expanded');
                    seeMore.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                    seeMore.textContent = expanded ? 'see less' : '… see more';
                });
            }

            if (charmAvatarUrl) {
                var charmLink = typeof blogV2ExpertInsight !== 'undefined' && blogV2ExpertInsight.charmLink
                    ? blogV2ExpertInsight.charmLink
                    : '#';
                var attribution = document.createElement('div');
                attribution.className = 'blog-v2-expert-insight__attribution';
                attribution.innerHTML =
                    '<a href="' + charmLink + '" class="blog-v2-expert-insight__attribution-link">' +
                    '<img src="' + charmAvatarUrl + '" alt="Charm Paz" width="40" height="40">' +
                    '<div class="blog-v2-expert-insight__attribution-text">' +
                    '<span class="blog-v2-expert-insight__attribution-name">Charm Paz, CHRP</span>' +
                    '<span class="blog-v2-expert-insight__attribution-title">Recruiter and Editor, GCheck</span>' +
                    '</div>' +
                    '</a>';
                wrapper.appendChild(attribution);
            }

            // Remove hr separators immediately before and after the expert insight block
            var prev = wrapper.previousElementSibling;
            if (prev && prev.matches && prev.matches('hr.wp-block-separator')) {
                prev.remove();
            }
            var next = wrapper.nextElementSibling;
            if (next && next.matches && next.matches('hr.wp-block-separator')) {
                next.remove();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
