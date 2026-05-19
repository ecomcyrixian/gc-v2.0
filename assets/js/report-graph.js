(function () {
  'use strict';

  var graphsInitialized = false;

  function setAnimationDelays(graph) {
    graph.querySelectorAll('.aar-report-graph__bar-item').forEach(function (item, i) {
      item.style.setProperty('--aar-bar-delay', (i * 80) + 'ms');
      item.style.setProperty('--aar-value-delay', (i * 80 + 900) + 'ms');
    });
    graph.querySelectorAll('.aar-report-graph__row').forEach(function (row, i) {
      row.style.setProperty('--aar-bar-delay', (i * 80) + 'ms');
      row.style.setProperty('--aar-value-delay', (i * 80 + 750) + 'ms');
    });
  }

  function animateBars(graph) {
    graph.classList.add('is-bars-animated');
  }

  function revealGraph(graph) {
    if (graph.classList.contains('is-visible')) {
      return;
    }
    setAnimationDelays(graph);
    graph.classList.add('is-visible');

    setTimeout(function () {
      animateBars(graph);
    }, 300);
  }

  /* ---- GSAP entrance ---- */

  function initGraphGSAP(graph) {
    var isVertical  = graph.classList.contains('aar-report-graph--vertical');
    var chartFrames = Array.prototype.slice.call(graph.querySelectorAll('.aar-report-graph__chart-frame'));

    /* Set initial hidden state, matching the CSS starting position. */
    if (chartFrames.length) {
      var fromVars = { opacity: 0 };
      if (isVertical) { fromVars.x = 40; } else { fromVars.y = 40; }
      gsap.set(chartFrames, fromVars);
    }

    /*
     * Observe the chart-frame directly, not the outer graph container.
     *
     * The outer container has a title / intro above the chart area. Observing
     * the container at 15% fires when just the title enters the viewport —
     * the chart-frame is still below the fold and its CSS transition plays
     * off-screen, completing before the user ever sees it.
     *
     * Observing the chart-frame directly (same pattern as .fade-up in the
     * HTML prototype) ensures the animation fires when the animated element
     * itself is entering the viewport, so the user actually sees it.
     */
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          observer.disconnect();
          revealGraph(graph);

          if (chartFrames.length) {
            var toVars = { opacity: 1, duration: 0.85, ease: 'power3.out' };
            if (isVertical) { toVars.x = 0; } else { toVars.y = 0; }
            gsap.to(chartFrames, toVars);
          }
        });
      },
      { threshold: 0.15 }
    );

    /* Observe each chart-frame so the trigger fires when the animated
       element enters the viewport, not when the container title enters. */
    if (chartFrames.length) {
      chartFrames.forEach(function (cf) { observer.observe(cf); });
    } else {
      observer.observe(graph);
    }

  }

  /* ---- fallback reveal (GSAP unavailable) ---- */

  function initGraphRevealFallback(graph) {
    if (!('IntersectionObserver' in window)) {
      revealGraph(graph);
      return;
    }

    var chartFrames = Array.prototype.slice.call(graph.querySelectorAll('.aar-report-graph__chart-frame'));

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          observer.disconnect();
          revealGraph(graph);
        });
      },
      { threshold: 0.15 }
    );

    if (chartFrames.length) {
      chartFrames.forEach(function (cf) { observer.observe(cf); });
    } else {
      observer.observe(graph);
    }
  }

  /* ---- horizontal axis alignment ---- */

  function alignHorizontalAxis(graph) {
    var plot = graph.querySelector('.aar-report-graph__plot--horizontal');
    if (!plot) {
      return;
    }

    if (window.matchMedia('(max-width: 767px)').matches) {
      plot.style.removeProperty('--aar-horizontal-axis-offset');
      plot.style.removeProperty('--aar-horizontal-axis-width');
      return;
    }

    var track = plot.querySelector('.aar-report-graph__row-track');
    if (!track) {
      return;
    }

    var pb = plot.getBoundingClientRect();
    var tb = track.getBoundingClientRect();
    plot.style.setProperty('--aar-horizontal-axis-offset', (tb.left - pb.left).toFixed(2) + 'px');
    plot.style.setProperty('--aar-horizontal-axis-width', tb.width.toFixed(2) + 'px');
    plot.classList.add('is-axis-aligned');
  }

  function initHorizontalAxisAlignment(graph) {
    var plot = graph.querySelector('.aar-report-graph__plot--horizontal');
    if (!plot) {
      return;
    }

    var update = function () {
      requestAnimationFrame(function () {
        alignHorizontalAxis(graph);
      });
    };

    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        alignHorizontalAxis(graph);
      });
    });

    if ('ResizeObserver' in window) {
      var ro = new ResizeObserver(update);
      ro.observe(plot);
      var rows = plot.querySelector('.aar-report-graph__rows');
      if (rows) {
        ro.observe(rows);
      }
    }

    window.addEventListener('resize', update);

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(update);
    }

    if (graph.classList.contains('aar-report-graph--motion')) {
      new MutationObserver(function () {
        if (graph.classList.contains('is-visible')) {
          update();
        }
      }).observe(graph, { attributes: true, attributeFilter: ['class'] });
    }
  }

  /* ---- init ---- */

  function initReportGraphs() {
    if (graphsInitialized) {
      return;
    }
    graphsInitialized = true;

    var hasGSAP = !!(window.gsap && window.ScrollTrigger);


    document.querySelectorAll('.aar-report-graph').forEach(function (graph) {
      var hasMotion = graph.classList.contains('aar-report-graph--motion');

      if (!hasMotion) {
        graph.classList.add('is-visible');
        initHorizontalAxisAlignment(graph);
        return;
      }

      initHorizontalAxisAlignment(graph);

      if (hasGSAP) {
        initGraphGSAP(graph);
      } else {
        initGraphRevealFallback(graph);
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReportGraphs);
  } else {
    initReportGraphs();
  }

  window.addEventListener('load', function () {
    if (!graphsInitialized) {
      initReportGraphs();
    }
  });
})();
