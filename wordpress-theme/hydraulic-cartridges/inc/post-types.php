<?php
/**
 * Custom post types.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_taxonomy('hc_family', array('hc_product'), array(
        'labels' => array(
            'name'          => 'Product families',
            'singular_name' => 'Product family',
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => false,
    ));

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
        'taxonomies'   => array('hc_family'),
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

add_action('init', 'hc_register_catalog_rewrites', 11);
add_filter('term_link', 'hc_family_term_link', 10, 3);
add_filter('post_type_link', 'hc_product_permalink', 10, 2);
add_filter('request', 'hc_catalog_request');

function hc_register_catalog_rewrites() {
    add_rewrite_rule(
        '^products/([^/]+)/([^/]+)/([^/]+)/?$',
        'index.php?post_type=hc_product&name=$matches[3]',
        'top'
    );
    add_rewrite_rule(
        '^products/([^/]+)/([^/]+)/?$',
        'index.php?hc_family=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        '^products/([^/]+)/?$',
        'index.php?hc_family=$matches[1]',
        'top'
    );
    if (! get_option('hc_rewrite_v2')) {
        update_option('hc_flush_rewrites', '1');
        update_option('hc_rewrite_v2', '1');
    }
}

function hc_family_term_link($url, $term, $taxonomy) {
    if (hc_family_taxonomy() !== $taxonomy) {
        return $url;
    }
    if ((int) $term->parent > 0) {
        $parent = get_term((int) $term->parent, $taxonomy);
        if ($parent && ! is_wp_error($parent)) {
            return home_url(user_trailingslashit('products/' . $parent->slug . '/' . $term->slug));
        }
    }
    return home_url(user_trailingslashit('products/' . $term->slug));
}

function hc_product_permalink($permalink, $post) {
    if ('hc_product' !== $post->post_type) {
        return $permalink;
    }
    $terms  = hc_product_family_terms($post->ID);
    $family = $terms['family'] ?? null;
    $group  = $terms['group'] ?? null;
    if ($family && ! is_wp_error($family) && $group && ! is_wp_error($group)) {
        return home_url(user_trailingslashit('products/' . $family->slug . '/' . $group->slug . '/' . $post->post_name));
    }
    if ($family && ! is_wp_error($family)) {
        return home_url(user_trailingslashit('products/' . $family->slug . '/' . $post->post_name));
    }
    return home_url(user_trailingslashit('products/' . $post->post_name));
}

function hc_catalog_request($vars) {
    if (empty($vars['hc_family']) || ! empty($vars['name'])) {
        return $vars;
    }
    $slug = $vars['hc_family'];
    if (get_term_by('slug', $slug, hc_family_taxonomy())) {
        return $vars;
    }
    $post = get_page_by_path($slug, OBJECT, 'hc_product');
    if ($post) {
        unset($vars['hc_family']);
        $vars['post_type']  = 'hc_product';
        $vars['name']       = $slug;
        $vars['hc_product'] = $slug;
    }
    return $vars;
}

add_action('pre_get_posts', function ($query) {
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }
    if ($query->is_post_type_archive(array('hc_product', 'hc_application')) || $query->is_tax('hc_family')) {
        $query->set('posts_per_page', -1);
        $query->set('orderby', 'menu_order title');
        $query->set('order', 'ASC');
    }
});
