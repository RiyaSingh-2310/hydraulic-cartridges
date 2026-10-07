<?php
/**
 * Shared helpers. Escape on output.
 */

if (! defined('ABSPATH')) {
    exit;
}

function hc_seed_data() {
    static $data = null;
    if (null === $data) {
        $path = get_template_directory() . '/inc/seed-data.json';
        $raw  = is_readable($path) ? file_get_contents($path) : '{}';
        $data = json_decode($raw, true);
        if (! is_array($data)) {
            $data = array();
        }
    }
    return $data;
}

function hc_company($key = null, $default = '') {
    $company = hc_seed_data()['company'] ?? array();
    $map     = array(
        'email'   => get_theme_mod('hc_email', $company['email'] ?? ''),
        'phone'   => get_theme_mod('hc_phone', $company['phone'] ?? ''),
        'address' => get_theme_mod('hc_address', $company['address'] ?? ''),
        'hours'   => get_theme_mod('hc_hours', $company['hours'] ?? ''),
        'iso'     => get_theme_mod('hc_iso', $company['iso'] ?? ''),
        'name'    => $company['name'] ?? 'Hydraulic Cartridges',
        'tagline' => $company['tagline'] ?? '',
    );
    if (null === $key) {
        return $map;
    }
    return $map[ $key ] ?? $default;
}

function hc_page_url($slug) {
    $page = get_page_by_path($slug);
    if ($page) {
        return get_permalink($page);
    }
    return home_url('/' . ltrim($slug, '/') . '/');
}

function hc_quote_url($product_slug = '') {
    $url = hc_page_url('request-quote');
    if ($product_slug) {
        $url = add_query_arg('product', $product_slug, $url);
    }
    return $url;
}

function hc_products_url() {
    $link = get_post_type_archive_link('hc_product');
    return $link ? $link : home_url('/products/');
}

function hc_applications_url() {
    $link = get_post_type_archive_link('hc_application');
    return $link ? $link : home_url('/applications/');
}

function hc_btn($href, $label, $variant = 'primary') {
    $class = 'btn';
    if ('ghost' === $variant) {
        $class .= ' btn-ghost';
    } elseif ('outline' === $variant) {
        $class .= ' btn-outline';
    } elseif ('dark' === $variant) {
        $class .= ' btn-dark';
    }
    printf(
        '<a class="%s" href="%s">%s</a>',
        esc_attr($class),
        esc_url($href),
        esc_html($label)
    );
}

function hc_section_header($eyebrow, $title, $copy = '', $split = false) {
    ?>
    <div class="section-head<?php echo $split ? ' split' : ''; ?>">
        <div>
            <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h2 class="display" style="font-size: var(--display-sm); margin-top: 0.75rem;">
                <?php echo esc_html($title); ?>
            </h2>
        </div>
        <?php if ($copy) : ?>
            <p class="lede"><?php echo esc_html($copy); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

function hc_page_hero($eyebrow, $title, $description, $compact = false, $crumbs = array()) {
    ?>
    <header class="page-hero<?php echo $compact ? ' compact' : ''; ?>">
        <div class="container">
            <?php if ($crumbs) : ?>
                <?php hc_render_crumbs($crumbs); ?>
            <?php endif; ?>
            <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h1 class="display"><?php echo esc_html($title); ?></h1>
            <p><?php echo esc_html($description); ?></p>
        </div>
    </header>
    <?php
}

function hc_render_crumbs($items) {
    if (! $items) {
        return;
    }
    echo '<nav class="crumbs" aria-label="Breadcrumb"><ol>';
    $last = count($items) - 1;
    foreach ($items as $i => $item) {
        $label = $item['label'] ?? '';
        $url   = $item['url'] ?? '';
        echo '<li>';
        if ($url && $i !== $last) {
            printf('<a href="%s">%s</a>', esc_url($url), esc_html($label));
        } else {
            echo '<span aria-current="page">' . esc_html($label) . '</span>';
        }
        echo '</li>';
    }
    echo '</ol></nav>';
}

function hc_reveal_open($delay = 0, $class = '') {
    $style = $delay ? '--reveal-delay: ' . esc_attr($delay) . 's;' : '';
    $cls   = trim('reveal ' . $class);
    printf('<div class="%s"%s>', esc_attr($cls), $style ? ' style="' . esc_attr($style) . '"' : '');
}

function hc_reveal_close() {
    echo '</div>';
}

function hc_decode_meta($post_id, $key, $default = array()) {
    $raw = get_post_meta($post_id, $key, true);
    if (is_array($raw)) {
        return $raw;
    }
    if (is_string($raw) && $raw !== '') {
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw))));
        return $lines ?: $default;
    }
    return $default;
}

