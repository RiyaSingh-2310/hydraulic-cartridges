<?php
$product = hc_get_featured_product();
if (! $product) {
    return;
}
?>
<section class="section featured">
    <div class="container featured-grid">
        <?php hc_reveal_open(); ?>
            <div class="featured-visual">
                <?php hc_product_visual($product['visual'], $product['name']); ?>
                <span class="tech-label" style="left: 1rem; top: 1rem;"><?php echo esc_html($product['model']); ?></span>
                <span class="tech-label" style="right: 1rem; bottom: 1rem;"><?php echo esc_html($product['cavity']); ?></span>
            </div>
        <?php hc_reveal_close(); ?>
        <?php hc_reveal_open(0.08, 'featured-copy'); ?>
            <p class="eyebrow"><?php echo esc_html($product['category']); ?></p>
            <h2 class="display"><?php echo esc_html($product['name']); ?></h2>
            <p><?php echo esc_html(wp_strip_all_tags($product['overview'])); ?></p>
            <div class="spec-pills">
                <div>
                    <small>Pressure</small>
                    <strong><?php echo esc_html($product['pressure']); ?></strong>
                </div>
                <div>
                    <small>Flow</small>
                    <strong><?php echo esc_html($product['flow']); ?></strong>
                </div>
                <div>
                    <small>Cavity</small>
                    <strong><?php echo esc_html($product['cavity']); ?></strong>
                </div>
            </div>
            <ul class="highlight-list">
                <?php foreach (array_slice($product['features'], 0, 3) as $i => $feature) : ?>
                    <li><span>0<?php echo esc_html((string) ($i + 1)); ?></span><?php echo esc_html($feature); ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="hero-actions">
                <?php hc_btn($product['permalink'], 'View Details'); ?>
                <?php hc_btn(hc_quote_url(), 'Request Quote', 'ghost'); ?>
            </div>
        <?php hc_reveal_close(); ?>
    </div>
</section>
