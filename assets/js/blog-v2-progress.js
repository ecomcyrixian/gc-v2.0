/**
 * Blog V2 Progress Bar Scroll Functionality
 * Handles sticky positioning and scroll progress calculation
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        const $progressBar = $('#blog-hero-progress-bar');
        const $progressFill = $('#blog-hero-progress-fill');
        
        if (!$progressBar.length || !$progressFill.length) {
            return;
        }

        const progressColor = $progressBar.data('progress-color') || '#4F51FD';
        $progressFill.css('background-color', progressColor);

        const $header = $('#header-cont');
        const $pageHero = $('.blog-v2-hero');
        const $layoutContainer = $('.blog-v2-layout');
        const $content = $('.blog-v2-content');
        const initialWidth = 150;
        
        let layoutContainerTop = null;
        let progressBarOriginalTop = null;
        let contentBottom = null;

        function getNavbarHeight() {
            if (!$header.length) return 0;
            return $header.outerHeight() || 0;
        }

        function getProgressBarWidth() {
            return $(window).width();
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
                if (contentBottom === null) {
                    return;
                }
            }

            if (progressBarOriginalTop === null) {
                const progressBarOffset = $progressBar.offset();
                if (progressBarOffset) {
                    progressBarOriginalTop = progressBarOffset.top;
                } else {
                    return;
                }
            }

            const navbarHeight = getNavbarHeight();
            const sidebarStickyTop = 130;
            const stickyTriggerPoint = layoutContainerTop - sidebarStickyTop;
            
            if (scrollTop >= stickyTriggerPoint) {
                if (!$progressBar.hasClass('is-sticky')) {
                    $progressBar.addClass('is-sticky');
                }
                $progressBar.css('top', navbarHeight + 'px');
                
                const windowHeight = $(window).height();
                const documentBottom = scrollTop + windowHeight;
                const scrollableContentHeight = contentBottom - layoutContainerTop;
                const scrolledPastLayout = scrollTop - layoutContainerTop;
                
                let progress = 0;
                if (scrollableContentHeight > 0) {
                    progress = Math.min(Math.max(scrolledPastLayout / scrollableContentHeight, 0), 1);
                } else {
                    progress = 1;
                }
                
                if (documentBottom >= contentBottom - 50) {
                    progress = 1;
                }
                
                const maxWidth = getProgressBarWidth();
                const currentWidth = initialWidth + (progress * (maxWidth - initialWidth));
                $progressFill.css('width', currentWidth + 'px');
            } else {
                if ($progressBar.hasClass('is-sticky')) {
                    $progressBar.removeClass('is-sticky');
                }
                $progressBar.css('top', '');
                $progressFill.css('width', initialWidth + 'px');
            }
        }

        updateProgressBar();

        let ticking = false;
        $(window).on('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateProgressBar();
                    ticking = false;
                });
                ticking = true;
            }
        });

        $(window).on('resize', function() {
            layoutContainerTop = null;
            progressBarOriginalTop = null;
            contentBottom = null;
            updateProgressBar();
        });
    });

})(jQuery);
