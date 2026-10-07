(() => {
  const cfg = window.hcCommerce || {};
  const ajaxUrl = cfg.ajaxUrl || '';
  const nonce = cfg.nonce || '';
  const drawer = document.querySelector('[data-cart-drawer]');
  const drawerBody = document.querySelector('[data-cart-body]');
  const drawerFoot = document.querySelector('[data-cart-foot]');
  const drawerTotal = document.querySelector('[data-cart-total]');
  let cartBusy = false;

  function request(action, body) {
    const data = new FormData();
    data.append('action', action);
    data.append('nonce', nonce);
    Object.entries(body).forEach(([key, value]) => data.append(key, String(value)));
    return fetch(ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' }).then((res) => res.json());
  }

  function esc(value) {
    return String(value ?? '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function setBadge(selector, count) {
    document.querySelectorAll(selector).forEach((badge) => {
      const n = Number(count) || 0;
      badge.textContent = String(n);
      badge.hidden = n < 1;
    });
  }

  function toast(message) {
    let el = document.querySelector('[data-cart-toast]');
    if (!el) {
      el = document.createElement('div');
      el.className = 'cart-toast';
      el.setAttribute('data-cart-toast', '');
      el.setAttribute('role', 'status');
      document.body.appendChild(el);
    }
    el.textContent = message;
    el.classList.add('is-on');
    window.clearTimeout(toast.timer);
    toast.timer = window.setTimeout(() => el.classList.remove('is-on'), 2200);
  }

  function qtyFrom(button) {
    const wrap = button.closest('[data-product-actions], .detail-buy, .cart-row');
    const input = wrap?.querySelector('[data-qty-input]');
    const value = Number(input?.value || 1);
    return Number.isFinite(value) && value > 0 ? value : 1;
  }

  function renderCart(payload) {
    if (!drawerBody) return;
    setBadge('[data-cart-count]', payload.count);
    const items = payload.items || [];
    if (!items.length) {
      drawerBody.innerHTML = '<p class="cart-drawer-empty">Your cart is empty. Browse the catalog and add a series.</p>';
      if (drawerFoot) drawerFoot.hidden = true;
      return;
    }
    if (drawerFoot) drawerFoot.hidden = false;
    if (drawerTotal) {
      drawerTotal.textContent = `Total: Quotation on request · ${payload.count} ${Number(payload.count) === 1 ? 'item' : 'items'}`;
    }
    drawerBody.innerHTML = items
      .map(
        (item) => `
        <article class="drawer-item">
          <a class="drawer-visual" href="${esc(item.permalink)}">${item.visualHtml || ''}</a>
          <div class="drawer-copy">
            <h3><a href="${esc(item.permalink)}">${esc(item.name)}</a></h3>
            <p class="cart-price">${esc(item.price || 'On request')}</p>
            <div class="drawer-controls">
              <div class="qty-control">
                <button type="button" class="qty-btn" data-drawer-minus data-product-id="${esc(item.id)}" aria-label="Decrease quantity">−</button>
                <span class="qty-value" data-drawer-qty>${esc(item.qty)}</span>
                <button type="button" class="qty-btn" data-drawer-plus data-product-id="${esc(item.id)}" aria-label="Increase quantity">+</button>
              </div>
              <button type="button" class="cart-remove" data-drawer-remove data-product-id="${esc(item.id)}">Delete</button>
            </div>
          </div>
        </article>`
      )
      .join('');
  }

  function loadCart() {
    if (!drawerBody) return Promise.resolve();
    return request('hc_cart', { cart_action: 'get' })
      .then((json) => {
        if (!json.success) throw new Error('cart');
        renderCart(json.data);
      })
      .catch(() => {
        if (drawerBody) {
          drawerBody.innerHTML = '<p class="cart-drawer-empty">Cart could not be loaded. Refresh and try again.</p>';
        }
        if (drawerFoot) drawerFoot.hidden = true;
      });
  }

  function setDrawer(open) {
    if (!drawer) return;
    drawer.classList.toggle('is-open', open);
    drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
    document.body.classList.toggle('drawer-open', open);
    if (open) {
      document.querySelector('.menu-layer')?.classList.remove('is-open');
      document.querySelector('.site-header')?.classList.remove('menu-open');
      document.querySelector('.menu-toggle')?.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      document.documentElement.style.overflow = '';
      loadCart();
      drawer.querySelector('.cart-drawer-close')?.focus();
    }
  }

  function paintWish(button, on) {
    button.classList.toggle('is-on', on);
    button.setAttribute('aria-pressed', on ? 'true' : 'false');
    const label = on ? 'Remove from Wishlist' : 'Add to Wishlist';
    button.setAttribute('aria-label', label);
    const text = button.querySelector('[data-wish-label]');
    if (text) text.textContent = label;
  }

  document.querySelectorAll('[data-qty]').forEach((wrap) => {
    const input = wrap.querySelector('[data-qty-input]');
    if (!input) return;
    wrap.querySelector('[data-qty-minus]')?.addEventListener('click', () => {
      input.value = String(Math.max(1, Number(input.value || 1) - 1));
      input.dispatchEvent(new Event('change', { bubbles: true }));
    });
    wrap.querySelector('[data-qty-plus]')?.addEventListener('click', () => {
      input.value = String(Math.min(999, Number(input.value || 1) + 1));
      input.dispatchEvent(new Event('change', { bubbles: true }));
    });
  });

  document.addEventListener('click', (event) => {
    const add = event.target.closest('[data-add-cart]');
    if (!add) return;
    const id = add.getAttribute('data-product-id');
    if (!id) return;
    add.disabled = true;
    request('hc_cart', { cart_action: 'add', product_id: id, qty: qtyFrom(add) })
      .then((json) => {
        if (!json.success) throw new Error('add');
        setBadge('[data-cart-count]', json.data.count);
        if (drawer?.classList.contains('is-open')) renderCart(json.data);
        toast('Added to cart');
      })
      .catch(() => toast('Could not add this product'))
      .finally(() => {
        add.disabled = false;
      });
  });

  document.querySelectorAll('[data-cart-update]').forEach((input) => {
    input.addEventListener('change', () => {
      request('hc_cart', {
        cart_action: 'update',
        product_id: input.getAttribute('data-product-id'),
        qty: input.value,
      }).then((json) => {
        if (json.success) {
          setBadge('[data-cart-count]', json.data.count);
          window.location.reload();
        }
      });
    });
  });

  document.querySelectorAll('[data-cart-remove]').forEach((button) => {
    button.addEventListener('click', () => {
      request('hc_cart', { cart_action: 'remove', product_id: button.getAttribute('data-product-id') }).then((json) => {
        if (json.success) {
          setBadge('[data-cart-count]', json.data.count);
          window.location.reload();
        }
      });
    });
  });

  document.addEventListener('click', (event) => {
    const open = event.target.closest('[data-cart-open]');
    if (open) {
      event.preventDefault();
      document.querySelector('[data-account-menu]')?.setAttribute('hidden', '');
      setDrawer(true);
      return;
    }
    if (event.target.closest('[data-cart-close]')) {
      setDrawer(false);
    }
  });

  drawer?.addEventListener('click', (event) => {
    const minus = event.target.closest('[data-drawer-minus]');
    const plus = event.target.closest('[data-drawer-plus]');
    const remove = event.target.closest('[data-drawer-remove]');
    const control = minus || plus || remove;
    if (!control || cartBusy) return;
    const id = control.getAttribute('data-product-id');
    const current = Number(control.closest('.drawer-item')?.querySelector('[data-drawer-qty]')?.textContent || 1);
    let action = 'update';
    let qty = current;
    if (remove) {
      action = 'remove';
    } else if (minus) {
      qty = Math.max(1, current - 1);
    } else if (plus) {
      qty = Math.min(999, current + 1);
    }
    cartBusy = true;
    request('hc_cart', { cart_action: action, product_id: id, qty })
      .then((json) => {
        if (json.success) renderCart(json.data);
      })
      .finally(() => {
        cartBusy = false;
      });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && drawer?.classList.contains('is-open')) {
      setDrawer(false);
    }
  });

  document.addEventListener('click', (event) => {
    const wish = event.target.closest('[data-wish]');
    if (!wish) return;
    const id = wish.getAttribute('data-product-id');
    if (!id) return;
    wish.disabled = true;
    request('hc_wishlist', { wish_action: 'toggle', product_id: id })
      .then((json) => {
        if (!json.success) throw new Error('wish');
        const saved = Boolean(json.data.saved);
        paintWish(wish, saved);
        setBadge('[data-wish-count]', json.data.count);
        toast(saved ? 'Added to wishlist' : 'Removed from wishlist');
        if (!saved && wish.closest('[data-wishlist-page]')) {
          wish.closest('.product-card')?.remove();
          if (!document.querySelector('[data-wishlist-page] .product-card')) {
            window.location.reload();
          }
        }
      })
      .catch(() => toast('Could not update wishlist'))
      .finally(() => {
        wish.disabled = false;
      });
  });

  const account = document.querySelector('[data-account-toggle]');
  const menu = document.querySelector('[data-account-menu]');
  if (account && menu) {
    account.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      const willOpen = menu.hidden;
      menu.hidden = !willOpen;
      account.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
    });
    document.addEventListener('click', (event) => {
      if (!event.target.closest('.header-account')) {
        menu.hidden = true;
        account.setAttribute('aria-expanded', 'false');
      }
    });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && !menu.hidden) {
        menu.hidden = true;
        account.setAttribute('aria-expanded', 'false');
        account.focus();
      }
    });
  }
})();
