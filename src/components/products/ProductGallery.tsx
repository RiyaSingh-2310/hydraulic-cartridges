import { useState } from 'react'
import { images } from '../../data/images'
import type { Product } from '../../types'
import { ProductVisual } from './ProductVisual'

interface ProductGalleryProps {
  product: Product
}

export function ProductGallery({ product }: ProductGalleryProps) {
  const [active, setActive] = useState(0)
  const panels = [
    { key: 'drawing', caption: product.galleryCaptions[0] },
    { key: 'machine', caption: product.galleryCaptions[1] },
    { key: 'test', caption: product.galleryCaptions[2] },
  ]

  return (
    <div className="gallery">
      <div className="gallery-main" aria-live="polite">
        {active === 0 ? (
          <div style={{ width: '80%' }}>
            <ProductVisual kind={product.visual} title={product.name} />
          </div>
        ) : (
          <img
            src={active === 1 ? images.machining.src : images.testing.src}
            alt={panels[active].caption}
            style={{ width: '100%', height: '22rem', objectFit: 'cover' }}
          />
        )}
      </div>
      <div className="gallery-thumbs">
        {panels.map((panel, i) => (
          <button
            key={panel.key}
            type="button"
            className={i === active ? 'active' : ''}
            onClick={() => setActive(i)}
          >
            {panel.caption}
          </button>
        ))}
      </div>
    </div>
  )
}
