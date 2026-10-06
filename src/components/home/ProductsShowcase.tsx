import { products } from '../../data/products'
import { ProductCard } from '../products/ProductCard'
import { Reveal } from '../common/Reveal'
import { SectionHeader } from '../common/SectionHeader'

export function ProductsShowcase() {
  return (
    <section className="section" style={{ paddingTop: 0 }}>
      <div className="container">
        <SectionHeader
          split
          eyebrow="Product families"
          title="Precision mechanical components"
          copy="Standard and custom fluid-power assemblies engineered to ISO cavity specifications — with custom work when the circuit demands it."
        />
        <div className="product-grid">
          {products.map((product, index) => (
            <Reveal key={product.slug} delay={index * 0.04}>
              <ProductCard product={product} index={index} />
            </Reveal>
          ))}
        </div>
      </div>
    </section>
  )
}
