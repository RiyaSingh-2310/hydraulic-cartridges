import { type FormEvent, useState } from 'react'
import { Link, useNavigate, useSearchParams } from 'react-router-dom'
import { PageHero } from '../components/common/PageHero'
import { useShop, type ShopUser } from '../context/ShopContext'

interface StoredAccount extends ShopUser {
  password: string
}

function readAccounts(): StoredAccount[] {
  try {
    const parsed = JSON.parse(localStorage.getItem('hc-accounts') ?? '[]') as StoredAccount[]
    return Array.isArray(parsed) ? parsed : []
  } catch {
    return []
  }
}

export default function AccountPage() {
  const [params] = useSearchParams()
  const navigate = useNavigate()
  const { user, login, logout } = useShop()
  const view = params.get('view') === 'register' ? 'register' : 'login'
  const notice = params.get('notice')
  const redirect = params.get('redirect') || '/products'
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState('')

  function onSubmit(event: FormEvent) {
    event.preventDefault()
    const accounts = readAccounts()
    const normalized = email.trim().toLowerCase()
    if (!normalized.includes('@') || password.length < 8) {
      setError('Enter a valid email and a password of at least 8 characters.')
      return
    }
    if (view === 'register') {
      if (accounts.some((account) => account.email === normalized)) {
        setError('An account already exists for that email. Login instead.')
        return
      }
      const next: StoredAccount = { name: name.trim() || normalized, email: normalized, password }
      localStorage.setItem('hc-accounts', JSON.stringify([...accounts, next]))
      login({ name: next.name, email: next.email })
      navigate(redirect)
      return
    }
    const match = accounts.find((account) => account.email === normalized && account.password === password)
    if (!match) {
      setError('Login failed. Check the email and password.')
      return
    }
    login({ name: match.name, email: match.email })
    navigate(redirect)
  }

  return (
    <>
      <PageHero
        eyebrow="Account"
        title={user ? 'My Account' : view === 'register' ? 'Sign Up' : 'Login'}
        description={
          user
            ? 'Your quotation cart and wishlist stay in this browser.'
            : notice === 'login-cart'
              ? 'Please log in to continue with your cart.'
              : 'Login or create an account to request a quotation.'
        }
      />
      <section className="section">
        <div className="container">
          {notice === 'login-cart' && !user ? (
            <p className="notice-banner">Please log in to continue with your cart.</p>
          ) : null}
          {user ? (
            <div className="auth-card">
              <p className="eyebrow">Signed in</p>
              <h2 className="display" style={{ fontSize: '1.8rem', margin: '0.4rem 0 0.75rem' }}>
                {user.name}
              </h2>
              <p>{user.email}</p>
              <div className="hero-actions">
                <Link className="btn btn-outline" to="/wishlist">
                  Wishlist
                </Link>
                <Link className="btn" to="/request-quote">
                  My Orders / Requests
                </Link>
                <button type="button" className="btn btn-outline" onClick={logout}>
                  Logout
                </button>
              </div>
            </div>
          ) : (
            <form className="auth-card form-grid" onSubmit={onSubmit}>
              {error ? <p className="notice-banner">{error}</p> : null}
              {view === 'register' ? (
                <div className="field">
                  <label htmlFor="acc-name">Name</label>
                  <input id="acc-name" value={name} autoComplete="name" onChange={(event) => setName(event.target.value)} />
                </div>
              ) : null}
              <div className="field">
                <label htmlFor="acc-email">Email</label>
                <input
                  id="acc-email"
                  type="email"
                  required
                  autoComplete="email"
                  value={email}
                  onChange={(event) => setEmail(event.target.value)}
                />
              </div>
              <div className="field">
                <label htmlFor="acc-pass">Password</label>
                <input
                  id="acc-pass"
                  type="password"
                  required
                  minLength={8}
                  autoComplete={view === 'register' ? 'new-password' : 'current-password'}
                  value={password}
                  onChange={(event) => setPassword(event.target.value)}
                />
              </div>
              <button className="btn" type="submit">
                {view === 'register' ? 'Create Account' : 'Login'}
              </button>
              {view === 'login' ? (
                <p>
                  Need an account? <Link to={`/account?view=register&redirect=${encodeURIComponent(redirect)}`}>Create Account</Link>
                </p>
              ) : (
                <p>
                  Already registered? <Link to={`/account?redirect=${encodeURIComponent(redirect)}`}>Login</Link>
                </p>
              )}
            </form>
          )}
        </div>
      </section>
    </>
  )
}
