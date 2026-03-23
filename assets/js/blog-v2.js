/**
 * Blog V2
 */

/* Progress Bar */
(function() {
    'use strict';

    function runWhenIdle(cb) {
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(cb, { timeout: 2000 });
        } else {
            setTimeout(cb, 1);
        }
    }

    function initProgressBar() {
        var progressBar = document.getElementById('blog-hero-progress-bar');
        var progressFill = document.getElementById('blog-hero-progress-fill');
        if (!progressBar || !progressFill) return;

        var wrapper = progressBar.closest('.blog-v2-progress-wrapper');
        if (wrapper) {
            var reserveH = progressBar.offsetHeight || 3;
            wrapper.style.minHeight = reserveH + 'px';
            wrapper.style.height = reserveH + 'px';
            wrapper.style.overflow = 'visible';
        }

        var progressColor = progressBar.getAttribute('data-progress-color') || '#4F51FD';
        progressFill.style.backgroundColor = progressColor;

        var header = document.getElementById('header-cont');
        var layoutContainer = document.querySelector('.blog-v2-layout');
        var content = document.querySelector('.blog-v2-content');
        var initialWidth = 150;

        function getScrollTop() {
            var se = document.scrollingElement || document.documentElement;
            return se.scrollTop != null ? se.scrollTop : window.pageYOffset || 0;
        }

        function getProgressBarTopPx() {
            if (!header) return 0;
            var hr = header.getBoundingClientRect();
            if (hr.bottom <= 0) return 0;
            return Math.max(0, Math.round(hr.bottom));
        }

        function calculateLayoutTop() {
            if (!layoutContainer) return null;
            var rect = layoutContainer.getBoundingClientRect();
            return rect.top + getScrollTop();
        }

        function calculateContentBottom() {
            if (!content) return null;
            var rect = content.getBoundingClientRect();
            return rect.top + getScrollTop() + content.offsetHeight;
        }

        function updateProgressBar() {
            var windowHeight = window.innerHeight;
            var scrollTop = getScrollTop();
            var maxWidth = Math.max(
                document.documentElement.clientWidth || window.innerWidth || 0,
                1
            );

            var layoutTop = calculateLayoutTop();
            if (layoutTop === null) {
                var barRect = progressBar.getBoundingClientRect();
                layoutTop = barRect.top + getScrollTop();
            }
            var contentBottom = calculateContentBottom();
            if (contentBottom === null) return;

            var headerOffset = getProgressBarTopPx();
            var sidebarStickyTop = 130;
            var stickyTriggerPoint = layoutTop - sidebarStickyTop;
            var documentBottom = scrollTop + windowHeight;
            var scrollableContentHeight = contentBottom - layoutTop;
            var scrolledPastLayout = scrollTop - layoutTop;

            var isSticky = scrollTop >= stickyTriggerPoint;
            var progress = 0;
            if (scrollableContentHeight > 0) {
                progress = Math.min(Math.max(scrolledPastLayout / scrollableContentHeight, 0), 1);
            } else {
                progress = 1;
            }
            if (documentBottom >= contentBottom - 50) progress = 1;

            var currentWidth = isSticky
                ? initialWidth + (progress * (maxWidth - initialWidth))
                : initialWidth;

            if (isSticky) {
                if (!progressBar.classList.contains('is-sticky')) {
                    progressBar.classList.add('is-sticky');
                    if (wrapper) wrapper.classList.add('is-sticky-active');
                }
                if (progressBar.parentNode !== document.body) {
                    document.body.appendChild(progressBar);
                }
                progressBar.style.top = headerOffset + 'px';
                progressBar.style.left = '0';
                progressBar.style.right = '0';
                progressBar.style.width = '100%';
                progressBar.style.zIndex = '99990';
                progressFill.style.width = currentWidth + 'px';
            } else {
                if (progressBar.classList.contains('is-sticky')) {
                    progressBar.classList.remove('is-sticky');
                    if (wrapper) wrapper.classList.remove('is-sticky-active');
                }
                if (wrapper && progressBar.parentNode !== wrapper) {
                    wrapper.appendChild(progressBar);
                }
                progressBar.style.top = '';
                progressBar.style.left = '';
                progressBar.style.right = '';
                progressBar.style.width = '';
                progressBar.style.zIndex = '';
                progressFill.style.width = currentWidth + 'px';
            }
        }

        var ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    updateProgressBar();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        window.addEventListener('resize', function() {
            if (wrapper) {
                var rh = progressBar.offsetHeight || 3;
                wrapper.style.minHeight = rh + 'px';
                wrapper.style.height = rh + 'px';
            }
            updateProgressBar();
        });

        updateProgressBar();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() { runWhenIdle(initProgressBar); });
    } else {
        runWhenIdle(initProgressBar);
    }
})();

