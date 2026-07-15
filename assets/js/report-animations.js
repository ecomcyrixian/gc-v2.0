(function () {
  'use strict';

  /*
   * Section entrance + counter animations for the Automation Anxiety Report.
   *
   * CWV notes:
   * - Script is defer → zero render-blocking (no LCP / FCP penalty).
   * - Only elements BELOW the fold are hidden before animation; above-fold
   *   content is left untouched so LCP elements are never hidden.
   * - opacity + transform only → zero layout shift (CLS = 0).
   * - IntersectionObserver + requestAnimationFrame → main-thread-friendly.
   *
   * CSS for .aar-will-animate / .aar-visible lives in parallax-report.css.
   */

  var aarDone = false;

  /* ── Viewport helper ──────────────────────────────────────────────────── */

  function isAboveFold(el) {
    var rect = el.getBoundingClientRect();
    return rect.top < window.innerHeight && rect.bottom > 0;
  }

  /* ── Counter (requestAnimationFrame, no external deps) ────────────────── */

  function parseCounter(text) {
    var m = (text || '').trim().match(/^([\d,]+)(.*)/);
    if (!m) { return null; }
    var n = parseInt(m[1].replace(/,/g, ''), 10);
    if (!n) { return null; }
    return { n: n, suffix: m[2], comma: m[1].indexOf(',') !== -1 };
  }

  function runCounter(el) {
    var target = +el.dataset.aarTarget;
    var suffix = el.dataset.aarSuffix || '';
    var comma  = el.dataset.aarComma === '1';
    var t0 = performance.now(), dur = 1600;
    requestAnimationFrame(function step(now) {
      var t = Math.max(0, Math.min((now - t0) / dur, 1));
      var v = Math.round((1 - Math.pow(1 - t, 3)) * target);
      el.textContent = (comma ? v.toLocaleString('en-US') : String(v)) + suffix;
      if (t < 1) { requestAnimationFrame(step); }
      else { el.textContent = (comma ? target.toLocaleString('en-US') : String(target)) + suffix; }
    });
  }

  /* ── Shared IntersectionObservers ────────────────────────────────────── */

  /* Fade observer: fires at 12% visibility, adds .aar-visible */
  var fadeIO = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (!e.isIntersecting) { return; }
      fadeIO.unobserve(e.target);
      e.target.classList.add('aar-visible');
    });
  }, { threshold: 0.12 });

  /* Counter observer: fires at 50% visibility, same as HTML prototype */
  var counterIO = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (!e.isIntersecting) { return; }
      counterIO.unobserve(e.target);
      runCounter(e.target);
    });
  }, { threshold: 0.5 });

  /* ── Fade helpers ─────────────────────────────────────────────────────── */

  /*
   * Mark a single element for fade-up and observe it.
   * Skip if the element is already visible above the fold — this protects
   * LCP elements from being hidden after initial paint.
   */
  function observe(el) {
    if (isAboveFold(el)) { return; }
    el.classList.add('aar-will-animate');
    fadeIO.observe(el);
  }

  /*
   * Observe a parent container; when it enters the viewport, stagger-reveal
   * all matching children. Skip the whole group if already above the fold.
   */
  function observeGroup(parent, childSel, threshold) {
    if (isAboveFold(parent)) { return; }
    var els = Array.prototype.slice.call(parent.querySelectorAll(childSel));
    if (!els.length) { return; }
    els.forEach(function (el, i) {
      el.classList.add('aar-will-animate');
      if (i > 0) { el.classList.add('aar-delay-' + Math.min(i, 8)); }
    });
    new IntersectionObserver(function (entries, io) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) { return; }
        io.unobserve(e.target);
        els.forEach(function (el) { el.classList.add('aar-visible'); });
      });
    }, { threshold: threshold || 0.05 }).observe(parent);
  }

  /* ── Main init ────────────────────────────────────────────────────────── */

  function init() {
    if (aarDone) { return; }
    aarDone = true;

    /* Prepare counter elements first (resets text to "0X" before hiding) */
    document.querySelectorAll(
      '.card-item h4 span:first-child,' +
      '.aar-report-blue-box__heading,' +
      '.aar-report-media-feature__bluebox-heading,' +
      '.aar-report-feature-stat-split__stat-value,' +
      '.tih-report-blue-box__stat-value,' +
      '.tih-report-fallout__card-value,' +
      '.aar-report-graph__pie-value,' +
      '.swr-report-concept__stat-value'
    ).forEach(function (el) {
      var p = parseCounter(el.textContent);
      if (!p) { return; }
      el.dataset.aarTarget = p.n;
      el.dataset.aarSuffix = p.suffix;
      el.dataset.aarComma  = p.comma ? '1' : '0';
      el.textContent = '0' + p.suffix;
      counterIO.observe(el);
    });

    /* Section headings */
    document.querySelectorAll('.aar-report-section-heading').forEach(observe);

    /* Trust in Hiring report frames */
    document.querySelectorAll('.content--trust-in-hiring > .container > [class^="frame-"], .content--trust-in-hiring > .container > [class*=" frame-"]').forEach(observe);

    /* Shadow Workforce report frames */
    document.querySelectorAll('.content--shadow-workforce > .container > .frame, .swr-report-opening').forEach(observe);

    /* Executive summary */
    document.querySelectorAll('.aar-executive-summary__title').forEach(observe);
    document.querySelectorAll('.aar-executive-summary__intro').forEach(observe);
    document.querySelectorAll('.aar-report-item-list').forEach(function (list) {
      observeGroup(list, '.aar-report-item-list__item', 0.1);
    });

    /* Methodology */
    document.querySelectorAll('.aar-methodology__title').forEach(observe);
    document.querySelectorAll('.aar-methodology__intro').forEach(observe);
    document.querySelectorAll('.aar-methodology__content').forEach(observe);

    /* Media features */
    document.querySelectorAll('.aar-report-media-feature').forEach(observe);

    /* Stat card grids */
    document.querySelectorAll('.aar-report-stat-cards').forEach(function (container) {
      var header = container.querySelector('.aar-report-stat-cards__header');
      if (header) { observe(header); }
      observeGroup(container, '.card-item', 0.05);
    });

    /* Feature stat split */
    document.querySelectorAll('.aar-report-feature-stat-split').forEach(function (container) {
      var copy = container.querySelector('.aar-report-feature-stat-split__copy');
      if (copy) { observe(copy); }
      observeGroup(container, '.aar-report-feature-stat-split__stat', 0.05);
    });

    /* Quotes */
    document.querySelectorAll('.aar-report-quote').forEach(observe);

    /* Callout cards */
    document.querySelectorAll('.aar-report-callout-card').forEach(observe);

    /* Standalone blue boxes (not inside media-feature, which already fades) */
    document.querySelectorAll('.aar-report-blue-box').forEach(function (el) {
      if (el.closest('.aar-report-media-feature')) { return; }
      observe(el);
    });

    /* Cyan callout boxes (Trust in Hiring frame 3, etc.) */
    document.querySelectorAll('.aar-report-cyan-box').forEach(observe);

    /* Split copy sections */
    document.querySelectorAll('.aar-report-split-copy').forEach(observe);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  window.addEventListener('load', init);

})();
