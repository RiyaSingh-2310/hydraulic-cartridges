<?php
/**
 * Custom post types.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_post_type('hc_product', array(
        'labels' => array(
            'name'          => 'Products',
            'singular_name' => 'Product',
            'add_new_item'  => 'Add Product',
            'edit_item'     => 'Edit Product',
        ),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-admin-tools',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields'),
        'rewrite'      => array('slug' => 'products', 'with_front' => false),
    ));

    register_post_type('hc_application', array(
        'labels' => array(
            'name'          => 'Solutions',
            'singular_name' => 'Solution',
            'add_new_item'  => 'Add Solution',
            'edit_item'     => 'Edit Solution',
        ),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-admin-site-alt3',
        'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields'),
        'rewrite'      => array('slug' => 'applications', 'with_front' => false),
    ));

    register_post_type('hc_resource', array(
        'labels' => array(
            'name'          => 'Resources',
            'singular_name' => 'Resource',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-media-document',
        'supports'     => array('title', 'page-attributes', 'custom-fields'),
        'rewrite'      => false,
    ));

    register_post_type('hc_faq', array(
        'labels' => array(
            'name'          => 'FAQs',
            'singular_name' => 'FAQ',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-editor-help',
        'supports'     => array('title', 'editor', 'page-attributes'),
        'rewrite'      => false,
    ));
});

add_action('after_switch_theme', function () {
    update_option('hc_flush_rewrites', '1');
});

add_action('init', function () {
    if (get_option('hc_flush_rewrites')) {
        flush_rewrite_rules();
        delete_option('hc_flush_rewrites');
    }
}, 20);

add_action('pre_get_posts', function ($query) {
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }
    if ($query->is_post_type_archive(array('hc_product', 'hc_application'))) {
        $query->set('posts_per_page', -1);
        $query->set('orderby', 'menu_order title');
        $query->set('order', 'ASC');
    }
});
