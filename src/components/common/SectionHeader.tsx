interface SectionHeaderProps {
  eyebrow: string
  title: string
  copy?: string
  split?: boolean
}

export function SectionHeader({ eyebrow, title, copy, split }: SectionHeaderProps) {
  return (
    <div className={`section-head${split ? ' split' : ''}`}>
      <div>
        <p className="eyebrow">{eyebrow}</p>
        <h2 className="display" style={{ fontSize: 'var(--display-sm)', marginTop: '0.75rem' }}>
          {title}
        </h2>
      </div>
      {copy ? <p className="lede">{copy}</p> : null}
    </div>
  )
}
