<?php
/**
 * Template Name: Request a Quote
 */

get_header();
$products = hc_get_products();
$preset   = isset($_GET['product']) ? sanitize_text_field(wp_unslash($_GET['product'])) : '';
$from_cart = isset($_GET['from']) && 'cart' === sanitize_key(wp_unslash($_GET['from']));
$cart_items = $from_cart ? hc_cart_items() : array();
if ($cart_items && ! $preset) {
    $preset = $cart_items[0]['slug'];
}
$cart_note = '';
foreach ($cart_items as $line) {
    $cart_note .= $line['qty'] . ' × ' . $line['name'] . ($line['model'] ? ' (' . $line['model'] . ')' : '') . "\n";
}
hc_page_hero(
    'Request a quote',
    'Tell us the circuit. We will answer with a cartridge.',
    $from_cart
        ? 'Your cart series are listed below. Confirm application details so the desk can quote.'
        : 'Frontend validation only — there is no server submission in this phase. A success state confirms the form is complete.'
);
?>
<section class="section">
    <div class="container" style="max-width: 52rem;">
        <div class="success-panel" data-quote-success hidden>
            <h2>Request ready for review</h2>
            <p>
                Thank you, <span data-quote-name></span>. The quotation packet for <span data-quote-company></span> has been captured
                in this browser session only. A production build will send it to the manufacturer
                desk.
            </p>
            <p style="margin-top: 1rem; color: var(--steel);">
                Product: <span data-quote-product></span> · Qty: <span data-quote-qty></span> · <span data-quote-country></span>
            </p>
        </div>
        <form class="form-grid two" data-quote-form method="post" novalidate>
            <?php wp_nonce_field('hc_quote', 'hc_quote_nonce'); ?>
            <div class="field" data-field="name">
                <label for="quote-name">Name</label>
                <input id="quote-name" name="name" minlength="2" maxlength="35" autocomplete="name" />
            </div>
            <div class="field" data-field="company">
                <label for="quote-company">Company</label>
                <input id="quote-company" name="company" autocomplete="organization" />
            </div>
            <div class="field" data-field="email">
                <label for="quote-email">Email</label>
                <input id="quote-email" name="email" type="email" autocomplete="email" />
            </div>
            <div class="field" data-field="phone">
                <label for="quote-phone">Phone</label>
                <input id="quote-phone" name="phone" autocomplete="tel" />
            </div>
            <div class="field" data-field="country">
                <label for="quote-country">Country</label>
                <input id="quote-country" name="country" autocomplete="country-name" />
            </div>
            <div class="field" data-field="product">
                <label for="quote-product">Product / Category</label>
                <select id="quote-product" name="product">
                    <option value="">Select a family</option>
                    <?php foreach ($products as $item) : ?>
                        <option value="<?php echo esc_attr($item['slug']); ?>" <?php selected($preset, $item['slug']); ?>>
                            <?php echo esc_html($item['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field" data-field="quantity">
                <label for="quote-quantity">Quantity</label>
                <input id="quote-quantity" name="quantity" inputmode="numeric" />
            </div>
            <div class="field" data-field="application">
                <label for="quote-application">Application</label>
                <input id="quote-application" name="application" />
            </div>
            <div class="field full" data-field="message">
                <label for="quote-message">Message</label>
                <textarea id="quote-message" name="message" minlength="1" placeholder="Pressure, flow, cavity code, fluid, and duty cycle."><?php echo esc_textarea($cart_note ? "Cart lines:\n" . $cart_note : ''); ?></textarea>
            </div>
            <div>
                <button class="btn" type="submit">Submit request</button>
            </div>
        </form>
    </div>
</section>
<?php
get_footer();
