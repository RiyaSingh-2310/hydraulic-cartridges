import { useEffect, useId, useRef, useState } from 'react'
import { AnimatePresence, motion, useReducedMotion } from 'framer-motion'
import { NavLink, useLocation } from 'react-router-dom'
import { navLinks } from '../../data/company'
import { useScrolled } from '../../hooks/useScrolled'
import { Button } from '../common/Button'
import { Logo } from '../common/Logo'

export function Header() {
  const scrolled = useScrolled()
  const { pathname } = useLocation()
  const isHome = pathname === '/'
  const [menuPath, setMenuPath] = useState<string | null>(null)
  const open = menuPath === pathname
  const reduceMotion = useReducedMotion()
  const toggleRef = useRef<HTMLButtonElement>(null)
  const closeRef = useRef<HTMLButtonElement>(null)
  const panelId = useId()

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
        <div className="header-cta">
          <Button to="/request-quote">Request a Quote</Button>
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
                {navLinks.map((link) => (
                  <NavLink
                    key={link.to}
                    to={link.to}
                    end={link.end}
                    className={({ isActive }) => (isActive ? 'active' : undefined)}
                    onClick={closeMenu}
                  >
                    {link.label}
                  </NavLink>
                ))}
              </div>
              <Button to="/request-quote" onClick={closeMenu}>
                Request a Quote
              </Button>
            </motion.nav>
          </motion.div>
        ) : null}
      </AnimatePresence>
    </header>
  )
}
