import { Link } from 'react-router-dom'
import { catalogFamilies, catalogProducts, familyPath, groupPath } from '../../data/catalog'
import { ProductCard } from '../products/ProductCard'
import { ProductVisual } from '../products/ProductVisual'
import { Reveal } from '../common/Reveal'
import { SectionHeader } from '../common/SectionHeader'

const featured = catalogProducts.filter((product) => product.model).slice(0, 8)

export function ProductsShowcase() {
  return (
    <>
      <section className="section" id="product-range">
        <div className="container">
          <SectionHeader
            split
            eyebrow="Shop by category"
            title="The manufacturing range"
            copy="Six product families from the catalog. Open a family, or use the category bar to jump straight into a group."
          />
          <div className="product-grid">
            {catalogFamilies.map((family, index) => (
              <Reveal key={family.slug} delay={index * 0.04}>
                <article className="product-card">
                  <Link to={familyPath(family.slug)} className="product-card-visual" aria-label={family.name}>
                    <ProductVisual kind={family.visual} title={family.name} />
                  </Link>
                  <div className="product-card-body">
                    <p className="meta">
                      {String(index + 1).padStart(2, '0')} · {family.children.length} groups
                    </p>
                    <h3>
                      <Link to={familyPath(family.slug)}>{family.name}</Link>
                    </h3>
                    <p>{family.intro}</p>
                    <ul style={{ margin: 0, paddingLeft: '1.1rem', color: 'var(--steel)' }}>
                      {family.children.slice(0, 3).map((group) => (
                        <li key={group.slug}>
                          <Link to={groupPath(family.slug, group.slug)}>{group.name}</Link>
                        </li>
                      ))}
                    </ul>
                    <Link className="explore-link" to={familyPath(family.slug)}>
                      Explore all {family.name} →
                    </Link>
                  </div>
                </article>
              </Reveal>
            ))}
          </div>
        </div>
      </section>
      <section className="section" style={{ paddingTop: 0 }}>
        <div className="container">
          <SectionHeader
            split
            eyebrow="Featured products"
            title="Specify from the catalog"
            copy="Series published in the current catalog. Add one to the cart or open the full specification."
          />
          <div className="product-grid">
            {featured.map((product) => (
              <ProductCard key={product.slug} product={product} />
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
