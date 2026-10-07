import { createContext, useContext, useEffect, useMemo, useState, type ReactNode } from 'react'
import { getProduct } from '../data/products'

export interface CartLine {
  slug: string
  qty: number
}

export interface ShopUser {
  name: string
  email: string
}

interface ShopContextValue {
  cart: CartLine[]
  wishlist: string[]
  user: ShopUser | null
  cartCount: number
  cartOpen: boolean
  notice: string
  openCart: () => void
  closeCart: () => void
  addToCart: (slug: string, qty?: number) => void
  setQty: (slug: string, qty: number) => void
  removeFromCart: (slug: string) => void
  toggleWishlist: (slug: string) => void
  wished: (slug: string) => boolean
  login: (user: ShopUser) => void
  logout: () => void
}

const ShopContext = createContext<ShopContextValue | null>(null)
const storageKey = 'hc-shop'

interface StoredShop {
  cart: CartLine[]
  wishlist: string[]
  user: ShopUser | null
}

function readStored(): StoredShop {
  try {
    const raw = localStorage.getItem(storageKey)
    if (!raw) return { cart: [], wishlist: [], user: null }
    const parsed = JSON.parse(raw) as StoredShop
    return {
      cart: Array.isArray(parsed.cart) ? parsed.cart : [],
      wishlist: Array.isArray(parsed.wishlist) ? parsed.wishlist : [],
      user: parsed.user ?? null,
    }
  } catch {
    return { cart: [], wishlist: [], user: null }
  }
}

export function ShopProvider({ children }: { children: ReactNode }) {
  const stored = useMemo(readStored, [])
  const [cart, setCart] = useState<CartLine[]>(stored.cart)
  const [wishlist, setWishlist] = useState<string[]>(stored.wishlist)
  const [user, setUser] = useState<ShopUser | null>(stored.user)
  const [cartOpen, setCartOpen] = useState(false)
  const [notice, setNotice] = useState('')

  useEffect(() => {
    localStorage.setItem(storageKey, JSON.stringify({ cart, wishlist, user }))
  }, [cart, wishlist, user])

  useEffect(() => {
    if (!notice) return
    const timer = window.setTimeout(() => setNotice(''), 2200)
    return () => window.clearTimeout(timer)
  }, [notice])

  const value = useMemo<ShopContextValue>(() => {
    const cartCount = cart.reduce((sum, line) => sum + line.qty, 0)
    return {
      cart,
      wishlist,
      user,
      cartCount,
      cartOpen,
      notice,
      openCart: () => setCartOpen(true),
      closeCart: () => setCartOpen(false),
      addToCart: (slug, qty = 1) => {
        if (!getProduct(slug)) return
        const amount = Math.max(1, Math.min(999, qty))
        setCart((current) => {
          const existing = current.find((line) => line.slug === slug)
          if (!existing) return [...current, { slug, qty: amount }]
          return current.map((line) =>
            line.slug === slug ? { ...line, qty: Math.min(999, line.qty + amount) } : line,
          )
        })
        setNotice('Added to cart')
      },
      setQty: (slug, qty) => {
        setCart((current) =>
          qty < 1
            ? current.filter((line) => line.slug !== slug)
            : current.map((line) => (line.slug === slug ? { ...line, qty: Math.min(999, qty) } : line)),
        )
      },
      removeFromCart: (slug) => {
        setCart((current) => current.filter((line) => line.slug !== slug))
      },
      toggleWishlist: (slug) => {
        setWishlist((current) => {
          const saved = current.includes(slug)
          setNotice(saved ? 'Removed from wishlist' : 'Added to wishlist')
          return saved ? current.filter((item) => item !== slug) : [...current, slug]
        })
      },
      wished: (slug) => wishlist.includes(slug),
      login: (next) => setUser(next),
      logout: () => setUser(null),
    }
  }, [cart, wishlist, user, cartOpen, notice])

  return <ShopContext.Provider value={value}>{children}</ShopContext.Provider>
}

export function useShop() {
  const value = useContext(ShopContext)
  if (!value) throw new Error('useShop must be used within ShopProvider')
  return value
}
