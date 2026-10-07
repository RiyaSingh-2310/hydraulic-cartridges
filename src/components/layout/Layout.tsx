import { Suspense } from 'react'
import { Outlet, useLocation } from 'react-router-dom'
import { useShop } from '../../context/ShopContext'
import { CartDrawer } from './CartDrawer'
import { Footer } from './Footer'
import { Header } from './Header'

function RouteFallback() {
  return (
    <div className="container" style={{ padding: '6rem 0' }}>
      <p className="eyebrow">Loading</p>
    </div>
  )
}

export function Layout() {
  const { pathname } = useLocation()
  const isHome = pathname === '/'
  const { notice } = useShop()

  return (
    <div className={`page-shell${isHome ? ' home' : ''}`}>
      <a className="skip-link" href="#main">
        Skip to content
      </a>
      <Header />
      <main id="main">
        <Suspense fallback={<RouteFallback />}>
          <Outlet />
        </Suspense>
      </main>
      <Footer />
      <CartDrawer />
      {notice ? (
        <div className="cart-toast" role="status">
          {notice}
        </div>
      ) : null}
    </div>
  )
}
