<?php
/**
 * Quote cart, account URLs, and AJAX — quotation catalog, not payments.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', 'hc_ensure_commerce_pages', 40);
add_action('wp_ajax_hc_cart', 'hc_ajax_cart');
add_action('wp_ajax_nopriv_hc_cart', 'hc_ajax_cart');
add_action('wp_ajax_hc_wishlist', 'hc_ajax_wishlist');
add_action('wp_ajax_nopriv_hc_wishlist', 'hc_ajax_wishlist');
add_action('wp_login', 'hc_cart_merge_on_login', 10, 2);
add_action('wp_login', 'hc_wishlist_merge_on_login', 10, 2);
add_action('pre_get_posts', 'hc_product_search_query');

function hc_cart_url() {
    return hc_page_url('cart');
}

function hc_account_url($args = array()) {
    $url = hc_page_url('account');
    return $args ? add_query_arg($args, $url) : $url;
}

function hc_show_catalog_bar() {
    return true;
}

function hc_wishlist_url() {
    return hc_page_url('wishlist');
}

function hc_checkout_url() {
    $quote = add_query_arg('from', 'cart', hc_quote_url());
    if (is_user_logged_in()) {
        return $quote;
    }
    return hc_account_url(array(
        'redirect_to' => $quote,
        'notice'      => 'login-cart',
    ));
}

function hc_ensure_commerce_pages() {
    $pages = array(
        'cart'     => array('Cart', 'page-templates/page-cart.php', 'Review items before requesting a quotation.'),
        'account'  => array('Account', 'page-templates/page-account.php', 'Sign in to continue with your quotation cart.'),
        'wishlist' => array('Wishlist', 'page-templates/page-wishlist.php', 'Products saved for a later quotation.'),
    );
    if (get_option('hc_commerce_pages') === '1' && get_page_by_path('wishlist') && get_page_by_path('cart') && get_page_by_path('account')) {
        return;
    }
    foreach ($pages as $slug => $cfg) {
        $existing = get_page_by_path($slug);
        if ($existing) {
            update_post_meta($existing->ID, '_wp_page_template', $cfg[1]);
            continue;
        }
        $id = wp_insert_post(array(
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $cfg[0],
            'post_name'    => $slug,
            'post_excerpt' => $cfg[2],
        ));
        if (! is_wp_error($id) && $id) {
            update_post_meta($id, '_wp_page_template', $cfg[1]);
        }
    }
    update_option('hc_commerce_pages', '1');
}

function hc_cart_cookie_path() {
    return defined('COOKIEPATH') && COOKIEPATH ? COOKIEPATH : '/';
}

function hc_cart_get_raw() {
    if (is_user_logged_in()) {
        $cart = get_user_meta(get_current_user_id(), '_hc_cart', true);
        if (is_array($cart)) {
            return $cart;
        }
    }
    if (empty($_COOKIE['hc_cart'])) {
        return array();
    }
    $decoded = json_decode(wp_unslash($_COOKIE['hc_cart']), true);
    return is_array($decoded) ? $decoded : array();
}

function hc_cart_save($cart) {
    $clean = array();
    foreach ($cart as $id => $qty) {
        $id  = (int) $id;
        $qty = max(1, min(999, (int) $qty));
        if ($id > 0) {
            $clean[ $id ] = $qty;
        }
    }
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), '_hc_cart', $clean);
    }
    setcookie(
        'hc_cart',
        wp_json_encode($clean),
        time() + MONTH_IN_SECONDS,
        hc_cart_cookie_path(),
        COOKIE_DOMAIN,
        is_ssl(),
        true
    );
    $_COOKIE['hc_cart'] = wp_json_encode($clean);
    return $clean;
}

function hc_cart_count($cart = null) {
    $cart  = null === $cart ? hc_cart_get_raw() : $cart;
    $total = 0;
    foreach ($cart as $qty) {
        $total += (int) $qty;
    }
    return $total;
}

function hc_cart_items($cart = null) {
    $cart  = null === $cart ? hc_cart_get_raw() : $cart;
    $items = array();
    foreach ($cart as $id => $qty) {
        $product = hc_product_from_post((int) $id);
        if (! $product) {
            continue;
        }
        ob_start();
        hc_product_visual($product['visual'], $product['name']);
        $visual = ob_get_clean();
        $items[] = array(
            'id'         => $product['id'],
            'slug'       => $product['slug'],
            'name'       => $product['name'],
            'model'      => $product['model'],
            'category'   => $product['category'],
            'permalink'  => $product['permalink'],
            'visual'     => $product['visual'],
            'visualHtml' => $visual,
            'qty'        => (int) $qty,
            'price'      => 'On request',
        );
    }
    return $items;
}

function hc_cart_payload($cart = null) {
    $cart = null === $cart ? hc_cart_get_raw() : $cart;
    return array(
        'count' => hc_cart_count($cart),
        'items' => hc_cart_items($cart),
    );
}

function hc_ajax_cart() {
    check_ajax_referer('hc_commerce', 'nonce');
    $action = sanitize_key(wp_unslash($_POST['cart_action'] ?? 'get'));
    $cart   = hc_cart_get_raw();
    $id     = (int) ($_POST['product_id'] ?? 0);
    $qty    = isset($_POST['qty']) ? (int) $_POST['qty'] : 1;

    if ('add' === $action && $id) {
        $post = get_post($id);
        if (! $post || 'hc_product' !== $post->post_type || 'publish' !== $post->post_status) {
            wp_send_json_error(array('message' => 'Product not found.'), 404);
        }
        $cart[ $id ] = (isset($cart[ $id ]) ? (int) $cart[ $id ] : 0) + max(1, $qty);
        $cart        = hc_cart_save($cart);
    } elseif ('update' === $action && $id) {
        if ($qty < 1) {
            unset($cart[ $id ]);
        } else {
            $cart[ $id ] = $qty;
        }
        $cart = hc_cart_save($cart);
    } elseif ('remove' === $action && $id) {
        unset($cart[ $id ]);
        $cart = hc_cart_save($cart);
    } elseif ('clear' === $action) {
        $cart = hc_cart_save(array());
    }

    wp_send_json_success(hc_cart_payload($cart));
}

function hc_wishlist_get_raw() {
    if (is_user_logged_in()) {
        $list = get_user_meta(get_current_user_id(), '_hc_wishlist', true);
        if (is_array($list)) {
            return $list;
        }
    }
    if (empty($_COOKIE['hc_wishlist'])) {
        return array();
    }
    $decoded = json_decode(wp_unslash($_COOKIE['hc_wishlist']), true);
    return is_array($decoded) ? $decoded : array();
}

function hc_wishlist_save($list) {
    $clean = array();
    foreach ($list as $id => $flag) {
        $id = (int) $id;
        if ($id > 0 && $flag) {
            $clean[ $id ] = 1;
        }
    }
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), '_hc_wishlist', $clean);
    }
    setcookie(
        'hc_wishlist',
        wp_json_encode($clean),
        time() + MONTH_IN_SECONDS,
        hc_cart_cookie_path(),
        COOKIE_DOMAIN,
        is_ssl(),
        true
    );
    $_COOKIE['hc_wishlist'] = wp_json_encode($clean);
    return $clean;
}

function hc_wishlist_has($id, $list = null) {
    $list = null === $list ? hc_wishlist_get_raw() : $list;
    return ! empty($list[ (int) $id ]);
}

function hc_wishlist_count($list = null) {
    $list = null === $list ? hc_wishlist_get_raw() : $list;
    return count($list);
}

function hc_wishlist_items($list = null) {
    $list  = null === $list ? hc_wishlist_get_raw() : $list;
    $items = array();
    foreach (array_keys($list) as $id) {
        $product = hc_product_from_post((int) $id);
        if ($product) {
            $items[] = $product;
        }
    }
    return $items;
}

function hc_wishlist_payload($list = null) {
    $list = null === $list ? hc_wishlist_get_raw() : $list;
    $ids  = array();
    foreach (array_keys($list) as $id) {
        $ids[] = (int) $id;
    }
    return array(
        'count' => count($ids),
        'ids'   => $ids,
    );
}

function hc_ajax_wishlist() {
    check_ajax_referer('hc_commerce', 'nonce');
    $action = sanitize_key(wp_unslash($_POST['wish_action'] ?? 'get'));
    $list   = hc_wishlist_get_raw();
    $id     = (int) ($_POST['product_id'] ?? 0);

    if (in_array($action, array('toggle', 'add', 'remove'), true) && $id) {
        $post = get_post($id);
        if (! $post || 'hc_product' !== $post->post_type || 'publish' !== $post->post_status) {
            wp_send_json_error(array('message' => 'Product not found.'), 404);
        }
        $saved = ! empty($list[ $id ]);
        if ('add' === $action || ('toggle' === $action && ! $saved)) {
            $list[ $id ] = 1;
        } else {
            unset($list[ $id ]);
        }
        $list = hc_wishlist_save($list);
    }

    $payload           = hc_wishlist_payload($list);
    $payload['saved']  = $id ? hc_wishlist_has($id, $list) : false;
    wp_send_json_success($payload);
}

function hc_wishlist_merge_on_login($user_login, $user) {
    $cookie = array();
    if (! empty($_COOKIE['hc_wishlist'])) {
        $decoded = json_decode(wp_unslash($_COOKIE['hc_wishlist']), true);
        $cookie  = is_array($decoded) ? $decoded : array();
    }
    $saved = get_user_meta($user->ID, '_hc_wishlist', true);
    $saved = is_array($saved) ? $saved : array();
    foreach ($cookie as $id => $flag) {
        $id = (int) $id;
        if ($id > 0 && $flag) {
            $saved[ $id ] = 1;
        }
    }
    update_user_meta($user->ID, '_hc_wishlist', $saved);
}

function hc_cart_merge_on_login($user_login, $user) {
    $cookie = array();
    if (! empty($_COOKIE['hc_cart'])) {
        $decoded = json_decode(wp_unslash($_COOKIE['hc_cart']), true);
        $cookie  = is_array($decoded) ? $decoded : array();
    }
    $saved = get_user_meta($user->ID, '_hc_cart', true);
    $saved = is_array($saved) ? $saved : array();
    foreach ($cookie as $id => $qty) {
        $id  = (int) $id;
        $qty = (int) $qty;
        if ($id < 1) {
            continue;
        }
        $saved[ $id ] = (isset($saved[ $id ]) ? (int) $saved[ $id ] : 0) + max(1, $qty);
    }
    update_user_meta($user->ID, '_hc_cart', $saved);
}

function hc_product_search_query($query) {
    if (is_admin() || ! $query->is_main_query() || ! $query->is_search()) {
        return;
    }
    $query->set('post_type', array('hc_product'));
}

function hc_add_to_cart_button($product, $label = 'Add to Cart') {
    if (! $product) {
        return;
    }
    printf(
        '<button type="button" class="btn" data-add-cart data-product-id="%d">%s</button>',
        (int) $product['id'],
        esc_html($label)
    );
}

function hc_qty_control($value = 1, $name = 'qty') {
    $value = max(1, (int) $value);
    ?>
    <div class="qty-control" data-qty>
        <button type="button" class="qty-btn" data-qty-minus aria-label="Decrease quantity">−</button>
        <input class="qty-input" data-qty-input name="<?php echo esc_attr($name); ?>" type="number" min="1" max="999" value="<?php echo esc_attr((string) $value); ?>" />
        <button type="button" class="qty-btn" data-qty-plus aria-label="Increase quantity">+</button>
    </div>
    <?php
}

function hc_icon_heart() {
    ?>
    <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12 19.2 4.9 12.4a3.7 3.7 0 0 1 5.2-5.2L12 9l1.9-1.8a3.7 3.7 0 0 1 5.2 5.2L12 19.2z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
    </svg>
    <?php
}

function hc_wishlist_button($product, $variant = 'icon') {
    if (! $product || empty($product['id'])) {
        return;
    }
    $on    = hc_wishlist_has($product['id']);
    $label = $on ? 'Remove from Wishlist' : 'Add to Wishlist';
    $class = 'wish-btn' . ('text' === $variant ? ' wish-btn--text' : '') . ($on ? ' is-on' : '');
    ?>
    <button
        type="button"
        class="<?php echo esc_attr($class); ?>"
        data-wish
        data-product-id="<?php echo esc_attr((string) $product['id']); ?>"
        aria-pressed="<?php echo $on ? 'true' : 'false'; ?>"
        aria-label="<?php echo esc_attr($label); ?>"
    >
        <?php hc_icon_heart(); ?>
        <?php if ('text' === $variant) : ?>
            <span data-wish-label><?php echo esc_html($label); ?></span>
        <?php endif; ?>
    </button>
    <?php
}

function hc_header_icon_wishlist() {
    $count = hc_wishlist_count();
    ?>
    <a class="header-icon wish-icon" href="<?php echo esc_url(hc_wishlist_url()); ?>" aria-label="Wishlist">
        <?php hc_icon_heart(); ?>
        <span class="cart-badge" data-wish-count <?php echo $count ? '' : 'hidden'; ?>><?php echo esc_html((string) $count); ?></span>
    </a>
    <?php
}

function hc_header_icon_cart() {
    $count = hc_cart_count();
    ?>
    <button type="button" class="header-icon cart-icon" data-cart-open aria-haspopup="dialog" aria-label="Open cart">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6.5 7h14l-1.4 8.2a2 2 0 0 1-2 1.6H9.2a2 2 0 0 1-2-1.7L5.2 4.8H3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="9.5" cy="20" r="1.2" fill="currentColor"/>
            <circle cx="17.5" cy="20" r="1.2" fill="currentColor"/>
        </svg>
        <span class="cart-badge" data-cart-count <?php echo $count ? '' : 'hidden'; ?>><?php echo esc_html((string) $count); ?></span>
    </button>
    <?php
}

function hc_header_icon_user() {
    $logged = is_user_logged_in();
    $url    = hc_account_url();
    ?>
    <div class="header-account">
        <button type="button" class="header-icon" data-account-toggle aria-expanded="false" aria-haspopup="true" aria-label="<?php echo $logged ? 'Account' : 'Login'; ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-width="1.6"/>
                <path d="M5.2 19.2c.9-3.2 3.6-5.2 6.8-5.2s5.9 2 6.8 5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
        </button>
        <div class="account-menu" hidden data-account-menu>
            <?php if ($logged) : ?>
                <p class="account-menu-label"><?php echo esc_html(wp_get_current_user()->display_name); ?></p>
                <a href="<?php echo esc_url($url); ?>">My Account</a>
                <a href="<?php echo esc_url(hc_quote_url()); ?>">My Orders / Requests</a>
                <a href="<?php echo esc_url(hc_wishlist_url()); ?>">Wishlist</a>
                <button type="button" data-cart-open>Cart</button>
                <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">Logout</a>
            <?php else : ?>
                <a href="<?php echo esc_url($url); ?>">Login</a>
                <a href="<?php echo esc_url(hc_account_url(array('view' => 'register'))); ?>">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

function hc_render_cart_drawer() {
    ?>
    <div class="cart-drawer" data-cart-drawer aria-hidden="true">
        <button type="button" class="cart-drawer-backdrop" data-cart-close aria-label="Close cart"></button>
        <aside class="cart-drawer-panel" role="dialog" aria-modal="true" aria-labelledby="cart-drawer-title">
            <header class="cart-drawer-head">
                <h2 id="cart-drawer-title">Your cart</h2>
                <button type="button" class="cart-drawer-close" data-cart-close aria-label="Close cart">✕</button>
            </header>
            <div class="cart-drawer-body" data-cart-body>
                <p class="cart-drawer-empty">Loading cart…</p>
            </div>
            <footer class="cart-drawer-foot" data-cart-foot hidden>
                <p class="cart-drawer-total" data-cart-total>Total: Quotation on request</p>
                <button type="button" class="btn btn-outline" data-cart-close>Continue Shopping</button>
                <a class="btn" data-cart-checkout href="<?php echo esc_url(hc_checkout_url()); ?>">Go to Checkout with My Cart</a>
            </footer>
        </aside>
    </div>
    <?php
}
