import { PageHero } from '../components/common/PageHero'
import { ProductCard } from '../components/products/ProductCard'
import { products } from '../data/products'

export default function ProductsPage() {
  return (
    <>
      <PageHero
        eyebrow="Catalog"
        title="Hydraulic cartridge families"
        description="Screw-in valves for pressure, flow, direction, and load control — plus custom cavities when a standard ISO interface is not enough."
      />
      <section className="section">
        <div className="container product-grid">
          {products.map((product, index) => (
            <ProductCard key={product.slug} product={product} index={index} />
          ))}
        </div>
      </section>
    </>
  )
}
