import { NavLink } from 'react-router-dom'
import type { Product } from '../../types'
import { ProductVisual } from './ProductVisual'

interface ProductCardProps {
  product: Product
  index?: number
}

export function ProductCard({ product, index }: ProductCardProps) {
  const label = index !== undefined ? String(index + 1).padStart(2, '0') : product.model

  return (
    <article className="product-card">
      <div className="product-card-visual">
        <ProductVisual kind={product.visual} title={product.name} />
      </div>
      <div className="product-card-body">
        <p className="meta">
          {label} · {product.category}
        </p>
        <h3>{product.name}</h3>
        <p>{product.shortDescription}</p>
        <div className="spec-row">
          <span>{product.pressure}</span>
          <span>{product.flow}</span>
        </div>
        <NavLink className="explore-link" to={`/products/${product.slug}`}>
          Explore product →
        </NavLink>
      </div>
    </article>
  )
}
