/**
 * Blog V2 Progress Bar Scroll Functionality
 * Handles sticky positioning and scroll progress calculation.
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
            cachedMaxWidth = $(window).width();
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
            // Phase 1: batch all layout reads (avoid forced reflow: no reads after writes)
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

            // Compute state from reads only
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

            // Phase 2: batch all DOM writes (no layout reads after this)
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

        // Run first layout read only on first scroll to avoid forced reflow during load (315ms unattributed)
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
