<?php
/**
 * Template Name: Wishlist
 */

get_header();
$items = hc_wishlist_items();
hc_page_hero(
    'Saved',
    'Wishlist',
    $items
        ? 'Keep series here, then move them into the quotation cart when you are ready to specify.'
        : 'Your wishlist is empty.'
);
?>
<section class="section" data-wishlist-page>
    <div class="container">
        <?php if (! $items) : ?>
            <p class="notice">Save products with the heart icon on any series card or product page.</p>
            <div class="hero-actions" style="margin-top: 1.25rem;">
                <?php hc_btn(hc_products_url(), 'Browse products'); ?>
            </div>
        <?php else : ?>
            <div class="product-grid">
                <?php foreach ($items as $product) : ?>
                    <?php hc_product_card($product); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
