(() => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const hero = document.querySelector('.hero');
  const media = hero?.querySelector('.hero-media');
  if (!hero || !media || reduce) return;

  const update = () => {
    const rect = hero.getBoundingClientRect();
    const h = hero.offsetHeight || 1;
    const progress = Math.min(1, Math.max(0, -rect.top / h));
    media.style.transform = `translateY(${progress * 80}px)`;
    media.style.opacity = String(1 - progress * 0.45);
  };

  update();
  window.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
})();
