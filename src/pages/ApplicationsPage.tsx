import { Link } from 'react-router-dom'
import { PageHero } from '../components/common/PageHero'
import { applications } from '../data/applications'

export default function ApplicationsPage() {
  return (
    <>
      <PageHero
        eyebrow="Solutions"
        title="Applications across industrial machinery"
        description="The same cartridge families serve mobile frames, plant automation, energy auxiliaries, and specialized machines — selected by duty, not by fashion."
      />
      <section className="section">
        <div className="container applications-grid">
          {applications.map((app) => (
            <Link className="app-panel" to={`/applications/${app.slug}`} key={app.slug}>
              <img src={app.image} alt={app.imageAlt} loading="lazy" />
              <div className="app-panel-body">
                <h2>{app.name}</h2>
                <p>{app.shortDescription}</p>
              </div>
            </Link>
          ))}
        </div>
      </section>
    </>
  )
}
