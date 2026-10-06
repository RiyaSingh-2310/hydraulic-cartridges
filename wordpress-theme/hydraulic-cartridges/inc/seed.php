<?php
/**
 * Seed pages, CPT content, menu, and reading settings on first activation.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('after_switch_theme', 'hc_seed_content');

function hc_seed_content() {
    if (get_option('hc_seeded')) {
        update_option('hc_flush_rewrites', '1');
        return;
    }

    $data = hc_seed_data();
    $order = 0;

    foreach (($data['products'] ?? array()) as $item) {
        $existing = get_page_by_path($item['slug'], OBJECT, 'hc_product');
        $post_id  = $existing ? $existing->ID : wp_insert_post(array(
            'post_type'    => 'hc_product',
            'post_status'  => 'publish',
            'post_title'   => sanitize_text_field($item['name']),
            'post_name'    => sanitize_title($item['slug']),
            'post_content' => wp_kses_post($item['overview']),
            'menu_order'   => $order++,
        ));
        if (is_wp_error($post_id) || ! $post_id) {
            continue;
        }
        hc_update_product_meta($post_id, $item);
    }

    $order = 0;
    foreach (($data['applications'] ?? array()) as $item) {
        $existing = get_page_by_path($item['slug'], OBJECT, 'hc_application');
        $post_id  = $existing ? $existing->ID : wp_insert_post(array(
            'post_type'    => 'hc_application',
            'post_status'  => 'publish',
            'post_title'   => sanitize_text_field($item['name']),
            'post_name'    => sanitize_title($item['slug']),
            'post_content' => wp_kses_post($item['overview']),
            'menu_order'   => $order++,
        ));
        if (is_wp_error($post_id) || ! $post_id) {
            continue;
        }
        update_post_meta($post_id, '_hc_short_description', sanitize_text_field($item['shortDescription']));
        update_post_meta($post_id, '_hc_challenges', wp_json_encode($item['challenges']));
        update_post_meta($post_id, '_hc_solutions', wp_json_encode($item['solutions']));
        update_post_meta($post_id, '_hc_typical_products', wp_json_encode($item['typicalProducts']));
        update_post_meta($post_id, '_hc_image', esc_url_raw($item['image']));
        update_post_meta($post_id, '_hc_image_alt', sanitize_text_field($item['imageAlt']));
    }

    $order = 0;
    foreach (($data['resources'] ?? array()) as $item) {
        $existing = get_page_by_path($item['slug'], OBJECT, 'hc_resource');
        $post_id  = $existing ? $existing->ID : wp_insert_post(array(
            'post_type'   => 'hc_resource',
            'post_status' => 'publish',
            'post_title'  => sanitize_text_field($item['title']),
            'post_name'   => sanitize_title($item['slug']),
            'menu_order'  => $order++,
        ));
        if (! is_wp_error($post_id) && $post_id) {
            update_post_meta($post_id, '_hc_description', sanitize_text_field($item['description']));
            update_post_meta($post_id, '_hc_type', sanitize_text_field($item['type']));
        }
    }

    $order = 0;
    foreach (($data['faqs'] ?? array()) as $item) {
        wp_insert_post(array(
            'post_type'    => 'hc_faq',
            'post_status'  => 'publish',
            'post_title'   => sanitize_text_field($item['question']),
            'post_content' => wp_kses_post($item['answer']),
            'menu_order'   => $order++,
        ));
    }

    $pages = array(
        'home'          => array('Home', '', ''),
        'about'         => array('About', 'page-templates/page-about.php', 'About Hydraulic Cartridges'),
        'resources'     => array('Resources', 'page-templates/page-resources.php', 'Documentation for specification work'),
        'contact'       => array('Contact', 'page-templates/page-contact.php', 'Speak with the engineering desk'),
        'request-quote' => array('Request a Quote', 'page-templates/page-request-quote.php', 'Tell us the circuit. We will answer with a cartridge.'),
        'privacy'       => array('Privacy policy', 'page-templates/page-privacy.php', 'Placeholder policy'),
        'terms'         => array('Terms of use', 'page-templates/page-terms.php', 'Placeholder terms'),
    );

    $created = array();
    foreach ($pages as $slug => $cfg) {
        $existing = get_page_by_path($slug);
        if ($existing) {
            $created[ $slug ] = $existing->ID;
            if ($cfg[1]) {
                update_post_meta($existing->ID, '_wp_page_template', $cfg[1]);
            }
            continue;
        }
        $id = wp_insert_post(array(
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $cfg[0],
            'post_name'    => $slug,
            'post_content' => '',
            'post_excerpt' => $cfg[2],
        ));
        if (! is_wp_error($id) && $id) {
            $created[ $slug ] = $id;
            if ($cfg[1]) {
                update_post_meta($id, '_wp_page_template', $cfg[1]);
            }
        }
    }

    if (! empty($created['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', (int) $created['home']);
    }

    if (! get_option('permalink_structure')) {
        update_option('permalink_structure', '/%postname%/');
    }

    hc_seed_menu($created);
    update_option('hc_seeded', '1');
    update_option('hc_flush_rewrites', '1');
}

function hc_update_product_meta($post_id, $item) {
    update_post_meta($post_id, '_hc_model', sanitize_text_field($item['model']));
    update_post_meta($post_id, '_hc_category', sanitize_text_field($item['category']));
    update_post_meta($post_id, '_hc_category_slug', sanitize_text_field($item['categorySlug']));
    update_post_meta($post_id, '_hc_short_description', sanitize_text_field($item['shortDescription']));
    update_post_meta($post_id, '_hc_pressure', sanitize_text_field($item['pressure']));
    update_post_meta($post_id, '_hc_flow', sanitize_text_field($item['flow']));
    update_post_meta($post_id, '_hc_cavity', sanitize_text_field($item['cavity']));
    update_post_meta($post_id, '_hc_visual', sanitize_text_field($item['visual']));
    update_post_meta($post_id, '_hc_gallery_captions', wp_json_encode($item['galleryCaptions']));
    update_post_meta($post_id, '_hc_features', wp_json_encode($item['features']));
    update_post_meta($post_id, '_hc_technical', wp_json_encode($item['technical']));
    update_post_meta($post_id, '_hc_applications', wp_json_encode($item['applications']));
    update_post_meta($post_id, '_hc_related', wp_json_encode($item['relatedSlugs']));
    update_post_meta($post_id, '_hc_featured', ! empty($item['featured']) ? '1' : '');
}

function hc_seed_menu($pages) {
    $name = 'Primary';
    $menu = wp_get_nav_menu_object($name);
    if (! $menu) {
        $menu_id = wp_create_nav_menu($name);
    } else {
        $menu_id = (int) $menu->term_id;
    }

    $items = wp_get_nav_menu_items($menu_id);
    if ($items) {
        $locations = get_theme_mod('nav_menu_locations', array());
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        return;
    }

    $entries = array(
        array('Home', home_url('/'), 'custom'),
        array('Products', hc_products_url(), 'archive', 'hc_product'),
        array('Solutions', hc_applications_url(), 'archive', 'hc_application'),
        array('About', '', 'page', $pages['about'] ?? 0),
        array('Resources', '', 'page', $pages['resources'] ?? 0),
        array('Contact', '', 'page', $pages['contact'] ?? 0),
    );

    $position = 1;
    foreach ($entries as $entry) {
        $args = array(
            'menu-item-title'  => $entry[0],
            'menu-item-status' => 'publish',
            'menu-item-position' => $position++,
        );
        if ('page' === $entry[2] && ! empty($entry[3])) {
            $args['menu-item-type']      = 'post_type';
            $args['menu-item-object']    = 'page';
            $args['menu-item-object-id'] = (int) $entry[3];
        } elseif ('archive' === $entry[2]) {
            $args['menu-item-type']   = 'post_type_archive';
            $args['menu-item-object'] = $entry[3];
            $args['menu-item-url']    = $entry[1];
        } else {
            $args['menu-item-type']      = 'custom';
            $args['menu-item-url']       = $entry[1];
        }
        wp_update_nav_menu_item($menu_id, 0, $args);
    }

    $locations = get_theme_mod('nav_menu_locations', array());
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}
