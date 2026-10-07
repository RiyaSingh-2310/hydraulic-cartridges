import { Link } from 'react-router-dom'
import { PageHero } from '../components/common/PageHero'
import { ProductCard } from '../components/products/ProductCard'
import { getProduct } from '../data/products'
import { useShop } from '../context/ShopContext'

export default function WishlistPage() {
  const { wishlist } = useShop()
  const items = wishlist.map((slug) => getProduct(slug)).filter((item) => Boolean(item))

  return (
    <>
      <PageHero
        eyebrow="Saved"
        title="Wishlist"
        description={
          items.length
            ? 'Series you saved from the catalog. Add one to the cart when you are ready to request a quotation.'
            : 'Your wishlist is empty.'
        }
      />
      <section className="section">
        <div className="container">
          {items.length === 0 ? (
            <>
              <p>Save products with the heart on any series card or product page.</p>
              <div className="hero-actions">
                <Link className="btn" to="/products">
                  Browse products
                </Link>
              </div>
            </>
          ) : (
            <div className="product-grid">
              {items.map((product) => (
                <ProductCard key={product!.slug} product={product!} />
              ))}
            </div>
          )}
        </div>
      </section>
    </>
  )
}
