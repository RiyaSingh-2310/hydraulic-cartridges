import { PageHero } from '../components/common/PageHero'

export default function TermsPage() {
  return (
    <>
      <PageHero
        compact
        eyebrow="Legal"
        title="Terms of use"
        description="Placeholder terms for reviewing the frontend catalog. Not a commercial contract."
      />
      <section className="section">
        <div className="container" style={{ maxWidth: '42rem' }}>
          <p>
            Product specifications on this site are structured mock data for visual review. They
            must be confirmed in a formal quotation before design freeze.
          </p>
          <p style={{ marginTop: '1rem', color: 'var(--steel)' }}>
            Hydraulic Cartridges retains the right to revise ratings, cavities, and lead-time
            statements at quotation.
          </p>
        </div>
      </section>
    </>
  )
}
