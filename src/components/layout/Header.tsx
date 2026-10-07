import { useEffect, useId, useRef, useState } from 'react'
import { AnimatePresence, motion, useReducedMotion } from 'framer-motion'
import { NavLink, useLocation } from 'react-router-dom'
import { navLinks } from '../../data/company'
import { catalogFamilies, familyPath, groupPath } from '../../data/catalog'
import { useShop } from '../../context/ShopContext'
import { useScrolled } from '../../hooks/useScrolled'
import { Logo } from '../common/Logo'
import { CategoryBar } from './CategoryBar'

function HeartIcon() {
  return (
    <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
      <path
        d="M12 19.2 4.9 12.4a3.7 3.7 0 0 1 5.2-5.2L12 9l1.9-1.8a3.7 3.7 0 0 1 5.2 5.2L12 19.2z"
        fill="none"
        stroke="currentColor"
        strokeWidth="1.6"
        strokeLinejoin="round"
      />
    </svg>
  )
}

function CartIcon() {
  return (
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <path
        d="M6.5 7h14l-1.4 8.2a2 2 0 0 1-2 1.6H9.2a2 2 0 0 1-2-1.7L5.2 4.8H3"
        stroke="currentColor"
        strokeWidth="1.6"
        strokeLinecap="round"
        strokeLinejoin="round"
      />
      <circle cx="9.5" cy="20" r="1.2" fill="currentColor" />
      <circle cx="17.5" cy="20" r="1.2" fill="currentColor" />
    </svg>
  )
}

function PersonIcon() {
  return (
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <circle cx="12" cy="8" r="3.25" stroke="currentColor" strokeWidth="1.6" />
      <path
        d="M5.2 19.2c.9-3.2 3.6-5.2 6.8-5.2s5.9 2 6.8 5.2"
        stroke="currentColor"
        strokeWidth="1.6"
        strokeLinecap="round"
      />
    </svg>
  )
}

function MobileCatalog({ onNavigate }: { onNavigate: () => void }) {
  const [familyOpen, setFamilyOpen] = useState<string | null>(null)
  const [groupOpen, setGroupOpen] = useState<string | null>(null)

  return (
    <div className="mobile-products">
      <NavLink to="/products" className={({ isActive }) => (isActive ? 'active' : undefined)} onClick={onNavigate}>
        Products
      </NavLink>
      <div className="mobile-families">
        {catalogFamilies.map((family) => {
          const open = familyOpen === family.slug
          return (
            <div className="mobile-family" key={family.slug}>
              <button
                type="button"
                className="mobile-family-toggle"
                aria-expanded={open}
                onClick={() => {
                  setFamilyOpen(open ? null : family.slug)
                  setGroupOpen(null)
                }}
              >
                {family.name}
              </button>
              {open ? (
                <div className="mobile-family-panel">
                  <NavLink className="mobile-cat-link" to={familyPath(family.slug)} onClick={onNavigate}>
                    All {family.name}
                  </NavLink>
                  {family.children.map((group) => {
                    const groupIsOpen = groupOpen === group.slug
                    return (
                      <div key={group.slug}>
                        <button
                          type="button"
                          className="mobile-sub-toggle"
                          aria-expanded={groupIsOpen}
                          onClick={() => setGroupOpen(groupIsOpen ? null : group.slug)}
                        >
                          {group.name}
                        </button>
                        {groupIsOpen ? (
                          <div className="mobile-sub-panel">
                            <NavLink className="mobile-cat-link" to={groupPath(family.slug, group.slug)} onClick={onNavigate}>
                              View {group.name}
                            </NavLink>
                            {group.products.map((product) => (
                              <NavLink
                                key={product.slug}
                                className="mobile-cat-link"
                                to={`/products/${product.slug}`}
                                onClick={onNavigate}
                              >
                                {product.model ? `${product.model} — ` : ''}
                                {product.name}
                              </NavLink>
                            ))}
                          </div>
                        ) : null}
                      </div>
                    )
                  })}
                </div>
              ) : null}
            </div>
          )
        })}
      </div>
    </div>
  )
}

