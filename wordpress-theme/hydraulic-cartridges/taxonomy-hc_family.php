<?php
/**
 * Product family / group archive.
 */

get_header();
$term = get_queried_object();
if (! $term || is_wp_error($term)) {
    wp_safe_redirect(hc_products_url());
    exit;
}

$is_group = (int) $term->parent > 0;
$family   = $is_group ? get_term((int) $term->parent, hc_family_taxonomy()) : $term;
$group    = $is_group ? $term : null;
$children = $is_group ? array() : hc_get_family_terms($term->term_id);
$intro    = hc_term_intro($term);

$eyebrow = $is_group && $family && ! is_wp_error($family) ? hc_public_label($family->name, $family->slug) : 'Catalog';
$crumbs  = array(
    array('label' => 'Home', 'url' => home_url('/')),
    array('label' => 'Products', 'url' => hc_products_url()),
);
if ($is_group && $family && ! is_wp_error($family)) {
    $crumbs[] = array('label' => hc_public_label($family->name, $family->slug), 'url' => hc_family_link($family));
}
$crumbs[] = array('label' => hc_public_label($term->name, $term->slug), 'url' => '');
hc_page_hero($eyebrow, hc_public_label($term->name, $term->slug), $intro, $is_group, $crumbs);
?>
<section class="section">
    <div class="container catalog-shell">
        <?php
        get_template_part(
            'template-parts/catalog/sidebar',
            null,
            array(
                'family' => ($family && ! is_wp_error($family)) ? $family : $term,
                'group'  => $group,
            )
        );
        ?>
        <div class="catalog-main">
            <?php if ($children) : ?>
                <div class="family-grid">
                    <?php foreach ($children as $child) : ?>
                        <?php hc_family_card($child); ?>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <?php $products = hc_products_in_term($term, false); ?>
                <?php if ($products) : ?>
                    <div class="product-grid">
                        <?php foreach ($products as $product) : ?>
                            <?php hc_listing_card($product); ?>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="notice">No published series in this group yet. Request a quotation for application-specific units.</p>
                <?php endif; ?>
            <?php endif; ?>
            <?php
            get_template_part(
                'template-parts/catalog/related-ranges',
                null,
                array('current' => ($family && ! is_wp_error($family)) ? $family : $term)
            );
            ?>
        </div>
    </div>
</section>
<?php
get_footer();
