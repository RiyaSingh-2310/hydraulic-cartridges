interface LogoProps {
  inverted?: boolean
}

export function Logo({ inverted = true }: LogoProps) {
  const mark = inverted ? '#C47A3A' : '#C47A3A'
  const text = inverted ? '#F8F5EF' : '#0A0C0E'
  const sub = inverted ? '#C6C0B4' : '#3A4450'

  return (
    <span className="brand">
      <svg className="brand-mark" viewBox="0 0 32 32" aria-hidden="true">
        <rect width="32" height="32" fill={inverted ? '#0A0C0E' : '#F2EEE6'} />
        <path d="M7 6h7v3.2h-3.2V22.8H14V26H7V6zm11 0h7v3.2h-3.2V22.8H25V26h-7V6z" fill={mark} />
      </svg>
      <span className="brand-text">
        <strong style={{ color: text }}>Hydraulic Cartridges</strong>
        <span style={{ color: sub }}>Precision fluid power</span>
      </span>
    </span>
  )
}
