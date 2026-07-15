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
		var direction = 1;

		var swiper = new Swiper(root, {
			slidesPerView: 1,
			spaceBetween: 0,
			speed: 500,
			autoHeight: false,
			pagination: paginationEl
				? { el: paginationEl, clickable: true }
				: undefined,
			a11y: {
				enabled: true,
				prevSlideMessage: 'Previous report',
				nextSlideMessage: 'Next report',
			},
		});

		// Ping-pong: 1 → 2 → 3 → 2 → 1 (no jump from last back to first).
		setInterval(function () {
			if (swiper.destroyed) {
				return;
			}
			if (direction > 0) {
				if (swiper.activeIndex >= total - 1) {
					direction = -1;
					swiper.slidePrev();
				} else {
					swiper.slideNext();
				}
			} else if (swiper.activeIndex <= 0) {
				direction = 1;
				swiper.slideNext();
			} else {
				swiper.slidePrev();
			}
		}, AUTOPLAY_MS);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initWhitepaperBannerCarousel);
	} else {
		initWhitepaperBannerCarousel();
	}
})();

/* Author archive infinite articles */
(function () {
    'use strict';

    function initAuthorInfiniteArticles() {
        var loader = document.querySelector('.author-articles-loader');
        var list = document.querySelector('.author-page .latest-articles .card-cont');

        if (!loader || !list) {
            return;
        }

        var isLoading = false;
        var hasMore = true;
        var lastLoadScrollY = -Infinity;

        function setStatus(message) {
            var status = loader.querySelector('.author-articles-loader__status');
            if (status) {
                status.textContent = message;
            }
        }

        function loadNextPage() {
            var nextPage = parseInt(loader.getAttribute('data-next-page'), 10);
            var maxPages = parseInt(loader.getAttribute('data-max-pages'), 10);

            if (isLoading || !hasMore || !nextPage || !maxPages || nextPage > maxPages) {
                return;
            }

            isLoading = true;
            lastLoadScrollY = window.scrollY || window.pageYOffset || 0;
            loader.classList.add('is-loading');
            setStatus('Loading more articles...');

            var authorUrl = loader.getAttribute('data-author-url') || window.location.href;
            var requestUrl = new URL(authorUrl, window.location.origin);
            requestUrl.searchParams.set('gc_author_articles', '1');
            requestUrl.searchParams.set('articles_page', String(nextPage));

            fetch(requestUrl.toString(), {
                method: 'GET',
                credentials: 'same-origin',
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Author articles request failed.');
                    }
                    return response.json();
                })
                .then(function (payload) {
                    if (!payload || !payload.success || !payload.data) {
                        throw new Error('Invalid author articles response.');
                    }

                    if (payload.data.html) {
                        list.insertAdjacentHTML('beforeend', payload.data.html);
                    }

                    hasMore = Boolean(payload.data.hasMore);
                    loader.setAttribute('data-next-page', String(payload.data.nextPage || nextPage + 1));

                    if (!hasMore) {
                        loader.remove();
                    }
                })
                .catch(function () {
                    hasMore = false;
                    setStatus('More articles could not be loaded.');
                })
                .finally(function () {
                    isLoading = false;
                    loader.classList.remove('is-loading');
                });
        }

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    var currentScrollY = window.scrollY || window.pageYOffset || 0;

                    if (entry.isIntersecting && currentScrollY - lastLoadScrollY > 120) {
                        loadNextPage();
                    }
                });
            }, {
                rootMargin: '0px 0px 100px 0px',
            });

            observer.observe(loader);
        } else {
            window.addEventListener('scroll', function () {
                var currentScrollY = window.scrollY || window.pageYOffset || 0;

                if (loader.getBoundingClientRect().top < window.innerHeight + 100 && currentScrollY - lastLoadScrollY > 120) {
                    loadNextPage();
                }
            }, { passive: true });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAuthorInfiniteArticles);
    } else {
        initAuthorInfiniteArticles();
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
