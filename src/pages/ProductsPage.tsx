import { Link, useSearchParams } from 'react-router-dom'
import { PageHero } from '../components/common/PageHero'
import { ProductCard } from '../components/products/ProductCard'
import { catalogFamilies, catalogProducts, familyPath, groupPath } from '../data/catalog'

export default function ProductsPage() {
  const [params] = useSearchParams()
  const familySlug = params.get('family') ?? ''
  const groupSlug = params.get('group') ?? ''
  const family = catalogFamilies.find((item) => item.slug === familySlug)
  const group = family?.children.find((item) => item.slug === groupSlug)
  const listed = group ? group.products : family ? family.children.flatMap((item) => item.products) : catalogProducts

  const title = group?.name ?? family?.name ?? 'Hydraulic cartridge families'
  const description =
    group?.intro ||
    family?.intro ||
    'Valves, pumps, filters, accessories, heat exchangers, and specialties from the current catalog.'

  return (
    <>
      <PageHero eyebrow={family ? family.name : 'Catalog'} title={title} description={description} />
      <section className="section">
        <div className="container">
          <nav className="family-jump" aria-label="Product families">
            <Link to="/products" className={!family ? 'is-active' : undefined}>
              All
            </Link>
            {catalogFamilies.map((item) => (
              <Link key={item.slug} to={familyPath(item.slug)} className={item.slug === familySlug ? 'is-active' : undefined}>
                {item.name}
              </Link>
            ))}
          </nav>
          {family && !group ? (
            <nav className="family-jump" aria-label={`${family.name} groups`}>
              {family.children.map((item) => (
                <Link key={item.slug} to={groupPath(family.slug, item.slug)}>
                  {item.name}
                </Link>
              ))}
            </nav>
          ) : null}
          <div className="product-grid">
            {listed.map((product, index) => (
              <ProductCard key={product.slug} product={product} index={index} />
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
