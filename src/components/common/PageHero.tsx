interface PageHeroProps {
  eyebrow: string
  title: string
  description: string
  compact?: boolean
}

export function PageHero({ eyebrow, title, description, compact }: PageHeroProps) {
  return (
    <header className={`page-hero${compact ? ' compact' : ''}`}>
      <div className="container">
        <p className="eyebrow">{eyebrow}</p>
        <h1 className="display">{title}</h1>
        <p>{description}</p>
      </div>
    </header>
  )
}
