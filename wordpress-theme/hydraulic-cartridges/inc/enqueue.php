<?php
/**
 * Asset enqueueing.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', function () {
    $uri = get_template_directory_uri();
    $dir = get_template_directory();

    wp_enqueue_style(
        'hc-fonts',
        'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700&family=Barlow:ital,wght@0,400;0,500;0,600;1,400&family=IBM+Plex+Mono:wght@400;500&display=swap',
        array(),
        null
    );

    $sheets = array(
        'hc-tokens'     => '/assets/css/tokens.css',
        'hc-layout'     => '/assets/css/layout.css',
        'hc-components' => '/assets/css/components.css',
        'hc-wordpress'  => '/assets/css/wordpress.css',
    );

    $prev = array('hc-fonts');
    foreach ($sheets as $handle => $path) {
        wp_enqueue_style(
            $handle,
            $uri . $path,
            $prev,
            (string) filemtime($dir . $path)
        );
        $prev = array($handle);
    }

    wp_enqueue_script(
        'hc-theme',
        $uri . '/assets/js/theme.js',
        array(),
        (string) filemtime($dir . '/assets/js/theme.js'),
        true
    );

    if (is_front_page()) {
        wp_enqueue_script(
            'hc-home',
            $uri . '/assets/js/home.js',
            array(),
            (string) filemtime($dir . '/assets/js/home.js'),
            true
        );
    }

    if (is_singular('hc_product')) {
        wp_enqueue_script(
            'hc-gallery',
            $uri . '/assets/js/gallery.js',
            array(),
            (string) filemtime($dir . '/assets/js/gallery.js'),
            true
        );
    }

    if (is_page(array('contact', 'request-quote'))) {
        wp_enqueue_script(
            'hc-forms',
            $uri . '/assets/js/forms.js',
            array(),
            (string) filemtime($dir . '/assets/js/forms.js'),
            true
        );
    }
});

add_action('wp_head', function () {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
    echo '<link rel="icon" type="image/svg+xml" href="' . esc_url(get_template_directory_uri() . '/assets/icons/favicon.svg') . '" />' . "\n";
}, 1);
