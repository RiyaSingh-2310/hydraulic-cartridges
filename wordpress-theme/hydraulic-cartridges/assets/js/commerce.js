(() => {
  const cfg = window.hcCommerce || {};
  const ajaxUrl = cfg.ajaxUrl || '';
  const nonce = cfg.nonce || '';

  function request(body) {
    const data = new FormData();
    data.append('action', 'hc_cart');
    data.append('nonce', nonce);
    Object.entries(body).forEach(([key, value]) => data.append(key, String(value)));
    return fetch(ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' }).then((res) => res.json());
  }

  function setCount(count) {
    const badge = document.querySelector('[data-cart-count]');
    if (!badge) return;
    const n = Number(count) || 0;
    badge.textContent = String(n);
    badge.hidden = n < 1;
  }

  function toast(message) {
    let el = document.querySelector('[data-cart-toast]');
    if (!el) {
      el = document.createElement('div');
      el.className = 'cart-toast';
      el.setAttribute('data-cart-toast', '');
      document.body.appendChild(el);
    }
    el.textContent = message;
    el.classList.add('is-on');
    window.clearTimeout(toast.t);
    toast.t = window.setTimeout(() => el.classList.remove('is-on'), 2200);
  }

  function qtyFrom(button) {
    const wrap = button.closest('[data-product-actions], .detail-buy, .cart-row');
    const input = wrap?.querySelector('[data-qty-input]');
    const value = Number(input?.value || 1);
    return Number.isFinite(value) && value > 0 ? value : 1;
  }

  document.querySelectorAll('[data-qty]').forEach((wrap) => {
    const input = wrap.querySelector('[data-qty-input]');
    wrap.querySelector('[data-qty-minus]')?.addEventListener('click', () => {
      input.value = String(Math.max(1, Number(input.value || 1) - 1));
      input.dispatchEvent(new Event('change', { bubbles: true }));
    });
    wrap.querySelector('[data-qty-plus]')?.addEventListener('click', () => {
      input.value = String(Math.min(999, Number(input.value || 1) + 1));
      input.dispatchEvent(new Event('change', { bubbles: true }));
    });
  });

  document.querySelectorAll('[data-add-cart]').forEach((button) => {
    button.addEventListener('click', () => {
      const id = button.getAttribute('data-product-id');
      if (!id) return;
      button.disabled = true;
      request({ cart_action: 'add', product_id: id, qty: qtyFrom(button) })
        .then((json) => {
          if (!json.success) throw new Error('add');
          setCount(json.data.count);
          toast('Added to cart');
        })
        .catch(() => toast('Could not add this product'))
        .finally(() => {
          button.disabled = false;
        });
    });
  });

  document.querySelectorAll('[data-cart-update]').forEach((input) => {
    input.addEventListener('change', () => {
      request({
        cart_action: 'update',
        product_id: input.getAttribute('data-product-id'),
        qty: input.value,
      }).then((json) => {
        if (json.success) {
          setCount(json.data.count);
          window.location.reload();
        }
      });
    });
  });

  document.querySelectorAll('[data-cart-remove]').forEach((button) => {
    button.addEventListener('click', () => {
      request({ cart_action: 'remove', product_id: button.getAttribute('data-product-id') }).then((json) => {
        if (json.success) {
          setCount(json.data.count);
          window.location.reload();
        }
      });
    });
  });

  const account = document.querySelector('[data-account-toggle]');
  const menu = document.querySelector('[data-account-menu]');
  if (account && menu) {
    account.addEventListener('click', (event) => {
      if (window.matchMedia('(min-width: 960px)').matches) {
        event.preventDefault();
        menu.hidden = !menu.hidden;
      }
    });
    document.addEventListener('click', (event) => {
      if (!event.target.closest('.header-account')) menu.hidden = true;
    });
  }
})();
