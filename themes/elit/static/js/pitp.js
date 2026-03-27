/**
 * Pee in the Pool — Static archive comment injection system
 *
 * Simulates the ebb and flow of audience participation from the
 * original 2006 live installation. Comments are injected into story
 * text based on a time-of-day activity cycle and/or manual override.
 *
 * Activity model (local time):
 *   - 5pm–midnight: peak activity (reading/event hours)
 *   - Noon–1pm: slight lunch bump
 *   - 2am–10am: quiet hours
 *   - Everything else: moderate baseline
 */

(function () {
  'use strict';

  var stories = window.pitpStories || {};
  var allComments = window.pitpComments || [];
  var currentChapter = 1;
  var isClean = false;
  var manualOverride = null; // null = auto, 0–1 = manual level
  var seededComments = null; // cached shuffled selection per session

  // Seed a pseudo-random shuffle per page visit so it's consistent
  // within a session but different between visits
  var sessionSeed = Math.random();

  // Seeded PRNG (mulberry32)
  function mulberry32(seed) {
    return function () {
      seed |= 0;
      seed = seed + 0x6D2B79F5 | 0;
      var t = Math.imul(seed ^ seed >>> 15, 1 | seed);
      t = t + Math.imul(t ^ t >>> 7, 61 | t) ^ t;
      return ((t ^ t >>> 14) >>> 0) / 4294967296;
    };
  }

  /**
   * Calculate activity level (0–1) based on local hour.
   * Returns a float representing how "busy" the pool should be.
   */
  function getTimeActivity() {
    var hour = new Date().getHours();
    var minute = new Date().getMinutes();
    var t = hour + minute / 60;

    // Evening peak: 5pm (17) to midnight (24) — ramps up from 17, peaks ~20–22
    if (t >= 17 && t < 24) {
      // Ramp: 17→0.5, 19→0.85, 20-22→1.0, 23→0.7
      if (t < 19) return 0.5 + (t - 17) * 0.175;
      if (t < 20) return 0.85 + (t - 19) * 0.15;
      if (t < 22) return 1.0;
      return 1.0 - (t - 22) * 0.15;
    }

    // Late night: midnight to 2am — winding down
    if (t >= 0 && t < 2) return 0.5 - t * 0.15;

    // Quiet hours: 2am–10am
    if (t >= 2 && t < 10) return 0.1;

    // Morning ramp: 10am–noon
    if (t >= 10 && t < 12) return 0.1 + (t - 10) * 0.1;

    // Lunch bump: noon–1pm
    if (t >= 12 && t < 13) return 0.35;

    // Afternoon: 1pm–5pm, gentle baseline
    if (t >= 13 && t < 17) return 0.2 + (t - 13) * 0.05;

    return 0.2;
  }

  /**
   * Get current activity level, considering manual override.
   * Returns 0–1.
   */
  function getActivityLevel() {
    if (manualOverride !== null) return manualOverride;
    return getTimeActivity();
  }

  /**
   * Map activity level to comment count.
   * 0 → 0 comments, 0.1 → ~3, 0.5 → ~15, 1.0 → ~40
   */
  function getCommentCount(activity) {
    if (isClean) return 0;
    return Math.round(activity * 40);
  }

  /**
   * Select comments for display using session-seeded shuffle.
   * This ensures the same comments appear consistently within
   * a page visit but vary between visits.
   */
  function selectComments(count) {
    if (count === 0) return [];

    // Build a session-stable shuffled order (once)
    if (!seededComments) {
      var rng = mulberry32(Math.floor(sessionSeed * 2147483647));
      seededComments = allComments.slice();
      // Fisher-Yates with seeded RNG
      for (var i = seededComments.length - 1; i > 0; i--) {
        var j = Math.floor(rng() * (i + 1));
        var tmp = seededComments[i];
        seededComments[i] = seededComments[j];
        seededComments[j] = tmp;
      }
    }

    return seededComments.slice(0, Math.min(count, seededComments.length));
  }

  /**
   * Assign a "heat" class to a comment based on its position
   * in the selected set. Earlier = hotter (more recent in simulation).
   */
  function getHeatClass(index, total) {
    var pct = total > 1 ? index / (total - 1) : 0;
    if (pct < 0.25) return 'pitp-comment-hot';
    if (pct < 0.5) return 'pitp-comment-warm';
    if (pct < 0.75) return 'pitp-comment-cool';
    return 'pitp-comment-cold';
  }

  /**
   * Escape HTML entities for safe display.
   */
  function escapeHtml(text) {
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  /**
   * Render a chapter with comments injected into the story text.
   * Mirrors the original algorithm: divide story into segments
   * and insert comments at regular intervals.
   */
  function renderChapter(chapterNum) {
    currentChapter = chapterNum;
    var storyText = stories[String(chapterNum)] || '';
    var activity = getActivityLevel();
    var commentCount = getCommentCount(activity);
    var comments = selectComments(commentCount);

    var html;

    if (comments.length === 0) {
      // Clean view — just render story paragraphs
      html = storyToHtml(storyText);
    } else {
      // Split story into paragraphs first, then inject comments
      // while preserving paragraph structure
      var paragraphs = storyText.split(/\n\n+/);

      // Count total words across all paragraphs
      var totalWords = 0;
      var paraWords = [];
      paragraphs.forEach(function (p) {
        var words = p.trim().split(/\s+/);
        paraWords.push(words);
        totalWords += words.length;
      });

      var breakPoint = Math.floor(totalWords / (comments.length + 1));
      if (breakPoint < 3) breakPoint = 3;

      var commentIndex = 0;
      var wordCount = 0;
      var htmlParts = [];

      paraWords.forEach(function (words) {
        var result = [];
        for (var i = 0; i < words.length; i++) {
          result.push(escapeHtml(words[i]));
          wordCount++;

          if (wordCount >= breakPoint && commentIndex < comments.length) {
            var cls = getHeatClass(commentIndex, comments.length);
            var commentText = escapeHtml(comments[commentIndex].text);
            result.push(' <span class="pitp-comment ' + cls + '">' + commentText + '</span> ');
            commentIndex++;
            wordCount = 0;
          }
        }
        htmlParts.push('<p>' + result.join(' ') + '</p>');
      });

      // Insert any remaining comments at the end of the last paragraph
      if (commentIndex < comments.length) {
        var trailing = [];
        while (commentIndex < comments.length) {
          var cls2 = getHeatClass(commentIndex, comments.length);
          var ct = escapeHtml(comments[commentIndex].text);
          trailing.push('<span class="pitp-comment ' + cls2 + '">' + ct + '</span>');
          commentIndex++;
        }
        htmlParts.push('<p>' + trailing.join(' ') + '</p>');
      }

      html = htmlParts.join('');
    }

    document.getElementById('pitp-content').innerHTML = html;

    // Update activity display
    updateActivityDisplay(activity, commentCount);

    // Update chapter nav buttons (both top and bottom)
    document.querySelectorAll('#pitp-chapter-nav button, #pitp-chapter-nav-bottom button').forEach(function (btn) {
      btn.classList.toggle('active', parseInt(btn.dataset.chapter) === chapterNum);
    });
  }

  /**
   * Convert plain text to HTML paragraphs.
   */
  function storyToHtml(text) {
    var paragraphs = text.split(/\n\n+/);
    return paragraphs.map(function (p) {
      return '<p>' + escapeHtml(p.trim()).replace(/\n/g, '<br>') + '</p>';
    }).join('');
  }

  /**
   * Update the activity bar and comment count display.
   */
  function updateActivityDisplay(activity, count) {
    var fill = document.getElementById('pitp-activity-fill');
    var countEl = document.getElementById('pitp-comment-count');
    fill.style.width = Math.round(activity * 100) + '%';
    countEl.textContent = count + ' comment' + (count !== 1 ? 's' : '');
  }

  /**
   * Initialize the reader.
   */
  function init() {
    // Chapter nav (top and bottom)
    document.querySelectorAll('#pitp-chapter-nav button, #pitp-chapter-nav-bottom button').forEach(function (btn) {
      btn.addEventListener('click', function () {
        renderChapter(parseInt(this.dataset.chapter));
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    });

    // Clean the pool toggle
    var cleanBtn = document.getElementById('pitp-clean-btn');
    cleanBtn.addEventListener('click', function () {
      isClean = !isClean;
      this.classList.toggle('active', isClean);
      this.textContent = isClean ? 'Dirty the pool' : 'Clean the pool';
      renderChapter(currentChapter);
    });

    // Activity slider
    var slider = document.getElementById('pitp-slider');
    var sliderLabel = document.getElementById('pitp-slider-label');

    slider.addEventListener('input', function () {
      var val = parseInt(this.value);
      if (val === 50) {
        manualOverride = null;
        sliderLabel.textContent = 'auto';
      } else {
        manualOverride = val / 100;
        if (val < 15) {
          sliderLabel.textContent = 'quiet';
        } else if (val < 40) {
          sliderLabel.textContent = 'mellow';
        } else if (val < 65) {
          sliderLabel.textContent = 'moderate';
        } else if (val < 85) {
          sliderLabel.textContent = 'busy';
        } else {
          sliderLabel.textContent = 'reading night';
        }
      }
      renderChapter(currentChapter);
    });

    // Info popover
    var infoBtn = document.getElementById('pitp-info-btn');
    var popover = document.getElementById('pitp-info-popover');
    infoBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      popover.classList.toggle('visible');
    });
    document.addEventListener('click', function () {
      popover.classList.remove('visible');
    });
    popover.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    // Initial render
    renderChapter(1);
  }

  document.addEventListener('DOMContentLoaded', init);
})();
