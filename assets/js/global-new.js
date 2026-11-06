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

    $('header#home a[href="#key-features"]').on('click', function (e) {
        var target = document.getElementById('key-features');
        if (!target) {
            return;
        }

        e.preventDefault();
        this.blur();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    /* Keep #quote out of the URL. If it stays, the next click scrolls back to the form and the button never opens. */
    function clearQuoteHash() {
        if (window.location.hash === '#quote' && window.history.replaceState) {
            window.history.replaceState(null, '', window.location.pathname + window.location.search);
        }
    }

    function samePageQuoteLink(node) {
        var link = node && node.closest ? node.closest('a[href="#quote"], a[href$="#quote"]') : null;
        var url;

        if (!link) {
            return null;
        }

        try {
            url = new URL(link.href, window.location.href);
        } catch (err) {
            return null;
        }

        if (url.origin !== window.location.origin || url.pathname !== window.location.pathname || url.hash !== '#quote') {
            return null;
        }

        return document.getElementById('quote') ? link : null;
    }

    document.addEventListener('mousedown', function (event) {
        if (samePageQuoteLink(event.target)) {
            return;
        }

        clearQuoteHash();
    }, true);

    document.addEventListener('click', function (event) {
        var link = samePageQuoteLink(event.target);
        var target = document.getElementById('quote');

        if (!link || !target) {
            return;
        }

        event.preventDefault();
        clearQuoteHash();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        link.blur();
    }, true);

    if (window.location.hash === '#quote' && document.getElementById('quote')) {
        clearQuoteHash();
        document.getElementById('quote').scrollIntoView({ behavior: 'auto', block: 'start' });
    }

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
            if ($(window).width() <= 1123) {
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

/* GCheck in action: homepage tabs */
(function () {
    'use strict';

    var AUTOPLAY_MS = 9000;
    var TICK_MS = 50;

    function initGcAction(root) {
        var tabs = Array.prototype.slice.call(root.querySelectorAll('[role="tab"]'));
        var panels = tabs.map(function (tab) {
            return document.getElementById(tab.getAttribute('aria-controls'));
        });

        var elapsed = 0;

        if (!tabs.length) {
            return;
        }

        function select(index, focus) {
            elapsed = 0;

            tabs.forEach(function (tab, i) {
                var active = i === index;
                var bar = tab.querySelector('.progress');
                tab.setAttribute('aria-selected', active ? 'true' : 'false');
                tab.tabIndex = active ? 0 : -1;
                if (bar) {
                    bar.style.transform = 'scaleX(0)';
                }
                if (panels[i]) {
                    panels[i].hidden = !active;
                }
            });

            if (focus) {
                tabs[index].focus();
            }

            var list = tabs[index].parentNode;
            if (list.scrollWidth > list.clientWidth) {
                list.scrollTo({ left: tabs[index].offsetLeft - list.offsetLeft, behavior: 'smooth' });
            }

            var nextPanel = panels[(index + 1) % panels.length];
            var nextImg = nextPanel ? nextPanel.querySelector('img') : null;
            if (nextImg) {
                nextImg.loading = 'eager';
            }
        }

        tabs.forEach(function (tab, i) {
            tab.addEventListener('click', function () {
                select(i, false);
            });

            tab.addEventListener('keydown', function (e) {
                var count = tabs.length;
                var to = null;

                if (e.key === 'ArrowRight') {
                    to = (i + 1) % count;
                } else if (e.key === 'ArrowLeft') {
                    to = (i - 1 + count) % count;
                } else if (e.key === 'Home') {
                    to = 0;
                } else if (e.key === 'End') {
                    to = count - 1;
                }

                if (to !== null) {
                    e.preventDefault();
                    select(to, true);
                }
            });
        });

        root.querySelectorAll('[data-gc-next]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var current = tabs.findIndex(function (tab) {
                    return tab.getAttribute('aria-selected') === 'true';
                });
                select((current + 1) % tabs.length, true);
            });
        });

        // Autoplay (like the whitepaper banner): a plain timer moves to the next
        // tab every AUTOPLAY_MS and fills the active tab's progress bar.
        // Hovering the active tab pauses it (checked live each tick, so it
        // can't get stuck); clicking a tab restarts the count.
        var canHover = window.matchMedia('(hover: hover)').matches;

        root.classList.add('is-autoplay');

        setInterval(function () {
            if (canHover && root.querySelector('.tab[aria-selected="true"]:hover')) {
                return;
            }

            elapsed += TICK_MS;

            if (elapsed >= AUTOPLAY_MS) {
                var current = tabs.findIndex(function (tab) {
                    return tab.getAttribute('aria-selected') === 'true';
                });
                select((current + 1) % tabs.length, false);
                return;
            }

            var bar = root.querySelector('[aria-selected="true"] .progress');
            if (bar) {
                bar.style.transform = 'scaleX(' + elapsed / AUTOPLAY_MS + ')';
            }
        }, TICK_MS);
    }

    function bootGcAction() {
        document.querySelectorAll('#gcheck-in-action').forEach(initGcAction);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootGcAction);
    } else {
        bootGcAction();
    }
})();

