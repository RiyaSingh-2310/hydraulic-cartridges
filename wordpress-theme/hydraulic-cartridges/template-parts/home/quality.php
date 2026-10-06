<?php
$images  = hc_images();
$quality = $images['quality'] ?? array('src' => '', 'alt' => '');
?>
<section class="section">
    <div class="container quality-grid">
        <?php hc_reveal_open(); ?>
            <div class="split-media tech-frame" style="min-height: 28rem;">
                <img src="<?php echo esc_url($quality['src']); ?>" alt="<?php echo esc_attr($quality['alt']); ?>" loading="lazy" />
                <span class="tech-label" style="left: 1rem; top: 1rem;">QA · LINE</span>
            </div>
        <?php hc_reveal_close(); ?>
        <?php hc_reveal_open(0.08); ?>
            <p class="eyebrow">Quality</p>
            <h2 class="display">Built to perform. Tested to endure.</h2>
            <p class="lede">
                Consistency is not a slogan on this floor. Geometry, materials, and functional tests are
                treated as one manufacturing sequence.
            </p>
            <div class="quality-points">
                <div>
                    <strong>Assurance</strong>
                    <p>Inspection points sit inside production, aligned with ISO 9001 compliant practice.</p>
                </div>
                <div>
                    <strong>Machining</strong>
                    <p>Cavity threads, sealing lands, and seats are finished for repeatable cartridge fit.</p>
                </div>
                <div>
                    <strong>Testing</strong>
                    <p>Catalog units are functionally tested. Custom circuits receive application validation.</p>
                </div>
                <div>
                    <strong>Materials</strong>
                    <p>Hardened internals and industrial seal options specified to fluid and temperature.</p>
                </div>
            </div>
        <?php hc_reveal_close(); ?>
    </div>
</section>
