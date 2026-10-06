(() => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const header = document.querySelector('.site-header');
  const toggle = document.querySelector('.menu-toggle');
  const layer = document.querySelector('.menu-layer');
  const closeBtn = document.querySelector('.menu-close');
  const backdrop = document.querySelector('.menu-backdrop');
  const sr = toggle?.querySelector('.sr-only');

  function setOpen(open) {
    if (!header || !layer || !toggle) return;
    header.classList.toggle('menu-open', open);
    layer.classList.toggle('is-open', open);
    toggle.classList.toggle('open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (sr) sr.textContent = open ? 'Close menu' : 'Open menu';
    document.body.style.overflow = open ? 'hidden' : '';
    document.documentElement.style.overflow = open ? 'hidden' : '';
    if (open) closeBtn?.focus();
  }

  function closeMenu(restore) {
    setOpen(false);
    if (restore) toggle?.focus();
  }

  toggle?.addEventListener('click', () => {
    const open = !layer?.classList.contains('is-open');
    setOpen(open);
    if (!open) toggle.focus();
  });
  closeBtn?.addEventListener('click', () => closeMenu(true));
  backdrop?.addEventListener('click', () => closeMenu(true));
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && layer?.classList.contains('is-open')) {
      closeMenu(true);
    }
  });

  const onScroll = () => {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 8);
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  const reveals = document.querySelectorAll('.reveal');
  if (reduce) {
    reveals.forEach((el) => el.classList.add('is-in'));
  } else if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-in');
            io.unobserve(entry.target);
          }
        });
      },
      { rootMargin: '0px 0px -80px 0px', threshold: 0.01 }
    );
    reveals.forEach((el) => io.observe(el));
  } else {
    reveals.forEach((el) => el.classList.add('is-in'));
  }

  document.querySelectorAll('[data-resource-card]').forEach((card) => {
    card.addEventListener('click', () => {
      const slug = card.getAttribute('data-resource-card');
      const title = card.getAttribute('data-resource-title') || '';
      const notice = card.closest('section')?.querySelector('[data-resource-notice]');
      const label = notice?.querySelector('[data-resource-label]');
      document.querySelectorAll('[data-resource-card].active').forEach((el) => {
        if (el !== card) el.classList.remove('active');
      });
      const on = !card.classList.contains('active');
      card.classList.toggle('active', on);
      if (notice && label) {
        if (on) {
          label.textContent = title;
          notice.hidden = false;
        } else {
          notice.hidden = true;
        }
      }
    });
  });
})();
