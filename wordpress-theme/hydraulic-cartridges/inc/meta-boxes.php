<?php
/**
 * Admin meta boxes for products, solutions, and resources.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('add_meta_boxes', function () {
    add_meta_box('hc_product_details', 'Product details', 'hc_render_product_metabox', 'hc_product', 'normal', 'high');
    add_meta_box('hc_application_details', 'Solution details', 'hc_render_application_metabox', 'hc_application', 'normal', 'high');
    add_meta_box('hc_resource_details', 'Resource details', 'hc_render_resource_metabox', 'hc_resource', 'normal', 'high');
});

function hc_metabox_nonce() {
    wp_nonce_field('hc_save_meta', 'hc_meta_nonce');
}

function hc_render_product_metabox($post) {
    hc_metabox_nonce();
    $fields = array(
        '_hc_model'             => 'Model',
        '_hc_category'          => 'Category',
        '_hc_category_slug'     => 'Category slug',
        '_hc_short_description' => 'Short description',
        '_hc_pressure'          => 'Pressure',
        '_hc_flow'              => 'Flow',
        '_hc_cavity'            => 'Cavity',
        '_hc_visual'            => 'Visual key (cartridge, solenoid, check, relief, flow, directional, counterbalance, custom)',
    );
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<p><label><strong>' . esc_html($label) . '</strong><br />';
        if ('_hc_short_description' === $key) {
            echo '<textarea name="' . esc_attr($key) . '" class="widefat" rows="3">' . esc_textarea($value) . '</textarea>';
        } else {
            echo '<input type="text" class="widefat" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" />';
        }
        echo '</label></p>';
    }
    $features = hc_decode_meta($post->ID, '_hc_features');
    $captions = hc_decode_meta($post->ID, '_hc_gallery_captions');
    $apps     = hc_decode_meta($post->ID, '_hc_applications');
    $related  = hc_decode_meta($post->ID, '_hc_related');
    $tech     = hc_decode_meta($post->ID, '_hc_technical');
    $tech_txt = '';
    foreach ($tech as $row) {
        if (is_array($row)) {
            $tech_txt .= ($row['label'] ?? '') . ' | ' . ($row['value'] ?? '') . "\n";
        }
    }
    echo '<p><label><strong>Features (one per line)</strong><br /><textarea name="_hc_features" class="widefat" rows="4">' . esc_textarea(implode("\n", $features)) . '</textarea></label></p>';
    echo '<p><label><strong>Gallery captions (one per line)</strong><br /><textarea name="_hc_gallery_captions" class="widefat" rows="3">' . esc_textarea(implode("\n", $captions)) . '</textarea></label></p>';
    echo '<p><label><strong>Typical applications (one per line)</strong><br /><textarea name="_hc_applications" class="widefat" rows="3">' . esc_textarea(implode("\n", $apps)) . '</textarea></label></p>';
    echo '<p><label><strong>Related product slugs (one per line)</strong><br /><textarea name="_hc_related" class="widefat" rows="3">' . esc_textarea(implode("\n", $related)) . '</textarea></label></p>';
    echo '<p><label><strong>Technical specs (label | value)</strong><br /><textarea name="_hc_technical" class="widefat" rows="6">' . esc_textarea($tech_txt) . '</textarea></label></p>';
    $featured = get_post_meta($post->ID, '_hc_featured', true);
    echo '<p><label><input type="checkbox" name="_hc_featured" value="1" ' . checked($featured, '1', false) . ' /> Featured product</label></p>';
}

function hc_render_application_metabox($post) {
    hc_metabox_nonce();
    $short = get_post_meta($post->ID, '_hc_short_description', true);
    $image = get_post_meta($post->ID, '_hc_image', true);
    $alt   = get_post_meta($post->ID, '_hc_image_alt', true);
    echo '<p><label><strong>Short description</strong><br /><textarea name="_hc_short_description" class="widefat" rows="3">' . esc_textarea($short) . '</textarea></label></p>';
    echo '<p><label><strong>Image URL</strong><br /><input type="url" class="widefat" name="_hc_image" value="' . esc_attr($image) . '" /></label></p>';
    echo '<p><label><strong>Image alt</strong><br /><input type="text" class="widefat" name="_hc_image_alt" value="' . esc_attr($alt) . '" /></label></p>';
    echo '<p><label><strong>Challenges (one per line)</strong><br /><textarea name="_hc_challenges" class="widefat" rows="4">' . esc_textarea(implode("\n", hc_decode_meta($post->ID, '_hc_challenges'))) . '</textarea></label></p>';
    echo '<p><label><strong>Engineering response (one per line)</strong><br /><textarea name="_hc_solutions" class="widefat" rows="4">' . esc_textarea(implode("\n", hc_decode_meta($post->ID, '_hc_solutions'))) . '</textarea></label></p>';
    echo '<p><label><strong>Typical product slugs (one per line)</strong><br /><textarea name="_hc_typical_products" class="widefat" rows="3">' . esc_textarea(implode("\n", hc_decode_meta($post->ID, '_hc_typical_products'))) . '</textarea></label></p>';
}

function hc_render_resource_metabox($post) {
    hc_metabox_nonce();
    echo '<p><label><strong>Type label</strong><br /><input type="text" class="widefat" name="_hc_type" value="' . esc_attr(get_post_meta($post->ID, '_hc_type', true)) . '" /></label></p>';
    echo '<p><label><strong>Description</strong><br /><textarea name="_hc_description" class="widefat" rows="3">' . esc_textarea(get_post_meta($post->ID, '_hc_description', true)) . '</textarea></label></p>';
}

add_action('save_post_hc_product', 'hc_save_product_meta');
add_action('save_post_hc_application', 'hc_save_application_meta');
add_action('save_post_hc_resource', 'hc_save_resource_meta');

function hc_verify_meta_nonce() {
    return isset($_POST['hc_meta_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hc_meta_nonce'])), 'hc_save_meta');
}

function hc_lines_from_post($key) {
    if (! isset($_POST[ $key ])) {
        return array();
    }
    $raw = sanitize_textarea_field(wp_unslash($_POST[ $key ]));
    return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw))));
}

function hc_save_product_meta($post_id) {
    if (! hc_verify_meta_nonce() || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }
    $text = array('_hc_model', '_hc_category', '_hc_category_slug', '_hc_pressure', '_hc_flow', '_hc_cavity', '_hc_visual');
    foreach ($text as $key) {
        if (isset($_POST[ $key ])) {
            update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[ $key ])));
        }
    }
    if (isset($_POST['_hc_short_description'])) {
        update_post_meta($post_id, '_hc_short_description', sanitize_textarea_field(wp_unslash($_POST['_hc_short_description'])));
    }
    update_post_meta($post_id, '_hc_features', wp_json_encode(hc_lines_from_post('_hc_features')));
    update_post_meta($post_id, '_hc_gallery_captions', wp_json_encode(hc_lines_from_post('_hc_gallery_captions')));
    update_post_meta($post_id, '_hc_applications', wp_json_encode(hc_lines_from_post('_hc_applications')));
    update_post_meta($post_id, '_hc_related', wp_json_encode(hc_lines_from_post('_hc_related')));
    $tech = array();
    foreach (hc_lines_from_post('_hc_technical') as $line) {
        $parts = array_map('trim', explode('|', $line, 2));
        $tech[] = array('label' => $parts[0] ?? '', 'value' => $parts[1] ?? '');
    }
    update_post_meta($post_id, '_hc_technical', wp_json_encode($tech));
    update_post_meta($post_id, '_hc_featured', empty($_POST['_hc_featured']) ? '' : '1');
}

function hc_save_application_meta($post_id) {
    if (! hc_verify_meta_nonce() || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || ! current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['_hc_short_description'])) {
        update_post_meta($post_id, '_hc_short_description', sanitize_textarea_field(wp_unslash($_POST['_hc_short_description'])));
    }
    if (isset($_POST['_hc_image'])) {
        update_post_meta($post_id, '_hc_image', esc_url_raw(wp_unslash($_POST['_hc_image'])));
    }
    if (isset($_POST['_hc_image_alt'])) {
        update_post_meta($post_id, '_hc_image_alt', sanitize_text_field(wp_unslash($_POST['_hc_image_alt'])));
    }
    update_post_meta($post_id, '_hc_challenges', wp_json_encode(hc_lines_from_post('_hc_challenges')));
    update_post_meta($post_id, '_hc_solutions', wp_json_encode(hc_lines_from_post('_hc_solutions')));
    update_post_meta($post_id, '_hc_typical_products', wp_json_encode(hc_lines_from_post('_hc_typical_products')));
}

function hc_save_resource_meta($post_id) {
    if (! hc_verify_meta_nonce() || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || ! current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['_hc_type'])) {
        update_post_meta($post_id, '_hc_type', sanitize_text_field(wp_unslash($_POST['_hc_type'])));
    }
    if (isset($_POST['_hc_description'])) {
        update_post_meta($post_id, '_hc_description', sanitize_textarea_field(wp_unslash($_POST['_hc_description'])));
    }
}
