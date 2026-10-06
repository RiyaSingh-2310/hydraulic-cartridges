<?php
$images = hc_images();
$hero   = $images['hero'] ?? array('src' => '', 'alt' => '');
?>
<section class="hero" aria-label="Introduction">
    <div class="hero-media">
        <img
            src="<?php echo esc_url($hero['src']); ?>"
            alt="<?php echo esc_attr($hero['alt']); ?>"
            fetchpriority="high"
            width="2200"
            height="1400"
        />
        <div class="hero-shade"></div>
    </div>
    <div class="container-wide hero-content">
        <div class="hero-copy">
            <p class="eyebrow">Precision hydraulic engineering</p>
            <h1 class="display">Cartridge valves. Measured to the cavity.</h1>
            <p class="lede">
                Direct-from-manufacturer screw-in cartridges and custom manifolds for continuous-duty
                350-bar industrial equipment — specified, machined, and tested as a complete fluid-power
                component.
            </p>
            <div class="hero-actions">
                <?php hc_btn(hc_products_url(), 'Explore Products'); ?>
                <?php hc_btn(hc_quote_url(), 'Request a Quote', 'ghost'); ?>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <span>350 bar</span>
                <small>Continuous operating class</small>
            </div>
            <div class="hero-stat">
                <span>ISO 9001</span>
                <small>Compliant manufacturing</small>
            </div>
            <div class="hero-stat">
                <span>100%</span>
                <small>Catalog units functionally tested</small>
            </div>
        </div>
    </div>
</section>
