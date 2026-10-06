import { images } from '../../data/images'
import { Button } from '../common/Button'
import { Reveal } from '../common/Reveal'

export function AboutPreview() {
  return (
    <section className="section" style={{ background: 'var(--white)' }}>
      <div className="container about-editorial">
        <Reveal>
          <p className="eyebrow">About</p>
          <h2 className="display">A manufacturer for engineers who specify, not browse.</h2>
          <p className="lede" style={{ marginTop: '1rem' }}>
            The company exists to put precision cartridges into OEM manifolds with a short path from
            application question to machined part.
          </p>
          <div className="hero-actions">
            <Button to="/about" variant="outline">
              Read the philosophy
            </Button>
          </div>
        </Reveal>
        <Reveal delay={0.08}>
          <div className="split-media" style={{ minHeight: '24rem' }}>
            <img src={images.about.src} alt={images.about.alt} loading="lazy" />
          </div>
        </Reveal>
      </div>
    </section>
  )
}
