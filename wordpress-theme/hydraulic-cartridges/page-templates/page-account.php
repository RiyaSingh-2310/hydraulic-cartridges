<?php
/**
 * Template Name: Account
 */

if (is_user_logged_in() && isset($_GET['action']) && 'logout' === $_GET['action']) {
    wp_logout();
    wp_safe_redirect(hc_account_url());
    exit;
}

$redirect = isset($_GET['redirect_to']) ? wp_validate_redirect(esc_url_raw(wp_unslash($_GET['redirect_to'])), hc_checkout_url()) : hc_checkout_url();
$view     = isset($_GET['view']) ? sanitize_key(wp_unslash($_GET['view'])) : 'login';
$notice   = isset($_GET['notice']) ? sanitize_key(wp_unslash($_GET['notice'])) : '';
$error    = '';

if ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['hc_auth_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hc_auth_nonce'])), 'hc_auth')) {
    $mode = sanitize_key(wp_unslash($_POST['mode'] ?? 'login'));
    if ('register' === $mode) {
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $pass  = (string) ($_POST['password'] ?? '');
        $name  = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
        if (! is_email($email) || strlen($pass) < 8) {
            $error = 'Enter a valid email and a password of at least 8 characters.';
            $view  = 'register';
        } elseif (email_exists($email)) {
            $error = 'An account already exists for that email. Sign in instead.';
            $view  = 'login';
        } else {
            $user_id = wp_create_user($email, $pass, $email);
            if (is_wp_error($user_id)) {
                $error = $user_id->get_error_message();
                $view  = 'register';
            } else {
                if ($name) {
                    wp_update_user(array('ID' => $user_id, 'display_name' => $name));
                }
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id, true);
                wp_safe_redirect($redirect ?: hc_checkout_url());
                exit;
            }
        }
    } else {
        $signon = wp_signon(array(
            'user_login'    => sanitize_email(wp_unslash($_POST['email'] ?? '')),
            'user_password' => (string) ($_POST['password'] ?? ''),
            'remember'      => true,
        ), is_ssl());
        if (is_wp_error($signon)) {
            $error = 'Sign-in failed. Check the email and password.';
            $view  = 'login';
        } else {
            wp_safe_redirect($redirect ?: hc_checkout_url());
            exit;
        }
    }
}

get_header();
$user = wp_get_current_user();
$from_cart = 'login-cart' === $notice;
hc_page_hero(
    'Account',
    is_user_logged_in() ? 'My Account' : ('register' === $view ? 'Sign Up' : 'Login'),
    is_user_logged_in()
        ? 'Your quotation cart, wishlist, and requests stay with this account.'
        : ($from_cart ? 'Please log in to continue with your cart.' : 'Login or create an account to request a quotation.')
);
?>
<section class="section">
    <div class="container">
        <?php if ('login-cart' === $notice && ! is_user_logged_in()) : ?>
            <p class="notice-banner">Please log in to continue with your cart.</p>
        <?php endif; ?>

        <?php if (is_user_logged_in()) : ?>
            <div class="auth-card">
                <p class="eyebrow">Signed in</p>
                <h2 class="display" style="font-size: 1.8rem; margin: 0.4rem 0 0.75rem;"><?php echo esc_html($user->display_name); ?></h2>
                <p><?php echo esc_html($user->user_email); ?></p>
                <div class="cart-actions" style="margin-top: 1.25rem;">
                    <?php hc_btn(hc_wishlist_url(), 'Wishlist', 'outline'); ?>
                    <?php hc_btn(hc_cart_url(), 'Cart', 'outline'); ?>
                    <?php hc_btn(hc_quote_url(), 'My Orders / Requests'); ?>
                    <?php hc_btn(wp_logout_url(home_url('/')), 'Logout', 'outline'); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="auth-card">
                <?php if ($error) : ?>
                    <p class="notice-banner"><?php echo esc_html($error); ?></p>
                <?php endif; ?>
                <form class="form-grid" method="post">
                    <?php wp_nonce_field('hc_auth', 'hc_auth_nonce'); ?>
                    <input type="hidden" name="mode" value="<?php echo esc_attr('register' === $view ? 'register' : 'login'); ?>" />
                    <?php if ('register' === $view) : ?>
                        <div class="field">
                            <label for="acc-name">Name</label>
                            <input id="acc-name" name="name" autocomplete="name" />
                        </div>
                    <?php endif; ?>
                    <div class="field">
                        <label for="acc-email">Email</label>
                        <input id="acc-email" name="email" type="email" autocomplete="email" required />
                    </div>
                    <div class="field">
                        <label for="acc-pass">Password</label>
                        <input id="acc-pass" name="password" type="password" autocomplete="<?php echo 'register' === $view ? 'new-password' : 'current-password'; ?>" required minlength="8" />
                    </div>
                    <div>
                        <button class="btn" type="submit"><?php echo 'register' === $view ? 'Create Account' : 'Login'; ?></button>
                    </div>
                </form>
                <?php if ('register' !== $view) : ?>
                    <p class="auth-switch">
                        <a href="<?php echo esc_url(wp_lostpassword_url(hc_account_url())); ?>">Forgot Password</a>
                    </p>
                    <p class="auth-switch">
                        Need an account?
                        <a href="<?php echo esc_url(hc_account_url(array('view' => 'register', 'redirect_to' => $redirect, 'notice' => $notice))); ?>">Create Account</a>
                    </p>
                <?php else : ?>
                    <p class="auth-switch">
                        Already registered?
                        <a href="<?php echo esc_url(hc_account_url(array('redirect_to' => $redirect, 'notice' => $notice))); ?>">Login</a>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
