import { type FormEvent, useState } from 'react'
import { PageHero } from '../components/common/PageHero'
import { Button } from '../components/common/Button'
import { company } from '../data/company'
import {
  emptyContactForm,
  hasMeaningfulText,
  validateContactForm,
  type ContactFormValues,
} from '../lib/validation'

export default function ContactPage() {
  const [values, setValues] = useState<ContactFormValues>(emptyContactForm)
  const [errors, setErrors] = useState<ReturnType<typeof validateContactForm>>({})
  const [status, setStatus] = useState<'idle' | 'submitting' | 'success' | 'error'>('idle')
  const canSend = hasMeaningfulText(values.message)

  function update<K extends keyof ContactFormValues>(key: K, value: ContactFormValues[K]) {
    setValues((current) => ({ ...current, [key]: value }))
    if (errors[key]) {
      setErrors((current) => ({ ...current, [key]: undefined }))
    }
  }

  async function onSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault()
    const nextErrors = validateContactForm(values)
    setErrors(nextErrors)
    if (Object.keys(nextErrors).length > 0) return

    setStatus('submitting')
    await new Promise((resolve) => setTimeout(resolve, 650))
    setStatus('success')
  }

  return (
    <>
      <PageHero
        eyebrow="Contact"
        title="Speak with the engineering desk"
        description="Use this form for application questions. Quotations with product and quantity should go through Request a Quote."
      />
      <section className="section">
        <div className="container detail-layout">
          <div>
            <p>
              Email <a href={`mailto:${company.email}`}>{company.email}</a>
            </p>
            <p style={{ marginTop: '0.5rem' }}>
              Phone <a href="tel:+917007891857">{company.phone}</a>
            </p>
            <p style={{ marginTop: '1rem', color: 'var(--steel)' }}>{company.address}</p>
            <p style={{ marginTop: '0.5rem', color: 'var(--steel)' }}>{company.hours}</p>
          </div>
          {status === 'success' ? (
            <div className="success-panel">
              <h2>Message recorded</h2>
              <p>
                Thank you, {values.name.trim()}. This is a frontend-only confirmation. No backend is
                connected yet. A production environment will route this to the engineering desk.
              </p>
            </div>
          ) : (
            <form className="form-grid" onSubmit={onSubmit} noValidate>
              <div className="field">
                <label htmlFor="name">Name</label>
                <input
                  id="name"
                  name="name"
                  autoComplete="name"
                  minLength={2}
                  maxLength={35}
                  value={values.name}
                  aria-invalid={Boolean(errors.name)}
                  className={errors.name ? 'invalid' : undefined}
                  onChange={(event) => update('name', event.target.value)}
                />
                {errors.name ? (
                  <p className="error" role="alert">
                    {errors.name}
                  </p>
                ) : null}
              </div>
              <div className="field">
                <label htmlFor="email">Email</label>
                <input
                  id="email"
                  name="email"
                  type="email"
                  autoComplete="email"
                  value={values.email}
                  aria-invalid={Boolean(errors.email)}
                  className={errors.email ? 'invalid' : undefined}
                  onChange={(event) => update('email', event.target.value)}
                />
                {errors.email ? (
                  <p className="error" role="alert">
                    {errors.email}
                  </p>
                ) : null}
              </div>
              <div className="field full">
                <label htmlFor="message">Message</label>
                <textarea
                  id="message"
                  name="message"
                  minLength={1}
                  value={values.message}
                  aria-invalid={Boolean(errors.message)}
                  className={errors.message ? 'invalid' : undefined}
                  onChange={(event) => update('message', event.target.value)}
                />
                {errors.message ? (
                  <p className="error" role="alert">
                    {errors.message}
                  </p>
                ) : null}
              </div>
              {status === 'error' ? (
                <p className="error" role="alert">
                  The message could not be recorded. Please try again.
                </p>
              ) : null}
              <div>
                <Button type="submit" disabled={!canSend} loading={status === 'submitting'}>
                  Send message
                </Button>
              </div>
            </form>
          )}
        </div>
      </section>
    </>
  )
}
