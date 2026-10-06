<?php
/**
 * Products archive.
 */

get_header();
hc_page_hero(
    'Catalog',
    'Hydraulic cartridge families',
    'Screw-in valves for pressure, flow, direction, and load control — plus custom cavities when a standard ISO interface is not enough.'
);
$products = hc_get_products();
?>
<section class="section">
    <div class="container product-grid">
        <?php foreach ($products as $index => $product) : ?>
            <?php hc_product_card($product, $index); ?>
        <?php endforeach; ?>
    </div>
</section>
<?php
get_footer();
