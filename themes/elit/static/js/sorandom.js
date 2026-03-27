/**
 * soRandom — Client-side randomized story reader
 *
 * The story has 12 segment types (p1–p12) across 3 pages,
 * plus tangent segments (type "t") linked by keywords.
 * Each page load randomly selects one segment per slot.
 */

(function () {
  'use strict';

  // Page definitions: which segment types appear on each page
  var PAGES = {
    1: ['p1', 'p2', 'p3', 'p4'],
    2: ['p5', 'p6', 'p7', 'p8'],
    3: ['p9', 'p10', 'p11', 'p12']
  };

  var data = window.soRandomData || [];
  var currentPage = 1;
  var mode = 'story'; // 'story' or 'tangent'

  // Group segments by type
  var segmentsByType = {};
  data.forEach(function (seg) {
    if (!segmentsByType[seg.type]) {
      segmentsByType[seg.type] = [];
    }
    segmentsByType[seg.type].push(seg);
  });

  // Build keyword list from actual tangent data — only link words
  // that have at least one matching tangent entry
  var KEYWORDS = [];
  (function () {
    var kwSet = {};
    var tangents = segmentsByType['t'] || [];
    tangents.forEach(function (seg) {
      var kws = seg.keywords.toLowerCase().split(/\s+/);
      kws.forEach(function (k) {
        k = k.trim();
        if (k) kwSet[k] = true;
      });
    });
    KEYWORDS = Object.keys(kwSet);
  })();

  // Fisher-Yates shuffle
  function shuffle(arr) {
    var a = arr.slice();
    for (var i = a.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var tmp = a[i];
      a[i] = a[j];
      a[j] = tmp;
    }
    return a;
  }

  // Pick a random segment of the given type
  function pickSegment(type) {
    var segs = segmentsByType[type];
    if (!segs || segs.length === 0) return null;
    return segs[Math.floor(Math.random() * segs.length)];
  }

  // Add keyword links to text
  function linkKeywords(text) {
    // Sort keywords by length (longest first) to avoid partial matches
    var sorted = KEYWORDS.slice().sort(function (a, b) {
      return b.length - a.length;
    });

    sorted.forEach(function (kw) {
      // Match whole words, case-insensitive, but preserve original case
      var regex = new RegExp('\\b(' + kw + ')\\b', 'gi');
      text = text.replace(regex, function (match) {
        return '<span class="sorandom-keyword" data-keyword="' +
          kw.toLowerCase() + '">' + match + '</span>';
      });
    });

    return text;
  }

  // Convert newlines to HTML
  function textToHtml(text) {
    // Escape HTML first
    var div = document.createElement('div');
    div.textContent = text;
    var escaped = div.innerHTML;
    // Convert newlines to breaks
    escaped = escaped.replace(/\n/g, '<br>');
    return escaped;
  }

  // Render story page
  function renderPage(pageNum) {
    mode = 'story';
    currentPage = pageNum;
    var types = PAGES[pageNum];
    if (!types) return;

    var html = '';
    types.forEach(function (type) {
      var seg = pickSegment(type);
      if (seg) {
        var content = textToHtml(seg.text);
        content = linkKeywords(content);
        html += '<div class="sorandom-segment">' + content + '</div>';
      }
    });

    document.getElementById('sr-content').innerHTML = html;
    document.getElementById('sr-tangent-bar').style.display = 'none';

    // Update nav buttons
    var buttons = document.querySelectorAll('#sr-page-nav button');
    buttons.forEach(function (btn) {
      btn.classList.toggle('active', parseInt(btn.dataset.page) === pageNum);
    });

    bindKeywordClicks();
  }

  // Render tangent view for a keyword
  function renderTangent(keyword) {
    mode = 'tangent';
    var tangents = segmentsByType['t'] || [];

    // Filter tangents whose keywords field contains this keyword
    var matching = tangents.filter(function (seg) {
      var kws = seg.keywords.toLowerCase().split(/[\s,;]+/);
      return kws.indexOf(keyword.toLowerCase()) !== -1;
    });

    // Shuffle and take up to 4
    matching = shuffle(matching).slice(0, 4);

    var html = '';
    if (matching.length === 0) {
      html = '<div class="sorandom-segment"><em>No tangent passages found for &ldquo;' +
        keyword + '&rdquo;. Try another word.</em></div>';
    } else {
      matching.forEach(function (seg) {
        var content = textToHtml(seg.text);
        content = linkKeywords(content);
        html += '<div class="sorandom-segment">' + content + '</div>';
      });
    }

    document.getElementById('sr-content').innerHTML = html;

    // Show tangent bar
    document.getElementById('sr-tangent-keyword').textContent = keyword;
    document.getElementById('sr-tangent-bar').style.display = 'flex';

    // Deactivate page buttons
    var buttons = document.querySelectorAll('#sr-page-nav button');
    buttons.forEach(function (btn) { btn.classList.remove('active'); });

    bindKeywordClicks();
  }

  // Bind click handlers on keyword spans
  function bindKeywordClicks() {
    document.querySelectorAll('.sorandom-keyword').forEach(function (el) {
      el.addEventListener('click', function () {
        renderTangent(this.dataset.keyword);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    });
  }

  // Init
  document.addEventListener('DOMContentLoaded', function () {
    // Page nav buttons
    document.querySelectorAll('#sr-page-nav button').forEach(function (btn) {
      btn.addEventListener('click', function () {
        renderPage(parseInt(this.dataset.page));
      });
    });

    // Back button from tangent view
    document.getElementById('sr-back-btn').addEventListener('click', function () {
      renderPage(currentPage);
    });

    // Reshuffle button
    document.getElementById('sr-reshuffle').addEventListener('click', function () {
      if (mode === 'story') {
        renderPage(currentPage);
      }
    });

    // Initial render
    renderPage(1);
  });
})();
