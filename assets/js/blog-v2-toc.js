/**
 * Blog V2 Table of Contents
 * TOC is built server-side (PHP). This script only handles:
 * - Scroll-based active section highlighting
 * - Smooth scroll on link click
 * Init delayed with requestIdleCallback to reduce main-thread work on mobile.
 */

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
        // Skip TOC on mobile (sidebar is hidden) to avoid forced reflow from offset()/outerHeight()
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
