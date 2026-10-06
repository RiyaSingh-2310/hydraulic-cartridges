import { PageHero } from '../components/common/PageHero'
import { images } from '../data/images'
import { capabilities, company } from '../data/company'

export default function AboutPage() {
  return (
    <>
      <PageHero
        eyebrow="About Hydraulic Cartridges"
        title="Manufacturer first. Catalog second."
        description="The company is organized around machining, application engineering, and tested cartridges for industrial OEMs — not around a storefront of unrelated parts."
      />
      <section className="section">
        <div className="container about-editorial">
          <div>
            <p className="eyebrow">Philosophy</p>
            <h2 className="display" style={{ fontSize: 'var(--display-sm)', margin: '0.7rem 0 1rem' }}>
              Specify the cavity. Then cut the metal.
            </h2>
            <p>
              Hydraulic Cartridges is a direct-from-manufacturer source for screw-in valves and custom
              manifold components. The published industrial class is 350 bar continuous, with ISO 9001
              compliant manufacturing practice.
            </p>
            <p style={{ marginTop: '1rem', color: 'var(--steel)' }}>
              Engineering support exists to read the duty cycle before a part number is promised.
              Customer focus means quoting what can be made and tested — including custom cavities
              from CAD when catalog geometry will not sit in the block.
            </p>
            <div className="counter-row">
              <div>
                <strong>350</strong>
                <span>Bar class</span>
              </div>
              <div>
                <strong>ISO</strong>
                <span>9001 practice</span>
              </div>
              <div>
                <strong>100%</strong>
                <span>Catalog tested</span>
              </div>
            </div>
          </div>
          <div className="split-media" style={{ minHeight: '28rem' }}>
            <img src={images.about.src} alt={images.about.alt} />
          </div>
        </div>
      </section>
      <section className="section capabilities">
        <div className="container">
          <h2 className="display" style={{ fontSize: 'var(--display-sm)', marginBottom: '2rem' }}>
            How the company works
          </h2>
          <div className="cap-grid">
            {capabilities.map((item) => (
              <article className="cap-item" key={item.index}>
                <p className="idx">{item.index}</p>
                <h3>{item.title}</h3>
                <p>{item.description}</p>
              </article>
            ))}
          </div>
          <p style={{ marginTop: '2rem', color: 'var(--steel)' }}>
            Enquiries: {company.email} · {company.phone}
          </p>
        </div>
      </section>
    </>
  )
}
