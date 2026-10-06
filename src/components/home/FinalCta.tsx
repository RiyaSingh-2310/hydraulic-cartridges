import { Button } from '../common/Button'
import { Reveal } from '../common/Reveal'

export function FinalCta() {
  return (
    <section className="section final-cta">
      <div className="container">
        <Reveal>
          <p className="eyebrow">Next step</p>
          <h2 className="display">Let’s engineer the right solution.</h2>
          <p>
            Tell us what you are building. The desk can help identify the cartridge family, cavity,
            and whether the circuit needs a custom block.
          </p>
          <div className="hero-actions">
            <Button to="/request-quote">Request a Quote</Button>
            <Button to="/contact" variant="ghost">
              Contact Us
            </Button>
          </div>
        </Reveal>
      </div>
    </section>
  )
}
