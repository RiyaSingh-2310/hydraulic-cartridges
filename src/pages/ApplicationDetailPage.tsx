import { Link, Navigate, useParams } from 'react-router-dom'
import { Button } from '../components/common/Button'
import { PageHero } from '../components/common/PageHero'
import { ProductCard } from '../components/products/ProductCard'
import { getApplication } from '../data/applications'
import { getProduct } from '../data/products'

export default function ApplicationDetailPage() {
  const { slug } = useParams()
  const application = slug ? getApplication(slug) : undefined

  if (!application) {
    return <Navigate to="/applications" replace />
  }

  const related = application.typicalProducts
    .map((item) => getProduct(item))
    .filter((item) => Boolean(item))

  return (
    <>
      <PageHero eyebrow="Application" title={application.name} description={application.shortDescription} />
      <section className="section">
        <div className="container detail-layout">
          <div className="split-media" style={{ minHeight: '24rem' }}>
            <img src={application.image} alt={application.imageAlt} />
          </div>
          <div>
            <p className="eyebrow">Circuit context</p>
            <h2 className="display" style={{ fontSize: '2rem', margin: '0.6rem 0 1rem' }}>
              How the valves are used
            </h2>
            <p>{application.overview}</p>
            <div className="hero-actions">
              <Button to="/request-quote">Request a Quote</Button>
              <Button to="/products" variant="outline">
                Browse products
              </Button>
            </div>
          </div>
        </div>
      </section>
      <section className="section" style={{ paddingTop: 0 }}>
        <div className="container detail-layout">
          <div>
            <h2 className="display" style={{ fontSize: '1.8rem', marginBottom: '1rem' }}>
              Typical challenges
            </h2>
            <ul className="highlight-list">
              {application.challenges.map((item, i) => (
                <li key={item}>
                  <span>0{i + 1}</span>
                  {item}
                </li>
              ))}
            </ul>
          </div>
          <div>
            <h2 className="display" style={{ fontSize: '1.8rem', marginBottom: '1rem' }}>
              Engineering response
            </h2>
            <ul className="highlight-list">
              {application.solutions.map((item, i) => (
                <li key={item}>
                  <span>0{i + 1}</span>
                  {item}
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>
      <section className="section" style={{ paddingTop: 0 }}>
        <div className="container">
          <h2 className="display" style={{ fontSize: '2rem', marginBottom: '1.5rem' }}>
            Typical products
          </h2>
          <div className="related-grid">
            {related.map((product) =>
              product ? <ProductCard key={product.slug} product={product} /> : null,
            )}
          </div>
          <p style={{ marginTop: '1.5rem' }}>
            <Link to="/applications">All applications</Link>
          </p>
        </div>
      </section>
    </>
  )
}
