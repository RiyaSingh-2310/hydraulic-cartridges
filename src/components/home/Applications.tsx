import { Link } from 'react-router-dom'
import { applications } from '../../data/applications'
import { Reveal } from '../common/Reveal'
import { SectionHeader } from '../common/SectionHeader'

export function Applications() {
  return (
    <section className="section">
      <div className="container">
        <SectionHeader
          split
          eyebrow="Industries"
          title="Where the circuit lives"
          copy="Cartridge valves earn their place on machines that move load, hold pressure, and run without drama across shifts."
        />
        <div className="applications-grid">
          {applications.map((app, index) => (
            <Reveal key={app.slug} delay={index * 0.03}>
              <Link className="app-panel" to={`/applications/${app.slug}`}>
                <img src={app.image} alt={app.imageAlt} loading="lazy" />
                <div className="app-panel-body">
                  <h3>{app.name}</h3>
                  <p>{app.shortDescription}</p>
                </div>
              </Link>
            </Reveal>
          ))}
        </div>
      </div>
    </section>
  )
}
