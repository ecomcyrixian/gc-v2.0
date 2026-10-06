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
        var headerCont = document.getElementById('header-cont');
        var mobileNav = document.getElementById('mobile-nav');
        if (headerCont && mobileNav) {
            mobileNav.style.setProperty('--gc-header-h', headerCont.offsetHeight + 'px');
        }
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
            }
        }, 250);
    });

    /* Services nav panel: a group only takes over once the cursor rests on it,
       so travelling diagonally to the links pane keeps the current group open */
    var GROUP_HOVER_DELAY = 150;

    $('#desktop-nav .nav-panel--group').each(function() {
        var $rows = $(this).children('.nav-panel__items').children('li');
        var $panes = $(this).children('.nav-panel__panes').children('.nav-panel__group-pane');
        var $menuBlock = $(this).closest('.menu-block');
        var hoverTimer;

        if (!$rows.length) {
            return;
        }

        function activate($row) {
            var paneId = $row.attr('data-pane');

            $rows.not($row).removeClass('is-active');
            $row.addClass('is-active');

            $panes.removeClass('is-active');
            if (paneId) {
                $panes.filter('[id="' + paneId + '"]').addClass('is-active');
            }
        }

        activate($rows.first());

        $rows.on('mouseenter', function() {
            var $row = $(this);
            clearTimeout(hoverTimer);
            hoverTimer = setTimeout(function() {
                activate($row);
            }, GROUP_HOVER_DELAY);
        });

        $rows.on('mouseleave', function() {
            clearTimeout(hoverTimer);
        });

        $menuBlock.on('mouseleave', function() {
            clearTimeout(hoverTimer);
            activate($rows.first());
        });
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

		// Ping-pong: forward to the last slide, then back (no jump from last to first).
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

/* Book a demo: reveal the help card once the Calendly calendar has rendered */
(function () {
    'use strict';

    var READY_CLASS = 'is-calendar-ready';
    var FALLBACK_DELAY = 6000;

    function initDemoCalendar() {
        var rows = document.querySelectorAll('.demo-calendar');
        if (!rows.length) {
            return;
        }

        rows.forEach(function (row) {
            var widget = row.querySelector('.calendly-inline-widget');
            if (!widget) {
                row.classList.add(READY_CLASS);
                return;
            }

            var reveal = function () {
                row.classList.add(READY_CLASS);
            };

            window.addEventListener('message', function (e) {
                if (!e.data || typeof e.data.event !== 'string') {
                    return;
                }
                // Posted once the scheduling page is visible inside the iframe.
                if (e.data.event === 'calendly.event_type_viewed') {
                    reveal();
                }
                // Calendly reports its own content height, so the CSS values are only a fallback.
                if (e.data.event === 'calendly.page_height' && e.data.payload && e.data.payload.height) {
                    widget.style.height = e.data.payload.height;
                }
            });

            // The iframe is injected by widget.js, so watch for it instead of querying now.
            var observer = new MutationObserver(function () {
                var frame = widget.querySelector('iframe');
                if (!frame) {
                    return;
                }
                observer.disconnect();
                frame.addEventListener('load', reveal);
            });
            observer.observe(widget, { childList: true, subtree: true });

            // Never leave the card hidden if Calendly is blocked or slow.
            window.setTimeout(reveal, FALLBACK_DELAY);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDemoCalendar);
    } else {
        initDemoCalendar();
    }
})();
