/**
 * Blog V2 – combined bundle (progress bar, TOC, expert insight).
 * Loaded only on single posts via is_single().
 * Each feature is a self-contained IIFE with its own guard clause
 * so it silently no-ops when its DOM elements are absent.
 */

/* ── Progress Bar ────────────────────────────────────────────── */
(function($) {
    'use strict';

    function runWhenIdle(cb) {
        var timeout = 2000;
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(cb, { timeout: timeout });
        } else {
            setTimeout(cb, 1);
        }
    }

    function initProgressBar() {
        const $progressBar = $('#blog-hero-progress-bar');
        const $progressFill = $('#blog-hero-progress-fill');
        const $wrapper = $progressBar.closest('.blog-v2-progress-wrapper');
        
        if (!$progressBar.length || !$progressFill.length) {
            return;
        }

        const progressColor = $progressBar.data('progress-color') || '#4F51FD';
        $progressFill.css('background-color', progressColor);

        const $header = $('#header-cont');
        const $layoutContainer = $('.blog-v2-layout');
        const $content = $('.blog-v2-content');
        const initialWidth = 150;

        let layoutContainerTop = null;
        let contentBottom = null;
        let cachedNavbarHeight = null;
        let cachedMaxWidth = null;

        function getNavbarHeight() {
            if (cachedNavbarHeight !== null) return cachedNavbarHeight;
            if (!$header.length) return 0;
            cachedNavbarHeight = $header.outerHeight() || 0;
            return cachedNavbarHeight;
        }

        function getProgressBarWidth() {
            if (cachedMaxWidth !== null) return cachedMaxWidth;
            cachedMaxWidth = document.documentElement.clientWidth;
            return cachedMaxWidth;
        }

        function calculateLayoutTop() {
            if ($layoutContainer.length) {
                const layoutOffset = $layoutContainer.offset();
                if (layoutOffset) {
                    return layoutOffset.top;
                }
            }
            return null;
        }

        function calculateContentBottom() {
            if ($content.length) {
                const contentOffset = $content.offset();
                const contentHeight = $content.outerHeight();
                if (contentOffset && contentHeight) {
                    return contentOffset.top + contentHeight;
                }
            }
            return null;
        }

        function updateProgressBar() {
            const windowHeight = $(window).height();
            const scrollTop = $(window).scrollTop();
            const maxWidth = getProgressBarWidth();

            if (layoutContainerTop === null) {
                layoutContainerTop = calculateLayoutTop();
                if (layoutContainerTop === null) {
                    const progressBarOffset = $progressBar.offset();
                    if (progressBarOffset) {
                        layoutContainerTop = progressBarOffset.top;
                    } else {
                        return;
                    }
                }
            }
            if (contentBottom === null) {
                contentBottom = calculateContentBottom();
                if (contentBottom === null) return;
            }

            const navbarHeight = getNavbarHeight();
            const sidebarStickyTop = 130;
            const stickyTriggerPoint = layoutContainerTop - sidebarStickyTop;
            const documentBottom = scrollTop + windowHeight;
            const scrollableContentHeight = contentBottom - layoutContainerTop;
            const scrolledPastLayout = scrollTop - layoutContainerTop;

            const isSticky = scrollTop >= stickyTriggerPoint;
            let progress = 0;
            if (scrollableContentHeight > 0) {
                progress = Math.min(Math.max(scrolledPastLayout / scrollableContentHeight, 0), 1);
            } else {
                progress = 1;
            }
            if (documentBottom >= contentBottom - 50) progress = 1;
            const currentWidth = isSticky
                ? initialWidth + (progress * (maxWidth - initialWidth))
                : initialWidth;

            if (isSticky) {
                if (!$progressBar.hasClass('is-sticky')) {
                    $progressBar.addClass('is-sticky');
                    if ($wrapper.length) $wrapper.addClass('is-sticky-active');
                }
                $progressBar.css('top', navbarHeight + 'px');
                $progressFill.css('width', currentWidth + 'px');
            } else {
                if ($progressBar.hasClass('is-sticky')) {
                    $progressBar.removeClass('is-sticky');
                    if ($wrapper.length) $wrapper.removeClass('is-sticky-active');
                }
                $progressBar.css('top', '');
                $progressFill.css('width', currentWidth + 'px');
            }
        }

        var didFirstRun = false;
        function onScroll() {
            if (!didFirstRun) {
                didFirstRun = true;
                updateProgressBar();
            }
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateProgressBar();
                    ticking = false;
                });
                ticking = true;
            }
        }
        let ticking = false;
        $(window).on('scroll', onScroll);

        $(window).on('resize', function() {
            layoutContainerTop = null;
            contentBottom = null;
            cachedNavbarHeight = null;
            cachedMaxWidth = null;
            updateProgressBar();
        });
    }

    $(document).ready(function() {
        runWhenIdle(initProgressBar);
    });

})(jQuery);