/* Table of Contents */
(function() {
    'use strict';

    function runWhenIdle(cb) {
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(cb, { timeout: 2000 });
        } else {
            setTimeout(cb, 1);
        }
    }

    function initTOC() {
        var tocList = document.getElementById('blog-v2-toc-list');
        var content = document.querySelector('.blog-v2-content');
        if (!tocList || !content) return;
        if (window.innerWidth < 768) return;

        var excludedSelector = '._article-keytakeaways, .wp-block-group._article-keytakeaways';
        var cachedContentBottom = null;
        var cachedHeadingTops = null;

        function getTOCHeadings() {
            var all = content.querySelectorAll('h2.wp-block-heading');
            var filtered = [];
            all.forEach(function(h) {
                if (!h.closest(excludedSelector)) filtered.push(h);
            });
            return filtered;
        }

        function getContentBottom() {
            if (cachedContentBottom !== null) return cachedContentBottom;
            var rect = content.getBoundingClientRect();
            cachedContentBottom = rect.top + window.pageYOffset + content.offsetHeight;
            return cachedContentBottom;
        }

        function getHeadingTops(headings) {
            if (cachedHeadingTops !== null && cachedHeadingTops.length === headings.length) return cachedHeadingTops;
            cachedHeadingTops = headings.map(function(h) {
                var r = h.getBoundingClientRect();
                return r.top + window.pageYOffset;
            });
            return cachedHeadingTops;
        }

        tocList.querySelectorAll('.blog-v2-toc__link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = link.getAttribute('href');
                var target = document.querySelector(targetId);
                if (target) {
                    var top = target.getBoundingClientRect().top + window.pageYOffset - 130;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        });

        function updateActiveTOC() {
            var scrollTop = window.pageYOffset;
            var windowHeight = window.innerHeight;
            var scrollBottom = scrollTop + windowHeight / 3;
            var documentBottom = scrollTop + windowHeight;
            var cBottom = getContentBottom();
            var maxScrollTop = document.documentElement.scrollHeight - windowHeight;

            var headings = getTOCHeadings();
            var allLinks = tocList.querySelectorAll('.blog-v2-toc__link');
            if (headings.length === 0 || cBottom == null) return;

            var headingTops = getHeadingTops(headings);
            var currentActiveIndex = -1;

            headings.forEach(function(h, index) {
                var id = h.getAttribute('id');
                if (!id) return;
                var headingTop = headingTops[index] || 0;
                if (headingTop <= scrollBottom) {
                    var link = tocList.querySelector('a[href="#' + id + '"]');
                    if (link) {
                        var linkArr = Array.prototype.slice.call(allLinks);
                        currentActiveIndex = linkArr.indexOf(link);
                    }
                }
            });

            if ((documentBottom >= cBottom - 10 || scrollTop >= maxScrollTop - 2) && headings.length > 0) {
                var lastH = headings[headings.length - 1];
                var lastId = lastH.getAttribute('id');
                if (lastId) {
                    var lastLink = tocList.querySelector('a[href="#' + lastId + '"]');
                    if (lastLink) {
                        var linkArr = Array.prototype.slice.call(allLinks);
                        currentActiveIndex = linkArr.indexOf(lastLink);
                    }
                }
            }

            allLinks.forEach(function(link, index) {
                link.classList.remove('is-active', 'is-visited');
                if (currentActiveIndex >= 0 && index <= currentActiveIndex) {
                    link.classList.add('is-visited');
                    if (index === currentActiveIndex) link.classList.add('is-active');
                }
            });
        }

        var ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    updateActiveTOC();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        updateActiveTOC();

        window.addEventListener('resize', function() {
            cachedContentBottom = null;
            cachedHeadingTops = null;
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() { runWhenIdle(initTOC); });
    } else {
        runWhenIdle(initTOC);
    }
})();

/* Expert Insight */
(function () {
    'use strict';

    function runWhenIdle(cb) {
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(cb, { timeout: 2000 });
        } else {
            setTimeout(cb, 1);
        }
    }

    function init() {
        document.querySelectorAll('.blog-v2-expert-insight__see-more').forEach(function (seeMore) {
            var wrapper = seeMore.closest('.blog-v2-expert-insight');
            if (!wrapper) return;

            seeMore.addEventListener('click', function () {
                var expanded = wrapper.classList.toggle('is-expanded');
                seeMore.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                seeMore.textContent = expanded ? 'show less' : '… show more';
            });
        });

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

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() { runWhenIdle(init); });
    } else {
        runWhenIdle(init);
    }
})();
