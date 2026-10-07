import catalogBlueprint from './catalog.json'
import type { Product, ProductVisualKind } from '../types'

interface RawProduct {
  slug: string
  name: string
  model?: string
  pressure?: string
  flow?: string
  cavity?: string
  visual?: string
}

interface RawGroup {
  slug: string
  name: string
  intro?: string
  visual?: string
  products?: RawProduct[]
}

interface RawFamily {
  slug: string
  name: string
  visual?: string
  intro?: string
  children: RawGroup[]
}

const visuals = new Set<ProductVisualKind>([
  'cartridge',
  'solenoid',
  'check',
  'relief',
  'flow',
  'directional',
  'counterbalance',
  'custom',
])

function asVisual(value: string | undefined, fallback: ProductVisualKind): ProductVisualKind {
  if (value && visuals.has(value as ProductVisualKind)) return value as ProductVisualKind
  return fallback
}

export interface CatalogGroup {
  slug: string
  name: string
  intro: string
  visual: ProductVisualKind
  products: Product[]
}

export interface CatalogFamily {
  slug: string
  name: string
  intro: string
  visual: ProductVisualKind
  children: CatalogGroup[]
}

function toProduct(
  family: RawFamily,
  group: RawGroup,
  item: RawProduct,
  siblings: string[],
): Product {
  const visual = asVisual(item.visual, asVisual(group.visual, asVisual(family.visual, 'cartridge')))
  const pressure = item.pressure ?? 'Confirmed at quotation'
  const flow = item.flow ?? 'Circuit dependent'
  const cavity = item.cavity ?? 'See cavity family'
  return {
    slug: item.slug,
    name: item.name,
    model: item.model ?? '',
    category: group.name,
    categorySlug: group.slug,
    family: family.name,
    familySlug: family.slug,
    groupSlug: group.slug,
    shortDescription: group.intro ?? family.intro ?? '',
    overview: group.intro ?? family.intro ?? item.name,
    pressure,
    flow,
    cavity,
    visual,
    galleryCaptions: [item.name, 'Machining reference', 'Functional test'],
    features: [
      group.intro ?? family.intro ?? item.name,
      pressure !== 'Confirmed at quotation' ? `Pressure class ${pressure}` : 'Pressure confirmed with the application',
      flow !== 'Circuit dependent' ? `Rated flow ${flow}` : 'Flow confirmed with the circuit',
    ],
    technical: [
      { label: 'Family', value: family.name },
      { label: 'Group', value: group.name },
      { label: 'Model', value: item.model || '—' },
      { label: 'Pressure', value: pressure },
      { label: 'Flow', value: flow },
      { label: 'Interface', value: cavity },
    ],
    applications: [],
    relatedSlugs: siblings.filter((slug) => slug !== item.slug).slice(0, 3),
    featured: item.slug === 'hcv-hsp-20',
  }
}

function buildCatalog(raw: RawFamily[]): { families: CatalogFamily[]; products: Product[] } {
  const products: Product[] = []
  const families: CatalogFamily[] = raw.map((family) => {
    const familyVisual = asVisual(family.visual, 'cartridge')
    const children = family.children.map((group) => {
      const series = group.products?.length
        ? group.products
        : [
            {
              slug: group.slug,
              name: group.name,
              visual: group.visual,
            },
          ]
      const slugs = series.map((item) => item.slug)
      const mapped = series.map((item) => toProduct(family, group, item, slugs))
      products.push(...mapped)
      return {
        slug: group.slug,
        name: group.name,
        intro: group.intro ?? '',
        visual: asVisual(group.visual, familyVisual),
        products: mapped,
      }
    })
    return {
      slug: family.slug,
      name: family.name,
      intro: family.intro ?? '',
      visual: familyVisual,
      children,
    }
  })
  return { families, products }
}

const built = buildCatalog(catalogBlueprint as RawFamily[])

export const catalogFamilies = built.families
export const catalogProducts = built.products

const bySlug = new Map(catalogProducts.map((product) => [product.slug, product]))

export function getCatalogProduct(slug: string): Product | undefined {
  return bySlug.get(slug)
}

export function familyPath(slug: string) {
  return `/products?family=${encodeURIComponent(slug)}`
}

export function groupPath(familySlug: string, groupSlug: string) {
  return `/products?family=${encodeURIComponent(familySlug)}&group=${encodeURIComponent(groupSlug)}`
}
