/**
 * Blog V2 Table of Contents Generator
 * Auto-generates TOC from h2 and h3 headings in .blog-v2-content
 * Highlights active section on scroll
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        const $tocList = $('#blog-v2-toc-list');
        const $content = $('.blog-v2-content');
        
        if (!$tocList.length || !$content.length) {
            return;
        }

        function generateId(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }

        function buildTOC() {
            const headings = $content.find('h2');
            const tocItems = [];

            headings.each(function(index) {
                const $heading = $(this);
                const text = $heading.text().trim();
                
                if (!text) return;

                let id = $heading.attr('id');
                if (!id) {
                    id = generateId(text);
                    let uniqueId = id;
                    let counter = 1;
                    while ($('#' + uniqueId).length > 0) {
                        uniqueId = id + '-' + counter;
                        counter++;
                    }
                    id = uniqueId;
                    $heading.attr('id', id);
                }

                tocItems.push({
                    id: id,
                    text: text,
                    level: 2,
                    index: index + 1
                });
            });

            return tocItems;
        }

        function renderTOC(tocItems) {
            if (tocItems.length === 0) {
                $tocList.parent().hide();
                return;
            }

            $tocList.empty();
            
            tocItems.forEach(function(item) {
                const $li = $('<li>', {
                    class: 'blog-v2-toc__item blog-v2-toc__item--level-2'
                });

                const $link = $('<a>', {
                    href: '#' + item.id,
                    text: item.text,
                    class: 'blog-v2-toc__link'
                });

                $link.on('click', function(e) {
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

                $li.append($link);
                $tocList.append($li);
            });
        }

        function updateActiveTOC() {
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            const scrollBottom = scrollTop + windowHeight / 3;

            let currentActive = null;
            let currentActiveIndex = -1;
            const headings = $content.find('h2');
            const allLinks = $tocList.find('.blog-v2-toc__link');

            headings.each(function(index) {
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

        const tocItems = buildTOC();
        renderTOC(tocItems);

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
