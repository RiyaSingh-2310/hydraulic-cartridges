(() => {
  const gallery = document.querySelector('[data-gallery]');
  if (!gallery) return;
  const main = gallery.querySelector('[data-gallery-main]');
  const drawing = gallery.querySelector('[data-gallery-drawing]');
  const buttons = [...gallery.querySelectorAll('[data-gallery-thumb]')];
  let panels = [];
  try {
    panels = JSON.parse(gallery.getAttribute('data-gallery') || '[]');
  } catch (e) {
    panels = [];
  }

  buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
      buttons.forEach((el, i) => el.classList.toggle('active', i === index));
      if (!main) return;
      main.replaceChildren();
      if (index === 0 && drawing) {
        drawing.childNodes.forEach((node) => {
          main.appendChild(node.cloneNode(true));
        });
        return;
      }
      const panel = panels[index];
      if (!panel?.src) return;
      const img = document.createElement('img');
      img.src = panel.src;
      img.alt = panel.alt || '';
      img.style.width = '100%';
      img.style.height = '22rem';
      img.style.objectFit = 'cover';
      main.appendChild(img);
    });
  });
})();
