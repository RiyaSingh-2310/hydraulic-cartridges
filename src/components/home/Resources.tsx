import { useState } from 'react'
import { Link } from 'react-router-dom'
import { resources } from '../../data/company'
import { Reveal } from '../common/Reveal'
import { SectionHeader } from '../common/SectionHeader'

export function Resources() {
  const [active, setActive] = useState<string | null>(null)

  return (
    <section className="section">
      <div className="container">
        <SectionHeader
          split
          eyebrow="Resources"
          title="Technical material, ready for the desk"
          copy="Catalog pages, specifications, and application notes. File delivery is a placeholder in this frontend phase."
        />
        <div className="resource-grid">
          {resources.map((item, index) => (
            <Reveal key={item.slug} delay={index * 0.03}>
              {item.slug === 'engineering' ? (
                <Link className="resource-card" to="/contact" style={{ display: 'block' }}>
                  <span>{item.type}</span>
                  <h3>{item.title}</h3>
                  <p>{item.description}</p>
                </Link>
              ) : (
                <button
                  type="button"
                  className={`resource-card${active === item.slug ? ' active' : ''}`}
                  onClick={() => setActive(item.slug)}
                >
                  <span>{item.type}</span>
                  <h3>{item.title}</h3>
                  <p>{item.description}</p>
                </button>
              )}
            </Reveal>
          ))}
        </div>
        {active ? (
          <p className="notice" role="status">
            “{resources.find((item) => item.slug === active)?.title}” is a frontend placeholder.
            Downloadable files will be connected in a later phase.{' '}
            <Link to="/resources">Open the resources desk</Link>.
          </p>
        ) : null}
      </div>
    </section>
  )
}
