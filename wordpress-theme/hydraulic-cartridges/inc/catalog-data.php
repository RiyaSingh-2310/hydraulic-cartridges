<?php
/**
 * Catalog information architecture (families → groups → series).
 */

if (! defined('ABSPATH')) {
    exit;
}

function hc_catalog_blueprint() {
    return array(
        array(
            'slug'   => 'valves',
            'name'   => 'Valves',
            'visual' => 'cartridge',
            'intro'  => 'Screw-in, in-line, and manifold-mounted valves specified by cavity, function, and duty cycle for continuous-duty industrial circuits.',
            'children' => array(
                array(
                    'slug'  => 'proportional-cartridge-valves',
                    'name'  => 'Proportional Cartridge Valves',
                    'intro' => 'Electro-proportional cartridges for metered flow, pressure, and directional control in compact manifolds.',
                    'visual'=> 'solenoid',
                    'products' => array(
                        array('slug' => 'hcv-hsp-20', 'name' => 'Poppet, 2-Way, Normally Closed', 'model' => 'HCV-HSP-20', 'pressure' => '350 bar', 'flow' => 'Up to 20 L/min', 'cavity' => 'ISO cartridge', 'visual' => 'solenoid'),
                        array('slug' => 'hcv-hsp-21', 'name' => 'Poppet, 2-Way, Normally Open', 'model' => 'HCV-HSP-21', 'pressure' => '350 bar', 'flow' => 'Up to 20 L/min', 'cavity' => 'ISO cartridge', 'visual' => 'solenoid'),
                        array('slug' => 'hcv-spv-30', 'name' => 'Proportional Flow Control Cartridge, Normally Closed', 'model' => 'HCV-SPV-30', 'pressure' => '315 bar', 'flow' => 'Up to 30 L/min', 'cavity' => 'ISO cartridge', 'visual' => 'flow'),
                        array('slug' => 'hcv-spv-31', 'name' => 'Proportional Flow Control Cartridge, Normally Open', 'model' => 'HCV-SPV-31', 'pressure' => '315 bar', 'flow' => 'Up to 30 L/min', 'cavity' => 'ISO cartridge', 'visual' => 'flow'),
                        array('slug' => 'hcv-spv-33', 'name' => 'Proportional Flow Control Cartridge, Normally Closed', 'model' => 'HCV-SPV-33', 'pressure' => '315 bar', 'flow' => 'Up to 40 L/min', 'cavity' => 'ISO cartridge', 'visual' => 'flow'),
                        array('slug' => 'hcv-pv', 'name' => 'Normally Closed, 2-Way Proportional Flow Control Valve', 'model' => 'HCV-PV', 'pressure' => '315 bar', 'flow' => 'Up to 25 L/min', 'cavity' => 'ISO / SAE', 'visual' => 'flow'),
                        array('slug' => 'hcv-sts-20', 'name' => 'Proportional Electric Relief Valve', 'model' => 'HCV-STS-20', 'pressure' => '350 bar', 'flow' => 'Up to 20 L/min', 'cavity' => 'ISO cartridge', 'visual' => 'relief'),
                        array('slug' => 'hcv-sts-36', 'name' => 'Proportional Electric Reducing/Relieving Valve', 'model' => 'HCV-STS-36', 'pressure' => '350 bar', 'flow' => 'Up to 36 L/min', 'cavity' => 'ISO cartridge', 'visual' => 'relief'),
                        array('slug' => 'hcv-hsp-47c', 'name' => 'Proportional Spool, 4-Way, 3-Position, Closed Center', 'model' => 'HCV-HSP-47C', 'pressure' => '315 bar', 'flow' => 'Up to 47 L/min', 'cavity' => 'SAE / ISO', 'visual' => 'directional'),
                        array('slug' => 'hcv-hsp-47d', 'name' => 'Proportional Spool, 4-Way, 3-Position, Motor Spool', 'model' => 'HCV-HSP-47D', 'pressure' => '315 bar', 'flow' => 'Up to 47 L/min', 'cavity' => 'SAE / ISO', 'visual' => 'directional'),
                        array('slug' => 'hcv-sy-dpca-c-1', 'name' => 'Digital Proportional Controller — Case', 'model' => 'HCV-SY-DPCA-C-1', 'pressure' => '—', 'flow' => 'Electronics', 'cavity' => 'DIN / panel', 'visual' => 'custom'),
                        array('slug' => 'hcv-sy-dpca-p-1', 'name' => 'Digital Proportional Controller — PCB Only', 'model' => 'HCV-SY-DPCA-P-1', 'pressure' => '—', 'flow' => 'Electronics', 'cavity' => 'PCB', 'visual' => 'custom'),
                        array('slug' => 'hcv-sy-dpca-c-2', 'name' => 'Dual Output Proportional Controller', 'model' => 'HCV-SY-DPCA-C-2', 'pressure' => '—', 'flow' => 'Electronics', 'cavity' => 'DIN / panel', 'visual' => 'custom'),
                        array('slug' => 'hcv-sy-dpca-d-p9-1', 'name' => 'Digital Proportional Controller — DIN Plug', 'model' => 'HCV-SY-DPCA-D-P9-1', 'pressure' => '—', 'flow' => 'Electronics', 'cavity' => 'DIN plug', 'visual' => 'custom'),
                    ),
                ),
                array('slug' => 'metric-special-cavity-cartridge-valves', 'name' => 'Metric & Special Cavity Cartridge Valves', 'intro' => 'Cartridge valves for metric and application-specific cavities when a standard ISO interface will not sit in the block.', 'visual' => 'cartridge'),
                array('slug' => 'sae-cavity-cartridge-valves', 'name' => 'SAE Cavity Cartridge Valves', 'intro' => 'Screw-in valves specified to SAE cavity families for OEM manifolds and serviceable industrial circuits.', 'visual' => 'cartridge'),
                array('slug' => 'solenoid-cartridge-valve', 'name' => 'Solenoid Cartridge Valves', 'intro' => 'Electrically actuated on/off cartridges for compact directional and isolation functions.', 'visual' => 'solenoid'),
                array('slug' => 'cavity-tool', 'name' => 'Cavity Tool', 'intro' => 'Cavity cutting and finishing tools used to prepare ISO, SAE, and special cavities for cartridge installation.', 'visual' => 'custom'),
                array('slug' => 'proportional-valve', 'name' => 'Proportional Valves', 'intro' => 'In-line and subplate proportional valves for pressure, flow, and directional metering outside the cartridge envelope.', 'visual' => 'solenoid'),
                array('slug' => 'solenoid-directional-valve', 'name' => 'Solenoid Directional Valves', 'intro' => 'Two-, three-, and four-way solenoid directional valves for cylinder and motor circuits.', 'visual' => 'directional'),
                array('slug' => 'modular-hydraulic-valve', 'name' => 'Modular Hydraulic Valves', 'intro' => 'Sandwich and modular stack valves for compact CETOP / NG pressure, flow, and check functions.', 'visual' => 'custom'),
                array('slug' => 'pressure-compensated-flow-control-valve', 'name' => 'Pressure Compensated Flow Control Valves', 'intro' => 'Load-independent flow cartridges and in-line valves for stable actuator speed.', 'visual' => 'flow'),
                array('slug' => 'hydraulic-control-valve', 'name' => 'Hydraulic Control Valves', 'intro' => 'Pressure-control families including relief, reducing, and sequence functions.', 'visual' => 'relief'),
                array('slug' => 'logic-valve', 'name' => 'Logic Valves', 'intro' => 'Cartridge logic elements for high-flow directional and pressure logic inside the manifold.', 'visual' => 'cartridge'),
                array('slug' => 'needle-valve', 'name' => 'Needle Valves', 'intro' => 'Fine-thread needle valves for precise metering and isolation at low to medium flow.', 'visual' => 'flow'),
                array('slug' => 'in-line-flow-control-valve', 'name' => 'In-line Flow Control Valves', 'intro' => 'Line-mounted flow controls for machines that cannot accept a screw-in cavity.', 'visual' => 'flow'),
                array('slug' => 'in-line-check-valve', 'name' => 'In-line Check Valves', 'intro' => 'Low-leakage in-line check valves for load holding and reverse-flow isolation.', 'visual' => 'check'),
                array('slug' => 'lifting-valve', 'name' => 'Lifting Valves', 'intro' => 'Load-holding and counterbalance valves for controlled lowering of overrunning loads.', 'visual' => 'counterbalance'),
                array('slug' => 'explosion-proof-valve', 'name' => 'Explosion-proof Valves', 'intro' => 'Solenoid valves with explosion-proof coil and enclosure options for classified atmospheres.', 'visual' => 'solenoid'),
            ),
        ),
        array(
            'slug'   => 'pumps',
            'name'   => 'Pumps',
            'visual' => 'custom',
            'intro'  => 'Gear, vane, and piston pumps specified by pressure class, displacement, and circuit duty.',
            'children' => array(
                array(
                    'slug'  => 'gear-pump',
                    'name'  => 'Gear Pump',
                    'intro' => 'External gear pumps for industrial and mobile auxiliary circuits.',
                    'visual'=> 'custom',
                    'products' => array(
                        array('slug' => 'hcv-gp-single', 'name' => 'Single Gear Pump', 'model' => 'HCV-GP-S', 'pressure' => '250 bar', 'flow' => 'Displacement by order', 'cavity' => 'Flange / SAE', 'visual' => 'custom'),
                        array('slug' => 'hcv-gp-tandem', 'name' => 'Tandem Gear Pump', 'model' => 'HCV-GP-T', 'pressure' => '250 bar', 'flow' => 'Dual displacement', 'cavity' => 'Flange / SAE', 'visual' => 'custom'),
                        array('slug' => 'hcv-gp-divider', 'name' => 'Synchronous Flow Divider', 'model' => 'HCV-GP-FD', 'pressure' => '250 bar', 'flow' => 'Matched outlets', 'cavity' => 'Manifold / line', 'visual' => 'custom'),
                        array('slug' => 'hcv-gp-relief', 'name' => 'Gear Pump with Relief Valve', 'model' => 'HCV-GP-RV', 'pressure' => '250 bar', 'flow' => 'Integrated relief', 'cavity' => 'Flange / SAE', 'visual' => 'relief'),
                        array('slug' => 'hcv-gp-pu', 'name' => 'Chemical Pump (PU)', 'model' => 'HCV-GP-PU', 'pressure' => 'Application', 'flow' => 'Fluid-specific', 'cavity' => 'Flange', 'visual' => 'custom'),
                    ),
                ),
                array('slug' => 'internal-gear-pump', 'name' => 'Internal Gear Pump', 'intro' => 'Quiet internal-gear pumps for industrial power units and continuous-duty stations.', 'visual' => 'custom'),
                array('slug' => 'piston-pump', 'name' => 'Piston Pump', 'intro' => 'Axial piston pumps for higher pressure and variable-displacement industrial circuits.', 'visual' => 'custom'),
                array('slug' => 'piston-motor', 'name' => 'Piston Motor', 'intro' => 'Piston motors matched to piston-pump circuits for rotary work functions.', 'visual' => 'custom'),
                array('slug' => '400bar-vane-pump', 'name' => '400 bar Vane Pump', 'intro' => 'High-pressure vane pumps for 400 bar class industrial duty.', 'visual' => 'custom'),
                array('slug' => 'high-pressure-vane-pump', 'name' => 'High Pressure Vane Pump', 'intro' => 'High-pressure vane pumps for compact power units and machine tools.', 'visual' => 'custom'),
                array('slug' => 'high-pressure-vane-motor', 'name' => 'High Pressure Vane Motor', 'intro' => 'Vane motors for high-pressure rotary drives.', 'visual' => 'custom'),
                array('slug' => '250bar-vane-pump', 'name' => '250 bar Vane Pump', 'intro' => 'Industrial vane pumps for 250 bar continuous class.', 'visual' => 'custom'),
                array('slug' => 'vane-pump', 'name' => 'Vane Pump', 'intro' => 'General industrial vane pumps where low noise and mid-pressure duty are required.', 'visual' => 'custom'),
            ),
        ),
        array(
            'slug'   => 'filters',
            'name'   => 'Filters',
            'visual' => 'flow',
            'intro'  => 'Pressure, return, suction, and indicator products that protect cavities, pumps, and proportional valves from contamination.',
            'children' => array(
                array(
                    'slug'  => 'mega-flow-rate-filter',
                    'name'  => 'Mega Flow Rate Filter',
                    'intro' => 'High-flow filtration assemblies for large power units and return lines.',
                    'visual'=> 'flow',
                    'products' => array(
                        array('slug' => 'hcv-dfm', 'name' => 'DFM Mega Flow Filter', 'model' => 'HCV-DFM', 'pressure' => 'Return line', 'flow' => 'High flow', 'cavity' => 'In-line', 'visual' => 'flow'),
                        array('slug' => 'hcv-dmph', 'name' => 'DMPH Duplex Filter', 'model' => 'HCV-DMPH', 'pressure' => 'Return line', 'flow' => 'High flow', 'cavity' => 'In-line duplex', 'visual' => 'flow'),
                        array('slug' => 'hcv-smph', 'name' => 'SMPH Spin-on Filter', 'model' => 'HCV-SMPH', 'pressure' => 'Return line', 'flow' => 'Medium–high', 'cavity' => 'Spin-on', 'visual' => 'flow'),
                    ),
                ),
                array('slug' => 'aluminum-filter', 'name' => 'Aluminum Filter', 'intro' => 'Lightweight aluminum-bodied filters for mobile and compact industrial circuits.', 'visual' => 'flow'),
                array('slug' => 'super-high-pressure-filter', 'name' => 'Super High Pressure Filter', 'intro' => 'High-pressure filters for 350 bar class pump and valve protection.', 'visual' => 'flow'),
                array('slug' => 'return-line-filter', 'name' => 'Return Line Filter', 'intro' => 'Tank-mounted and in-line return filters for reservoir cleanliness.', 'visual' => 'flow'),
                array('slug' => 'high-pressure-filter', 'name' => 'High Pressure Filter', 'intro' => 'Pressure-line filters specified ahead of proportional and servo valves.', 'visual' => 'flow'),
                array('slug' => 'medium-pressure-filter', 'name' => 'Medium Pressure Filter', 'intro' => 'Medium-pressure filtration for auxiliary and lubrication circuits.', 'visual' => 'flow'),
                array('slug' => 'suction-filter', 'name' => 'Suction Filter', 'intro' => 'Suction strainers and filters protecting pump inlets.', 'visual' => 'flow'),
                array('slug' => 'strainer', 'name' => 'Strainer', 'intro' => 'Coarse strainers for fill points and suction protection.', 'visual' => 'flow'),
                array('slug' => 'pressure-indicator', 'name' => 'Pressure Indicator', 'intro' => 'Visual and electrical clogging indicators for filter maintenance.', 'visual' => 'check'),
            ),
        ),
        array(
            'slug'   => 'accessories',
            'name'   => 'Accessories',
            'visual' => 'check',
            'intro'  => 'Sensing, gauging, and installation accessories that complete a specified hydraulic circuit.',
            'children' => array(
                array('slug' => 'pressure-switch', 'name' => 'Pressure Switch', 'intro' => 'Electromechanical pressure switches for pump unload and safety interlocks.', 'visual' => 'check'),
                array('slug' => 'modular-pressure-switch', 'name' => 'Modular Pressure Switch', 'intro' => 'Stackable modular pressure switches for compact power-unit panels.', 'visual' => 'check'),
                array('slug' => 'oil-level-switch', 'name' => 'Oil Level Switch', 'intro' => 'Reservoir level switches to protect pumps from dry running.', 'visual' => 'check'),
                array('slug' => 'pressure-sensor', 'name' => 'Pressure Sensor', 'intro' => 'Analog and digital pressure transducers for closed-loop and monitoring duty.', 'visual' => 'check'),
                array('slug' => 'pressure-gauge', 'name' => 'Pressure Gauge', 'intro' => 'Industrial pressure gauges for panel and line mounting.', 'visual' => 'check'),
                array('slug' => 'temperature-gauge', 'name' => 'Temperature Gauge', 'intro' => 'Fluid temperature gauges for reservoir and line monitoring.', 'visual' => 'check'),
                array('slug' => '6-stations-pressure-selector', 'name' => '6 Stations Pressure Selector', 'intro' => 'Multi-station pressure selectors for test stands and multi-circuit panels.', 'visual' => 'custom'),
                array('slug' => 'fluid-level-gauge', 'name' => 'Fluid Level Gauge', 'intro' => 'Sight glasses and level gauges for hydraulic reservoirs.', 'visual' => 'check'),
                array('slug' => 'filler-breather-filter', 'name' => 'Filler Breather Filter', 'intro' => 'Combined fill and breather assemblies for tank cleanliness.', 'visual' => 'flow'),
                array('slug' => 'air-breather', 'name' => 'Air Breather', 'intro' => 'Reservoir breathers that limit airborne contamination.', 'visual' => 'flow'),
                array('slug' => 'end-cover', 'name' => 'End Cover', 'intro' => 'Manifold and pump end covers specified to the cavity family.', 'visual' => 'custom'),
                array('slug' => 'gauge-damper', 'name' => 'Gauge Damper', 'intro' => 'Snubbers that protect gauges from pressure spikes.', 'visual' => 'check'),
                array('slug' => 'pipe-clamp', 'name' => 'Pipe Clamp', 'intro' => 'Industrial pipe and hose clamps for vibration control.', 'visual' => 'custom'),
                array('slug' => 'drive-coupling', 'name' => 'Drive Coupling', 'intro' => 'Pump–motor couplings for industrial power units.', 'visual' => 'custom'),
            ),
        ),
        array(
            'slug'   => 'heat-exchangers',
            'name'   => 'Heat Exchangers',
            'visual' => 'custom',
            'intro'  => 'Oil and air heat exchangers sized to keep hydraulic fluid in the specified temperature window.',
            'children' => array(
                array(
                    'slug'  => 'oil-heat-exchanger',
                    'name'  => 'Oil Heat Exchanger',
                    'intro' => 'Shell-and-tube oil coolers for industrial power units.',
                    'visual'=> 'custom',
                    'products' => array(
                        array('slug' => 'hcv-tj', 'name' => 'TJ Hydraulic High Efficiency Type', 'model' => 'HCV-TJ', 'pressure' => 'Circuit dependent', 'flow' => 'High efficiency', 'cavity' => 'Shell & tube', 'visual' => 'custom'),
                        array('slug' => 'hcv-hh', 'name' => 'HH Standard Economic Type', 'model' => 'HCV-HH', 'pressure' => 'Circuit dependent', 'flow' => 'Standard duty', 'cavity' => 'Shell & tube', 'visual' => 'custom'),
                    ),
                ),
                array('slug' => 'air-heat-exchanger', 'name' => 'Air Heat Exchanger', 'intro' => 'Air-oil coolers for plant environments where water is not available.', 'visual' => 'custom'),
                array('slug' => 'air-heat-exchanger-for-mobile', 'name' => 'Air Heat Exchanger for Mobile', 'intro' => 'Compact air-oil coolers for vehicle-mounted hydraulic systems.', 'visual' => 'custom'),
                array('slug' => 'mobile-heat-exchanger-with-tank-and-filter', 'name' => 'Mobile Heat Exchanger with Tank and Filter', 'intro' => 'Integrated cooler, tank, and filter packages for mobile auxiliary circuits.', 'visual' => 'custom'),
            ),
        ),
        array(
            'slug'   => 'specialities',
            'name'   => 'Specialties',
            'visual' => 'custom',
            'intro'  => 'Application-engineered manifolds, seal kits, actuators, and machine-specific control valves.',
            'children' => array(
                array('slug' => 'hydraulic-surface-grinder-control-valve', 'name' => 'Hydraulic Surface Grinder Control Valve', 'intro' => 'Machine-specific control valves for surface grinder hydraulic circuits.', 'visual' => 'directional'),
                array(
                    'slug'  => 'manifold',
                    'name'  => 'Manifold',
                    'intro' => 'Steel and aluminum cartridge manifolds from catalog cavities to custom multi-function blocks.',
                    'visual'=> 'custom',
                    'products' => array(
                        array('slug' => 'hcv-s-006', 'name' => 'Manifold S-006', 'model' => 'HCV-S-006', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                        array('slug' => 'hcv-s-007', 'name' => 'Manifold S-007', 'model' => 'HCV-S-007', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                        array('slug' => 'hcv-m-301-1', 'name' => 'Manifold M-301-1', 'model' => 'HCV-M-301-1', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                        array('slug' => 'hcv-s-101', 'name' => 'Manifold S-101', 'model' => 'HCV-S-101', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                        array('slug' => 'hcv-s-102', 'name' => 'Manifold S-102', 'model' => 'HCV-S-102', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                        array('slug' => 'hcv-k-101', 'name' => 'Manifold K-101', 'model' => 'HCV-K-101', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                        array('slug' => 'hcv-ci-150', 'name' => 'Manifold CI-150', 'model' => 'HCV-CI-150', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                        array('slug' => 'hcv-ci-008', 'name' => 'Manifold CI-008', 'model' => 'HCV-CI-008', 'pressure' => '350 bar', 'flow' => 'Circuit dependent', 'cavity' => 'Custom block', 'visual' => 'custom'),
                    ),
                ),
                array('slug' => 'cartridge-seal-kits', 'name' => 'Cartridge Seal Kits', 'intro' => 'Seal kits specified to cartridge series, fluid, and temperature.', 'visual' => 'check'),
                array('slug' => 'hydraulic-rotary-actuator', 'name' => 'Hydraulic Rotary Actuator', 'intro' => 'Rotary actuators for compact angular motion in industrial machinery.', 'visual' => 'custom'),
            ),
        ),
    );
}

function hc_existing_product_term_map() {
    return array(
        'screw-in-cartridge-valves'   => 'sae-cavity-cartridge-valves',
        'solenoid-cartridge-valves'   => 'solenoid-cartridge-valve',
        'check-valves'                => 'in-line-check-valve',
        'relief-valves'               => 'hydraulic-control-valve',
        'flow-control-valves'         => 'pressure-compensated-flow-control-valve',
        'directional-valves'          => 'solenoid-directional-valve',
        'counterbalance-valves'       => 'lifting-valve',
        'custom-hydraulic-solutions'  => 'manifold',
    );
}