/* ── Table of Contents ───────────────────────────────────────── */
(function($) {
    'use strict';

    function runWhenIdle(cb) {
        var timeout = 2000;
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(cb, { timeout: timeout });
        } else {
            setTimeout(cb, 1);
        }
    }

    function initTOC() {
        const $tocList = $('#blog-v2-toc-list');
        const $content = $('.blog-v2-content');

        if (!$tocList.length || !$content.length) {
            return;
        }
        if (typeof window.innerWidth !== 'undefined' && window.innerWidth < 768) {
            return;
        }

        const excludedContainers = '._article-keytakeaways, .wp-block-group._article-keytakeaways';

        function getTOCHeadings() {
            return $content.find('h2.wp-block-heading').filter(function() {
                return !$(this).closest(excludedContainers).length;
            });
        }

        var cachedContentBottom = null;
        var cachedHeadingTops = null;

        function getContentBottom() {
            if (cachedContentBottom !== null) return cachedContentBottom;
            var off = $content.offset();
            var h = $content.outerHeight();
            if (off && h) cachedContentBottom = off.top + h;
            return cachedContentBottom;
        }

        function getHeadingTops($headings) {
            if (cachedHeadingTops !== null && cachedHeadingTops.length === $headings.length) return cachedHeadingTops;
            var tops = [];
            $headings.each(function() {
                var o = $(this).offset();
                tops.push(o ? o.top : 0);
            });
            cachedHeadingTops = tops;
            return tops;
        }

        $tocList.find('.blog-v2-toc__link').on('click', function(e) {
            e.preventDefault();
            const targetId = $(this).attr('href');
            const $target = $(targetId);
            if ($target.length) {
                const offset = 130;
                $('html, body').animate({
                    scrollTop: $target.offset().top - offset
                }, 500);
            }
        });

        function updateActiveTOC() {
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            const scrollBottom = scrollTop + windowHeight / 3;
            const documentBottom = scrollTop + windowHeight;
            const contentBottom = getContentBottom();
            const maxScrollTop = $(document).height() - windowHeight;

            const $headings = getTOCHeadings();
            const allLinks = $tocList.find('.blog-v2-toc__link');

            if ($headings.length === 0 || contentBottom == null) {
                return;
            }

            var headingTops = getHeadingTops($headings);
            let currentActive = null;
            let currentActiveIndex = -1;

            $headings.each(function(index) {
                const $heading = $(this);
                const id = $heading.attr('id');
                if (!id) return;

                const headingTop = headingTops[index] != null ? headingTops[index] : 0;

                if (headingTop <= scrollBottom) {
                    currentActive = id;
                    const $link = $tocList.find('a[href="#' + id + '"]');
                    if ($link.length) {
                        currentActiveIndex = allLinks.index($link);
                    }
                }
            });

            if ((documentBottom >= contentBottom - 10 || scrollTop >= maxScrollTop - 2) && $headings.length > 0) {
                const lastHeading = $headings.last();
                const lastId = lastHeading.attr('id');
                if (lastId) {
                    const $lastLink = $tocList.find('a[href="#' + lastId + '"]');
                    if ($lastLink.length) {
                        currentActiveIndex = allLinks.index($lastLink);
                    }
                }
            }

            allLinks.removeClass('is-active is-visited');

            if (currentActiveIndex >= 0) {
                allLinks.each(function(index) {
                    const $link = $(this);
                    if (index <= currentActiveIndex) {
                        $link.addClass('is-visited');
                        if (index === currentActiveIndex) {
                            $link.addClass('is-active');
                        }
                    }
                });
            }
        }

        let ticking = false;
        $(window).on('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateActiveTOC();
                    ticking = false;
                });
                ticking = true;
            }
        });

        updateActiveTOC();

        $(window).on('resize', function() {
            cachedContentBottom = null;
            cachedHeadingTops = null;
        });
    }

    $(document).ready(function() {
        runWhenIdle(initTOC);
    });
})(jQuery);

/* ── Expert Insight ──────────────────────────────────────────── */
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
