<?php
/**
 * Seed catalog taxonomy and series products (runs once, even if the original theme seed already ran).
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('init', 'hc_seed_catalog', 30);

function hc_seed_catalog() {
    if (get_option('hc_catalog_seeded') === '1') {
        return;
    }
    if (! taxonomy_exists(hc_family_taxonomy())) {
        return;
    }

    $order = 0;
    foreach (hc_catalog_blueprint() as $family) {
        $parent = hc_upsert_family_term($family, 0, $order++);
        if (! $parent) {
            continue;
        }
        $child_order = 0;
        foreach ($family['children'] as $child) {
            $term = hc_upsert_family_term($child, (int) $parent['term_id'], $child_order++);
            if (! $term) {
                continue;
            }
            $products = $child['products'] ?? array();
            if (! $products) {
                $products = array(
                    array(
                        'slug'     => $child['slug'] . '-series',
                        'name'     => $child['name'],
                        'model'    => 'HCV-' . strtoupper(substr(preg_replace('/[^a-z0-9]+/i', '', $child['slug']), 0, 8)),
                        'pressure' => '350 bar class',
                        'flow'     => 'Circuit dependent',
                        'cavity'   => 'ISO / SAE / custom',
                        'visual'   => $child['visual'] ?? $family['visual'],
                    ),
                );
            }
            $p_order = 0;
            foreach ($products as $item) {
                hc_upsert_catalog_product($item, $child, $family, $term, $p_order++);
            }
        }
    }

    foreach (hc_existing_product_term_map() as $slug => $term_slug) {
        $posts = get_posts(array(
            'name'        => $slug,
            'post_type'   => 'hc_product',
            'post_status' => 'any',
            'numberposts' => 1,
        ));
        $term = get_term_by('slug', $term_slug, hc_family_taxonomy());
        if ($posts && $term && ! is_wp_error($term)) {
            wp_set_object_terms($posts[0]->ID, array((int) $term->term_id), hc_family_taxonomy(), false);
        }
    }

    update_option('hc_catalog_seeded', '1');
    update_option('hc_flush_rewrites', '1');
}

function hc_upsert_family_term($item, $parent_id, $order) {
    $existing = get_term_by('slug', $item['slug'], hc_family_taxonomy());
    if ($existing && ! is_wp_error($existing)) {
        wp_update_term((int) $existing->term_id, hc_family_taxonomy(), array(
            'description' => $item['intro'] ?? '',
            'parent'      => $parent_id,
        ));
        $term_id = (int) $existing->term_id;
    } else {
        $result = wp_insert_term($item['name'], hc_family_taxonomy(), array(
            'slug'        => $item['slug'],
            'description' => $item['intro'] ?? '',
            'parent'      => $parent_id,
        ));
        if (is_wp_error($result)) {
            return null;
        }
        $term_id = (int) $result['term_id'];
    }
    update_term_meta($term_id, '_hc_intro', sanitize_text_field($item['intro'] ?? ''));
    update_term_meta($term_id, '_hc_visual', sanitize_text_field($item['visual'] ?? 'cartridge'));
    update_term_meta($term_id, 'order', (int) $order);
    return array('term_id' => $term_id);
}

function hc_upsert_catalog_product($item, $child, $family, $term, $order) {
    $existing = get_page_by_path($item['slug'], OBJECT, 'hc_product');
    $short    = $item['short'] ?? ($child['intro'] ?? '');
    $overview = $item['overview'] ?? sprintf(
        '%1$s is specified in the %2$s range for industrial circuits that need documented pressure, flow, and cavity compatibility. Confirm ratings during quotation.',
        $item['name'],
        $child['name']
    );
    $payload  = array(
        'model'             => $item['model'] ?? '',
        'category'          => $child['name'],
        'categorySlug'      => $child['slug'],
        'shortDescription'  => $short,
        'pressure'          => $item['pressure'] ?? '',
        'flow'              => $item['flow'] ?? '',
        'cavity'            => $item['cavity'] ?? '',
        'visual'            => $item['visual'] ?? ($child['visual'] ?? 'cartridge'),
        'galleryCaptions'   => array('Series drawing', 'Machining reference', 'Functional test'),
        'features'          => $item['features'] ?? array(
            'Specified for industrial continuous duty',
            'Cavity and seal options confirmed at quotation',
            'Functional test available on catalog units',
            'Application review before part-number lock',
        ),
        'technical'         => $item['technical'] ?? array(
            array('label' => 'Model', 'value' => $item['model'] ?? ''),
            array('label' => 'Product group', 'value' => $child['name']),
            array('label' => 'Family', 'value' => $family['name']),
            array('label' => 'Pressure class', 'value' => $item['pressure'] ?? 'Confirm at quotation'),
            array('label' => 'Flow / displacement', 'value' => $item['flow'] ?? 'Circuit dependent'),
            array('label' => 'Interface', 'value' => $item['cavity'] ?? 'ISO / SAE / custom'),
        ),
        'applications'      => $item['applications'] ?? array('Industrial Automation', 'Mobile Hydraulics', 'Manufacturing'),
        'relatedSlugs'      => array(),
        'accessories'       => $item['accessories'] ?? array(),
        'downloads'         => array(
            array('title' => 'Product Datasheet', 'type' => 'PDF · Placeholder'),
            array('title' => 'Technical Drawing', 'type' => 'DWG · Placeholder'),
            array('title' => 'Installation Notes', 'type' => 'PDF · Placeholder'),
        ),
        'featured'          => false,
    );

    if ($existing) {
        $post_id = $existing->ID;
    } else {
        $post_id = wp_insert_post(array(
            'post_type'    => 'hc_product',
            'post_status'  => 'publish',
            'post_title'   => sanitize_text_field($item['name']),
            'post_name'    => sanitize_title($item['slug']),
            'post_content' => wp_kses_post($overview),
            'menu_order'   => $order,
        ));
    }
    if (is_wp_error($post_id) || ! $post_id) {
        return;
    }
    hc_update_product_meta($post_id, $payload);
    update_post_meta($post_id, '_hc_accessories', wp_json_encode($payload['accessories']));
    update_post_meta($post_id, '_hc_downloads', wp_json_encode($payload['downloads']));
    wp_set_object_terms($post_id, array((int) $term['term_id']), hc_family_taxonomy(), false);
}
