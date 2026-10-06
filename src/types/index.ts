export interface SpecItem {
  label: string
  value: string
}

export interface Product {
  slug: string
  name: string
  model: string
  category: string
  categorySlug: string
  shortDescription: string
  overview: string
  pressure: string
  flow: string
  cavity: string
  visual: ProductVisualKind
  galleryCaptions: string[]
  features: string[]
  technical: SpecItem[]
  applications: string[]
  relatedSlugs: string[]
  featured?: boolean
}

export type ProductVisualKind =
  | 'cartridge'
  | 'solenoid'
  | 'check'
  | 'relief'
  | 'flow'
  | 'directional'
  | 'counterbalance'
  | 'custom'

export interface Application {
  slug: string
  name: string
  shortDescription: string
  overview: string
  challenges: string[]
  solutions: string[]
  typicalProducts: string[]
  image: string
  imageAlt: string
}

export interface Capability {
  index: string
  title: string
  description: string
}

export interface ResourceItem {
  slug: string
  title: string
  description: string
  type: string
}

export interface NavLink {
  label: string
  to: string
  end?: boolean
}
