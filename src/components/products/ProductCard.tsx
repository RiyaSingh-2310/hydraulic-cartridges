import { NavLink } from 'react-router-dom'
import type { Product } from '../../types'
import { useShop } from '../../context/ShopContext'
import { ProductVisual } from './ProductVisual'

interface ProductCardProps {
  product: Product
  index?: number
}

export function ProductCard({ product, index }: ProductCardProps) {
  const { addToCart, toggleWishlist, wished } = useShop()
  const saved = wished(product.slug)
  const label = index !== undefined ? String(index + 1).padStart(2, '0') : product.model

  return (
    <article className="product-card">
      <div className="product-card-visual">
        <button
          type="button"
          className={`wish-btn${saved ? ' is-on' : ''}`}
          aria-pressed={saved}
          aria-label={saved ? 'Remove from wishlist' : 'Add to wishlist'}
          onClick={() => toggleWishlist(product.slug)}
        >
          <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
            <path
              d="M12 19.2 4.9 12.4a3.7 3.7 0 0 1 5.2-5.2L12 9l1.9-1.8a3.7 3.7 0 0 1 5.2 5.2L12 19.2z"
              fill="none"
              stroke="currentColor"
              strokeWidth="1.6"
              strokeLinejoin="round"
            />
          </svg>
        </button>
        <ProductVisual kind={product.visual} title={product.name} />
      </div>
      <div className="product-card-body">
        <p className="meta">
          {label ? `${label} · ` : ''}
          {product.category}
        </p>
        <h3>
          <NavLink to={`/products/${product.slug}`}>{product.name}</NavLink>
        </h3>
        <p>{product.shortDescription}</p>
        <div className="spec-row">
          <span>{product.pressure}</span>
          <span>{product.flow}</span>
        </div>
        <p className="cart-price">Quote on request</p>
        <div className="product-card-actions">
          <button type="button" className="btn" onClick={() => addToCart(product.slug, 1)}>
            Add to Cart
          </button>
          <NavLink className="btn btn-outline" to={`/products/${product.slug}`}>
            View details
          </NavLink>
        </div>
      </div>
    </article>
  )
}
