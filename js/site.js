/**
 * YARAMAY site.js
 *
 * AOS (Animate On Scroll) — global config per design system:
 *   duration: 600
 *   easing: ease-out-cubic
 *   once: true
 *   offset: 80
 * Respects prefers-reduced-motion via AOS built-in detection + CSS overrides.
 */
if (typeof AOS !== 'undefined') {
  AOS.init({
    duration: 600,
    easing: 'ease-out-cubic',
    once: true,
    offset: 80,
  });
}

(function () {
  var rotateEl = document.querySelector('.hero-rotate-word');
  if (rotateEl) {
    var words = ['Digital Presence', 'IT Solutions', 'Web Design'];
    var index = 0;
    var prefersReduced =
      window.matchMedia &&
      window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!prefersReduced) {
      setInterval(function () {
        rotateEl.classList.add('is-fading');
        setTimeout(function () {
          index = (index + 1) % words.length;
          rotateEl.textContent = words[index];
          rotateEl.classList.remove('is-fading');
        }, 300);
      }, 3500);
    }
  }
})();

(function () {
  var counters = document.querySelectorAll('[data-count-to]');
  if (!counters.length) return;

  var prefersReduced =
    window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function animateCounter(el) {
    if (el.dataset.counted === 'true') return;
    el.dataset.counted = 'true';

    var target = parseInt(el.getAttribute('data-count-to'), 10);
    var suffix = el.getAttribute('data-count-suffix') || '';
    var duration = 1800;
    var start = 0;
    var startTime = null;

    if (prefersReduced) {
      el.textContent = target + suffix;
      return;
    }

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      var current = Math.floor(start + (target - start) * eased);
      el.textContent = current + suffix;
      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = target + suffix;
      }
    }

    requestAnimationFrame(step);
  }

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.4 }
  );

  counters.forEach(function (counter) {
    observer.observe(counter);
  });
})();

(function () {
  var navbar = document.getElementById('siteNavbar');
  if (!navbar) return;

  var navLinks = document.querySelectorAll('[data-nav]');
  var sections = document.querySelectorAll('section[id]');
  var collapseEl = document.getElementById('navbarNav');

  function getNavOffset() {
    return navbar.offsetHeight;
  }

  function updateNavbarScroll() {
    navbar.classList.toggle('navbar-scrolled', window.scrollY > 40);
  }

  function setActiveNav(sectionId) {
    navLinks.forEach(function (link) {
      var isActive = link.getAttribute('href') === '#' + sectionId;
      link.classList.toggle('active', isActive);
    });
  }

  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (event) {
      var href = anchor.getAttribute('href');
      if (!href || href === '#') return;

      var target = document.querySelector(href);
      if (!target) return;

      event.preventDefault();

      var top =
        target.getBoundingClientRect().top + window.scrollY - getNavOffset();

      window.scrollTo({ top: top, behavior: 'smooth' });

      if (collapseEl && collapseEl.classList.contains('show')) {
        var instance = bootstrap.Collapse.getInstance(collapseEl);
        if (instance) instance.hide();
      }
    });
  });

  if (sections.length && navLinks.length) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            setActiveNav(entry.target.id);
          }
        });
      },
      {
        rootMargin: '-' + getNavOffset() + 'px 0px -55% 0px',
        threshold: 0,
      }
    );

    sections.forEach(function (section) {
      observer.observe(section);
    });
  }

  window.addEventListener('scroll', updateNavbarScroll, { passive: true });
  updateNavbarScroll();
})();

(function () {
  var params = new URLSearchParams(window.location.search);
  var status = params.get('contact');
  if (!status) return;

  var alertEl = document.getElementById('contact-alert');
  if (!alertEl) return;

  var reason = params.get('reason');
  var messages = {
    success: 'Thank you! Your message has been sent. We will get back to you soon.',
    error: {
      missing: 'Please fill in all fields before sending.',
      email: 'Please enter a valid email address.',
      send: 'We could not send your message. Please try again later or email us directly.',
    },
  };

  alertEl.classList.remove('d-none', 'alert-success', 'alert-danger');
  if (status === 'success') {
    alertEl.classList.add('alert-success');
    alertEl.textContent = messages.success;
    var form = document.getElementById('contact-form');
    if (form) form.reset();
  } else {
    alertEl.classList.add('alert-danger');
    alertEl.textContent =
      (messages.error && messages.error[reason]) || messages.error.send;
  }

  params.delete('contact');
  params.delete('reason');
  var query = params.toString();
  var cleanUrl =
    window.location.pathname +
    (query ? '?' + query : '') +
    window.location.hash;
  window.history.replaceState({}, '', cleanUrl);
})();

(function () {
  var positionSelect = document.getElementById('position');
  var positionOtherWrap = document.getElementById('position-other-wrap');
  if (positionSelect && positionOtherWrap) {
    function togglePositionOther() {
      var show = positionSelect.value === 'other';
      positionOtherWrap.hidden = !show;
      if (!show) {
        var otherInput = document.getElementById('position_other');
        if (otherInput) otherInput.value = '';
      }
    }
    positionSelect.addEventListener('change', togglePositionOther);
    togglePositionOther();
  }
})();

(function () {
  var params = new URLSearchParams(window.location.search);
  var status = params.get('registration');
  if (!status) return;

  var alertEl = document.getElementById('registration-alert');
  if (!alertEl) return;

  var reason = params.get('reason');
  var messages = {
    success: 'Thank you! Your registration has been submitted successfully. We will contact you soon.',
    error: {
      missing: 'Please fill in all required fields before submitting.',
      email: 'Please enter a valid email address.',
      send: 'We could not send your registration. Please try again later or contact us directly.',
    },
  };

  alertEl.classList.remove('d-none', 'alert-success', 'alert-danger');
  if (status === 'success') {
    alertEl.classList.add('alert-success');
    alertEl.textContent = messages.success;
    var form = document.getElementById('registration-form');
    if (form) form.reset();
    var positionOtherWrap = document.getElementById('position-other-wrap');
    if (positionOtherWrap) positionOtherWrap.hidden = true;
  } else {
    alertEl.classList.add('alert-danger');
    alertEl.textContent =
      (messages.error && messages.error[reason]) || messages.error.send;
  }

  params.delete('registration');
  params.delete('reason');
  var query = params.toString();
  var cleanUrl =
    window.location.pathname +
    (query ? '?' + query : '') +
    window.location.hash;
  window.history.replaceState({}, '', cleanUrl);
})();
