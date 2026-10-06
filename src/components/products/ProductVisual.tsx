import { useId } from 'react'
import type { ProductVisualKind } from '../../types'

interface ProductVisualProps {
  kind: ProductVisualKind
  title: string
}

export function ProductVisual({ kind, title }: ProductVisualProps) {
  const uid = useId().replace(/:/g, '')
  const coil = kind === 'solenoid'
  const wide = kind === 'custom' || kind === 'directional'
  const relief = kind === 'relief' || kind === 'counterbalance'
  const flow = kind === 'flow'

  return (
    <svg viewBox="0 0 240 240" role="img" aria-label={title}>
      <defs>
        <linearGradient id={`steel-${uid}`} x1="0" x2="0" y1="0" y2="1">
          <stop offset="0%" stopColor="#e4dfd4" />
          <stop offset="50%" stopColor="#8e969f" />
          <stop offset="100%" stopColor="#4a535c" />
        </linearGradient>
      </defs>
      <rect width="240" height="240" fill="#101418" />
      <g stroke="rgba(246,241,232,0.07)" fill="none">
        <path d="M12 12h216v216H12z" />
        <path d="M12 120h216M120 12v216" />
      </g>
      {coil ? (
        <g transform="translate(120 22)">
          <rect x="-28" y="0" width="56" height="46" fill="#2a3138" stroke="#C47A3A" />
          <rect x="-22" y="8" width="44" height="6" fill="#C47A3A" opacity="0.7" />
          <rect x="-22" y="18" width="44" height="6" fill="#8a929c" />
          <rect x="-22" y="28" width="44" height="6" fill="#C47A3A" opacity="0.7" />
          <rect x="-16" y="46" width="32" height="118" fill={`url(#steel-${uid})`} />
          <rect x="-20" y="78" width="40" height="8" fill="#5d656d" />
          <rect x="-20" y="108" width="40" height="8" fill="#5d656d" />
          <polygon points="-10,164 10,164 7,196 -7,196" fill="#7a828b" />
        </g>
      ) : wide ? (
        <g transform="translate(42 78)">
          <rect x="0" y="20" width="156" height="36" fill={`url(#steel-${uid})`} />
          <rect x="18" y="8" width="22" height="60" fill="#6d757e" />
          <rect x="67" y="0" width="22" height="76" fill="#C47A3A" />
          <rect x="116" y="8" width="22" height="60" fill="#6d757e" />
          <circle cx="29" cy="38" r="6" fill="#101418" />
          <circle cx="78" cy="38" r="6" fill="#101418" />
          <circle cx="127" cy="38" r="6" fill="#101418" />
        </g>
      ) : relief ? (
        <g transform="translate(120 24)">
          <circle cx="0" cy="18" r="16" fill={`url(#steel-${uid})`} />
          <rect x="-8" y="32" width="16" height="22" fill="#6d757e" />
          <rect x="-20" y="54" width="40" height="10" fill={`url(#steel-${uid})`} />
          <rect x="-14" y="64" width="28" height="92" fill="#9aa1a8" />
          <rect x="-14" y="88" width="28" height="8" fill="#C47A3A" />
          <polygon points="-9,156 9,156 6,188 -6,188" fill="#7b828a" />
        </g>
      ) : flow ? (
        <g transform="translate(120 28)">
          <rect x="-26" y="0" width="52" height="14" fill={`url(#steel-${uid})`} />
          <rect x="-10" y="14" width="20" height="16" fill="#C47A3A" />
          <rect x="-18" y="30" width="36" height="12" fill={`url(#steel-${uid})`} />
          <rect x="-15" y="42" width="30" height="100" fill="#9aa1a8" />
          <rect x="-15" y="70" width="30" height="5" fill="#5c646c" />
          <rect x="-15" y="92" width="30" height="5" fill="#5c646c" />
          <polygon points="-10,142 10,142 7,174 -7,174" fill="#7b828a" />
        </g>
      ) : (
        <g transform="translate(120 26)">
          <rect x="-18" y="0" width="36" height="18" fill={`url(#steel-${uid})`} />
          <rect x="-14" y="18" width="28" height="22" fill="#6d757e" />
          <rect x="-22" y="40" width="44" height="12" fill={`url(#steel-${uid})`} />
          <rect x="-16" y="52" width="32" height="90" fill="#9aa1a8" />
          <rect x="-16" y="70" width="32" height="6" fill="#5c646c" />
          <rect x="-16" y="92" width="32" height="6" fill="#5c646c" />
          <rect x="-20" y="142" width="40" height="10" fill={`url(#steel-${uid})`} />
          <polygon points="-12,152 12,152 8,180 -8,180" fill="#7b828a" />
          <rect x="-6" y="180" width="12" height="16" fill="#C47A3A" />
        </g>
      )}
      <text
        x="18"
        y="222"
        fill="#C6C0B4"
        fontSize="8"
        fontFamily="IBM Plex Mono, monospace"
        letterSpacing="1.4"
      >
        {kind.toUpperCase()}
      </text>
    </svg>
  )
}
