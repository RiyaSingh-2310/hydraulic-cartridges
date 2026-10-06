import { PageHero } from '../components/common/PageHero'

export default function PrivacyPage() {
  return (
    <>
      <PageHero
        compact
        eyebrow="Legal"
        title="Privacy policy"
        description="Placeholder policy for the frontend launch. Replace with counsel-approved text before production."
      />
      <section className="section">
        <div className="container" style={{ maxWidth: '42rem' }}>
          <p>
            This website currently stores no account data and does not submit forms to a server.
            Quote and contact entries exist only in the browser session after validation.
          </p>
          <p style={{ marginTop: '1rem', color: 'var(--steel)' }}>
            When a backend is connected, this page will describe what is collected, why, and how
            long it is retained.
          </p>
        </div>
      </section>
    </>
  )
}
