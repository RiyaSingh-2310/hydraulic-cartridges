<?php
/**
 * Template Name: About
 */

get_header();
$images       = hc_images();
$about        = $images['about'] ?? array('src' => '', 'alt' => '');
$capabilities = hc_get_capabilities();
hc_page_hero(
    'About Hydraulic Cartridges',
    'Manufacturer first. Catalog second.',
    'The company is organized around machining, application engineering, and tested cartridges for industrial OEMs — not around a storefront of unrelated parts.'
);
?>
<section class="section">
    <div class="container about-editorial">
        <div>
            <p class="eyebrow">Philosophy</p>
            <h2 class="display" style="font-size: var(--display-sm); margin: 0.7rem 0 1rem;">
                Specify the cavity. Then cut the metal.
            </h2>
            <p>
                Hydraulic Cartridges is a direct-from-manufacturer source for screw-in valves and custom
                manifold components. The published industrial class is 350 bar continuous, with ISO 9001
                compliant manufacturing practice.
            </p>
            <p style="margin-top: 1rem; color: var(--steel);">
                Engineering support exists to read the duty cycle before a part number is promised.
                Customer focus means quoting what can be made and tested — including custom cavities
                from CAD when catalog geometry will not sit in the block.
            </p>
            <div class="counter-row">
                <div>
                    <strong>350</strong>
                    <span>Bar class</span>
                </div>
                <div>
                    <strong>ISO</strong>
                    <span>9001 practice</span>
                </div>
                <div>
                    <strong>100%</strong>
                    <span>Catalog tested</span>
                </div>
            </div>
        </div>
        <div class="split-media" style="min-height: 28rem;">
            <img src="<?php echo esc_url($about['src']); ?>" alt="<?php echo esc_attr($about['alt']); ?>" />
        </div>
    </div>
</section>
<section class="section capabilities">
    <div class="container">
        <h2 class="display" style="font-size: var(--display-sm); margin-bottom: 2rem;">
            How the company works
        </h2>
        <div class="cap-grid">
            <?php foreach ($capabilities as $item) : ?>
                <article class="cap-item">
                    <p class="idx"><?php echo esc_html($item['index']); ?></p>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
        <p style="margin-top: 2rem; color: var(--steel);">
            Enquiries: <?php echo esc_html(hc_company('email')); ?> · <?php echo esc_html(hc_company('phone')); ?>
        </p>
    </div>
</section>
<?php
get_footer();
