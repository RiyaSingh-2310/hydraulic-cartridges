<?php
$images = hc_images();
$intro  = $images['intro'] ?? array('src' => '', 'alt' => '');
?>
<section class="section">
    <div class="container intro-grid">
        <?php hc_reveal_open(); ?>
            <p class="eyebrow">Engineering without compromise</p>
            <h2 class="display">Built for circuits that cannot afford a weak cavity.</h2>
        <?php hc_reveal_close(); ?>
        <?php hc_reveal_open(0.08); ?>
            <div class="intro-copy">
                <p>
                    Hydraulic Cartridges supplies screw-in valves, solenoid functions, and custom manifold
                    components to machinery builders who need a manufacturer — not a catalog reseller.
                </p>
                <p>
                    The work is industrial and specific: ISO and SAE cavities, 350-bar continuous class,
                    and application review before a part number is locked. If the envelope is non-standard,
                    the cartridge is engineered to the block, not the other way around.
                </p>
            </div>
            <div class="tech-frame split-media" style="margin-top: 1.75rem; min-height: 16rem;">
                <img src="<?php echo esc_url($intro['src']); ?>" alt="<?php echo esc_attr($intro['alt']); ?>" loading="lazy" />
                <span class="tech-label" style="left: 0.9rem; top: 0.9rem;">INSP · 01</span>
                <span class="tech-label" style="right: 0.9rem; bottom: 0.9rem;">MANIFOLD INTERFACE</span>
            </div>
        <?php hc_reveal_close(); ?>
    </div>
</section>