export function Header() {
  const scrolled = useScrolled()
  const { pathname } = useLocation()
  const isHome = pathname === '/'
  const [menuPath, setMenuPath] = useState<string | null>(null)
  const [accountOpen, setAccountOpen] = useState(false)
  const open = menuPath === pathname
  const reduceMotion = useReducedMotion()
  const toggleRef = useRef<HTMLButtonElement>(null)
  const closeRef = useRef<HTMLButtonElement>(null)
  const accountRef = useRef<HTMLDivElement>(null)
  const panelId = useId()
  const { cartCount, wishlist, openCart, user, logout } = useShop()

  function closeMenu() {
    setMenuPath(null)
  }

  function closeMenuAndRestoreFocus() {
    setMenuPath(null)
    toggleRef.current?.focus()
  }

  useEffect(() => {
    const { body, documentElement } = document
    body.style.overflow = open ? 'hidden' : ''
    documentElement.style.overflow = open ? 'hidden' : ''
    return () => {
      body.style.overflow = ''
      documentElement.style.overflow = ''
    }
  }, [open])

  useEffect(() => {
    if (!open) return
    const onKey = (event: KeyboardEvent) => {
      if (event.key === 'Escape') {
        setMenuPath(null)
        toggleRef.current?.focus()
      }
    }
    document.addEventListener('keydown', onKey)
    closeRef.current?.focus()
    return () => document.removeEventListener('keydown', onKey)
  }, [open])

  useEffect(() => {
    if (!accountOpen) return
    const onPointer = (event: MouseEvent) => {
      if (!accountRef.current?.contains(event.target as Node)) setAccountOpen(false)
    }
    const onKey = (event: KeyboardEvent) => {
      if (event.key === 'Escape') setAccountOpen(false)
    }
    document.addEventListener('mousedown', onPointer)
    document.addEventListener('keydown', onKey)
    return () => {
      document.removeEventListener('mousedown', onPointer)
      document.removeEventListener('keydown', onKey)
    }
  }, [accountOpen])

  const headerClass = `site-header ${isHome ? 'overlay' : 'solid'}${scrolled ? ' scrolled' : ''}${open ? ' menu-open' : ''}`
  const duration = reduceMotion ? 0 : 0.34

  return (
    <header className={headerClass}>
      <div className="container-wide header-inner">
        <NavLink to="/" end aria-label="Hydraulic Cartridges home" onClick={closeMenu}>
          <Logo />
        </NavLink>
        <nav className="desktop-nav" aria-label="Primary">
          {navLinks.map((link) => (
            <NavLink
              key={link.to}
              to={link.to}
              end={link.end}
              className={({ isActive }) => (isActive ? 'active' : undefined)}
            >
              {link.label}
            </NavLink>
          ))}
        </nav>
        <div className="header-tools">
          <NavLink className="header-icon" to="/wishlist" aria-label="Wishlist">
            <HeartIcon />
            <span className="cart-badge" hidden={wishlist.length < 1}>
              {wishlist.length}
            </span>
          </NavLink>
          <button type="button" className="header-icon" aria-label="Open cart" onClick={openCart}>
            <CartIcon />
            <span className="cart-badge" hidden={cartCount < 1}>
              {cartCount}
            </span>
          </button>
          <div className="header-account" ref={accountRef}>
            <button
              type="button"
              className="header-icon"
              aria-label={user ? 'Account' : 'Login'}
              aria-expanded={accountOpen}
              aria-haspopup="true"
              onClick={() => setAccountOpen((current) => !current)}
            >
              <PersonIcon />
            </button>
            {accountOpen ? (
              <div className="account-menu">
                {user ? (
                  <>
                    <p className="account-menu-label">{user.name || user.email}</p>
                    <NavLink to="/account" onClick={() => setAccountOpen(false)}>
                      My Account
                    </NavLink>
                    <NavLink to="/request-quote" onClick={() => setAccountOpen(false)}>
                      My Orders / Requests
                    </NavLink>
                    <NavLink to="/wishlist" onClick={() => setAccountOpen(false)}>
                      Wishlist
                    </NavLink>
                    <button
                      type="button"
                      onClick={() => {
                        setAccountOpen(false)
                        openCart()
                      }}
                    >
                      Cart
                    </button>
                    <button
                      type="button"
                      onClick={() => {
                        logout()
                        setAccountOpen(false)
                      }}
                    >
                      Logout
                    </button>
                  </>
                ) : (
                  <>
                    <NavLink to="/account" onClick={() => setAccountOpen(false)}>
                      Login
                    </NavLink>
                    <NavLink to="/account?view=register" onClick={() => setAccountOpen(false)}>
                      Sign Up
                    </NavLink>
                  </>
                )}
              </div>
            ) : null}
          </div>
        </div>
        <button
          ref={toggleRef}
          className={`menu-toggle${open ? ' open' : ''}`}
          type="button"
          aria-expanded={open}
          aria-controls={panelId}
          onClick={() => setMenuPath(open ? null : pathname)}
        >
          <span />
          <span className="sr-only">{open ? 'Close menu' : 'Open menu'}</span>
        </button>
      </div>
      <CategoryBar />

      <AnimatePresence>
        {open ? (
          <motion.div key="mobile-menu" className="menu-layer">
            <motion.button
              type="button"
              className="menu-backdrop"
              aria-label="Close menu"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              transition={{ duration, ease: [0.22, 1, 0.36, 1] }}
              onClick={closeMenuAndRestoreFocus}
            />
            <motion.nav
              id={panelId}
              className="mobile-nav"
              aria-label="Mobile"
              initial={reduceMotion ? false : { opacity: 0, y: -18 }}
              animate={{ opacity: 1, y: 0 }}
              exit={reduceMotion ? undefined : { opacity: 0, y: -14 }}
              transition={{ duration, ease: [0.22, 1, 0.36, 1] }}
            >
              <div className="mobile-nav-head">
                <p className="eyebrow">Menu</p>
                <button ref={closeRef} type="button" className="menu-close" onClick={closeMenuAndRestoreFocus}>
                  Close
                </button>
              </div>
              <div className="mobile-nav-links">
                {navLinks.map((link) =>
                  link.to === '/products' ? (
                    <MobileCatalog key={link.to} onNavigate={closeMenu} />
                  ) : (
                    <NavLink
                      key={link.to}
                      to={link.to}
                      end={link.end}
                      className={({ isActive }) => (isActive ? 'active' : undefined)}
                      onClick={closeMenu}
                    >
                      {link.label}
                    </NavLink>
                  ),
                )}
              </div>
            </motion.nav>
          </motion.div>
        ) : null}
      </AnimatePresence>
    </header>
  )
}
