import { capabilities } from '../../data/company'
import { Reveal } from '../common/Reveal'
import { SectionHeader } from '../common/SectionHeader'

export function Capabilities() {
  return (
    <section className="section capabilities">
      <div className="container">
        <SectionHeader
          split
          eyebrow="Capabilities"
          title="The manufacturing argument"
          copy="A cartridge is only as trustworthy as the cavity, the seat, the test, and the engineer who selected it."
        />
        <div className="cap-grid">
          {capabilities.map((item, index) => (
            <Reveal key={item.index} delay={index * 0.04} className="cap-item">
              <p className="idx">{item.index}</p>
              <h3>{item.title}</h3>
              <p>{item.description}</p>
            </Reveal>
          ))}
        </div>
      </div>
    </section>
  )
}
