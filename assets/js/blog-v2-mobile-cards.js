/**
 * Blog V2 Mobile Cards Repositioning
 * Moves right sidebar cards above "About The Creator" section on mobile/tablet
 */

(function($) {
    'use strict';

    function repositionMobileCards() {
        const $mobileCards = $('.blog-v2-mobile-cards');
        const $aboutCreator = $('.blog-v2-content .wp-block-group._article-about-creator');
        const $content = $('.blog-v2-content');

        if (!$mobileCards.length || !$aboutCreator.length || !$content.length) {
            return;
        }

        // Check if we're on mobile/tablet
        const isMobile = window.matchMedia('(max-width: 767px)').matches;
        const isTablet = window.matchMedia('(max-width: 1023px)').matches;

        if (isMobile || isTablet) {
            // Move cards before about-creator if not already moved
            if ($mobileCards.parent().hasClass('blog-v2-footer-sections')) {
                $aboutCreator.before($mobileCards);
            }
        } else {
            // Move cards back to footer sections on desktop
            const $footerSections = $('.blog-v2-footer-sections');
            if ($footerSections.length && $mobileCards.parent().hasClass('blog-v2-content')) {
                // Insert at the beginning of footer sections (before CTA)
                const $cta = $footerSections.find('.blog-v2-cta');
                if ($cta.length) {
                    $cta.before($mobileCards);
                } else {
                    $footerSections.prepend($mobileCards);
                }
            }
        }
    }

    // Run on document ready
    $(document).ready(function() {
        repositionMobileCards();
    });

    // Run on window resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            repositionMobileCards();
        }, 250);
    });

})(jQuery);
