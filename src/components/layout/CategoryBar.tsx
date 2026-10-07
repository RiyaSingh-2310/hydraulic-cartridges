import { Link } from 'react-router-dom'
import { catalogFamilies, familyPath, groupPath } from '../../data/catalog'

export function CategoryBar() {
  return (
    <nav className="catalog-bar" aria-label="Product categories">
      <div className="catalog-bar-track">
        {catalogFamilies.map((family) => (
          <div className="catalog-bar-item" key={family.slug}>
            <Link className="catalog-bar-link" to={familyPath(family.slug)}>
              {family.name}
            </Link>
            <div className="catalog-drop" role="region" aria-label={`${family.name} groups`}>
              <p className="catalog-drop-title">{family.name}</p>
              <ul>
                {family.children.map((group) => (
                  <li key={group.slug}>
                    <Link className="catalog-drop-group" to={groupPath(family.slug, group.slug)}>
                      {group.name}
                    </Link>
                    {group.products.length > 1 || (group.products[0] && group.products[0].slug !== group.slug) ? (
                      <ul className="catalog-drop-series">
                        {group.products.map((product) => (
                          <li key={product.slug}>
                            <Link to={`/products/${product.slug}`}>
                              {product.name}
                              {product.model ? <span>{product.model}</span> : null}
                            </Link>
                          </li>
                        ))}
                      </ul>
                    ) : null}
                  </li>
                ))}
              </ul>
              <Link className="catalog-drop-foot" to={familyPath(family.slug)}>
                All {family.name} →
              </Link>
            </div>
          </div>
        ))}
      </div>
    </nav>
  )
}
