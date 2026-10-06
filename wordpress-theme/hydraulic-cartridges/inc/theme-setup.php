<?php
/**
 * Theme supports and body classes.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 64,
        'width'       => 64,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('automatic-feed-links');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'hydraulic-cartridges'),
    ));
});

add_filter('body_class', function ($classes) {
    $classes[] = 'page-shell';
    if (is_front_page()) {
        $classes[] = 'home';
    }
    return $classes;
});

add_filter('document_title_separator', function () {
    return '—';
});

add_filter('document_title_parts', function ($parts) {
    if (is_front_page()) {
        $parts['title'] = 'Hydraulic Cartridges';
        $parts['tagline'] = 'Precision Fluid Power';
        unset($parts['site']);
    }
    return $parts;
});

add_action('wp_head', function () {
    if (! is_front_page()) {
        return;
    }
    echo '<meta name="description" content="' . esc_attr('Hydraulic Cartridges manufactures precision screw-in cartridge valves and custom manifold components for high-pressure industrial equipment.') . '" />' . "\n";
});

add_filter('excerpt_more', function () {
    return '';
});
