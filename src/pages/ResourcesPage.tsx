import { useState } from 'react'
import { Link } from 'react-router-dom'
import { PageHero } from '../components/common/PageHero'
import { faqs, resources } from '../data/company'

export default function ResourcesPage() {
  const [active, setActive] = useState<string | null>(null)

  return (
    <>
      <PageHero
        eyebrow="Resources"
        title="Documentation for specification work"
        description="Use these desks as a map of what will ship as files later. Until then, product pages carry the structured mock specifications."
      />
      <section className="section">
        <div className="container">
          <div className="resource-grid">
            {resources.map((item) =>
              item.slug === 'engineering' ? (
                <Link key={item.slug} className="resource-card" to="/contact">
                  <span>{item.type}</span>
                  <h3>{item.title}</h3>
                  <p>{item.description}</p>
                </Link>
              ) : (
                <button
                  key={item.slug}
                  type="button"
                  className={`resource-card${active === item.slug ? ' active' : ''}`}
                  onClick={() => setActive(item.slug)}
                >
                  <span>{item.type}</span>
                  <h3>{item.title}</h3>
                  <p>{item.description}</p>
                </button>
              ),
            )}
          </div>
          {active ? (
            <p className="notice" role="status">
              Downloadable “{resources.find((item) => item.slug === active)?.title}” files are not
              connected yet. This is a visual placeholder for the resources architecture.
            </p>
          ) : null}
        </div>
      </section>
      <section className="section" style={{ paddingTop: 0 }}>
        <div className="container">
          <h2 className="display" style={{ fontSize: '2rem', marginBottom: '1rem' }}>
            FAQs
          </h2>
          <div className="faq-list">
            {faqs.map((item) => (
              <details key={item.question}>
                <summary>{item.question}</summary>
                <p>{item.answer}</p>
              </details>
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
