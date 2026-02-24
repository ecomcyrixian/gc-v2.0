/**
 * Blog V2 Table of Contents
 * TOC is built server-side (PHP). This script only handles:
 * - Scroll-based active section highlighting
 * - Smooth scroll on link click
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        const $tocList = $('#blog-v2-toc-list');
        const $content = $('.blog-v2-content');

        if (!$tocList.length || !$content.length) {
            return;
        }

        const excludedContainers = '._article-keytakeaways, .wp-block-group._article-keytakeaways';

        function getTOCHeadings() {
            return $content.find('h2.wp-block-heading').filter(function() {
                return !$(this).closest(excludedContainers).length;
            });
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
            const contentBottom = $content.offset().top + $content.outerHeight();
            const maxScrollTop = $(document).height() - windowHeight;

            const $headings = getTOCHeadings();
            const allLinks = $tocList.find('.blog-v2-toc__link');

            if ($headings.length === 0) {
                return;
            }

            let currentActive = null;
            let currentActiveIndex = -1;

            $headings.each(function(index) {
                const $heading = $(this);
                const id = $heading.attr('id');
                if (!id) return;

                const headingTop = $heading.offset().top;

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
    });
})(jQuery);
