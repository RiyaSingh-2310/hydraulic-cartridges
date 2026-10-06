import type { Capability, NavLink, ResourceItem } from '../types'

export const company = {
  name: 'Hydraulic Cartridges',
  tagline: 'Precision fluid power, manufactured with intent.',
  email: 'care@hydraulic-cartridges.com',
  phone: '(+91) 7007891857',
  address: 'Manufacturing address — placeholder pending official listing',
  hours: 'Engineering desk hours — placeholder',
  iso: 'ISO 9001 compliant manufacturing (as published on hydraulic-cartridges.com)',
  pressureClass: '350 bar continuous operating class',
}

export const navLinks: NavLink[] = [
  { label: 'Home', to: '/', end: true },
  { label: 'Products', to: '/products' },
  { label: 'Solutions', to: '/applications' },
  { label: 'About', to: '/about' },
  { label: 'Resources', to: '/resources' },
  { label: 'Contact', to: '/contact' },
]

export const capabilities: Capability[] = [
  {
    index: '01',
    title: 'Precision Manufacturing',
    description:
      'Cavity geometry, threads, and sealing lands are machined to tight industrial tolerances so cartridges seat consistently in OEM manifolds.',
  },
  {
    index: '02',
    title: 'Engineering Support',
    description:
      'Application engineers review pressure, flow, duty cycle, and envelope before recommending a catalog cartridge or a custom path.',
  },
  {
    index: '03',
    title: 'Custom Solutions',
    description:
      'When ISO cavities cannot meet the circuit, we develop hybrid cavities, special porting, and integrated manifold functions.',
  },
  {
    index: '04',
    title: 'Quality Control',
    description:
      'Dimensional checks and documented inspection points sit in the manufacturing sequence, not only at the end of the line.',
  },
  {
    index: '05',
    title: 'Testing & Validation',
    description:
      'Functional pressure, leakage, and shift tests are specified for the catalog range. Custom circuits receive application-specific validation.',
  },
  {
    index: '06',
    title: 'Global Supply Intent',
    description:
      'The commercial model is direct-from-manufacturer supply for industrial OEMs and machinery builders. Logistics details are confirmed at quotation.',
  },
]

export const resources: ResourceItem[] = [
  {
    slug: 'catalog',
    title: 'Product Catalog',
    description: 'Overview of cartridge families, cavities, and typical operating ranges.',
    type: 'PDF · Placeholder',
  },
  {
    slug: 'documentation',
    title: 'Technical Documentation',
    description: 'Installation notes, cavity drawings, and recommended torque values.',
    type: 'Library · Placeholder',
  },
  {
    slug: 'specifications',
    title: 'Product Specifications',
    description: 'Pressure, flow, seal, and material data for each published series.',
    type: 'Data · Placeholder',
  },
  {
    slug: 'guides',
    title: 'Application Guides',
    description: 'Selection notes for load holding, relief, flow, and directional circuits.',
    type: 'Guide · Placeholder',
  },
  {
    slug: 'faq',
    title: 'FAQs',
    description: 'Cavity compatibility, fluids, coil voltages, and quotation requirements.',
    type: 'Reference',
  },
  {
    slug: 'engineering',
    title: 'Contact Engineering',
    description: 'Send cavity files, duty cycle, and target envelope for a technical review.',
    type: 'Desk',
  },
]

export const faqs = [
  {
    question: 'Do you manufacture to ISO cavities?',
    answer:
      'Catalog cartridges are specified around ISO and SAE cavity families, with custom cavity work when the envelope requires it. Confirm the cavity code on the product page before specifying.',
  },
  {
    question: 'What operating pressure should designers assume?',
    answer:
      'The published industrial class on the existing brand site is 350 bar continuous. Individual series may be rated lower; use the product specification table as the design source.',
  },
  {
    question: 'Can you quote from CAD?',
    answer:
      'Yes. The request-a-quote flow accepts a description of the application now. File upload will be connected in a later phase; until then, reference drawings in the message field.',
  },
  {
    question: 'Is this website connected to live inventory?',
    answer:
      'No. This frontend uses structured mock catalog data so the experience can be reviewed visually. Commercial availability is confirmed during quotation.',
  },
]