function hc_product_from_post($post) {
    $post = get_post($post);
    if (! $post) {
        return null;
    }
    $id = $post->ID;
    return array(
        'id'              => $id,
        'slug'            => $post->post_name,
        'name'            => $post->post_title,
        'permalink'       => get_permalink($id),
        'model'           => get_post_meta($id, '_hc_model', true),
        'category'        => get_post_meta($id, '_hc_category', true),
        'categorySlug'    => get_post_meta($id, '_hc_category_slug', true),
        'shortDescription'=> get_post_meta($id, '_hc_short_description', true),
        'overview'        => $post->post_content,
        'pressure'        => get_post_meta($id, '_hc_pressure', true),
        'flow'            => get_post_meta($id, '_hc_flow', true),
        'cavity'          => get_post_meta($id, '_hc_cavity', true),
        'visual'          => get_post_meta($id, '_hc_visual', true) ?: 'cartridge',
        'galleryCaptions' => hc_decode_meta($id, '_hc_gallery_captions'),
        'features'        => hc_decode_meta($id, '_hc_features'),
        'technical'       => hc_decode_meta($id, '_hc_technical'),
        'applications'    => hc_decode_meta($id, '_hc_applications'),
        'relatedSlugs'    => hc_decode_meta($id, '_hc_related'),
        'accessories'     => hc_decode_meta($id, '_hc_accessories'),
        'downloads'       => hc_decode_meta($id, '_hc_downloads'),
        'featured'        => (bool) get_post_meta($id, '_hc_featured', true),
    );
}

function hc_application_from_post($post) {
    $post = get_post($post);
    if (! $post) {
        return null;
    }
    $id    = $post->ID;
    $thumb = get_the_post_thumbnail_url($id, 'full');
    $image = $thumb ? $thumb : get_post_meta($id, '_hc_image', true);
    return array(
        'id'               => $id,
        'slug'             => $post->post_name,
        'name'             => $post->post_title,
        'permalink'        => get_permalink($id),
        'shortDescription' => get_post_meta($id, '_hc_short_description', true),
        'overview'         => $post->post_content,
        'challenges'       => hc_decode_meta($id, '_hc_challenges'),
        'solutions'        => hc_decode_meta($id, '_hc_solutions'),
        'typicalProducts'  => hc_decode_meta($id, '_hc_typical_products'),
        'image'            => $image,
        'imageAlt'         => get_post_meta($id, '_hc_image_alt', true) ?: $post->post_title,
    );
}

function hc_get_products() {
    $query = new WP_Query(array(
        'post_type'      => 'hc_product',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ));
    $items = array();
    foreach ($query->posts as $post) {
        $items[] = hc_product_from_post($post);
    }
    wp_reset_postdata();
    return $items;
}

function hc_get_home_products() {
    $slugs = array();
    foreach ((hc_seed_data()['products'] ?? array()) as $item) {
        if (! empty($item['slug'])) {
            $slugs[] = $item['slug'];
        }
    }
    if (! $slugs) {
        return array_slice(hc_get_products(), 0, 8);
    }
    $query = new WP_Query(array(
        'post_type'      => 'hc_product',
        'posts_per_page' => count($slugs),
        'post_name__in'  => $slugs,
        'orderby'        => 'post_name__in',
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ));
    $items = array();
    foreach ($query->posts as $post) {
        $items[] = hc_product_from_post($post);
    }
    wp_reset_postdata();
    return $items;
}

function hc_get_product_by_slug($slug) {
    $posts = get_posts(array(
        'name'        => $slug,
        'post_type'   => 'hc_product',
        'post_status' => 'publish',
        'numberposts' => 1,
    ));
    return $posts ? hc_product_from_post($posts[0]) : null;
}

