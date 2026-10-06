import { images } from '../../data/images'
import { Reveal } from '../common/Reveal'

export function Quality() {
  return (
    <section className="section">
      <div className="container quality-grid">
        <Reveal>
          <div className="split-media tech-frame" style={{ minHeight: '28rem' }}>
            <img src={images.quality.src} alt={images.quality.alt} loading="lazy" />
            <span className="tech-label" style={{ left: '1rem', top: '1rem' }}>
              QA · LINE
            </span>
          </div>
        </Reveal>
        <Reveal delay={0.08}>
          <p className="eyebrow">Quality</p>
          <h2 className="display">Built to perform. Tested to endure.</h2>
          <p className="lede">
            Consistency is not a slogan on this floor. Geometry, materials, and functional tests are
            treated as one manufacturing sequence.
          </p>
          <div className="quality-points">
            <div>
              <strong>Assurance</strong>
              <p>Inspection points sit inside production, aligned with ISO 9001 compliant practice.</p>
            </div>
            <div>
              <strong>Machining</strong>
              <p>Cavity threads, sealing lands, and seats are finished for repeatable cartridge fit.</p>
            </div>
            <div>
              <strong>Testing</strong>
              <p>Catalog units are functionally tested. Custom circuits receive application validation.</p>
            </div>
            <div>
              <strong>Materials</strong>
              <p>Hardened internals and industrial seal options specified to fluid and temperature.</p>
            </div>
          </div>
        </Reveal>
      </div>
    </section>
  )
}
