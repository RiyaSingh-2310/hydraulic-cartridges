import { featuredProduct } from '../../data/products'
import { Button } from '../common/Button'
import { ProductVisual } from '../products/ProductVisual'
import { Reveal } from '../common/Reveal'

export function FeaturedProduct() {
  const product = featuredProduct

  return (
    <section className="section featured">
      <div className="container featured-grid">
        <Reveal>
          <div className="featured-visual">
            <ProductVisual kind={product.visual} title={product.name} />
            <span className="tech-label" style={{ left: '1rem', top: '1rem' }}>
              {product.model}
            </span>
            <span className="tech-label" style={{ right: '1rem', bottom: '1rem' }}>
              {product.cavity}
            </span>
          </div>
        </Reveal>
        <Reveal delay={0.08} className="featured-copy">
          <p className="eyebrow">{product.category}</p>
          <h2 className="display">{product.name}</h2>
          <p>{product.overview}</p>
          <div className="spec-pills">
            <div>
              <small>Pressure</small>
              <strong>{product.pressure}</strong>
            </div>
            <div>
              <small>Flow</small>
              <strong>{product.flow}</strong>
            </div>
            <div>
              <small>Cavity</small>
              <strong>{product.cavity}</strong>
            </div>
          </div>
          <ul className="highlight-list">
            {product.features.slice(0, 3).map((feature, i) => (
              <li key={feature}>
                <span>0{i + 1}</span>
                {feature}
              </li>
            ))}
          </ul>
          <div className="hero-actions">
            <Button to={`/products/${product.slug}`}>View Details</Button>
            <Button to="/request-quote" variant="ghost">
              Request Quote
            </Button>
          </div>
        </Reveal>
      </div>
    </section>
  )
}
