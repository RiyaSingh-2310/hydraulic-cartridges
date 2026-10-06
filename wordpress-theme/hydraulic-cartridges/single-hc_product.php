<?php
/**
 * Single product.
 */

get_header();
$product = hc_product_from_post(get_queried_object());
if (! $product) {
    wp_safe_redirect(hc_products_url());
    exit;
}

$related = array();
foreach ($product['relatedSlugs'] as $slug) {
    $item = hc_get_product_by_slug($slug);
    if ($item) {
        $related[] = $item;
    }
}

$images = hc_images();
$captions = $product['galleryCaptions'];
$gallery_payload = array(
    array('src' => '', 'alt' => $captions[0] ?? $product['name']),
    array('src' => $images['machining']['src'] ?? '', 'alt' => $captions[1] ?? ''),
    array('src' => $images['testing']['src'] ?? '', 'alt' => $captions[2] ?? ''),
);

hc_page_hero($product['category'], $product['name'], $product['shortDescription'], true);
?>
<section class="section">
    <div class="container detail-layout">
        <div
            class="gallery"
            data-gallery="<?php echo esc_attr(wp_json_encode($gallery_payload)); ?>"
        >
            <div class="gallery-main" aria-live="polite" data-gallery-main>
                <div style="width: 80%;">
                    <?php hc_product_visual($product['visual'], $product['name']); ?>
                </div>
            </div>
            <div data-gallery-drawing hidden>
                <div style="width: 80%;">
                    <?php hc_product_visual($product['visual'], $product['name']); ?>
                </div>
            </div>
            <div class="gallery-thumbs">
                <?php foreach ($captions as $i => $caption) : ?>
                    <button type="button" class="<?php echo 0 === $i ? 'active' : ''; ?>" data-gallery-thumb>
                        <?php echo esc_html($caption); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <p class="eyebrow"><?php echo esc_html($product['model']); ?></p>
            <h2 class="display" style="font-size: 2.2rem; margin: 0.6rem 0 1rem;">Overview</h2>
            <p><?php echo esc_html(wp_strip_all_tags($product['overview'])); ?></p>
            <div class="spec-pills" style="margin-top: 1.5rem;">
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
            <div class="hero-actions">
                <?php hc_btn(hc_quote_url($product['slug']), 'Request Quote'); ?>
                <?php hc_btn(hc_page_url('contact'), 'Speak to engineering', 'outline'); ?>
            </div>
        </div>
    </div>
</section>
<section class="section" style="padding-top: 0;">
    <div class="container detail-layout">
        <div>
            <h2 class="display" style="font-size: 2rem;">Technical information</h2>
            <table class="spec-table">
                <tbody>
                    <?php foreach ($product['technical'] as $row) : ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($row['label'] ?? ''); ?></th>
                            <td><?php echo esc_html($row['value'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="notice">
                Specification documents are placeholders in this frontend catalog. Confirm ratings
                during quotation.
            </p>
        </div>
        <div>
            <h2 class="display" style="font-size: 2rem;">Features</h2>
            <ul class="highlight-list">
                <?php foreach ($product['features'] as $i => $feature) : ?>
                    <li><span>0<?php echo esc_html((string) ($i + 1)); ?></span><?php echo esc_html($feature); ?></li>
                <?php endforeach; ?>
            </ul>
            <h2 class="display" style="font-size: 1.6rem; margin-top: 2rem;">Typical applications</h2>
            <p style="margin-top: 0.75rem; color: var(--steel);">
                <?php echo esc_html(implode(' · ', $product['applications'])); ?>
            </p>
        </div>
    </div>
</section>
<section class="section" style="padding-top: 0;">
    <div class="container">
        <h2 class="display" style="font-size: 2rem; margin-bottom: 1.5rem;">Related products</h2>
        <div class="related-grid">
            <?php foreach ($related as $item) : ?>
                <?php hc_product_card($item); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
get_footer();
