<?php
/**
 * Template Name: Cart
 */

get_header();
$items = hc_cart_items();
$proceed = is_user_logged_in()
    ? add_query_arg('from', 'cart', hc_quote_url())
    : hc_account_url(array(
        'redirect_to' => add_query_arg('from', 'cart', hc_quote_url()),
        'notice'      => 'login-cart',
    ));

hc_page_hero(
    'Catalog',
    'Your cart',
    $items
        ? 'Review series quantities, then continue to a quotation request. Prices are confirmed by the engineering desk.'
        : 'Your quotation cart is empty.'
);
?>
<section class="section">
    <div class="container" style="max-width: 58rem;">
        <?php if (! $items) : ?>
            <p class="notice">Add catalog series from a product page, then return here to request a quote.</p>
            <div class="hero-actions" style="margin-top: 1.25rem;">
                <?php hc_btn(hc_products_url(), 'Continue shopping'); ?>
            </div>
        <?php else : ?>
            <div class="cart-table">
                <?php foreach ($items as $item) : ?>
                    <article class="cart-row">
                        <div class="cart-visual"><?php hc_product_visual($item['visual'], $item['name']); ?></div>
                        <div>
                            <p class="meta"><?php echo esc_html(($item['model'] ? $item['model'] . ' · ' : '') . $item['category']); ?></p>
                            <h3><a href="<?php echo esc_url($item['permalink']); ?>"><?php echo esc_html($item['name']); ?></a></h3>
                        </div>
                        <div class="qty-control" data-qty>
                            <button type="button" class="qty-btn" data-qty-minus aria-label="Decrease quantity">−</button>
                            <input
                                class="qty-input"
                                data-qty-input
                                data-cart-update
                                data-product-id="<?php echo esc_attr((string) $item['id']); ?>"
                                type="number"
                                min="1"
                                value="<?php echo esc_attr((string) $item['qty']); ?>"
                            />
                            <button type="button" class="qty-btn" data-qty-plus aria-label="Increase quantity">+</button>
                        </div>
                        <p class="cart-price"><?php echo esc_html($item['price']); ?></p>
                        <button type="button" class="cart-remove" data-cart-remove data-product-id="<?php echo esc_attr((string) $item['id']); ?>">Remove</button>
                    </article>
                <?php endforeach; ?>
            </div>
            <aside class="cart-summary">
                <p><strong><?php echo esc_html((string) hc_cart_count()); ?></strong> line items · Total: quotation on request</p>
                <p class="notice">This catalog does not take online payment. Checkout continues as a quotation request.</p>
                <div class="cart-actions">
                    <?php hc_btn(hc_products_url(), 'Continue shopping', 'outline'); ?>
                    <?php hc_btn($proceed, is_user_logged_in() ? 'Proceed to request quote' : 'Proceed — sign in to continue'); ?>
                </div>
            </aside>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
