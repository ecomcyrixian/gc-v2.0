jQuery(document).ready(function($) {

    /* Header scroll class: read offset on first scroll only to avoid forced reflow on load.
       Adds body padding to compensate when header leaves flow (position:fixed) to prevent CLS. */
    var topOfOthDiv = null;
    var headerHeight = null;
    var isHomePage = !!document.getElementById('home');
    $(window).scroll(function() {
        var $header = $('#header-cont');
        if (topOfOthDiv === null) {
            if ($header.length) topOfOthDiv = $header.offset().top;
        }
        if (headerHeight === null && $header.length) {
            headerHeight = $header.outerHeight();
        }
        if (topOfOthDiv !== null && $(window).scrollTop() > topOfOthDiv) {
            if (!$header.hasClass('scroll')) {
                $header.addClass('scroll');
                if (!isHomePage && headerHeight) {
                    document.body.style.paddingTop = headerHeight + 'px';
                }
            }
        } else {
            if ($header.hasClass('scroll')) {
                $header.removeClass('scroll');
                if (!isHomePage) {
                    document.body.style.paddingTop = '';
                }
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

    // Close menus when resizing to mobile view
    // This ensures mega panels are hidden when switching from desktop to mobile
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if ($(window).width() <= 1230) {
                // Force hide mega panels on mobile by removing any active classes
                $('#desktop-nav .menu-block').removeClass('active');
                $('.hamburger-desktop').removeClass('active');
            }
        }, 250);
    });

});
