import type { ReactNode } from 'react'
import { Link } from 'react-router-dom'

type ButtonVariant = 'primary' | 'ghost' | 'outline' | 'dark'

interface ButtonProps {
  to?: string
  children: ReactNode
  variant?: ButtonVariant
  type?: 'button' | 'submit'
  onClick?: () => void
  className?: string
  disabled?: boolean
  loading?: boolean
}

const classMap: Record<ButtonVariant, string> = {
  primary: 'btn',
  ghost: 'btn btn-ghost',
  outline: 'btn btn-outline',
  dark: 'btn btn-dark',
}

export function Button({
  to,
  children,
  variant = 'primary',
  type = 'button',
  onClick,
  className = '',
  disabled = false,
  loading = false,
}: ButtonProps) {
  const cls = `${classMap[variant]} ${className}`.trim()
  const content = (
    <>
      {loading ? <span className="btn-spinner" aria-hidden="true" /> : null}
      <span>{loading ? 'Sending' : children}</span>
    </>
  )

  if (to) {
    return (
      <Link className={cls} to={to} onClick={onClick}>
        {children}
      </Link>
    )
  }

  return (
    <button className={cls} type={type} onClick={onClick} disabled={disabled || loading} aria-busy={loading}>
      {content}
    </button>
  )
}
