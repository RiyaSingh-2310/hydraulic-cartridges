<?php
$products = array_slice(hc_get_products(), 0, 8);
if (! $products) {
    return;
}
?>
<section class="section" aria-labelledby="featured-products-title">
    <div class="container">
        <?php
        hc_section_header(
            'Featured products',
            'Specify from the catalog',
            'Add a series to your cart or wishlist. Ratings and pricing are confirmed when you request a quotation.',
            true
        );
        ?>
        <div class="product-grid">
            <?php foreach ($products as $product) : ?>
                <?php hc_listing_card($product); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