/* Verified Entry: before/after phone tabs */
(function () {
    'use strict';

    function initVeToggle(root) {
        var tabs = Array.prototype.slice.call(root.querySelectorAll('[role="tab"]'));

        if (!tabs.length) {
            return;
        }

        function select(tab, focus) {
            tabs.forEach(function (item) {
                var active = item === tab;
                var panel = document.getElementById(item.getAttribute('aria-controls'));

                item.setAttribute('aria-selected', active ? 'true' : 'false');
                item.tabIndex = active ? 0 : -1;

                if (panel) {
                    panel.hidden = !active;
                }
            });

            if (focus) {
                tab.focus();
            }
        }

        tabs.forEach(function (tab, index) {
            tab.addEventListener('click', function () {
                select(tab);
            });

            tab.addEventListener('keydown', function (event) {
                var next = null;

                if (event.key === 'ArrowRight') next = tabs[(index + 1) % tabs.length];
                if (event.key === 'ArrowLeft') next = tabs[(index - 1 + tabs.length) % tabs.length];
                if (event.key === 'Home') next = tabs[0];
                if (event.key === 'End') next = tabs[tabs.length - 1];

                if (next) {
                    event.preventDefault();
                    select(next, true);
                }
            });
        });

        window.addEventListener('load', function () {
            root.querySelectorAll('[role="tabpanel"][hidden] img').forEach(function (img) {
                img.loading = 'eager';
            });
        });
    }

    function bootVeToggle() {
        document.querySelectorAll('.gc-static-page .ve-hero').forEach(initVeToggle);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootVeToggle);
    } else {
        bootVeToggle();
    }
})();

/* Pricing with quote: compare table and selected card */
(function () {
    document.querySelectorAll('.pricing-with-quote').forEach(function (root) {
        var toggle = root.querySelector('[data-compare-toggle]');
        var panel = root.querySelector('[data-compare]');
        if (toggle && panel) {
            toggle.addEventListener('click', function () {
                var open = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', String(!open));
                panel.hidden = open;
                toggle.querySelector('span').textContent = open ? 'Compare all features' : 'Hide comparison';
            });
        }

        var cards = root.querySelectorAll('.pricing-card');

        function selectCard(card) {
            cards.forEach(function (item) {
                item.classList.remove('is-selected');
            });
            if (card) {
                card.classList.add('is-selected');
            }
        }

        root.addEventListener('click', function (event) {
            var pkg = event.target.closest('[data-pkg], .pricing-card__cta');
            if (!pkg || !root.contains(pkg)) {
                return;
            }

            selectCard(pkg.closest('.pricing-card'));
        });
    });
})();
