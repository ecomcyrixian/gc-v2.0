/**
 * Blog V2 Expert Insight block
 * Wraps Gutenberg pale-cyan-blue paragraphs, adds "see more" expand and dynamic expert attribution.
 */
(function () {
    'use strict';

    var config = typeof blogV2ExpertInsight !== 'undefined' ? blogV2ExpertInsight : {};
    var experts = config.experts || {};
    var defaultCharm = {
        name: 'Charm Paz, CHRP',
        title: 'Recruiter and Editor, GCheck',
        avatar: config.charmAvatarUrl || '',
        link: config.charmLink || '#'
    };

    function slugFromAuthorHref(href) {
        if (!href || typeof href !== 'string') return '';
        var m = href.match(/author\/([^\/?#]+)/);
        return m ? m[1].toLowerCase() : '';
    }

    function getExpertForSlug(slug) {
        if (!slug) return defaultCharm.avatar ? defaultCharm : null;
        var expert = experts[slug];
        if (expert && expert.avatar) return expert;
        if (slug === 'charm' || slug === 'charm-paz') return defaultCharm.avatar ? defaultCharm : null;
        return expert || null;
    }

    function getInitials(name) {
        if (!name || typeof name !== 'string') return '';
        var parts = name.trim().split(/\s+/).filter(Boolean);
        if (parts.length >= 2) return (parts[0].charAt(0) + parts[1].charAt(0)).toUpperCase();
        return name.substring(0, 2).toUpperCase();
    }

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

            // Capture expert slug from first author link before removing
            var authorLinks = p.querySelectorAll('a[href*="author/"]');
            var expertSlug = '';
            if (authorLinks.length) {
                var href = authorLinks[0].getAttribute('href') || '';
                expertSlug = slugFromAuthorHref(href);
            }

            // Remove author link and preceding dash (e.g. " - <a href="...">Charm Paz, CHRP</a>" or " - <a href="...">Emile Garcia, SHRM-SCP, CHRP, CHRBP</a>")
            authorLinks.forEach(function (a) {
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

            var expert = getExpertForSlug(expertSlug);
            if (expert && (expert.avatar || expert.name)) {
                var link = expert.link || '#';
                var name = expert.name || defaultCharm.name;
                var title = expert.title || defaultCharm.title;
                var initials = getInitials(name);
                var attribution = document.createElement('div');
                attribution.className = 'blog-v2-expert-insight__attribution';
                var avatarClass = 'blog-v2-expert-insight__attribution-avatar';
                if (!expert.avatar) avatarClass += ' blog-v2-expert-insight__attribution-avatar--initials';
                attribution.innerHTML =
                    '<a href="' + link + '" class="blog-v2-expert-insight__attribution-link">' +
                    '<span class="' + avatarClass + '">' +
                    (expert.avatar
                        ? '<img src="' + expert.avatar + '" alt="' + name.replace(/"/g, '&quot;') + '" width="40" height="40" class="blog-v2-expert-insight__attribution-img">' +
                          '<span class="blog-v2-expert-insight__attribution-avatar-initials" aria-hidden="true"></span>'
                        : '<span class="blog-v2-expert-insight__attribution-avatar-initials" aria-hidden="true">' + initials + '</span>') +
                    '</span>' +
                    '<div class="blog-v2-expert-insight__attribution-text">' +
                    '<span class="blog-v2-expert-insight__attribution-name">' + name + '</span>' +
                    '<span class="blog-v2-expert-insight__attribution-title">' + title + '</span>' +
                    '</div>' +
                    '</a>';
                wrapper.appendChild(attribution);

                if (expert.avatar) {
                    var img = attribution.querySelector('.blog-v2-expert-insight__attribution-img');
                    var initialsEl = attribution.querySelector('.blog-v2-expert-insight__attribution-avatar-initials');
                    if (img && initialsEl) {
                        img.addEventListener('error', function () {
                            img.style.display = 'none';
                            initialsEl.textContent = initials;
                            initialsEl.style.display = 'flex';
                        });
                    }
                }
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
