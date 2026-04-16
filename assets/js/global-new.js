jQuery(document).ready(function($) {

    /* Header scroll */
    var topOfOthDiv = null;
    $(window).scroll(function() {
        var $header = $('#header-cont');
        if (topOfOthDiv === null) {
            if ($header.length) topOfOthDiv = $header.offset().top;
        }
        if (topOfOthDiv !== null && $(window).scrollTop() > topOfOthDiv) {
            if (!$header.hasClass('scroll')) {
                $header.addClass('scroll');
            }
        } else {
            if ($header.hasClass('scroll')) {
                $header.removeClass('scroll');
            }
        }
    });

    /* Hamburger menu */
    function debounce(func, delay) {
        var timeout;
        return function() {
            var context = this;
            var args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() { func.apply(context, args); }, delay);
        };
    }
    var myDebouncedFunction = debounce(function() {
        $('#header-cont').toggleClass('active');
        $('#mobile-nav').slideToggle('fast');
    }, 300);
    var mobileMenuEl = document.getElementById('mobile-menu');
    if (mobileMenuEl) {
        mobileMenuEl.addEventListener('click', myDebouncedFunction);
    }

    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if ($(window).width() <= 1230) {
                $('#desktop-nav .menu-block').removeClass('active');
                $('.hamburger-desktop').removeClass('active');
            }
        }, 250);
    });

});

/* Hero copy link */
(function () {
    'use strict';

    function initHeroCopyLink() {
        document.querySelectorAll('.blog-v2-hero__copy-link').forEach(function (btn) {
            if (btn.dataset.gcCopyLinkBound) {
                return;
            }
            btn.dataset.gcCopyLinkBound = '1';
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var url = this.getAttribute('data-url');
                var title = this.getAttribute('data-title') || document.title;
                var el = this;
                if (navigator.share) {
                    navigator.share({ title: title, url: url }).catch(function () {});
                    return;
                }
                if (navigator.clipboard && url && typeof navigator.clipboard.writeText === 'function') {
                    navigator.clipboard.writeText(url).then(function () {
                        el.classList.add('is-copy-success');
                        window.setTimeout(function () {
                            el.classList.remove('is-copy-success');
                        }, 1500);
                    }).catch(function () {});
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroCopyLink);
    } else {
        initHeroCopyLink();
    }
})();
