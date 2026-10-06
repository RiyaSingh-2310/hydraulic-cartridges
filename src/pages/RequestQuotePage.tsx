import { type FormEvent, useMemo, useState } from 'react'
import { useSearchParams } from 'react-router-dom'
import { Button } from '../components/common/Button'
import { PageHero } from '../components/common/PageHero'
import { products } from '../data/products'
import { emptyQuoteForm, validateQuoteForm, type QuoteFormValues } from '../lib/validation'

export default function RequestQuotePage() {
  const [params] = useSearchParams()
  const preset = params.get('product') ?? ''
  const [values, setValues] = useState<QuoteFormValues>({
    ...emptyQuoteForm,
    product: preset,
  })
  const [errors, setErrors] = useState<ReturnType<typeof validateQuoteForm>>({})
  const [submitted, setSubmitted] = useState(false)

  const options = useMemo(
    () => products.map((item) => ({ value: item.slug, label: item.name })),
    [],
  )

  function update<K extends keyof QuoteFormValues>(key: K, value: QuoteFormValues[K]) {
    setValues((current) => ({ ...current, [key]: value }))
  }

  function onSubmit(event: FormEvent) {
    event.preventDefault()
    const nextErrors = validateQuoteForm(values)
    setErrors(nextErrors)
    if (Object.keys(nextErrors).length === 0) {
      setSubmitted(true)
    }
  }

  return (
    <>
      <PageHero
        eyebrow="Request a quote"
        title="Tell us the circuit. We will answer with a cartridge."
        description="Frontend validation only — there is no server submission in this phase. A success state confirms the form is complete."
      />
      <section className="section">
        <div className="container" style={{ maxWidth: '52rem' }}>
          {submitted ? (
            <div className="success-panel">
              <h2>Request ready for review</h2>
              <p>
                Thank you, {values.name}. The quotation packet for {values.company} has been captured
                in this browser session only. A production build will send it to the manufacturer
                desk.
              </p>
              <p style={{ marginTop: '1rem', color: 'var(--steel)' }}>
                Product: {values.product || '—'} · Qty: {values.quantity} · {values.country}
              </p>
            </div>
          ) : (
            <form className="form-grid two" onSubmit={onSubmit} noValidate>
              <div className="field">
                <label htmlFor="quote-name">Name</label>
                <input
                  id="quote-name"
                  value={values.name}
                  minLength={2}
                  maxLength={35}
                  autoComplete="name"
                  aria-invalid={Boolean(errors.name)}
                  className={errors.name ? 'invalid' : undefined}
                  onChange={(e) => update('name', e.target.value)}
                />
                {errors.name ? (
                  <p className="error" role="alert">
                    {errors.name}
                  </p>
                ) : null}
              </div>
              <div className="field">
                <label htmlFor="quote-company">Company</label>
                <input
                  id="quote-company"
                  value={values.company}
                  onChange={(e) => update('company', e.target.value)}
                  autoComplete="organization"
                />
                {errors.company ? (
                  <p className="error" role="alert">
                    {errors.company}
                  </p>
                ) : null}
              </div>
              <div className="field">
                <label htmlFor="quote-email">Email</label>
                <input
                  id="quote-email"
                  type="email"
                  value={values.email}
                  aria-invalid={Boolean(errors.email)}
                  className={errors.email ? 'invalid' : undefined}
                  onChange={(e) => update('email', e.target.value)}
                  autoComplete="email"
                />
                {errors.email ? (
                  <p className="error" role="alert">
                    {errors.email}
                  </p>
                ) : null}
              </div>
              <div className="field">
                <label htmlFor="quote-phone">Phone</label>
                <input
                  id="quote-phone"
                  value={values.phone}
                  onChange={(e) => update('phone', e.target.value)}
                  autoComplete="tel"
                />
                {errors.phone ? <p className="error">{errors.phone}</p> : null}
              </div>
              <div className="field">
                <label htmlFor="quote-country">Country</label>
                <input
                  id="quote-country"
                  value={values.country}
                  onChange={(e) => update('country', e.target.value)}
                  autoComplete="country-name"
                />
                {errors.country ? <p className="error">{errors.country}</p> : null}
              </div>
              <div className="field">
                <label htmlFor="quote-product">Product / Category</label>
                <select
                  id="quote-product"
                  value={values.product}
                  onChange={(e) => update('product', e.target.value)}
                >
                  <option value="">Select a family</option>
                  {options.map((item) => (
                    <option key={item.value} value={item.value}>
                      {item.label}
                    </option>
                  ))}
                </select>
                {errors.product ? <p className="error">{errors.product}</p> : null}
              </div>
              <div className="field">
                <label htmlFor="quote-quantity">Quantity</label>
                <input
                  id="quote-quantity"
                  value={values.quantity}
                  onChange={(e) => update('quantity', e.target.value)}
                  inputMode="numeric"
                />
                {errors.quantity ? <p className="error">{errors.quantity}</p> : null}
              </div>
              <div className="field">
                <label htmlFor="quote-application">Application</label>
                <input
                  id="quote-application"
                  value={values.application}
                  onChange={(e) => update('application', e.target.value)}
                />
                {errors.application ? <p className="error">{errors.application}</p> : null}
              </div>
              <div className="field full">
                <label htmlFor="quote-message">Message</label>
                <textarea
                  id="quote-message"
                  minLength={1}
                  value={values.message}
                  onChange={(e) => update('message', e.target.value)}
                  placeholder="Pressure, flow, cavity code, fluid, and duty cycle."
                />
                {errors.message ? <p className="error">{errors.message}</p> : null}
              </div>
              <div>
                <Button type="submit">Submit request</Button>
              </div>
            </form>
          )}
        </div>
      </section>
    </>
  )
}
