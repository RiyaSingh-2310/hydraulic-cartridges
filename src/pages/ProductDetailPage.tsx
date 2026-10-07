import { useState } from 'react'
import { Navigate, useParams } from 'react-router-dom'
import { Button } from '../components/common/Button'
import { PageHero } from '../components/common/PageHero'
import { ProductCard } from '../components/products/ProductCard'
import { ProductGallery } from '../components/products/ProductGallery'
import { useShop } from '../context/ShopContext'
import { getProduct, getRelatedProducts } from '../data/products'

export default function ProductDetailPage() {
  const { slug } = useParams()
  const product = slug ? getProduct(slug) : undefined
  const { addToCart, toggleWishlist, wished } = useShop()
  const [qty, setQty] = useState(1)

  if (!product) {
    return <Navigate to="/products" replace />
  }

  const related = getRelatedProducts(product)
  const saved = wished(product.slug)

  return (
    <>
      <PageHero
        compact
        eyebrow={product.category}
        title={product.name}
        description={product.shortDescription}
      />
      <section className="section">
        <div className="container detail-layout">
          <ProductGallery product={product} />
          <div>
            <p className="eyebrow">{product.model}</p>
            <h2 className="display" style={{ fontSize: '2.2rem', margin: '0.6rem 0 1rem' }}>
              Overview
            </h2>
            <p>{product.overview}</p>
            <div className="spec-pills" style={{ marginTop: '1.5rem' }}>
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
            <div className="detail-buy">
              <div className="qty-control">
                <button type="button" className="qty-btn" aria-label="Decrease quantity" onClick={() => setQty((value) => Math.max(1, value - 1))}>
                  −
                </button>
                <span className="qty-value">{qty}</span>
                <button type="button" className="qty-btn" aria-label="Increase quantity" onClick={() => setQty((value) => Math.min(999, value + 1))}>
                  +
                </button>
              </div>
              <button
                type="button"
                className={`wish-btn${saved ? ' is-on' : ''}`}
                style={{ position: 'static', width: 'auto', borderRadius: '8px', padding: '0 0.9rem' }}
                aria-pressed={saved}
                onClick={() => toggleWishlist(product.slug)}
              >
                {saved ? 'Remove from Wishlist' : 'Add to Wishlist'}
              </button>
              <button type="button" className="btn" onClick={() => addToCart(product.slug, qty)}>
                Add to Cart
              </button>
              <div className="hero-actions">
                <Button to={`/request-quote?product=${product.slug}`}>Request Quote</Button>
                <Button to="/contact" variant="outline">
                  Speak to engineering
                </Button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section className="section" style={{ paddingTop: 0 }}>
        <div className="container detail-layout">
          <div>
            <h2 className="display" style={{ fontSize: '2rem' }}>
              Technical information
            </h2>
            <table className="spec-table">
              <tbody>
                {product.technical.map((row) => (
                  <tr key={row.label}>
                    <th scope="row">{row.label}</th>
                    <td>{row.value}</td>
                  </tr>
                ))}
              </tbody>
            </table>
            <p className="notice">
              Specification documents are placeholders in this frontend catalog. Confirm ratings
              during quotation.
            </p>
          </div>
          <div>
            <h2 className="display" style={{ fontSize: '2rem' }}>
              Features
            </h2>
            <ul className="highlight-list">
              {product.features.map((feature, i) => (
                <li key={feature}>
                  <span>0{i + 1}</span>
                  {feature}
                </li>
              ))}
            </ul>
            <h2 className="display" style={{ fontSize: '1.6rem', marginTop: '2rem' }}>
              Typical applications
            </h2>
            <p style={{ marginTop: '0.75rem', color: 'var(--steel)' }}>
              {product.applications.join(' · ')}
            </p>
          </div>
        </div>
      </section>
      <section className="section" style={{ paddingTop: 0 }}>
        <div className="container">
          <h2 className="display" style={{ fontSize: '2rem', marginBottom: '1.5rem' }}>
            Related products
          </h2>
          <div className="related-grid">
            {related.map((item) => (
              <ProductCard key={item.slug} product={item} />
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
