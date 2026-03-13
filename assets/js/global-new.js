jQuery(document).ready(function($) {

    /* Header scroll class: toggles .scroll for visual changes on scroll.
       Typical pages use CSS position:sticky — no body padding needed.
       Home page keeps position:fixed via CSS scoped to header#home. */
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