function hc_get_featured_product() {
    $query = new WP_Query(array(
        'post_type'      => 'hc_product',
        'posts_per_page' => 1,
        'meta_key'       => '_hc_featured',
        'meta_value'     => '1',
        'post_status'    => 'publish',
    ));
    if ($query->have_posts()) {
        $product = hc_product_from_post($query->posts[0]);
        wp_reset_postdata();
        return $product;
    }
    $all = hc_get_products();
    return $all[0] ?? null;
}

function hc_get_applications() {
    $query = new WP_Query(array(
        'post_type'      => 'hc_application',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ));
    $items = array();
    foreach ($query->posts as $post) {
        $items[] = hc_application_from_post($post);
    }
    wp_reset_postdata();
    return $items;
}

function hc_get_resources() {
    $query = new WP_Query(array(
        'post_type'      => 'hc_resource',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ));
    $items = array();
    foreach ($query->posts as $post) {
        $items[] = array(
            'slug'        => $post->post_name,
            'title'       => $post->post_title,
            'description' => get_post_meta($post->ID, '_hc_description', true) ?: $post->post_excerpt,
            'type'        => get_post_meta($post->ID, '_hc_type', true),
        );
    }
    wp_reset_postdata();
    if (! $items) {
        return hc_seed_data()['resources'] ?? array();
    }
    return $items;
}

function hc_get_faqs() {
    $query = new WP_Query(array(
        'post_type'      => 'hc_faq',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ));
    $items = array();
    foreach ($query->posts as $post) {
        $items[] = array(
            'question' => $post->post_title,
            'answer'   => wp_strip_all_tags($post->post_content),
        );
    }
    wp_reset_postdata();
    if (! $items) {
        return hc_seed_data()['faqs'] ?? array();
    }
    return $items;
}

function hc_get_capabilities() {
    $saved = get_theme_mod('hc_capabilities', '');
    if ($saved) {
        $decoded = json_decode($saved, true);
        if (is_array($decoded)) {
            return $decoded;
        }
    }
    return hc_seed_data()['capabilities'] ?? array();
}

function hc_images() {
    return hc_seed_data()['images'] ?? array();
}

function hc_phone_href() {
    $digits = preg_replace('/\D+/', '', hc_company('phone'));
    return 'tel:+' . $digits;
}

function hc_logo_markup() {
    if (has_custom_logo()) {
        $logo_id = get_theme_mod('custom_logo');
        $src     = wp_get_attachment_image_url($logo_id, 'full');
        ?>
        <span class="brand">
            <img class="brand-mark" src="<?php echo esc_url($src); ?>" alt="" />
            <span class="brand-text">
                <strong>Hydraulic Cartridges</strong>
                <span>Precision fluid power</span>
            </span>
        </span>
        <?php
        return;
    }
    ?>
    <span class="brand">
        <svg class="brand-mark" viewBox="0 0 32 32" aria-hidden="true">
            <rect width="32" height="32" fill="#0A0C0E" />
            <path d="M7 6h7v3.2h-3.2V22.8H14V26H7V6zm11 0h7v3.2h-3.2V22.8H25V26h-7V6z" fill="#C47A3A" />
        </svg>
        <span class="brand-text">
            <strong style="color: #F8F5EF;">Hydraulic Cartridges</strong>
            <span style="color: #C6C0B4;">Precision fluid power</span>
        </span>
    </span>
    <?php
}

function hc_product_card($product, $index = null) {
    if (! $product) {
        return;
    }
    $label = null !== $index ? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) : $product['model'];
    ?>
    <article class="product-card">
        <div class="product-card-visual">
            <?php hc_product_visual($product['visual'], $product['name']); ?>
        </div>
        <div class="product-card-body">
            <p class="meta"><?php echo esc_html($label . ' · ' . $product['category']); ?></p>
            <h3><?php echo esc_html($product['name']); ?></h3>
            <p><?php echo esc_html($product['shortDescription']); ?></p>
            <div class="spec-row">
                <span><?php echo esc_html($product['pressure']); ?></span>
                <span><?php echo esc_html($product['flow']); ?></span>
            </div>
            <a class="explore-link" href="<?php echo esc_url($product['permalink']); ?>">Explore product →</a>
        </div>
    </article>
    <?php
}
