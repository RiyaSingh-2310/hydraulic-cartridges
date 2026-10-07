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
add_action('wp_login', 'hc_cart_merge_on_login', 10, 2);
add_action('pre_get_posts', 'hc_product_search_query');

function hc_cart_url() {
    return hc_page_url('cart');
}

function hc_account_url($args = array()) {
    $url = hc_page_url('account');
    return $args ? add_query_arg($args, $url) : $url;
}

function hc_show_catalog_bar() {
    return is_front_page()
        || is_post_type_archive('hc_product')
        || is_tax(hc_family_taxonomy())
        || is_singular('hc_product')
        || is_post_type_archive('hc_application')
        || is_singular('hc_application')
        || is_page(array('cart', 'account', 'request-quote'));
}

function hc_ensure_commerce_pages() {
    if (get_option('hc_commerce_pages') === '1') {
        return;
    }
    $pages = array(
        'cart'    => array('Cart', 'page-templates/page-cart.php', 'Review items before requesting a quotation.'),
        'account' => array('Account', 'page-templates/page-account.php', 'Sign in to continue with your quotation cart.'),
    );
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
        $items[] = array(
            'id'        => $product['id'],
            'slug'      => $product['slug'],
            'name'      => $product['name'],
            'model'     => $product['model'],
            'category'  => $product['category'],
            'permalink' => $product['permalink'],
            'visual'    => $product['visual'],
            'qty'       => (int) $qty,
            'price'     => 'On request',
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

function hc_add_to_cart_button($product, $label = 'Add to cart') {
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

function hc_header_icon_user() {
    $logged = is_user_logged_in();
    $url    = hc_account_url();
    ?>
    <div class="header-account">
        <a class="header-icon" href="<?php echo esc_url($url); ?>" aria-label="<?php echo $logged ? 'Account' : 'Sign in'; ?>" data-account-toggle>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-width="1.6"/>
                <path d="M5.2 19.2c.9-3.2 3.6-5.2 6.8-5.2s5.9 2 6.8 5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
        </a>
        <div class="account-menu" hidden data-account-menu>
            <?php if ($logged) : ?>
                <p class="account-menu-label"><?php echo esc_html(wp_get_current_user()->display_name); ?></p>
                <a href="<?php echo esc_url($url); ?>">My account</a>
                <a href="<?php echo esc_url(hc_cart_url()); ?>">Cart</a>
                <a href="<?php echo esc_url(hc_quote_url()); ?>">Quote requests</a>
                <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">Log out</a>
            <?php else : ?>
                <a href="<?php echo esc_url($url); ?>">Sign in</a>
                <a href="<?php echo esc_url(hc_account_url(array('view' => 'register'))); ?>">Create account</a>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

function hc_header_icon_cart() {
    $count = hc_cart_count();
    ?>
    <a class="header-icon cart-icon" href="<?php echo esc_url(hc_cart_url()); ?>" aria-label="Cart">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M6.5 7h14l-1.4 8.2a2 2 0 0 1-2 1.6H9.2a2 2 0 0 1-2-1.7L5.2 4.8H3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="9.5" cy="20" r="1.2" fill="currentColor"/>
            <circle cx="17.5" cy="20" r="1.2" fill="currentColor"/>
        </svg>
        <span class="cart-badge" data-cart-count <?php echo $count ? '' : 'hidden'; ?>><?php echo esc_html((string) $count); ?></span>
    </a>
    <?php
}
