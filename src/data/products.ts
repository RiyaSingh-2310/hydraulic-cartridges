import type { Product } from '../types'

export const products: Product[] = [
  {
    slug: 'screw-in-cartridge-valves',
    name: 'Screw-in Cartridge Valves',
    model: 'HCV-SC Series',
    category: 'Cartridge Valves',
    categorySlug: 'cartridge',
    shortDescription:
      'Compact screw-in valves engineered for ISO and custom cavities in high-duty manifolds.',
    overview:
      'The HCV-SC series is designed for OEMs who need dense hydraulic circuits without sacrificing serviceability. Each cartridge is machined, assembled, and functionally tested for continuous-duty industrial pressure.',
    pressure: '350 bar',
    flow: 'Up to 80 L/min',
    cavity: 'ISO / custom',
    visual: 'cartridge',
    galleryCaptions: [
      'HCV-SC screw-in cartridge body',
      'Cavity interface machining',
      'Functional pressure test fixture',
    ],
    features: [
      'Zero-leak poppet and spool options',
      'Hardened steel internal components',
      'ISO cavity compatibility with custom options',
      'Stable response under continuous high-duty cycles',
    ],
    technical: [
      { label: 'Max. operating pressure', value: '350 bar (5,075 psi)' },
      { label: 'Rated flow', value: 'Up to 80 L/min' },
      { label: 'Cavity', value: 'ISO 7789 and custom' },
      { label: 'Temperature range', value: '−30 °C to +100 °C' },
      { label: 'Seals', value: 'NBR / FKM options' },
      { label: 'Body material', value: 'High-strength steel' },
    ],
    applications: ['Mobile Hydraulics', 'Industrial Automation', 'Manufacturing'],
    relatedSlugs: ['solenoid-cartridge-valves', 'relief-valves', 'custom-hydraulic-solutions'],
    featured: true,
  },
  {
    slug: 'solenoid-cartridge-valves',
    name: 'Solenoid Cartridge Valves',
    model: 'HCV-SV Series',
    category: 'Solenoid Valves',
    categorySlug: 'solenoid',
    shortDescription:
      'Electrically actuated cartridges for precise on/off and directional control in compact manifolds.',
    overview:
      'HCV-SV solenoid cartridges combine wet-armature coils with hardened seats for reliable shifting in mobile and industrial circuits. Coil options support common industrial voltages.',
    pressure: '315 bar',
    flow: 'Up to 60 L/min',
    cavity: 'SAE / ISO',
    visual: 'solenoid',
    galleryCaptions: [
      'Solenoid cartridge with coil assembly',
      'Coil and armature detail',
      'Manifold-mounted solenoid group',
    ],
    features: [
      'Wet-armature solenoid design',
      '12 V, 24 V, and 110/220 V coil options',
      'Manual override available',
      'Low leakage poppet construction',
    ],
    technical: [
      { label: 'Max. operating pressure', value: '315 bar (4,570 psi)' },
      { label: 'Rated flow', value: 'Up to 60 L/min' },
      { label: 'Response', value: 'Fast-shift industrial duty' },
      { label: 'Protection', value: 'IP65 coil options' },
      { label: 'Voltage', value: '12 / 24 VDC, 110 / 220 VAC' },
      { label: 'Duty cycle', value: 'Continuous' },
    ],
    applications: ['Material Handling', 'Specialized Machinery', 'Industrial Automation'],
    relatedSlugs: ['screw-in-cartridge-valves', 'directional-valves', 'flow-control-valves'],
  },
  {
    slug: 'check-valves',
    name: 'Check Valves',
    model: 'HCV-CK Series',
    category: 'Check Valves',
    categorySlug: 'check',
    shortDescription:
      'Low-leakage check cartridges that protect circuits and hold load with consistent cracking pressure.',
    overview:
      'HCV-CK check valves are built for repeatable sealing in load-holding and isolation circuits. Poppet geometry is optimized for low pressure drop while remaining tight at rest.',
    pressure: '350 bar',
    flow: 'Up to 120 L/min',
    cavity: 'ISO cavity',
    visual: 'check',
    galleryCaptions: [
      'Poppet-style check cartridge',
      'Seat and poppet machining',
      'Leak test station',
    ],
    features: [
      'Hardened poppet and seat',
      'Defined cracking pressure options',
      'Low pressure drop at rated flow',
      'Pilot-to-open variants available',
    ],
    technical: [
      { label: 'Max. operating pressure', value: '350 bar (5,075 psi)' },
      { label: 'Rated flow', value: 'Up to 120 L/min' },
      { label: 'Cracking pressure', value: '0.5 / 1 / 3 / 5 bar' },
      { label: 'Leakage', value: 'Near-zero at rated pressure' },
      { label: 'Mounting', value: 'Screw-in cartridge' },
      { label: 'Fluid', value: 'Mineral oil, compatible synthetics' },
    ],
    applications: ['Construction Equipment', 'Energy', 'Manufacturing'],
    relatedSlugs: ['counterbalance-valves', 'relief-valves', 'screw-in-cartridge-valves'],
  },
  {
    slug: 'relief-valves',
    name: 'Relief Valves',
    model: 'HCV-RV Series',
    category: 'Pressure Control',
    categorySlug: 'relief',
    shortDescription:
      'Direct-acting and pilot-operated relief cartridges for stable system pressure protection.',
    overview:
      'HCV-RV relief valves are specified where pressure must remain stable through load spikes. Direct-acting units serve compact circuits; pilot-operated designs handle higher flow with low override.',
    pressure: '350 bar',
    flow: 'Up to 150 L/min',
    cavity: 'ISO / SAE',
    visual: 'relief',
    galleryCaptions: [
      'Adjustable relief cartridge',
      'Spring and spool assembly',
      'Pressure override test',
    ],
    features: [
      'Direct-acting and pilot-operated options',
      'Tamper-resistant adjustment',
      'Low hysteresis pressure control',
      'Optional vent and remote control ports',
    ],
    technical: [
      { label: 'Max. setting', value: '350 bar (5,075 psi)' },
      { label: 'Rated flow', value: 'Up to 150 L/min' },
      { label: 'Adjustment', value: 'Screw with lock nut' },
      { label: 'Override', value: 'Low-override pilot designs' },
      { label: 'Repeatability', value: 'Industrial continuous duty' },
      { label: 'Cavity', value: 'ISO / SAE' },
    ],
    applications: ['Industrial Automation', 'Energy', 'Specialized Machinery'],
    relatedSlugs: ['flow-control-valves', 'check-valves', 'custom-hydraulic-solutions'],
  },
  {
    slug: 'flow-control-valves',
    name: 'Flow Control Valves',
    model: 'HCV-FC Series',
    category: 'Flow Control',
    categorySlug: 'flow',
    shortDescription:
      'Needle, pressure-compensated, and priority flow cartridges for controlled actuator speed.',
    overview:
      'HCV-FC flow controls keep actuator velocity predictable as load changes. Compensated designs maintain set flow independent of downstream pressure within the rated window.',
    pressure: '315 bar',
    flow: 'Up to 90 L/min',
    cavity: 'ISO cavity',
    visual: 'flow',
    galleryCaptions: [
      'Pressure-compensated flow cartridge',
      'Needle adjustment detail',
      'Flow bench verification',
    ],
    features: [
      'Pressure-compensated and needle options',
      'Fine-thread adjustment',
      'Priority and bypass configurations',
      'Stable metering at low flow',
    ],
    technical: [
      { label: 'Max. operating pressure', value: '315 bar (4,570 psi)' },
      { label: 'Rated flow', value: 'Up to 90 L/min' },
      { label: 'Compensation', value: 'Load-independent (compensated models)' },
      { label: 'Adjustment', value: 'Graduated knob / screw' },
      { label: 'Reverse free flow', value: 'Optional check path' },
      { label: 'Cavity', value: 'ISO' },
    ],
    applications: ['Agriculture', 'Mobile Hydraulics', 'Material Handling'],
    relatedSlugs: ['relief-valves', 'solenoid-cartridge-valves', 'directional-valves'],
  },
  {
    slug: 'directional-valves',
    name: 'Directional Valves',
    model: 'HCV-DV Series',
    category: 'Directional Control',
    categorySlug: 'directional',
    shortDescription:
      'Two-, three-, and four-way cartridge spools for compact directional control inside the manifold.',
    overview:
      'HCV-DV directional cartridges reduce hose runs by placing function control inside the block. Spool and poppet logics cover motor, cylinder, and regenerative circuits.',
    pressure: '315 bar',
    flow: 'Up to 70 L/min',
    cavity: 'SAE / ISO',
    visual: 'directional',
    galleryCaptions: [
      'Four-way directional cartridge',
      'Spool land precision grind',
      'Circuit manifold example',
    ],
    features: [
      '2-way, 3-way, and 4-way logics',
      'Solenoid, pneumatic, and manual pilots',
      'Soft-shift options for smoother motion',
      'Compact multi-function stacking in one block',
    ],
    technical: [
      { label: 'Max. operating pressure', value: '315 bar (4,570 psi)' },
      { label: 'Rated flow', value: 'Up to 70 L/min' },
      { label: 'Ways / positions', value: '2/2, 3/2, 4/2, 4/3' },
      { label: 'Actuation', value: 'Solenoid / pilot / manual' },
      { label: 'Spool leakage', value: 'Application-dependent' },
      { label: 'Cavity', value: 'SAE / ISO' },
    ],
    applications: ['Mobile Hydraulics', 'Construction Equipment', 'Specialized Machinery'],
    relatedSlugs: ['solenoid-cartridge-valves', 'screw-in-cartridge-valves', 'flow-control-valves'],
  },
  {
    slug: 'counterbalance-valves',
    name: 'Counterbalance Valves',
    model: 'HCV-CB Series',
    category: 'Load Control',
    categorySlug: 'counterbalance',
    shortDescription:
      'Load-holding counterbalance cartridges for controlled lowering and overrunning loads.',
    overview:
      'HCV-CB valves protect actuators from runaway motion. Pilot ratios and relief settings are selected to match cylinder area ratios and machine dynamics.',
    pressure: '350 bar',
    flow: 'Up to 100 L/min',
    cavity: 'ISO cavity',
    visual: 'counterbalance',
    galleryCaptions: [
      'Counterbalance cartridge assembly',
      'Pilot piston and relief seat',
      'Load-holding validation',
    ],
    features: [
      'Multiple pilot ratios',
      'Integrated relief and check',
      'Stable lowering without chatter',
      'Tamper-resistant setting',
    ],
    technical: [
      { label: 'Max. operating pressure', value: '350 bar (5,075 psi)' },
      { label: 'Rated flow', value: 'Up to 100 L/min' },
      { label: 'Pilot ratios', value: '3:1, 4.5:1, 8:1 typical' },
      { label: 'Function', value: 'Relief + check + pilot open' },
      { label: 'Adjustment', value: 'Screw with lock' },
      { label: 'Cavity', value: 'ISO' },
    ],
    applications: ['Construction Equipment', 'Material Handling', 'Mobile Hydraulics'],
    relatedSlugs: ['check-valves', 'relief-valves', 'screw-in-cartridge-valves'],
  },
  {
    slug: 'custom-hydraulic-solutions',
    name: 'Custom Hydraulic Solutions',
    model: 'HCV-CX Program',
    category: 'Custom Engineering',
    categorySlug: 'custom',
    shortDescription:
      'Application-specific cartridges, cavities, and manifold circuits built from your operating envelope.',
    overview:
      'When a catalog cavity cannot meet envelope, duty, or integration requirements, the HCV-CX program develops custom cartridges and manifold circuits. Engineering reviews CAD, duty cycle, and fluid conditions before quoting.',
    pressure: 'Up to 350 bar',
    flow: 'Circuit dependent',
    cavity: 'Custom / ISO hybrid',
    visual: 'custom',
    galleryCaptions: [
      'Custom manifold and cartridge set',
      'Cavity development from CAD',
      'Prototype functional validation',
    ],
    features: [
      'Custom cavity and porting',
      'Integrated multi-function blocks',
      'Prototype-to-production support',
      'Material and seal specification for duty',
    ],
    technical: [
      { label: 'Pressure class', value: 'Up to 350 bar continuous' },
      { label: 'Materials', value: 'Steel / aluminum manifolds' },
      { label: 'Input', value: 'CAD, cavity spec, duty cycle' },
      { label: 'Validation', value: 'Functional and leak testing' },
      { label: 'Documentation', value: 'Application drawings (placeholder)' },
      { label: 'Lead path', value: 'Engineering review then quotation' },
    ],
    applications: ['Specialized Machinery', 'Energy', 'Manufacturing'],
    relatedSlugs: [
      'screw-in-cartridge-valves',
      'directional-valves',
      'solenoid-cartridge-valves',
    ],
  },
]

export function getProduct(slug: string): Product | undefined {
  return products.find((item) => item.slug === slug)
}

export function getRelatedProducts(product: Product): Product[] {
  return product.relatedSlugs
    .map((slug) => getProduct(slug))
    .filter((item): item is Product => Boolean(item))
}

export const featuredProduct = products.find((item) => item.featured) ?? products[0]
