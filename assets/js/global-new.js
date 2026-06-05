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

    /* FAQ accordion */
    document.addEventListener('click', function (event) {
        var toggle = event.target.closest('#faq.faq--collapsible .faq-card__toggle');
        if (!toggle) {
            return;
        }

        var card = toggle.closest('.faq-card');
        var panel = document.getElementById(toggle.getAttribute('aria-controls'));
        var isOpen = toggle.getAttribute('aria-expanded') === 'true';

        toggle.setAttribute('aria-expanded', String(!isOpen));

        if (card) {
            card.classList.toggle('is-open', !isOpen);
        }

        if (panel) {
            panel.hidden = isOpen;
        }
    });

});

/* Whitepaper banner carousel */
(function () {
	'use strict';

	var AUTOPLAY_MS = 5000;

	function initWhitepaperBannerCarousel() {
		if (typeof Swiper === 'undefined') {
			return;
		}

		var root = document.querySelector('#whitepaper-banner .wb-swiper');
		if (!root || root.swiper) {
			return;
		}

		var slides = root.querySelectorAll('.swiper-slide');
		if (slides.length < 2) {
			return;
		}

		var paginationEl = root.querySelector('.wb-swiper__pagination');
		var total = slides.length;

		var swiper = new Swiper(root, {
			slidesPerView: 1,
			spaceBetween: 0,
			speed: 500,
			pagination: paginationEl
				? { el: paginationEl, clickable: true }
				: undefined,
			a11y: {
				enabled: true,
				prevSlideMessage: 'Previous report',
				nextSlideMessage: 'Next report',
			},
		});

		setInterval(function () {
			if (swiper.destroyed) {
				return;
			}
			if (swiper.activeIndex >= total - 1) {
				swiper.slideTo(0, 500);
			} else {
				swiper.slideNext();
			}
		}, AUTOPLAY_MS);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initWhitepaperBannerCarousel);
	} else {
		initWhitepaperBannerCarousel();
	}
})();

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
