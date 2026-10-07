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

$terms  = hc_product_family_terms($product['id']);
$family = $terms['family'];
$group  = $terms['group'];

if ($group && count($related) < 4) {
    foreach (hc_products_in_term($group, false) as $item) {
        if ($item['id'] === $product['id']) {
            continue;
        }
        $related[] = $item;
        if (count($related) >= 4) {
            break;
        }
    }
}

$seen = array();
foreach ($related as $item) {
    $seen[$item['id']] = true;
}
$accessories_term = get_term_by('slug', 'accessories', hc_family_taxonomy());
if ($accessories_term && ! is_wp_error($accessories_term) && (! $family || $family->slug !== 'accessories')) {
    $added = 0;
    foreach (hc_products_in_term($accessories_term, true) as $item) {
        if (! empty($seen[$item['id']])) {
            continue;
        }
        $related[] = $item;
        $seen[$item['id']] = true;
        $added++;
        if ($added >= 2) {
            break;
        }
    }
}

$images = hc_images();
$captions = $product['galleryCaptions'] ?: array('Series drawing', 'Machining reference', 'Functional test');
$gallery_payload = array(
    array('src' => '', 'alt' => $captions[0] ?? $product['name']),
    array('src' => $images['machining']['src'] ?? '', 'alt' => $captions[1] ?? ''),
    array('src' => $images['testing']['src'] ?? '', 'alt' => $captions[2] ?? ''),
);

$downloads = $product['downloads'];
if (! $downloads) {
    $downloads = array(
        array('title' => 'Product Datasheet', 'type' => 'PDF · Placeholder'),
        array('title' => 'Technical Drawing', 'type' => 'DWG · Placeholder'),
        array('title' => 'Installation Notes', 'type' => 'PDF · Placeholder'),
    );
}

$crumbs = array(
    array('label' => 'Home', 'url' => home_url('/')),
    array('label' => 'Products', 'url' => hc_products_url()),
);
if ($family) {
    $crumbs[] = array('label' => $family->name, 'url' => hc_family_link($family));
}
if ($group) {
    $crumbs[] = array('label' => $group->name, 'url' => hc_family_link($group));
}
$crumbs[] = array('label' => $product['name'], 'url' => '');

hc_page_hero($product['category'] ?: 'Product', $product['name'], $product['shortDescription'], true, $crumbs);
?>
<section class="section">
    <div class="container catalog-shell">
        <?php
        get_template_part(
            'template-parts/catalog/sidebar',
            null,
            array(
                'family' => $family,
                'group'  => $group,
            )
        );
        ?>
        <div class="catalog-main">
            <div class="detail-layout">
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
                    <?php if ($product['model']) : ?>
                        <p class="eyebrow"><?php echo esc_html($product['model']); ?></p>
                    <?php endif; ?>
                    <h2 class="display" style="font-size: 2.2rem; margin: 0.6rem 0 1rem;">Overview</h2>
                    <p><?php echo esc_html(wp_strip_all_tags($product['overview'])); ?></p>
                    <div class="spec-pills" style="margin-top: 1.5rem;">
                        <div>
                            <small>Pressure</small>
                            <strong><?php echo esc_html($product['pressure'] ?: '—'); ?></strong>
                        </div>
                        <div>
                            <small>Flow</small>
                            <strong><?php echo esc_html($product['flow'] ?: '—'); ?></strong>
                        </div>
                        <div>
                            <small>Interface</small>
                            <strong><?php echo esc_html($product['cavity'] ?: '—'); ?></strong>
                        </div>
                    </div>
                    <div class="detail-buy">
                        <?php hc_qty_control(1); ?>
                        <div class="hero-actions" data-product-actions>
                            <?php hc_add_to_cart_button($product); ?>
                            <?php hc_btn(hc_quote_url($product['slug']), 'Request a Quote', 'outline'); ?>
                            <?php hc_btn(hc_page_url('contact'), 'Speak to engineering', 'ghost'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-layout catalog-blocks">
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
                        Specification documents are placeholders in this catalog. Confirm ratings
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
                    <?php if ($product['applications']) : ?>
                        <h2 class="display" style="font-size: 1.6rem; margin-top: 2rem;">Typical applications</h2>
                        <p style="margin-top: 0.75rem; color: var(--steel);">
                            <?php echo esc_html(implode(' · ', $product['applications'])); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (! empty($product['accessories'])) : ?>
                <div class="catalog-block">
                    <h2 class="display" style="font-size: 1.8rem;">Accessories</h2>
                    <ul class="highlight-list">
                        <?php foreach ($product['accessories'] as $i => $acc) : ?>
                            <li><span>0<?php echo esc_html((string) ($i + 1)); ?></span><?php echo esc_html(is_array($acc) ? ($acc['title'] ?? '') : $acc); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="catalog-block">
                <h2 class="display" style="font-size: 1.8rem;">Downloads</h2>
                <div class="download-grid">
                    <?php foreach ($downloads as $file) : ?>
                        <div class="download-card">
                            <span><?php echo esc_html($file['type'] ?? 'Placeholder'); ?></span>
                            <h3><?php echo esc_html($file['title'] ?? 'Document'); ?></h3>
                            <p>File delivery is connected at quotation. This card reserves the download slot.</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($related) : ?>
                <div class="catalog-block">
                    <h2 class="display" style="font-size: 2rem; margin-bottom: 1.5rem;">Related products</h2>
                    <div class="related-grid">
                        <?php foreach ($related as $item) : ?>
                            <?php hc_product_card($item); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            get_template_part(
                'template-parts/catalog/related-ranges',
                null,
                array('current' => $family)
            );
            ?>
        </div>
    </div>
</section>
<?php
get_footer();
