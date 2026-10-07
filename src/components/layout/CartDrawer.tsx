import { useEffect } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { getProduct } from '../../data/products'
import { useShop } from '../../context/ShopContext'
import { ProductVisual } from '../products/ProductVisual'

export function CartDrawer() {
  const { cart, cartOpen, closeCart, setQty, removeFromCart, user } = useShop()
  const navigate = useNavigate()

  useEffect(() => {
    if (!cartOpen) return
    const onKey = (event: KeyboardEvent) => {
      if (event.key === 'Escape') closeCart()
    }
    document.addEventListener('keydown', onKey)
    const previous = document.body.style.overflow
    document.body.style.overflow = 'hidden'
    return () => {
      document.removeEventListener('keydown', onKey)
      document.body.style.overflow = previous
    }
  }, [cartOpen, closeCart])

  const lines = cart
    .map((line) => {
      const product = getProduct(line.slug)
      return product ? { product, qty: line.qty } : null
    })
    .filter((line): line is { product: NonNullable<ReturnType<typeof getProduct>>; qty: number } => Boolean(line))

  function checkout() {
    const target = '/request-quote?from=cart'
    closeCart()
    if (!user) {
      navigate(`/account?notice=login-cart&redirect=${encodeURIComponent(target)}`)
      return
    }
    navigate(target)
  }

  return (
    <div className={`cart-drawer${cartOpen ? ' is-open' : ''}`} aria-hidden={cartOpen ? undefined : true}>
      <button type="button" className="cart-drawer-backdrop" aria-label="Close cart" onClick={closeCart} />
      <aside className="cart-drawer-panel" role="dialog" aria-modal="true" aria-labelledby="cart-drawer-title">
        <header className="cart-drawer-head">
          <h2 id="cart-drawer-title">Your cart</h2>
          <button type="button" className="cart-drawer-close" onClick={closeCart} aria-label="Close cart">
            ✕
          </button>
        </header>
        <div className="cart-drawer-body">
          {lines.length === 0 ? (
            <p className="cart-drawer-empty">Your cart is empty. Browse the catalog and add a series.</p>
          ) : (
            lines.map(({ product, qty }) => (
              <article className="drawer-item" key={product.slug}>
                <Link className="drawer-visual" to={`/products/${product.slug}`} onClick={closeCart}>
                  <ProductVisual kind={product.visual} title={product.name} />
                </Link>
                <div className="drawer-copy">
                  <h3>
                    <Link to={`/products/${product.slug}`} onClick={closeCart}>
                      {product.name}
                    </Link>
                  </h3>
                  <p className="cart-price">On request</p>
                  <div className="drawer-controls">
                    <div className="qty-control">
                      <button
                        type="button"
                        className="qty-btn"
                        aria-label="Decrease quantity"
                        onClick={() => setQty(product.slug, Math.max(1, qty - 1))}
                      >
                        −
                      </button>
                      <span className="qty-value">{qty}</span>
                      <button
                        type="button"
                        className="qty-btn"
                        aria-label="Increase quantity"
                        onClick={() => setQty(product.slug, qty + 1)}
                      >
                        +
                      </button>
                    </div>
                    <button type="button" className="cart-remove" onClick={() => removeFromCart(product.slug)}>
                      Delete
                    </button>
                  </div>
                </div>
              </article>
            ))
          )}
        </div>
        {lines.length > 0 ? (
          <footer className="cart-drawer-foot">
            <p className="cart-drawer-total">
              Total: Quotation on request · {lines.reduce((sum, line) => sum + line.qty, 0)} items
            </p>
            <button type="button" className="btn btn-outline" onClick={closeCart}>
              Continue Shopping
            </button>
            <button type="button" className="btn" onClick={checkout}>
              Go to Checkout with My Cart
            </button>
          </footer>
        ) : null}
      </aside>
    </div>
  )
}
