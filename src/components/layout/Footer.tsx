import { Link } from 'react-router-dom'
import { company, navLinks } from '../../data/company'
import { Logo } from '../common/Logo'

export function Footer() {
  return (
    <footer className="site-footer">
      <div className="container-wide">
        <div className="footer-grid">
          <div className="footer-brand footer-col">
            <Logo />
            <p>
              Direct-from-manufacturer hydraulic cartridges and custom manifold components for
              continuous-duty industrial equipment.
            </p>
            <p>{company.iso}</p>
          </div>
          <div className="footer-col">
            <h2>Products</h2>
            <Link to="/products">Cartridge catalog</Link>
            <Link to="/products/screw-in-cartridge-valves">Screw-in valves</Link>
            <Link to="/products/custom-hydraulic-solutions">Custom solutions</Link>
            <Link to="/request-quote">Request a quote</Link>
          </div>
          <div className="footer-col">
            <h2>Company</h2>
            {navLinks.map((link) => (
              <Link key={link.to} to={link.to}>
                {link.label}
              </Link>
            ))}
            <Link to="/about">Engineering</Link>
          </div>
          <div className="footer-col">
            <h2>Contact</h2>
            <p>
              <a href={`mailto:${company.email}`}>{company.email}</a>
            </p>
            <p>
              <a href="tel:+917007891857">{company.phone}</a>
            </p>
            <p>{company.address}</p>
            <p>Social — placeholder (LinkedIn / YouTube)</p>
          </div>
        </div>
        <div className="footer-meta">
          <p>© {new Date().getFullYear()} Hydraulic Cartridges. All rights reserved.</p>
          <div className="footer-legal">
            <Link to="/privacy">Privacy policy</Link>
            <Link to="/terms">Terms</Link>
          </div>
        </div>
      </div>
    </footer>
  )
}
