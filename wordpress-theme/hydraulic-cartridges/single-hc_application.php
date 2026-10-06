<?php
get_header();
$application = hc_application_from_post(get_queried_object());
if (! $application) {
    wp_safe_redirect(hc_applications_url());
    exit;
}

$related = array();
foreach ($application['typicalProducts'] as $slug) {
    $item = hc_get_product_by_slug($slug);
    if ($item) {
        $related[] = $item;
    }
}

hc_page_hero('Application', $application['name'], $application['shortDescription']);
?>
<section class="section">
    <div class="container detail-layout">
        <div class="split-media" style="min-height: 24rem;">
            <img src="<?php echo esc_url($application['image']); ?>" alt="<?php echo esc_attr($application['imageAlt']); ?>" />
        </div>
        <div>
            <p class="eyebrow">Circuit context</p>
            <h2 class="display" style="font-size: 2rem; margin: 0.6rem 0 1rem;">How the valves are used</h2>
            <p><?php echo esc_html(wp_strip_all_tags($application['overview'])); ?></p>
            <div class="hero-actions">
                <?php hc_btn(hc_quote_url(), 'Request a Quote'); ?>
                <?php hc_btn(hc_products_url(), 'Browse products', 'outline'); ?>
            </div>
        </div>
    </div>
</section>
<section class="section" style="padding-top: 0;">
    <div class="container detail-layout">
        <div>
            <h2 class="display" style="font-size: 1.8rem; margin-bottom: 1rem;">Typical challenges</h2>
            <ul class="highlight-list">
                <?php foreach ($application['challenges'] as $i => $item) : ?>
                    <li><span>0<?php echo esc_html((string) ($i + 1)); ?></span><?php echo esc_html($item); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h2 class="display" style="font-size: 1.8rem; margin-bottom: 1rem;">Engineering response</h2>
            <ul class="highlight-list">
                <?php foreach ($application['solutions'] as $i => $item) : ?>
                    <li><span>0<?php echo esc_html((string) ($i + 1)); ?></span><?php echo esc_html($item); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
<section class="section" style="padding-top: 0;">
    <div class="container">
        <h2 class="display" style="font-size: 2rem; margin-bottom: 1.5rem;">Typical products</h2>
        <div class="related-grid">
            <?php foreach ($related as $product) : ?>
                <?php hc_product_card($product); ?>
            <?php endforeach; ?>
        </div>
        <p style="margin-top: 1.5rem;">
            <a href="<?php echo esc_url(hc_applications_url()); ?>">All applications</a>
        </p>
    </div>
</section>
<?php
get_footer();
