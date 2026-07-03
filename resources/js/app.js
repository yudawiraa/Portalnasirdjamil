import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const siteNav = document.querySelector('[data-site-nav]');
  const navToggle = document.querySelector('[data-nav-toggle]');
  const navMenu = document.querySelector('[data-nav-menu]');

  const setNavOpen = (isOpen) => {
    if (!siteNav || !navToggle) return;

    siteNav.classList.toggle('is-open', isOpen);
    navToggle.setAttribute('aria-expanded', String(isOpen));
    navToggle.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
  };

  navToggle?.addEventListener('click', () => {
    setNavOpen(!siteNav?.classList.contains('is-open'));
  });

  navMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setNavOpen(false));
  });

  document.addEventListener('click', (event) => {
    if (!siteNav?.classList.contains('is-open')) return;
    if (siteNav.contains(event.target)) return;

    setNavOpen(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      setNavOpen(false);
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 980) {
      setNavOpen(false);
    }
  });

  const revealItems = [...document.querySelectorAll('.reveal')];

  const revealVisibleItems = () => {
    revealItems.forEach((el) => {
      if (el.classList.contains('in')) return;

      const rect = el.getBoundingClientRect();
      const isVisible = rect.top < window.innerHeight * 0.9 && rect.bottom > 0;

      if (isVisible) {
        el.classList.add('in');
      }
    });
  };

  if ('IntersectionObserver' in window) {
    const revealObs = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          revealObs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    revealItems.forEach((el) => revealObs.observe(el));
  } else {
    revealItems.forEach((el) => el.classList.add('in'));
  }

  requestAnimationFrame(revealVisibleItems);
  window.addEventListener('scroll', revealVisibleItems, { passive: true });
  window.addEventListener('resize', revealVisibleItems);

  const steps = [...document.querySelectorAll('.aspirasi-step')];
  const stepIndicators = [...document.querySelectorAll('.step')];

  function showStep(step, shouldScroll = true) {
    steps.forEach((el) => {
      el.hidden = el.dataset.step !== String(step);
    });

    stepIndicators.forEach((el, index) => {
      const current = index + 1;
      el.classList.toggle('active', current === step);
      el.classList.toggle('done', current < step);
    });

    if (shouldScroll) {
      document.querySelector('.form-card')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  const aspirasiForm = document.querySelector('form[data-initial-step]');
  if (aspirasiForm) {
    showStep(Number(aspirasiForm.dataset.initialStep || 1), false);
  }

  document.querySelectorAll('[data-step-target]').forEach((button) => {
    button.addEventListener('click', () => showStep(Number(button.dataset.stepTarget)));
  });

  document.querySelectorAll('[data-filter]').forEach((button) => {
    button.addEventListener('click', () => {
      const group = button.closest('[data-filter-group]');
      const groupName = group?.dataset.filterGroup;
      const target = button.dataset.filter;
      group?.querySelectorAll('[data-filter]').forEach((el) => el.classList.remove('active'));
      button.classList.add('active');

      document.querySelectorAll(`[data-filterable="${groupName}"]`).forEach((item) => {
        item.classList.toggle('hidden', target !== 'semua' && item.dataset.category !== target);
      });

      document.querySelectorAll(`[data-filter-panel="${groupName}"]`).forEach((panel) => {
        const categories = (panel.dataset.filterPanelCategories || '').split(/\s+/).filter(Boolean);
        const shouldShow = target === 'semua'
          ? panel.dataset.showOnAll !== 'false'
          : categories.includes(target);

        panel.classList.toggle('hidden', !shouldShow);
      });

      requestAnimationFrame(revealVisibleItems);
    });
  });

  document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-tf-tab]');

    if (!button) {
      return;
    }

    const target = button.dataset.tfTab;

    document.querySelectorAll('[data-tf-tab]').forEach((tab) => {
      tab.classList.toggle('active', tab.dataset.tfTab === target);
    });

    document.querySelectorAll('[data-tf-panel]').forEach((panel) => {
      panel.classList.toggle('active', panel.dataset.tfPanel === target);
    });
  });

  document.querySelectorAll('[data-uppercase]').forEach((input) => {
    input.addEventListener('input', () => {
      input.value = input.value.toUpperCase();
    });
  });

  const slides = [...document.querySelectorAll('.slide')];
  const dots = [...document.querySelectorAll('.slider-dot')];
  let activeSlide = 0;

  function setSlide(index) {
    if (!slides.length) return;
    activeSlide = (index + slides.length) % slides.length;
    slides.forEach((slide, i) => slide.classList.toggle('active', i === activeSlide));
    dots.forEach((dot, i) => dot.classList.toggle('active', i === activeSlide));
  }

  dots.forEach((dot, i) => dot.addEventListener('click', () => setSlide(i)));

  if (slides.length > 1) {
    setInterval(() => setSlide(activeSlide + 1), 5000);
  }

  const processInstagramEmbeds = () => {
    if (window.instgrm?.Embeds?.process) {
      window.instgrm.Embeds.process();
      return;
    }

    const existingScript = document.querySelector('script[src*="instagram.com/embed.js"]');

    if (existingScript) {
      existingScript.addEventListener('load', () => window.instgrm?.Embeds?.process?.(), { once: true });
      return;
    }

    const script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.instagram.com/embed.js';
    script.addEventListener('load', () => window.instgrm?.Embeds?.process?.(), { once: true });
    document.body.appendChild(script);
  };

  document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-video-toggle]');

    if (!button) {
      return;
    }

    const card = button.closest('[data-video-card]');
    const embed = card?.querySelector('[data-video-embed]');

    if (!embed) {
      return;
    }

    embed.hidden = false;
    card.classList.add('is-open');
    card.querySelectorAll('[data-video-toggle]').forEach((toggle) => {
      toggle.setAttribute('aria-expanded', 'true');
    });

    requestAnimationFrame(() => {
      processInstagramEmbeds();
      embed.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
  });
});
