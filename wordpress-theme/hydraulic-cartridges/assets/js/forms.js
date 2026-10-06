(() => {
  const NAME_MIN = 2;
  const NAME_MAX = 35;
  const emailPattern =
    /^[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+@[A-Za-z0-9](?:[A-Za-z0-9-]{0,61}[A-Za-z0-9])?(?:\.[A-Za-z0-9](?:[A-Za-z0-9-]{0,61}[A-Za-z0-9])?)+$/;

  function validateName(raw) {
    const name = raw.trim();
    if (name.length < NAME_MIN || name.length > NAME_MAX) {
      return 'Name must be between 2 and 35 characters.';
    }
    return '';
  }

  function validateEmail(raw) {
    const email = raw.trim();
    if (!email || email.includes('..') || !emailPattern.test(email)) {
      return 'Please enter a valid email address.';
    }
    return '';
  }

  function hasMeaningfulText(raw) {
    return raw.trim().length >= 1;
  }

  function setError(field, message) {
    const input = field.querySelector('input, textarea, select');
    const existing = field.querySelector('.error');
    if (existing) existing.remove();
    if (!message) {
      input?.classList.remove('invalid');
      input?.removeAttribute('aria-invalid');
      return;
    }
    input?.classList.add('invalid');
    input?.setAttribute('aria-invalid', 'true');
    const p = document.createElement('p');
    p.className = 'error';
    p.setAttribute('role', 'alert');
    p.textContent = message;
    field.appendChild(p);
  }

  function valuesFrom(form, names) {
    const values = {};
    names.forEach((name) => {
      values[name] = form.elements[name]?.value ?? '';
    });
    return values;
  }

  const contact = document.querySelector('[data-contact-form]');
  if (contact) {
    const submit = contact.querySelector('[type="submit"]');
    const message = contact.querySelector('[name="message"]');
    const success = document.querySelector('[data-contact-success]');
    const nameEl = success?.querySelector('[data-contact-name]');

    const syncDisabled = () => {
      if (submit) submit.disabled = !hasMeaningfulText(message?.value ?? '');
    };
    syncDisabled();
    contact.addEventListener('input', syncDisabled);

    contact.addEventListener('submit', async (event) => {
      event.preventDefault();
      const values = valuesFrom(contact, ['name', 'email', 'message']);
      const errors = {
        name: validateName(values.name),
        email: validateEmail(values.email),
        message: hasMeaningfulText(values.message) ? '' : 'Please enter a message.',
      };
      ['name', 'email', 'message'].forEach((key) => {
        const field = contact.querySelector(`[data-field="${key}"]`);
        if (field) setError(field, errors[key]);
      });
      if (Object.values(errors).some(Boolean)) return;

      submit.disabled = true;
      submit.setAttribute('aria-busy', 'true');
      const spinner = document.createElement('span');
      spinner.className = 'btn-spinner';
      spinner.setAttribute('aria-hidden', 'true');
      submit.prepend(spinner);
      const label = submit.querySelector('[data-btn-label]');
      if (label) label.textContent = 'Sending';

      await new Promise((resolve) => setTimeout(resolve, 650));
      contact.hidden = true;
      if (nameEl) nameEl.textContent = values.name.trim();
      if (success) success.hidden = false;
    });
  }

  const quote = document.querySelector('[data-quote-form]');
  if (quote) {
    const success = document.querySelector('[data-quote-success]');
    quote.addEventListener('submit', (event) => {
      event.preventDefault();
      const values = valuesFrom(quote, [
        'name',
        'company',
        'email',
        'phone',
        'country',
        'product',
        'quantity',
        'application',
        'message',
      ]);
      const errors = {
        name: validateName(values.name),
        company: values.company.trim() ? '' : 'Enter your company.',
        email: validateEmail(values.email),
        phone: values.phone.trim() ? '' : 'Enter a phone number.',
        country: values.country.trim() ? '' : 'Enter a country.',
        product: values.product.trim() ? '' : 'Select a product or category.',
        quantity: values.quantity.trim() ? '' : 'Enter an estimated quantity.',
        application: values.application.trim() ? '' : 'Describe the application.',
        message: hasMeaningfulText(values.message) ? '' : 'Add a short technical note.',
      };
      Object.keys(errors).forEach((key) => {
        const field = quote.querySelector(`[data-field="${key}"]`);
        if (field) setError(field, errors[key]);
      });
      if (Object.values(errors).some(Boolean)) return;
      quote.hidden = true;
      const set = (sel, val) => {
        const el = success?.querySelector(sel);
        if (el) el.textContent = val;
      };
      set('[data-quote-name]', values.name);
      set('[data-quote-company]', values.company);
      set('[data-quote-product]', values.product || '—');
      set('[data-quote-qty]', values.quantity);
      set('[data-quote-country]', values.country);
      if (success) success.hidden = false;
    });
  }
})();
