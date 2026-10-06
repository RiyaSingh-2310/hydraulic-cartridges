import { images } from '../../data/images'
import { Reveal } from '../common/Reveal'

export function Intro() {
  return (
    <section className="section">
      <div className="container intro-grid">
        <Reveal>
          <p className="eyebrow">Engineering without compromise</p>
          <h2 className="display">Built for circuits that cannot afford a weak cavity.</h2>
        </Reveal>
        <Reveal delay={0.08}>
          <div className="intro-copy">
            <p>
              Hydraulic Cartridges supplies screw-in valves, solenoid functions, and custom manifold
              components to machinery builders who need a manufacturer — not a catalog reseller.
            </p>
            <p>
              The work is industrial and specific: ISO and SAE cavities, 350-bar continuous class,
              and application review before a part number is locked. If the envelope is non-standard,
              the cartridge is engineered to the block, not the other way around.
            </p>
          </div>
          <div className="tech-frame split-media" style={{ marginTop: '1.75rem', minHeight: '16rem' }}>
            <img src={images.intro.src} alt={images.intro.alt} loading="lazy" />
            <span className="tech-label" style={{ left: '0.9rem', top: '0.9rem' }}>
              INSP · 01
            </span>
            <span className="tech-label" style={{ right: '0.9rem', bottom: '0.9rem' }}>
              MANIFOLD INTERFACE
            </span>
          </div>
        </Reveal>
      </div>
    </section>
  )
}
