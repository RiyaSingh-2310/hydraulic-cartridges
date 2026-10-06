import type { Application } from '../types'

export const applications: Application[] = [
  {
    slug: 'mobile-hydraulics',
    name: 'Mobile Hydraulics',
    shortDescription:
      'Compact cartridges for vehicle-mounted systems that must hold pressure, shift cleanly, and survive vibration.',
    overview:
      'Mobile equipment demands dense manifolds, consistent valve response, and sealing that holds through shock and temperature swing. Cartridge architecture keeps circuits serviceable in the field.',
    challenges: [
      'Space-constrained vehicle frames',
      'Shock, vibration, and duty-cycle heat',
      'Service access in the field',
    ],
    solutions: [
      'Screw-in cartridges in compact steel blocks',
      'Solenoid and load-holding functions grouped by circuit',
      'Seal and material options for outdoor duty',
    ],
    typicalProducts: [
      'screw-in-cartridge-valves',
      'solenoid-cartridge-valves',
      'counterbalance-valves',
    ],
    image:
      'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'Heavy industrial metalwork associated with mobile equipment manufacturing',
  },
  {
    slug: 'industrial-automation',
    name: 'Industrial Automation',
    shortDescription:
      'Repeatable pressure and directional control for presses, fixtures, and automated production cells.',
    overview:
      'Automated plants need valves that repeat the same motion thousands of times per shift. Cartridge manifolds reduce leak points and keep hydraulic logic close to the actuator.',
    challenges: [
      'Cycle-to-cycle repeatability',
      'Leak-free continuous operation',
      'Integration with electrical controls',
    ],
    solutions: [
      'Solenoid cartridges matched to industrial voltages',
      'Relief and flow functions for stable process pressure',
      'Custom blocks for fixture and press circuits',
    ],
    typicalProducts: [
      'solenoid-cartridge-valves',
      'relief-valves',
      'flow-control-valves',
    ],
    image:
      'https://images.unsplash.com/photo-1581094794329-cdc91d0d8c56?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'Automated industrial production environment',
  },
  {
    slug: 'agriculture',
    name: 'Agriculture',
    shortDescription:
      'Durable flow and directional control for implements, steering, and auxiliary hydraulic functions.',
    overview:
      'Agricultural machines combine long idle periods with sudden high-load work. Valve selection focuses on contamination tolerance, simple service, and predictable implement speed.',
    challenges: [
      'Dust and fluid contamination',
      'Seasonal duty followed by storage',
      'Multiple implement circuits',
    ],
    solutions: [
      'Flow control for implement speed',
      'Check and relief protection on shared pumps',
      'Cartridge replacement without re-plumbing the machine',
    ],
    typicalProducts: ['flow-control-valves', 'check-valves', 'directional-valves'],
    image:
      'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'Agricultural machinery operating in the field',
  },
  {
    slug: 'construction-equipment',
    name: 'Construction Equipment',
    shortDescription:
      'Load-holding and pressure protection for booms, outriggers, and high-inertia work functions.',
    overview:
      'Construction hydraulics move heavy, overrunning loads. Counterbalance and relief cartridges are specified to keep motion controlled when gravity assists the actuator.',
    challenges: [
      'Overrunning and over-center loads',
      'Peak pressure spikes',
      'Rugged outdoor service',
    ],
    solutions: [
      'Counterbalance valves matched to cylinder ratios',
      'Relief protection at 350 bar class',
      'Hardened internals for abrasive duty',
    ],
    typicalProducts: [
      'counterbalance-valves',
      'relief-valves',
      'screw-in-cartridge-valves',
    ],
    image:
      'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'Construction equipment on an active job site',
  },
  {
    slug: 'material-handling',
    name: 'Material Handling',
    shortDescription:
      'Smooth lift, lower, and auxiliary control for warehouse and yard handling equipment.',
    overview:
      'Material handling systems need quiet, controlled motion and reliable load holding at rest. Cartridge valves keep lift circuits compact inside the vehicle or station manifold.',
    challenges: [
      'Smooth lowering under varying load',
      'Energy-efficient idle',
      'High daily cycle counts',
    ],
    solutions: [
      'Load-holding check and counterbalance functions',
      'Solenoid directional control for auxiliaries',
      'Compensated flow for consistent lift speed',
    ],
    typicalProducts: [
      'counterbalance-valves',
      'solenoid-cartridge-valves',
      'flow-control-valves',
    ],
    image:
      'https://images.unsplash.com/photo-1587293852726-70cdb56c2866?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'Industrial warehouse with material handling infrastructure',
  },
  {
    slug: 'energy',
    name: 'Energy',
    shortDescription:
      'Pressure-stable cartridges for power generation auxiliaries, test stands, and process hydraulics.',
    overview:
      'Energy applications often combine high pressure with long hold times. Valve leakage, seal selection, and documented test results matter as much as catalog flow ratings.',
    challenges: [
      'Long-duration pressure holding',
      'Safety-critical relief behavior',
      'Traceable quality documentation',
    ],
    solutions: [
      'Low-leakage check and relief cartridges',
      'Functional testing on every unit in this catalog range',
      'Custom manifolds for auxiliary power units',
    ],
    typicalProducts: ['relief-valves', 'check-valves', 'custom-hydraulic-solutions'],
    image:
      'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'Electrical transmission infrastructure representing energy applications',
  },
  {
    slug: 'manufacturing',
    name: 'Manufacturing',
    shortDescription:
      'Integrated hydraulic circuits for machine tools, forming equipment, and plant machinery.',
    overview:
      'Manufacturing OEMs specify cartridges to shorten machine build time and keep spares standardized. Custom blocks consolidate clamps, counters, and pressure sequences.',
    challenges: [
      'Dense function count in a small envelope',
      'Standardized spare parts',
      'Clean, leak-minimized machine design',
    ],
    solutions: [
      'Multi-cavity manifolds from CAD',
      'Standard screw-in families across machine lines',
      'Flow and directional logic inside the block',
    ],
    typicalProducts: [
      'custom-hydraulic-solutions',
      'directional-valves',
      'screw-in-cartridge-valves',
    ],
    image:
      'https://images.unsplash.com/photo-1537462715879-360eeb61a0ad?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'CNC manufacturing cell producing precision metal parts',
  },
  {
    slug: 'specialized-machinery',
    name: 'Specialized Machinery',
    shortDescription:
      'Application-engineered cartridges and cavities when standard catalog geometry is not enough.',
    overview:
      'Specialized machines often need unique porting, uncommon flow paths, or hybrid ISO/custom cavities. Engineering collaboration starts with the duty cycle, not a part number.',
    challenges: [
      'Non-standard envelopes',
      'Mixed functions in one cartridge',
      'Prototype iteration before production',
    ],
    solutions: [
      'Custom cavity development',
      'Prototype testing and revision',
      'Production cartridges matched to the approved circuit',
    ],
    typicalProducts: [
      'custom-hydraulic-solutions',
      'directional-valves',
      'solenoid-cartridge-valves',
    ],
    image:
      'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1600&q=80',
    imageAlt: 'Specialized precision assembly being inspected in an engineering environment',
  },
]

export function getApplication(slug: string): Application | undefined {
  return applications.find((item) => item.slug === slug)
}
