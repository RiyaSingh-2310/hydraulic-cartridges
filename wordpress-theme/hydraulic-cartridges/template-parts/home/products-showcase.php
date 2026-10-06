<?php $products = hc_get_products(); ?>
<section class="section" style="padding-top: 0;">
    <div class="container">
        <?php
        hc_section_header(
            'Product families',
            'Precision mechanical components',
            'Standard and custom fluid-power assemblies engineered to ISO cavity specifications — with custom work when the circuit demands it.',
            true
        );
        ?>
        <div class="product-grid">
            <?php foreach ($products as $index => $product) : ?>
                <?php hc_reveal_open($index * 0.04); ?>
                    <?php hc_product_card($product, $index); ?>
                <?php hc_reveal_close(); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
